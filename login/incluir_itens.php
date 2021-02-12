<?
include_once("inc/config.php");
pg_query ($db, "begin");
if ($_REQUEST[numero]){
  $numero = $_REQUEST["numero"];
}elseif($_REQUEST[numero_pedido]){
  $numero = $_REQUEST[numero_pedido];
}
echo "";
if ($_REQUEST[acao]=="excluir"){
  $Excluir = pg_query("delete from itens_do_pedido_internet where codigo='$_REQUEST[codigo]' and numero_pedido='$numero'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
}
if ($numero){
    $consulta = "select * from itens_do_pedido_internet where numero_pedido = '".$numero."' AND codigo = '".$_REQUEST[codigo_cc]."' order by codigo ASC" ;
    $resultado = pg_query($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
    $linha = pg_fetch_array($resultado);
    if ($linha == 0){
      $Opcao = "Novo";
      $erro = 0;
    }else{
      $Opcao = "Editar";
      $erro = 1;
    }
    if (($_REQUEST[codigo_cc]) and ($_REQUEST[qtd_cc])){
      $consulta = "select codigo from itens_do_pedido_internet where numero_pedido = '".$numero."' AND codigo = '".$_REQUEST[codigo_cc]."'" ;
      $resultado = pg_query($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      $linha = pg_fetch_array($resultado);
      if ($linha == 0){
        $erro = 0;
        $consulta1 = "select codigo from produtos where codigo = '".$_REQUEST[codigo_cc]."'" ;
        $resultado1 = pg_query($db,$consulta1) or die ($MensagemDbError.$consulta1.pg_query ($db, "rollback"));
        $linha1 = pg_fetch_array($resultado1);
        if ($linha1 == 0){
          $errop = 0;
        }else{
          $errop = 1;
        }
      }else{
        $erro = 1;
      }
    }else{
      $erro=3;
    }
    if ($_REQUEST["qtd_cc"] == ""){
      $erro = 4;
    }
    if ($_REQUEST["ipi_cc"]==""){
      $Ipi = 0;
    }else{
      $Ipi = str_replace(",",".",$_REQUEST[ipi_cc]);
    }
    $ValorIpi = $_REQUEST[valor_total_cc] * ($Ipi / 100);
    ##############################################################################
    #       PESO BRUTO E LIQUIDO 1 E 2
    ##############################################################################
    $consulta3 = "select peso_liquido, peso_bruto from produtos where codigo = '".$_REQUEST[codigo_cc]."'" ;
    $resultado3 = pg_query($db,$consulta3) or die ($MensagemDbError.$consulta1.pg_query ($db, "rollback"));
    $linha3 = pg_fetch_array($resultado3);
    $PesoBruto1 = str_replace(",",".",$_REQUEST[qtd_cc]) * str_replace(",",".",$linha3[peso_bruto]);
    $PesoLiquido1 = str_replace(",",".",$_REQUEST[qtd_cc]) * str_replace(",",".",$linha3[peso_liquido]);
    //$PesoBruto1 = $_REQUEST[qtd_cc] * $linha3[peso_bruto];
    //$PesoLiquido1 = $_REQUEST[qtd_cc] * $linha3[peso_liquido];
    ##############################################################################
    #       VERIFICAÇÃO DO ITEM PARA GRAVAÇÃO
    ##############################################################################
    if (($Opcao=="Editar") and ($erro!=2)){
      $consulta = $consulta."";
      $consulta = "Update itens_do_pedido_internet set
                     qtd='$_REQUEST[qtd_cc]',
                     valor_unitario='$_REQUEST[valor_unitario_cc]',
                     valor_total='$_REQUEST[valor_total_cc]',
                     valor_ipi='$ValorIpi',
                     ipi='$Ipi',
                     nome_do_produto='$_REQUEST[descricao_cc]',
                     preco_alterado='$_REQUEST[alterado1_cc]',
                     preco_venda='$_REQUEST[preco_venda_cc]',
                     peso_bruto='$PesoBruto1',
                     peso_liquido='$PesoLiquido1',
                     qtd_caixa='$_REQUEST[qtd_caixa_cc]' ";
      $consulta = $consulta." where codigo='$_REQUEST[codigo_cc]' and numero_pedido='$numero'";
      @pg_query ($db,$consulta);
      //echo $consulta;
     $qtd =$_REQUEST["qtd_cc"];
  }else{
    if (($erro==0) and ($errop==1)){
      /////////////////////////////////////////////////////////
      // NORMAL
      /////////////////////////////////////////////////////////
      $consulta = "INSERT INTO itens_do_pedido_internet ";
      $consulta = $consulta." (numero_pedido,codigo,qtd,preco_venda,preco_minimo,valor_unitario,";
      $consulta = $consulta."valor_total,especial,";
      $consulta = $consulta."ipi,valor_ipi,nome_do_produto,preco_alterado,";
      $consulta = $consulta."qtd_caixa, peso_bruto, peso_liquido, ";
      $consulta = $consulta." especificado ) values( ";
      $consulta=  $consulta."$numero, '$_REQUEST[codigo_cc]', $_REQUEST[qtd_cc], '$_REQUEST[preco_venda_cc]', '$_REQUEST[preco_minimo_cc]',";
      $consulta = $consulta."'$_REQUEST[valor_unitario_cc]', ";
      $consulta = $consulta."'$_REQUEST[valor_total_cc]', 0, ";
      $consulta = $consulta."'$Ipi', '$ValorIpi', '$_REQUEST[descricao_cc]', ";
      $consulta = $consulta."'$_REQUEST[alterado1_cc]', '$_REQUEST[qtd_caixa_cc]', '$PesoBruto1', '$PesoLiquido1', ";
      $consulta = $consulta."0 ) ";
      pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      //echo $consulta;
      $qtd = $_REQUEST["qtd_cc"];
    }
  }
//  echo $consulta;
//  echo "<BR>ULTIMO ORIGINAL: $_SESSION[ultimo_tem_cores]<BR>";
  if ($_REQUEST[optcores]=="false"){
    $_SESSION[UltimoTemCores] = "";
  }else{
    $_SESSION[UltimoTemCores] = "SIM";
  }
//  echo "<BR>OPT CORES: $_REQUEST[optcores]<BR>";
//  echo "<BR>ULTIMO: $_SESSION[UltimoTemCores]<BR>";
  $SqlCarregaItens = pg_query("Select codigo, nome_do_produto, qtd, valor_unitario, valor_total, ipi from itens_do_pedido_internet where numero_pedido = '$numero' order by id, especial ASC") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
  $cci = pg_num_rows($SqlCarregaItens);
//  echo $cci;
  if ($cci==0){
    $Sql = "Select codigo, nome_do_produto, qtd, valor_unitario, valor_total, ipi from itens_do_pedido_vendas where numero_pedido = '$numero' order by id ASC";
    $SqlCarregaItens = pg_query($Sql) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
    $cci = pg_num_rows($SqlCarregaItens);
    $_SESSION[enviado]=1;
    $_SESSION[bloqueio_pedido]="itens";
  }
  if ($cci>0){
    ?>
    <table cellspacing="0" cellpadding="0" border="0" class="texto1" width="100%">
      <tr>
        <td width="70"><b>Código</b></td>
        <td width="350">&nbsp;<b>Nome</b></td>
        <td width="60" align="center"><b>Qtd</b></td>
        <td width="60" align="center"><b>Vl. Unit.</b></td>
        <td width="60" align="center"><b>Vl. Ipi.</b></td>
        <td width="60" align="center"><b>Vl. Tot.</b></td>
        <td width="25" align="center"><b>&nbsp;Editar&nbsp;</b></td>
        <td width="25" align="center"><b>&nbsp;Excluir&nbsp;</b></td>
      </tr>
      <?
      while ($r = pg_fetch_array($SqlCarregaItens)){
        $ValorIpi = $r[valor_total] * ($r[ipi] / 100);
        $TotalIpi = $TotalIpi + $ValorIpi;
        $TotalMaisIpi = $r[valor_total] + $ValorIpi;
        $TotalPedido = $TotalPedido + $r[valor_total];
        $TotalPedidoGeral = $TotalPedidoGeral + $TotalMaisIpi;
        #Confere se tem especial para liberar o campo desconto novamente.
        if ($cci==1){ //Não é especial e tem uma linha só.
          $LiberaDesconto = "document.getElementById('boxdesconto').innerHTML='';document.ped.desconto.style.display='block';";
        }elseif ($cci==2){
          $SqlConfereEspecial = pg_query("Select codigo from itens_do_pedido_internet where numero_pedido = '$numero' and codigo='$r[codigo]' and especial='1'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          $cce = pg_num_rows($SqlCarregaItens);
          if ($cce>0){
            $LiberaDesconto = "document.getElementById('boxdesconto').innerHTML='';document.ped.desconto.style.display='block';";
          }
        }
        if ($Cor=="FFFFFF"){
          $Cor = "EEEEEE";
        }else{
          $Cor = "FFFFFF";
        }
        if ($r[nome_do_produto]){
          $Nome = $r[nome_do_produto];
        }else{
          $Nome = $r[nome];
        }
        ?>
        <tr bgcolor="<? echo $Cor;?>">
          <td width="70" class="item">&nbsp;<b><? echo "$r[codigo]";?></b></td>
          <td width="350" class="item">&nbsp;<? echo "$Nome";?></td>
          <td width="60" class="item" align="right"><b><? echo "$r[qtd]";?></b>&nbsp;</td>
          <td width="60" class="item" align="right"><? echo FormataCasas($r[valor_unitario],2,false);?>&nbsp;</td>
          <td width="60" class="item" align="right"><? echo FormataCasas($ValorIpi,2,false);?>&nbsp;</td>
          <td width="60" class="item" align="right"><b><? echo FormataCasas($TotalMaisIpi,2,false);?></b>&nbsp;</td>
          <td width="25" class="item" align="center">
            <?
            if (!$_SESSION[enviado]){
              ?>
              <img src="icones/alterar.gif" align="center" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para editar o ítem" onclick="Acha('editar_itens.php', 'numero=<? echo $numero;?>&codigo=<? echo $r[codigo]; ?>', 'itens')">
              <?
            }
            ?>
          </td>
          <td width="25" class="item" align="center">
            <?
            if (!$_SESSION[enviado]){
              ?>
              <img src="icones/excluir.png" align="center" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o ítem" onclick="if (confirm('Deseja realmente excluir o ítem - <? echo $r[codigo];?>?')){ Acha('incluir_itens.php', 'acao=excluir&numero=<? echo $numero;?>&codigo=<? echo $r[codigo]; ?>', 'GrdProdutos'); <? echo $LiberaDesconto;?>}">
              <?
            }
            ?>
          </td>
        </tr>
        <?
        $i++;
      }
      if (($TotalPedido) and ($TotalPedidoGeral)){
        $SqlAtualizaTotalPedido = pg_query("Update pedidos_internet_novo set total_com_desconto='$TotalPedido', total_sem_desconto='$TotalPedidoGeral' where numero = '$numero'");
      }
      ?>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top" colspan="6"><hr></hr></td>
        <td align="right" valign="top" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" colspan="2" align="right" class="erro"><b>Total :</b>&nbsp;</td>
        <td align="right" valign="top">&nbsp;</td>
        <td valign="top" align="right"><b><? echo FormataCasas($TotalPedido,2,false);?></b>&nbsp;</td>
        <td valign="top" align="right"><b><? echo FormataCasas($TotalIpi,2,false);?></b>&nbsp;</td>
        <td valign="top" align="right"><b><? echo FormataCasas($TotalPedidoGeral,2,false);?></b>&nbsp;</td>
        <td align="right" valign="top" colspan="3">&nbsp;</td>
      </tr>
    </table>
    <?
    $_SESSION[enviado]="";
  }else{
    ?>
    <BR><BR><center><b>Este pedido não contém itens.</b></center>
    <?
  }
  if ($erro == 1){
    ?>
    <BR><BR><center><b>Este item ja existe no pedido, os dados foram editados.</b></center>
    <?
  }
  if ($erro == 2){
    ?>
    <BR><BR><center><b>Digite as quantidades do produto!</b></center>
    <?
  }
  pg_query ($db, "commit");
  pg_close($db);
}else{
  echo "Digite o número do Pedido";
}
?>

