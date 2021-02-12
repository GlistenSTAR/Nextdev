<?php
include_once("inc/config.php");
$DisplayLinhaEspecial="none";
$NumeroCasas = ($CONF['arredondamento']>"100")?"3":"2";
if ((!$_REQUEST['EnterCodigo']) and ($_REQUEST['codigo'])){
  if ($_REQUEST['especial']){
    //$ValidaEspecial = " and especial = 1";
  }else{
    //$ValidaEspecial = " and especial = 0";
  }
  $Sql = "Select * from itens_do_pedido_internet where numero_pedido = '".$_REQUEST['numero']."' and codigo='".strtoupper($_REQUEST['codigo'])."' order by codigo, especial";
  $SqlCarregaItens = pg_query($Sql);
  $i = pg_fetch_array($SqlCarregaItens);
  $ValorUnitario1 = $i['valor_unitario'];
  $Qtd1 = $i['qtd'];
  $ValorTotal1 = $i['valor_total'];
  $Fator1 = $i['fator1'];
  $PrecoAlterado1 = $i['preco_alterado'];
  $i['peso_liquido'] = ($i['peso_liquido'] / $i['qtd']);
  $i['peso_bruto'] = ($i['peso_bruto'] / $i['qtd']);
  if ($_REQUEST['desconto']>0){
    $SqlCarregaItens2 = pg_query("Select * from itens_do_pedido_internet where numero_pedido = '".$_REQUEST['numero']."' and codigo='".strtoupper($_REQUEST['codigo'])."' order by codigo, especial limit 1 offset 1");
    $cci = pg_num_rows($SqlCarregaItens);
    if ($cci){
      $i2 = pg_fetch_array($SqlCarregaItens2);
      $ValorUnitario2 = $i2['valor_unitario'];
      $Qtd2 = $i2['qtd'];
      $ValorTotal2 = $i2['valor_total'];
      $Fator2 = $i2['fator2'];
      $PrecoAlterado2 = $i2['preco_alterado'];
      $DisplayLinhaEspecial="block";
    }
  }
  $Nome = $i['nome_do_produto'];
}elseif ($_REQUEST['codigo']){
  $SqlCamposExtra = ($CodigoEmpresa=="86")? " preco_minimo, tem_divisao, ":"";
  $SqlCamposExtra = ($CodigoEmpresa=="75")? " preco_minimo, pode_ser_especial, caixa_aberta, ":"";
  if ($_REQUEST['lista_preco']){
    $SqlCamposExtra .= "preco_venda$_REQUEST[lista_preco_cc] as preco_venda, ";
  }else{
    $SqlCamposExtra .= "preco_venda, ";
  }
  $Sql = "SELECT codigo, nome, qtd_caixa, $SqlCamposExtra ipi, produto_venda, classificacao_fiscal,  inativo, peso_bruto, peso_liquido, fabricante FROM produtos where codigo='".strtoupper($_REQUEST['codigo'])."'";
  echo $Sql;
  $SqlCarregaItens = pg_query($Sql);
  $i = pg_fetch_array($SqlCarregaItens);
  $ValorUnitario1 = $i['preco_venda'];
  $ValorUnitario2 = $i['preco_venda'];
  if ($i['inativo']=="1"){
    $ProdutoInexistente = "<span class=erro id=produtoinexistente>Produto Inativo</span>";
  }else{
    $Nome = $i['nome'];
  }
  if ($_REQUEST['desconto']>0){
    if (($CodigoEmpresa=="75") and ($i['pode_ser_especial']=="0")){
      $DisplayLinhaEspecial="none";
      $i['especial'] = "";
    }else{
      $DisplayLinhaEspecial="block";
      $i['especial'] = "1";
    }
    if ($_SESSION['vende_qualquer_produto']){
      $DisplayLinhaEspecial="block";
      $i['especial'] = "1";
    }
  }else{
    $DisplayLinhaEspecial="none";
  }
}
//echo "<BR><BR>$PrecoAlterado1<BR><BR>";
if ($PrecoAlterado1=="S"){
  $Sql3 = "SELECT preco_venda FROM produtos where codigo='".strtoupper($_REQUEST['codigo'])."'";
  $SqlCarregaItens3 = pg_query($Sql3);
  $i3 = pg_fetch_array($SqlCarregaItens3);
  //$ValorUnitario1 = $i3[valor_unitario];
  $i['preco_venda'] = $i3['preco_venda'];
}
if ($PrecoAlterado2=="S"){
  $Sql3 = "SELECT preco_venda FROM produtos where codigo='".strtoupper($_REQUEST['codigo'])."'";
  $SqlCarregaItens3 = pg_query($Sql3);
  $i3 = pg_fetch_array($SqlCarregaItens3);
  //$ValorUnitario2 = $i3[valor_unitario];
  $i['preco_venda'] = $i3['preco_venda'];
}
if ($_SESSION['vende_especial']=="0"){
  $DisplayLinhaEspecial="none";
  $i['especial'] = "";
}
if (($_REQUEST['codigo']) and ($CodigoEmpresa=="86")){ //Perfil
  $SqlCarregaCores= pg_query("SELECT tem_divisao, inativo FROM produtos where codigo='".strtoupper($_REQUEST['codigo'])."'");
  $cores1 = pg_fetch_array($SqlCarregaCores);
}
if ($Fator1=="0"){ $Fator1 = "";}
if ($Fator2=="0"){ $Fator2 = "";}
$QtdItens = $Qtd1 + $Qtd2;
if ($i['numero_pedido']){
  $Numero = $i['numero_pedido'];
}else{
  $Numero = $_REQUEST['numero'];
}
if ((!$Nome) and ($_REQUEST['codigo']) and (!$ProdutoInexistente)){
  $ProdutoInexistente = "<span class=erro id=produtoinexistente>Produto Inexistente</span>";
}
if (!$i2['codigo']){
  if (($_REQUEST['fator1']>0) and ($PrecoAlterado1=="")){
    $ValorUnitario1 = $ValorUnitario1 * ($_REQUEST['fator1'] / 100);
    $PrecoAlterado1 = "S";
  }else{
    $ValorUnitario1 = $ValorUnitario1;
    $PrecoAlterado1 = "N";
  }
  if (($_REQUEST['fator2']>0) and ($PrecoAlterado2=="")){
    $ValorUnitario2 = $ValorUnitario2 * $_REQUEST['fator2'];
    $PrecoAlterado2 = "S";
  }else{
    $ValorUnitario2 = $ValorUnitario2;
    $PrecoAlterado2 = "N";
  }
}
$ValorUnitario1 = number_format($ValorUnitario1, $NumeroCasas, ",", ".");
$ValorUnitario2 = number_format($ValorUnitario2, $NumeroCasas, ",", ".");
$ValorTotal1 = number_format($ValorTotal1, $NumeroCasas, ",", ".");
$ValorTotal2 = number_format($ValorTotal2, $NumeroCasas, ",", ".");
$ValorOriginal1 = ($i['valor_unitario'])? number_format($i['preco_venda'] * ($_REQUEST['fator1'] / 100), $NumeroCasas, ",", "."):$ValorUnitario1;
$ValorOriginal2 = ($i2['valor_unitario'])? number_format($i['preco_venda'] * $_REQUEST['fator2'], $NumeroCasas, ",", "."):$ValorUnitario2;
//echo "<BR>Valor Original: $ValorOriginal1<BR>";
//(2008-08-29 12:00:57) Isabel-Perplug (indústria): perplug industria = cx aberta e perplug comércio = cx fechada
if ($i['caixa_aberta']=="1"){ //Solicitação da Marcia na visita do Celso em 17/03/2009
  $CaixaFechada = 0;
}else{
  $FabricantePerplugCom = explode("PERPLUG COM",$i['fabricante']);
  $CaixaFechada = $CONF['CaixaFechada'];
  if ($FabricantePerplugCom[1]<>""){
    $CaixaFechada = true;
  }
  $FabricantePerplugInd = explode("PERPLUG IND",$i['fabricante']);
  if ($FabricantePerplugInd[1]<>""){
    $CaixaFechada = 2;
  }
  //echo $FabricantePerplugCom[1] - $FabricantePerplugInd[1];
  if (!$_SESSION['venda_casada']){ $_SESSION['venda_casada'] = $_REQUEST['ven_cas'];}
  if ($_SESSION['venda_casada']=="true"){
    $CaixaFechada = 0;
  }else{
    $CaixaFechada = $CaixaFechada;
  }
}
?>
<fieldset id="titulo_frame">
  <legend><!--&nbsp;&nbsp;Dados dos produtos - Venda-casada: <?php echo $_SESSION[venda_casada]?> - <?php echo $_REQUEST[ven_cas]?>- <?php echo $CaixaFechada?>--></legend>
  <table width="590" border="0" cellspacing="0" cellpadding="0" class="texto1" id="aba_produtos">
    <input type="hidden" name="classificacao_fiscal_cc" id="classificacao_fiscal_cc" value="<?php echo $i['classificacao_fiscal'];?>">
    <input type="hidden" name="produto_venda_cc"        id="produto_venda_cc" value="<?php echo $i['produto_venda'];?>">
    <input type="hidden" name="inativo_cc"              id="inativo_cc" value="<?php echo $i['inativo'];?>">
    <input type="hidden" name="preco_minimo_cc"         id="preco_minimo_cc" value="<?php echo $i['preco_minimo'];?>">
    <input type="hidden" name="qtd_caixa_cc"            id="qtd_caixa_cc" value="<?php echo $i['qtd_caixa'];?>">
    <input type="hidden" name="preco_venda_cc"          id="preco_venda_cc" value="<?php echo $i['preco_venda'];?>">
    <input type="hidden" name="unit1_original"          id="unit1_original" value="<?php echo $ValorOriginal1?>">
    <input type="hidden" name="unit2_original"          id="unit2_original" value="<?php echo $ValorOriginal2?>">
    <input type="hidden" name="alterado1"               id="alterado1" value="<?php echo $PrecoAlterado1;?>">
    <input type="hidden" name="alterado2"               id="alterado2" value="<?php echo $PrecoAlterado2;?>">
    <input type="hidden" name="opcao"                   id="opcao" value="editar">
    <input type="hidden" name="especial"                id="especial" value="<?php echo ($i2['especial']>0)? $i2['especial']: $i['especial'];;?>">
    <input type="hidden" name="peso_bruto"              id="peso_bruto" value="<?php echo $i['peso_bruto'];?>">
    <input type="hidden" name="peso_liquido"            id="peso_liquido" value="<?php echo $i['peso_liquido'];?>">
    <input type="hidden" name="caixafechada"            id="caixafechada" value="<?php echo $CaixaFechada;?>">
    <input type="hidden" name="codigo_empresa"          id="codigo_empresa" value="<?php echo $CodigoEmpresa;?>">
    <input type="hidden" name="confereminimo"           id="confereminimo" value="<?php echo $ConfereMinimo;?>">
    <input type="hidden" name="display_especial"        id="display_especial" value="<?php echo $DisplayLinhaEspecial?>">
    <input name="numero_pedido"                         id="numero_pedido"  type="hidden" size="20" maxlength="10" value="<?php echo $Numero;?>">
    <input type="hidden" name="descontocores"           id="descontocores">
    <tr>
      <td><img src="images/spacer.gif" width="1" height="2"></td>
    </tr>
    <tr>
      <td>Código:</td>
      <td>
        <input type="text" tabindex="10" size="10" name="codigo_cc" value="<?php echo strtoupper($_REQUEST['codigo']);?>" id="codigo_cc" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (this.value){Acha('editar_itens.php', 'numero='+document.ped.numero.value+'&codigo='+document.ped.codigo_cc.value+'&EnterCodigo=true&desconto='+document.ped.desconto.value+'&fator1='+document.ped.desconto1_cc.value+'&fator2='+document.ped.desconto2_cc.value+'&ven_cas='+document.ped.venda_casada.checked+'', 'itens');document.ped.qtd_cc.value='';document.getElementById('errovalor1').innerHTML = '';document.getElementById('errovalor2').innerHTML = '';document.ped.qtd_cc.focus();}}">
        <BR>
        <div id="listar_codigo" style="position:absolute; z-index:7000;"></div>
      </td>
      <?php
      if ($CodigoEmpresa=="86"){
        ?>
        <td align="center">Cores:</td>
        <td>
          <input type=checkbox style="border: 0px;" name="optcores" id="optcores" value="1" <?php if ($_SESSION['UltimoTemCores']){echo "checked";}?> onclick="document.ped.qtd_cc.focus();">
        </td>
        <?php
      }else{
        ?>
        <input type=hidden name="optcores" id="optcores">
        <?php
      }
      ?>
      <td align="right">&nbsp;Qtd:</td>
      <td>&nbsp;<input name="qtd_cc" tabindex="11" id="qtd_cc" dir="rtl" value="<?php echo $QtdItens;?>"  type="text" size="8" maxlength="10" onfocus="this.select()" onblur="if (document.ped.codigo_cc.value){}" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.ipi_cc.focus();return calculavalor(this.value); }"></td>
      <td valign="top" align="right" width="10">&nbsp;Ipi</td>
      <td valign="top">
        &nbsp;<input type="button"  style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" name="ipi_cc" tabindex="12" dir="rtl" value="<?php echo $i['ipi'];?>" id="ipi_cc" size="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.valor_unitario1_cc.focus();}">
      </td>
      <td valign="top" align="right" nowrap>&nbsp;Class. Fiscal</td>
      <td valign="top">
        &nbsp;<input type="button" style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: center;" size="8" name="classificacao_fiscal_cc" tabindex="12" dir="rtl" value="<?php echo $i['classificacao_fiscal'];?>" id="classificacao_fiscal_cc" size="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.valor_unitario1_cc.focus();}">
      </td>
    </tr>
    <tr>
      <?php
      if ($ProdutoInexistente){
        ?>
        <td align="center" colspan="2">&nbsp;<?php echo $ProdutoInexistente;?></td>
        <?php
      }else{
        ?>
        <td align="right">&nbsp;<!--Desc 1:--></td>
        <td>
          <input type="hidden" size="8" name="desconto11_cc" id="desconto11_cc" value="<?php echo $Fator1;?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.qtd1_cc.focus();}else{Acha1('listar.php','tipo=desconto&complemento=11&valor='+this.value+'','listar_desconto11');}">
          <BR>
          <div id="listar_desconto11" style="position:absolute;"></div>
        </td>
        <?php
      }
      ?>
      <td align="right" NOWRAP>&nbsp;Qtd 1:</td>
      <td>&nbsp;<input name="qtd1_cc" id="qtd1_cc" value="<?php echo $Qtd1;?>" type="button" style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" maxlength="10" onclick="setTimeout('document.ped.qtd1_cc.disabled=true',0);" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.valor_unitario1_cc.focus();}"></td>
      <td align="right" NOWRAP>&nbsp;Valor 1:</td>
      <td>&nbsp;<input name="valor_unitario1_cc" dir="rtl" id="valor_unitario1_cc" value="<?php echo $ValorUnitario1;?>" type="text" size="8" maxlength="20" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){calculavalor(); if (this.value){if (document.ped.desconto.value>0){if (document.getElementById('display_especial').value=='block'){document.ped.valor_unitario2_cc.focus();}else{if (document.getElementById('Ok').style.display!='none'){ document.ped.Ok.focus(); }}}else{ if (document.getElementById('Ok').style.display!='none'){ document.ped.Ok.focus(); } }}}else{this.focus();}"></td>
      <td align="right" NOWRAP>&nbsp;Total 1:</td>
      <td>&nbsp;<input name="valor_total1_cc" id="valor_total1_cc" value="<?php echo $ValorTotal1;?>" type="button" style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" maxlength="20" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (document.ped.desconto.value>0){document.ped.qtd2_cc.focus();}else{document.getElementById('Ok').style.display='block';document.ped.Ok.focus();}}"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;<!--Desc 2:--></td>
      <td>
        <input type="hidden" size="8" name="desconto22_cc" value="<?php echo $Fator2;?>" id="desconto22_cc" onfocus="this.select()"  onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.qtd2_cc.focus();}else{Acha1('listar.php','tipo=desconto&complemento=22&valor='+this.value+'','listar_desconto22');}">
        <BR>
        <div id="listar_desconto22" style="position:absolute;"></div>
      </td>
      <td align="right" NOWRAP>&nbsp;<?php echo ($DisplayLinhaEspecial=="none"?"":"Qtd 2:");?></td>
      <td>&nbsp;<input name="qtd2_cc" id="qtd2_cc" value="<?php echo $Qtd2;?>" type="<?php echo ($DisplayLinhaEspecial=="none"?"hidden":"button");?>" style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" maxlength="10" onclick="setTimeout('document.ped.qtd2_cc.disabled=true',0);" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.valor_unitario2_cc.focus();}"></td>
      <td align="right" NOWRAP>&nbsp;<?php echo ($DisplayLinhaEspecial=="none"?"":"Valor 2:");?></td>
      <td>&nbsp;<input name="valor_unitario2_cc" dir="rtl" id="valor_unitario2_cc" value="<?php echo $ValorUnitario2;?>"  type="<?php echo ($DisplayLinhaEspecial=="none"?"hidden":"text");?>" size="8" maxlength="20" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){calculavalor(); if (parseFloat(this.value)>0){document.ped.Ok.focus();}else{document.ped.valor_unitario1_cc.focus();}}else{this.focus();}"></td>
      <td align="right" NOWRAP>&nbsp;<?php echo ($DisplayLinhaEspecial=="none"?"":"Total 2:");?></td>
      <td>&nbsp;<input name="valor_total2_cc" id="valor_total2_cc" value="<?php echo $ValorTotal2;?>" type="<?php echo ($DisplayLinhaEspecial=="none"?"hidden":"button");?>" style="width: 60px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" maxlength="20" onfocus="this.select()" onblur="calculavalor(true);" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.getElementById('Ok').style.display='block';document.ped.Ok.focus();}"></td>
    </tr>
  </table>
  <table width="590" border="0" cellspacing="0" cellpadding="2" class="texto1">
    <tr>
      <td width="70" width="top">Descrição:</td>
      <td colspan="3" width="top">
        <input type="hidden" name="desc2" id="desc2" value='<?php echo htmlspecialchars($Nome);?>'>
        <input type="text" style="width: 300px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: left;" size="75" name="descricao_cc" value='<?php echo $Nome;?>' id="descricao_cc" onclick="this.value=''; document.getElementById('buscaProdutos').style.display='block'; document.getElementById('btn_procurar').focus();" onkeyup="this.value=''; document.getElementById('buscaProdutos').style.display='block'; document.getElementById('btn_procurar').focus();">
        <BR>
        <span id="buscaProdutos" style="display: none; position: absolute; z-index: 8000" onclick="document.getElementById('buscaProdutos').style.display='none';">
          <input type="text" size="70" name="btn_procurar" id="btn_procurar" onfocus="this.select();" onkeyup=" document.getElementById('buscaProdutos').style.display='block'; Acha1('listar.php','tipo=descricao&valor='+this.value+'','listar_descricao');">
          <BR>
          <div id="listar_descricao" style="position:absolute; z-index:7000; display: block;"></div>
        </span>
      </td>
      <td valign="top" colspan="4" align="center">
        <div id="cpanel">
          <div style="float: left;">
           	<div class="icon">
              <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 30px; height: 15px;" onclick=" if (!document.ped.descricao_cc.value){ alert('Digite o código do produto e tecle enter para carregá-lo!'); document.ped.codigo_cc.focus(); }else{ if (document.ped.descricao_cc.value!=document.ped.desc2.value){  alert('Digite o código do produto e tecle enter para carregá-lo!'); document.ped.codigo_cc.focus(); }else{ document.getElementById('listar_descricao').style.display='none'; document.getElementById('buscaProdutos').style.display='none'; <?php if ($_SESSION['sql_cores']){ echo "editaritens(false);"; }else{ echo "editaritens(true);"; } ?> } }">
           	</div>
          </div>
        </div>
      </td>
    </tr>
  </table>
</fieldset>
<?php
if ($ProdutoInexistente){
  ?>
  <script>
    document.ped.codigo_cc.focus();
  </script>
  <?php
}else{
  ?>
  <script>
    document.ped.qtd_cc.focus();
  </script>
  <?php
}
?>
