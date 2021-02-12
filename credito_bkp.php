<?php
include_once ("inc/common.php");
include "inc/verifica.php";
include_once "inc/config.php";
if (!$_REQUEST['cliente_id']){
  ?>
  <script language="JavaScript" src="inc/scripts/isdate.js"></script>
  <script language="JavaScript">
    function VerificaInicial() {
      DiaInicial=document.escolhe.dia_inicial.value;
      MesInicial=document.escolhe.mes_inicial.value;
      AnoInicial=document.escolhe.ano_inicial.value;
      DataInicial=DiaInicial+"/"+MesInicial+"/"+AnoInicial;
      if (!isDate(DataInicial)) {
        alert("Data Inicial Inválida.");
        //document.escolhe.numeronext.focus();
      }
    }
    function VerificaFinal() {
      DiaFinal=document.escolhe.dia_final.value;
      MesFinal=document.escolhe.mes_final.value;
      AnoFinal=document.escolhe.ano_final.value;
      DataFinal=DiaFinal+"/"+MesFinal+"/"+AnoFinal;
      if (!isDate(DataFinal)) {
        alert("Data Final Inválida.");
        //document.escolhe.numeronext.focus();
      }
    }
  </script>
  <div id="credito">
    <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
      </tr>
      <tr>
        <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
          <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
            <tr>
              <td width="592" colspan="3" valign="top">
                <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                  <tr>
                    <td>
                      <table border ="0" widht="50%" height="50" class="texto1" align="center">
                        <tr>
                          <td colspan="2" align="center">Selecione o cliente:</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><BR><BR></td>
                        </tr>
                        <tr>
                          <td width="20%">CNPJ/CPF:</td>
                          <td width="80%">
                            <input type="text" size="20" name="clientecnpj_cc" maxlength="18" id="clientecnpj_cc" value="<?php echo $p['cgc'];?>" onfocus="this.select()" onkeyup="if (this.value.length>3){Acha1('listar.php','tipo=clientecnpj&valor='+this.value+'','listar_clientecnpj');}">
                            <BR>
                            <div id="listar_clientecnpj" style="position:absolute; z-index: 7000;"></div>
                          </td>
                        </tr>
                        <tr>
                          <td width="20%">Cliente:</td>
                          <td width="80%">
                            <input type="hidden" name="cliente_id" id="cliente_id">
                            <input type="text" size="60" name="cliente_cc" id="cliente_cc" onfocus="this.select()" onkeyup=" if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else if (tecla == '13'){ acerta_campos('credito','Conteudo','credito.php',true); }else { Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');}">
                            <BR>
                            <div id="listar_cliente" style="position:absolute; z-index: 7000;"></div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><BR><BR><BR></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center">
                            <input name="consultar" id="consultar" type="button" value="Consultar" onclick="acerta_campos('credito','Conteudo','credito.php',true);">
                            <input value="Voltar" name="Voltar" id="Voltar" type="button" onclick="Acha('inicio.php','','Conteudo');">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
      </tr>
    </table>
  </div>
  <?php
}else{
  $cod_cliente = $_REQUEST['cliente_id'];
  $acha_cli_vendedor = pg_query("Select nome from clientes where codigo='".$cod_cliente."'");

  $c = pg_fetch_array($acha_cli_vendedor);
  ?>
  <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
    <tr>
      <td><img src="images/spacer.gif" width="1" height="3"></td>
    </tr>
    <tr>
      <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
    </tr>
    <tr>
      <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
        <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
          <tr>
            <td width="592" colspan="3" valign="top">
              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                <tr>
                  <td>
                    <table align=center width="100%" class="texto1">
                      <tr>
                        <td align=center><h4>Cliente:<i> <b><?php echo $c['nome'];?></b></i></h4></td>
                      </tr>
                    </table>
                    <table border = "0" style="border: 1px #cccccc;" width="100%" class="texto1" cellspacing="2" cellpadding="2">
                      <?php
                      $data_hoje = date("m/d/Y");
                      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
                        $FiltroExtra = " and (cancelada=0) ";
                      }
                      $consulta = "select numero, valor, emissao, vencimento, pagamento from duplicatas where (vencimento < '$data_hoje') and (codigo_do_cliente = $cod_cliente) and (pago=0) $FiltroExtra order by vencimento";
                      $resultado = pg_query($db, $consulta);
                      $NumeroLinhas = pg_num_rows($resultado);
                      if ($NumeroLinhas<>"") {
                        ?>
                        <tr>
                          <td align="center"><b>Número:</b></td>
                          <td align="center"><b>Valor:</b></td>
                          <td align="center"><b>Emissão:</b></td>
                          <td align="center"><b>Vencimento:</b></td>
                        </tr>
                        <?php
                        while ($linha = pg_fetch_array($resultado)) {
                          if ($cor=="#EEEEEE"){ //COR 1
                              $cor = "#FFFFFF"; //COR 2
                          }else{
                              $cor = "#EEEEEE";
                          }
                          $contador++;
                          ?>
                          <tr bgcolor="<?php echo $cor;?>">
                            <td align="center"><?php echo $linha['numero'];?></td>
                            <td align="right"><?php echo number_format($linha['valor'], 2, ",", "."); ?></td>
                            <td align="center"><?php $Ano = substr($linha['emissao'], 0, 4); $Mes = substr($linha['emissao'], 5, 2); $Dia =substr($linha['emissao'], 8, 2); echo $Dia."/".$Mes."/".$Ano; ?></td>
                            <td align="center"><?php $Ano = substr($linha['vencimento'], 0, 4); $Mes = substr($linha['vencimento'], 5, 2); $Dia =substr($linha['vencimento'], 8, 2); echo $Dia."/".$Mes."/".$Ano; ?></td>
                          </tr>
                          <?php
                        }
                        ?>
                        <tr><td colspan="4" align="center">Foram encontradas <b><?php echo $contador;?></b> duplicatas em atraso.</td></tr>
                        <?php
                      }else{
                        ?>
                        <tr><td colspan="4" align="center"><BR><BR><b>Nenhuma duplicata encontrada.!</b><BR><BR><BR><BR></td></tr>
                        <?php
                      }
                      ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center"><input value="Voltar" name="Voltar" type="button" onclick="Acha('credito.php','','Conteudo');"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
    </tr>
  </table>
  <?php
}
?>
