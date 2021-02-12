<?php
session_start();
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
    font-size: 12px;
    color: #182463;
  }
  .texto1{
    color: #000000;
    font-size: 10px;
  }
  .texto2{
    color: #404040;
    font-size: 10px;
    background-color: #F7F7F7;
  }
  .titulo{
    color: #182463;
    font-size: 10px;
    font-weight: bold;
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
<?php
###################################
##Fazendo a conexão com o servidor
###################################
include "inc/config.php";

###################################
# Variavel numero pedido no next (ja gravado)
###################################
$num = explode("%", $_REQUEST[numero]); //Retiro o final do numero se tiver espaço ou qualquer outro caracter
$numero = $num[0];
if (($numero == "") or ($_REQUEST[t]>1) or ($_REQUEST[t]<0)){
   //include "pedido_invalido2.php";
}else{
  $consulta = "select * from pedidos_internet_novo where numero = ".$numero;

  $resultado = pg_query($db, $consulta) or die("Erro na consulta : ".$consulta.pg_last.error($db));
  $NumeroLinhas = pg_num_rows($resultado);
  if ($NumeroLinhas == 0) {  # (2)
    //include "pedido_invalido.php";
  }else{
    $row = pg_fetch_object($resultado, 0);
    if ($row->codigo_vendedor!=$_SESSION[id_vendedor]) {
      if ($_SESSION[nivel]<2){
        exit;
      }
    }
    $TbVendedor = "SELECT nome FROM vendedores WHERE codigo = ".$row->codigo_vendedor;
    $TbVendedor = pg_query($db, $TbVendedor) or die("Erro na consulta : ".$TbVendedor.pg_last.error($db));
    $Vend = pg_fetch_object($TbVendedor, 0);
    $Vendedor = $Vend->nome;
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
    $AnoEntr = substr($row->data_prevista_entrega, 0, 4)."&nbsp;&nbsp;";
    $MesEntr = substr($row->data_prevista_entrega, 5, 2)."&nbsp;&nbsp;&nbsp;&nbsp;";
    $DiaEntr = substr($row->data_prevista_entrega, 8, 2)."&nbsp;&nbsp;";
    ########################################
    # Dados dos clientes  criado 20/01/2005
    ########################################
    $TbCliente = "SELECT endereco_numero,endereco,telefone,cidade,cep,bairro,apelido, codigo FROM clientes WHERE id = ".$id;
    $TabCliente = pg_query($db, $TbCliente) or die("Erro na consulta : ".$TbCliente.pg_last.error($db));
    $Cliente = pg_fetch_object($TabCliente, 0);
    ########################################
    $Cliente_Endereco = "$Cliente->endereco $Cliente->endereco_numero";
    $Cliente_Telefone = $Cliente->telefone;
    $Cliente_Cidade = $Cliente->cidade;
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
        $NOTASFISCAIS = "select entregue, data_emissao, data_saida from notas1 where numero_nota = ".$row->numero_nota;
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
    <table border="0" width="630" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td valign="top">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top" width="200">
                 <img src="images/<?=$CONF['logotipo_empresa']?>">
              </td>
              <td align="center" width="100%" class="titulo">
                <h3><b>ORÇAMENTO DE VENDAS <i>ON-LINE</i></h3>
              </td>
              <td>
                <td width="350" align="right" width="175">
                  <?
                    if ($CONF['logotipo_report']){
                  ?>
                    <img src="images/<?=$CONF['logotipo_report']?>">
                  <?
                }
                ?>
              </td>
            </tr>
          </table>
          <table border="0">
            <tr>
              <td align="left" colspan="2" valign="top">
                <fieldset id="titulo-frame">
                  <legend>Dados Cliente</legend>
                  <table border="0" class="texto1">
                    <tr>
                      <td width="100" class="titulo">Cliente :</td>
                      <td width="370"><? echo $row->cliente; ?><?=($CodigoEmpresa=="75")?" - $Cliente->codigo":""; ?></td>
                      <td width="100" class="titulo">CNPJ/CPF :</td>
                      <td width="100"><? echo $row->cgc; ?></font></td>
                    </tr>
                    <tr>
                      <td class="titulo">Endereço : </td>
                      <td><? echo $Cliente_Endereco; ?></td>
                      <td class="titulo">CEP :</td>
                      <td><? echo $Cliente_CEP; ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Cidade : </td>
                      <td><? echo $Cliente_Cidade; ?></td>
                      <td class="titulo">Telefone :</td>
                      <td><? echo $Cliente_Telefone; ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Bairro : </td>
                      <td><? echo $Cliente_Bairro; ?></td>
                      <td class="titulo">Apelido :</td>
                      <td><? echo $Cliente_Apelido; ?></td>
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
                  <table border="0" class="texto1">
                    <tr>
                      <td width="60" class="titulo">Número : </td>
                      <td width="100"><? echo $row->numero; ?></td>
                      <td width="60" class="titulo">Vendedor :</td>
                      <td width="200"><? echo $Vendedor; ?></td>
                      <td width="60" class="titulo">Desconto :</td>
                      <td width="100" align="right"><? echo number_format($row->desconto_pedido, 2, ",", "."); ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Data :</td>
                      <td><? echo $Dia."/".$Mes."/".$Ano; ?></td>
                      <td class="titulo">Cond Pag. :</td>
                      <?
                      #############################################################
                      # Coloca condicao de pagamento referente ao codigo do pagamento
                      #############################################################
                      if ($_REQUEST[t]=="0"){
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
                      <td width="100"><? echo $cp->descricao; ?></td>
                      <td width="100" class="titulo">Data Entrega :</td>
                      <td width="100"><? echo $DiaEntr."/".$MesEntr."/".$AnoEntr; ?></td>
                    </tr>
                    <tr>
                      <td class="titulo">Transport. :</td>
                      <td colspan="3"><? echo $row->transportadora; ?></td>
                      <td class="titulo">Status :</td>
                      <td><? echo $Status;?></td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>
          </table>
          <?
          # if ($Status != "Pendente" and $Status != "Aprovado") {
          if ($Status != "Pendente")  {
             ?>
             <table border = "0" class="texto1" width="630" align="center">
               <tr>
                 <td width="210" colspan="2"><span class="titulo">Nota :</span> <? echo $row->numero_nota;?>
                 <?
                 if ($Status != "Aprovado") {
                    ?>
                    <td width="210"><span class="titulo">Data Saida :</span> <? echo $DiaSaida."/".$MesSaida."/".$AnoSaida; ?>
                    <td width="230"><span class="titulo">Data Emissao :</span> <? echo $DiaEmissao."/".$MesEmissao."/".$AnoEmissao; ?>
                    <?
                 }
                 ?>
               </tr>
             </table>
             <?
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
                            <td width="370" class="titulo"<?if ($_REQUEST[t]=="0"){echo " colspan='2' ";}?>> Nome  </td>
                            <td width="65" align="right" class="titulo">QTD  </td>
                            <td width="40" align="right" class="titulo"> Unit. </td>
                            <?
                            if ($_REQUEST[t]=="1"){
                              ?>
                              <td width="30" align="right" class="titulo"> Ipi </td>
                              <?
                            }
                            ?>
                            <td width="60" align="right" class="titulo"> Total </td>
                          </tr>
                          <?php
                          #########################################################################
                          # Fazendo uma consulta SQL e retornando os resultados em uma tabela HTML
                          #########################################################################
                          $totalipi = 0;
                          $consulta = "select * from itens_do_pedido_internet where numero_pedido = '".trim($numero)."' and especial <>$_REQUEST[t]";
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
                            <tr class="texto<? echo $Classe;?>">
                              <td style="border: 1px solid #cccccc;"><? echo $linha['codigo']; ?></td>
                              <td style="border: 1px solid #cccccc;"<?if ($_REQUEST[t]=="0"){echo " colspan='2' ";}?>><? echo $linha['nome_do_produto']; ?></td>
                              <td align="right" style="border: 1px solid #cccccc;"><? echo $linha['qtd']; ?></td>
                              <td align="right" style="border: 1px solid #cccccc;"><? echo number_format($linha['valor_unitario'], 2, ",", ".") ; ?></td>
                              <?
                              if ($_REQUEST[t]=="1"){
                                ?>
                                <td align="right" style="border: 1px solid #cccccc;"><? echo number_format($linha['valor_ipi'], 2, ",", ".") ; ?></td>
                                <?
                              }
                              ?>
                              <td align="right" style="border: 1px solid #cccccc;"><? echo number_format($linha['valor_total'], 2, ",", ".") ; ?></td>
                            </tr>
                            <?
                            ############################################################
                            #Calculo do Total se considerar o pedido com parte especial
                            ############################################################
                            $totalprodutos = $totalprodutos + ($linha['qtd'] * $linha['valor_unitario']);

                            if ($_REQUEST[t]=="1"){
                              $totalipi = $totalipi + $linha['valor_ipi'];
                              $totalgeral = $totalgeral + ($linha['valor_ipi'] + ($linha['qtd'] * $linha['valor_unitario']));
                            }else{
                              $totalgeral = $totalgeral + (($linha['qtd'] * $linha['valor_unitario']));
                            }
                            
                            $PesoBruto = $PesoBruto + $linha[peso_bruto];
                            $PesoLiquido = $PesoLiquido + $linha[peso_liquido];
                            ### CORES
                            //preto, branco, azul, verde, vermelho, amarelo, marrom, cinza, laranja, rosa, violeta,bege, outra
                            $SomaPreto = $SomaPreto + $linha[preto];
                            $SomaBranco = $SomaBranco + $linha[branco];
                            $SomaAzul = $SomaAzul + $linha[azul];
                            $SomaVerde = $SomaVerde + $linha[verde];
                            $SomaVermelho = $SomaVermelho + $linha[vermelho];
                            $SomaAmarelo = $SomaAmarelo + $linha[amarelo];
                            $SomaMarrom = $SomaMarrom + $linha[marrom];
                            $SomaCinza = $SomaCinza + $linha[cinza];
                            $SomaLaranja = $SomaLaranja + $linha[laranja];
                            $SomaRosa = $SomaRosa + $linha[rosa];
                            $SomaVioleta = $SomaVioleta + $linha[violeta];
                            $SomaBege = $SomaBege + $linha[bege];
                            $SomaOutra = $SomaOutra + $linha[outra];
                          }
                          ?>
                          <tr>
                            <td colspan="6"><hr></hr></td>
                          </tr>
                          <tr>
                            <td align=left colspan="3">
                            <span class="titulo">Peso bruto :</span>
                              <? echo number_format($PesoBruto, 2, ",", "."); ?>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <span class="titulo">Peso líquido :</span> <? echo number_format($PesoLiquido, 2, ",", "."); ?>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <span class="titulo">IPI (A):</span>
                              <? echo number_format($totalipi, 2, ",", "."); ?>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <span class="titulo">Produtos (B):</span>
                              <? echo number_format($totalprodutos, 2, ",", "."); ?>
                            </td>
                            <td align=right class="titulo" colspan="2">Total (A + B):</td>
                            <td align=right><? echo number_format($totalgeral, 2, ",", "."); ?> </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <?
                  // Se tiver CORES
                  //echo "tem cores: $row->especificado";
                  if ($row->especificado<>"0"){
                    ?>
                    <table border="0">
                      <tr>
                        <td align="left" colspan="2">
                          <fieldset id="titulo-frame">
                            <legend>Cores</legend>
                            <table border="0" class="texto1">
                              <tr class="texto1">
                                <td width="100" class="titulo"> Preto: </td>
                                <td width="100"><? echo $SomaPreto; ?></td>
                                <td width="100" class="titulo"> Branco:</td>
                                <td width="200"><? echo $SomaBranco; ?></td>
                                <td width="100" class="titulo"> Azul:</td>
                                <td width="100"><? echo $SomaAzul ?></td>
                                <td class="titulo"> Verde:</td>
                                <td><? echo $SomaVerde; ?></td>
                              </tr>
                              <tr class="texto2">
                                <td class="titulo">Vermelho :</td>
                                <td width="100"><? echo $SomaVermelho; ?></td>
                                <td width="100" class="titulo"> Amarelo:</td>
                                <td width="100"><? echo $SomaAmarelo; ?></td>
                                <td class="titulo"> Cinza:</td>
                                <td><? echo $SomaCinza; ?></td>
                                <td class="titulo">Laranja :</td>
                                <td width="100"><? echo $SomaLaranja; ?></td>
                              </tr>
                              <tr class="texto1">
                                <td width="100" class="titulo"> Rosa:</td>
                                <td width="100"><? echo $SomaRosa; ?></td>
                                <td class="titulo"> Violeta:</td>
                                <td><? echo $SomaVioleta; ?></td>
                                <td class="titulo">Bege :</td>
                                <td width="100"><? echo $SomaBege; ?></td>
                                <td width="100" class="titulo"> Marrom:</td>
                                <td width="100"><? echo $SomaMarrom; ?></td>
                              </tr>
                              <tr class="texto2">
                                <td width="100" class="titulo"> Outra:</td>
                                <td width="100"><? echo $SomaOutra; ?></td>
                              </tr>
                            </table>
                          </fieldset>
                        </td>
                      </tr>
                    </table>
                    <?
                  }
                  ?>
                </fieldset>
              </td>
            </tr>
            <tr>
              <td>
                <table border="0" class="texto1">
                  <tr>
                    <td width="100" class="titulo">Observação:</td>
                    <td colspan=4 width="250">
                    <?
                    $obss = "select * from observacao_do_pedido where numero_pedido = ".trim($numero);
                    $oba = pg_query($db,$obss) or die("Erro na consulta : $obss. " .pg_last_error($db));
                    $obs = pg_fetch_array($oba);

                    echo $obs["observacao"];
                    ?>
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
            <?
            if (($row->desconto_cliente) and ($_REQUEST[t]>0)){
              ?>
              <input type="button" value="Impressão 2" name="imprimir2" id="imprimir2"  onclick="window.open('impressao2.php?numero=<? echo "$row->numero";?>&t=0','_blank')" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
              <?
            }else{
              ?>
              &nbsp;
              <?
            }
            ?>
          </td>
        </tr>
      </table>
      <BR>
      <span class="texto1">
        <b>* Para retirar o cabeçalho e o rodapé da página acesse:</b><BR>
        1 - Arquivo/ Configurar página;<BR>
        2 - Retire o conteúdo dos campos Cabeçalho e Rodapé;<BR>
        3 - Clique em OK e faça a impressão.<BR>
        ** Essa observação não sairá na impressão se o botão Imprimir for clicado.
      </span>
    </div>
   <?
  }
}
?>
</body>
</html>
