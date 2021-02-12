<?php
include ("inc/common.php");
###################################
##Fazendo a conex�o com o servidor
###################################
include "inc/config.php";
###################################
# Variavel numero pedido no next (ja gravado)
###################################
$num = explode("%", $_REQUEST['numero']); //Retiro o final do numero se tiver espa�o ou qualquer outro caracter
$numero = $num[0];
if (($numero == "") or ($_REQUEST['t']>1) or ($_REQUEST['t']<0)){
  $_SESSION['erro'] = "<span class='erro'>Pedido n�o encontrado<BR><BR><a href='javascript:window.close();'>Fechar Janela</a></span>";
  Header("Location: index.php");
}else{
  $consulta = "select * from pedidos where numero = '".$numero."'";
  $resultado = pg_query($db, $consulta) or die("Erro na consulta : ".$consulta.pg_last.error($db));
  $NumeroLinhas = pg_num_rows($resultado);
  if ($NumeroLinhas == 0) {
    $_SESSION['erro'] = "<span class='erro'>Pedido n�o encontrado<BR><BR><a href='javascript:window.close();'>Fechar Janela</a></span>";
    Header("Location: index.php");
  }else{
    $row = pg_fetch_object($resultado, 0);
//    if ($_SESSION['config']['vendas']['VendedorCliente']){
//      if ($row->codigo_vendedor != $_SESSION[id_vendedor]) {
//        exit;
//      }
//    }
    ###################################
    #$data_hoje = date(d."/".m."/".Y);
    #$mask = value(,00);
    #Colocando os valores na tela
    ###################################
    # Id dos Clientes
    ###################################
    $id = $row->id_cliente;
    ###################################
    # Data do pedido
    ###################################
    $Ano = substr($row->data, 0, 4);
    $Mes = substr($row->data, 5, 2);
    $Dia = substr($row->data, 8, 2);
    $AnoEntr = substr($row->data_prevista_entrega, 0, 4);
    $MesEntr = substr($row->data_prevista_entrega, 5, 2);
    $DiaEntr = substr($row->data_prevista_entrega, 8, 2);
    ########################################
    # Dados dos clientes  criado 20/01/2005
    ########################################
    $TbCliente = "SELECT endereco,telefone,cidade,estado, cep,bairro,apelido FROM clientes WHERE id = ".$id;
    $TabCliente = pg_query($db, $TbCliente) or die("Erro na consulta : ".$TbCliente.pg_last.error($db));
    $Cliente = pg_fetch_object($TabCliente, 0);
    ########################################
    $Cliente_Endereco = $Cliente->endereco;
    $Cliente_Telefone = $Cliente->telefone;
    $Cliente_Cidade = $Cliente->cidade;
    $Cliente_Estado = $Cliente->estado;
    $Cliente_CEP = $Cliente->cep;
    $Cliente_Bairro = $Cliente->bairro;
    $Cliente_Apelido = $Cliente->apelido;
    ####################################################
    # Verificando Status
    ####################################################
    if ($row->venda_efetivada == 0) {
      $Status = "Pendente";
    }
    if ($row->venda_efetivada != 0 and $row->nota == 0) {
      $Status = "Aprovado";
    }
    if ($row->nota == 1) {
      if ($row->numero_nota or $row->numero_nota != '') {
        $Nota = $row->numero_nota;
        $NOTASFISCAIS = "select data_emissao, data_saida from notas1 where modelo=55 and numero_nota = ".$row->numero_nota;
        $notas1 = pg_query($db, $NOTASFISCAIS) or die("Erro na consulta : ".$NOTASFISCAIS.pg_last.error($db));
        $NF = pg_fetch_object($notas1, 0);
        if ($NF->entregue != 0)  {
          $Status = "Entregue";
        }else{
          $Status = "Faturado";
        }
        $AnoSaida = substr($NF->data_saida, 0, 4);
        $MesSaida = substr($NF->data_saida, 5, 2);
        $DiaSaida = substr($NF->data_saida, 8, 2);
        $AnoEmissao = substr($NF->data_emissao, 0, 4);
        $MesEmissao = substr($NF->data_emissao, 5, 2);
        $DiaEmissao = substr($NF->data_emissao, 8, 2);
      }
    }
    ?>
    <html>
    <body>
    <style>
      a{text-decoration:none}
      a:hover{text-decoration:underline}
      body,{font-family:verdana;}
      input,select,tt,h3,h5,#c1,#c1v,#c2c,.m ul,.bar,.bv,#e1,#d0,#mm,#cd{font-family:verdana}
      #titulo-frame {
        padding: 1;
        width: 630px;
        font-size: 14px;
        color: #182463;
      }
      .texto1{
        color: #000000;
        font-size: 14px;
        font-family: arial, tahoma, verdana;
      }
      .texto2{
        color: #404040;
        font-size: 14px;
        background-color: #F7F7F7;
      }
      .titulo{
        color: #182463;
        font-size: 14px;
        font-weight: bold;
      }
      .arialg {
      	font-family: arial;
      	font-size: 28px;
      	color: #ED1C24;
      }
    </style>
    <script>
      function imprimir(){
        document.getElementById('naoimprimir').style.display='none';
        //alert(document.getElementById('nao-imprimir').style.display);
        window.print();
        setTimeout("document.getElementById('naoimprimir').style.display='block';",1000);
      }
    </script>
    <body>
    <table border="0" width="630" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td valign="top">
          <table border="0" cellspacing="0" cellpadding="0" width="630">
            <tr>
              <td width="5" align="center"><!--<img src="images/logo.jpg">-->&nbsp;</td>
              <td align="center" width="400" class="titulo">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="20" valign="bottom" class="arialg" colspan="2" align="center">
                      <b>PEDIDO DE VENDAS <i>ON-LINE</i></b>
                    </td>
                  </tr>
                  <tr>
                    <td height="20" valign="bottom" class="texto1">
                      &nbsp;
                      <?php
                      $SqlAchaVendedor = "select nome from vendedores where codigo = ".$_SESSION['id_vendedor'];
                      $ArrayVendedor = @pg_query($db, $SqlAchaVendedor);
                      $v = @pg_fetch_array($ArrayVendedor, 0);
                      echo ($v[nome])?"Representação: <b>$v[nome]</b>":"";
                      ?>
                    </td>
                    <td height="20" valign="bottom" class="texto1">
                      <?php
                      setlocale(LC_TIME,'pt_BR','ptb');
                      echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
                      ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <table border="0">
            <tr>
              <td align="left" colspan="2" valign="top">
                <fieldset id="titulo-frame">
                  <legend>Dados Cliente</legend>
                  <table border="0" class="texto1" width="620">
                    <tr>
                      <td width="50" class="titulo">Cliente :</td>
                      <td colspan="3"><?php echo $row->cliente; ?></td>
                    </tr>
                    <tr>
                      <td width="50" class="titulo">CNPJ/CPF :</td>
                      <td width="100"><?php echo $row->cgc; ?></font></td>
                      <td width="50" class="titulo">Contato :</td>
                      <td width="100"><?php echo $row->contato; ?></font></td>
                    </tr>
                    <tr>
                      <td class="titulo">Endere�o : </td>
                      <td><?php echo $Cliente_Endereco; ?></td>
                      <td class="titulo">CEP :</td>
                      <td><?php echo $Cliente_CEP; ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Cidade / UF : </td>
                      <td><?php echo "$Cliente_Cidade / $Cliente_Estado"; ?></td>
                      <td class="titulo">Telefone :</td>
                      <td><?php echo $Cliente_Telefone; ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Bairro : </td>
                      <td><?php echo $Cliente_Bairro; ?></td>
                      <td class="titulo">Apelido :</td>
                      <td><?php echo $Cliente_Apelido; ?></td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
          </table>
          <table border="0">
            <tr>
              <td align="left" colspan="2">
                <fieldset id="titulo-frame">
                  <legend>Dados do pedido</legend>
                  <table border="0" class="texto1" width="630">
                    <tr>
                      <td width="100" class="titulo">N�mero : </td>
                      <td width="100"><font color="red"><b><?php echo $row->numero; ?></b></font></td>
                      <td width="100" class="titulo">Vendedor :</td>
                      <td width="200">
                        <?php
                        $SqlAchaVendedor = "select nome from vendedores where codigo = ".$row->codigo_vendedor;
                        //echo $SqlAchaVendedor;
                        $ArrayVendedor = @pg_query($db, $SqlAchaVendedor);
                        $v = @pg_fetch_array($ArrayVendedor);
                        echo "$v[nome]";
                        ?>
                      </td>
                      <td class="titulo">Status :</td>
                      <td><?php echo $Status;?></td>
                    </tr>
                    <tr>
                      <td width="100" class="titulo">O.C. : </td>
                      <td width="100"><?php echo $row->numero_cliente; ?></td>
                      <td class="titulo">Cond Pag. :</td>
                      <?php
                      #############################################################
                      # Coloca condicao de pagamento referente ao codigo do pagamento
                      #############################################################
                      if ($_REQUEST['t']=="0"){
                        $COND="SELECT descricao FROM condicao_pagamento WHERE codigo = ".$row->codigo_pagamento1;
                        $condpag = pg_query($db, $COND) or die("Erro na consulta : ".$COND.pg_last.error($db));
                        $cp = @pg_fetch_object($condpag, 0);
                      }else{
                        $COND="SELECT descricao FROM condicao_pagamento WHERE codigo = ".$row->codigo_pagamento;
                        $condpag = pg_query($db, $COND) or die("Erro na consulta : ".$COND.pg_last.error($db));
                        $cp = @pg_fetch_object($condpag, 0);
                      }
                      #############################################################
                      ?>
                      <td width="100"><?php echo $cp->descricao; ?></td>


                    </tr>
                    <tr>
                      <td class="titulo">Trans. :</td>
                      <td colspan="3"><?php echo $row->transportadora; ?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <!--
                      <td width="100" class="titulo">Desconto :</td>
                      <td width="100" align="right"><?php echo number_format($row->desconto_pedido, 2, ",", "."); ?></td>
                      -->
                    </tr>
                    <tr>
                      <td class="titulo">Data :</td>
                      <td><?php echo $Dia."/".$Mes."/".$Ano; ?></td>
                      <td class="titulo">Emiss�o :</td>
                      <td><?php echo $row->emissao;?></td>
                      <td width="100" class="titulo">Entrega :</td>
                      <td width="100"><?php echo $DiaEntr."/".$MesEntr."/".$AnoEntr; ?></td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
          </table>
          <?php
          # if ($Status != "Pendente" and $Status != "Aprovado") {
          if ($Status != "Pendente")  {
             ?>
             <table border = "0" class="texto1" width="630">
               <tr>
                 <td class="titulo" width="80">NF :
                 <td width="130"><?php echo $row->numero_nota;?></td>
                 <?php
                 if ($Status != "Aprovado") {
                    ?>
                    <td class="titulo" width="90">Data Saida :
                    <td width="120"><?php echo $DiaSaida."/".$MesSaida."/".$AnoSaida; ?></td>
                    <td class="titulo" width="120">Data Emissao :
                    <td width="130" align="right"><?php echo $DiaEmissao."/".$MesEmissao."/".$AnoEmissao; ?></td>
                    <?php
                 }
                 ?>
               </tr>
             </table>
             <?php
          }
          #####################################################################
          # Consulta de itens do pedido
          #####################################################################
          ?>
          <table border="0">
            <tr>
              <td align="left" colspan="2">
                <fieldset id="titulo-frame">
                  <legend>Produtos</legend>
                  <table border="0" class="texto1">
                    <tr>
                      <td>
                        <table border = "0" class="texto1" cellspacing="3" cellpadding="3">
                          <tr>
                            <td width="60" class="titulo">Codigo  </td>
                            <td width="450" class="titulo"> Nome  </td>
                            <td width="65" align="right" class="titulo">QTD  </td>
                            <td width="60" align="right" class="titulo"> Valor unit </td>
                            <td width="60" align="right" class="titulo"> Valor IPI </td>
                            <td width="60" align="right" class="titulo"> Valor Tot </td>
                          </tr>
                          <?php
                          #########################################################################
                          # Fazendo uma consulta SQL e retornando os resultados em uma tabela HTML
                          #########################################################################
                          $totalipi = 0;
                          $consulta = "select * from itens_do_pedido_vendas where numero_pedido = '".trim($numero)."'";
                          //echo $consulta;
                          //exit;
                          $resultado = pg_query($db,$consulta) or die("Erro na consulta : $consulta. " .pg_last_error($db));
                          while ($linha = pg_fetch_array($resultado)) {
                            if ($Classe=="1"){
                              $Classe = "2";
                            }else{
                              $Classe = "1";
                            }
                            ?>
                            <tr class="texto<?php echo $Classe;?>">
                              <td width="60" style="border: 1px solid #cccccc;"><?php echo $linha['codigo']; ?></td>
                              <td width="450" style="border: 1px solid #cccccc;"><?php echo $linha['nome_do_produto']; ?></td>
                              <td width="60" align="right" style="border: 1px solid #cccccc;"><?php echo $linha['qtd']; ?></td>
                              <td width="60" align="right" style="border: 1px solid #cccccc;"><?php echo number_format($linha['valor_unitario'], 2, ",", ".") ; ?></td>
                              <td width="60" align="right" style="border: 1px solid #cccccc;"><?php echo number_format($linha['valor_ipi'], 2, ",", ".") ; ?></td>
                              <td width="60" align="right" style="border: 1px solid #cccccc;"><?php echo number_format($linha['valor_unitario'] * $linha['qtd'], 2, ",", ".") ; ?></td>
                            </tr>
                            <?php
                            ############################################################
                            #Calculo do Total se considerar o pedido com parte especial
                            ############################################################
                            $totalgeral = $totalgeral + ($linha['qtd']*$linha['valor_unitario']) + $linha['valor_ipi'];
                            $totalipi = $totalipi + $linha['valor_ipi'];
                          }
                          ?>
                          <tr>
                            <td colspan="6"><hr></hr></td>
                          </tr>
                          <tr>
                            <td align=right class="titulo">&nbsp;</td>
                            <td align=right class="titulo" colspan="3">Totais Pedido :</td>
                            <td align=right><?php echo number_format($totalipi, 2, ",", "."); ?> </td>
                            <td align=right><?php echo number_format($totalgeral, 2, ",", "."); ?> </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
            <tr>
              <td>
                <table border="0" class="texto1" width="620">
                  <tr>
                    <td width="100" width="620" class="texto1">
                      <fieldset id="titulo-frame" class="texto1">
                      <legend>Observa��o</legend>
                    <?php
                    $obss = "select * from observacao_do_pedido where numero_pedido = ".trim($numero);
                    $oba = pg_query($db,$obss) or die("Erro na consulta : $obss. " .pg_last_error($db));
                    $obs = pg_fetch_array($oba);
                    $Tirar = array("ﾃ");
                    $OBS = str_replace($Tirar, "�", $obs['observacao']);
                    echo "<span class=texto1>$OBS</span>";
                    ?>
                    </fieldset>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <div id="naoimprimir" style="display: block;">
      <table border = "0" width="630" class="texto1">
        <tr>
          <td align=center>
            <input type="button" value="Imprimir" name="imprimir" id="imprimir" onclick="imprimir(); return false;" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="Voltar" name="voltar" id="voltar" onclick="window.close();" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if (($row->desconto_cliente>0) and ($_REQUEST['t']>0)){
              ?>
              <input type="button" value="Impress�o 2" name="imprimir2" id="imprimir2"  onclick="window.open('impressao.php?numero=<?php echo "$row->numero";?>&t=0','_blank')" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
              <!--<img src="icones/pesquisar.png" border="0" title="Impress�o 2" onclick="window.open('impressao.php?numero=<?php echo "$r[numero]";?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">-->
              <?php
            }else{
              ?>
              &nbsp;
              <?php
            }
            ?>
          </td>
        </tr>
      </table>
      <BR>
      <span class="texto1">
        <b>* Para retirar o cabe�alho e o rodap� da Página acesse:</b><BR>
        1 - Arquivo/ Configurar Página;<BR>
        2 - Retire o conte�do dos campos Cabe�alho e Rodap�;<BR>
        3 - Clique em OK e fa�a a impress�o.<BR>
        ** Essa observa��o n�o sair� na impress�o, contanto que o bot�o Imprimir seja clicado.
      </span>
    </div>
   <?php
  }
}
?>
</body>
</html>
