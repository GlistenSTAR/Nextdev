<?php
include ("inc/common.php");
include "inc/verifica.php";
include_once "inc/config.php";

$DtDia = date("Y-m-d");

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
  
  
  #################################################
  #########Rotina nova Dênis: 24/02/2014 ##########
  #################################################
  
  //Limite de Crédito
  $SqlLimite = pg_query("SELECT nome, limite_credito FROM clientes WHERE id ='".$_REQUEST['cliente_id']."'");
  $Limite = pg_fetch_array($SqlLimite);  
  //echo "Limite:".number_format($Limite[limite_credito],2,',','.')."<br>";
  
  //Duplicatas Vencidas
  $SqlDuli = pg_query("SELECT Sum(valor) as dup FROM duplicatas WHERE vencimento < '$DtDia' AND pagar <> 1 AND pago = 0 AND codigo_do_cliente = '".$_REQUEST['cliente_id']."'");
  $DupliVenc = pg_fetch_array($SqlDuli);
  //echo "Dup. Venc.:".number_format($DupliVenc[dup],2,',','.')."<br>";
  
  //Duplicatas em Aberto
  $SQlDupli = pg_query("SELECT Sum(valor) as dup FROM duplicatas WHERE vencimento >= '".$DtDia."' AND pagar <> 1 AND pago = 0 AND codigo_do_cliente = '".$_REQUEST['cliente_id']."'");
  $DupliAb = pg_fetch_array($SQlDupli);
  //echo "Dup. AB.".number_format($DupliAb[dup],2,',','.')."<br>";
  
  //Pagamento 30 dias
  $Sql30D = pg_query("SELECT Sum(valor) as dup FROM duplicatas WHERE pagamento >= '".date("Y-m-d", strtotime("-30 days"))."' AND pagar <> 1 AND pago = 1 AND codigo_do_cliente ='".$_REQUEST['cliente_id']."' ");
  $Pag30 = pg_fetch_array($Sql30D);  
  //echo "30 Dias:".number_format($Pag30[dup],2,',','.')."<br>";
  
  
  //Pagamento 60 dias
  $Sql60D = pg_query("SELECT Sum(valor) as dup FROM duplicatas WHERE pagamento >= '".date("Y-m-d", strtotime("-60 days"))."' AND pagar <> 1 AND pago = 1 AND codigo_do_cliente ='".$_REQUEST['cliente_id']."' ");
  $Pag60 = pg_fetch_array($Sql60D);  
  //echo "60 Dias:".number_format($Pag60[dup],2,',','.')."<br>";  
  
  //Pagamento 90 dias
  $Sql90D = pg_query("SELECT Sum(valor) as dup FROM duplicatas WHERE pagamento >= '".date("Y-m-d", strtotime("-90 days"))."' AND pagar <> 1 AND pago = 1 AND codigo_do_cliente ='".$_REQUEST['cliente_id']."' ");
  $Pag90 = pg_fetch_array($Sql90D);  
  //echo "60 Dias:".number_format($Pag90[dup],2,',','.')."<br>";    
  
  //Pedidos não efetivados    
  $SqlNEfet = pg_query("SELECT sum(total_com_desconto) as total_pedidos FROM pedidos WHERE numero IN (SELECT numero FROM pedidos WHERE venda_efetivada = 0 AND cancelado = 0 AND outros = 0 AND id_cliente = '".$_REQUEST['cliente_id']."')");  
  $NEfet = pg_fetch_array($SqlNEfet);  
  //echo "pedidos:".number_format($NEfet[total_pedidos],2,',','.')."<br>";
  
  //Saldo Livre
   $Livre = number_format($Limite[limite_credito] - $DupliVenc[dup] - $DupliAb[dup] - $NEfet[total_pedidos],2,',','.');
  
  #################################################
  #########Fim Rotina nova               ##########
  #################################################  
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
                        <td align="left"><h3>Cliente:<i> <b><?php echo $c['nome'];?></b></i></h3></td>
                      </tr>
                    </table>
                    
                    <table align="center" width="592px" border="0" cellpadding="0" cellspacing="0" class="texto1">
                      <tr>
                        <td width="25%">Limite de Crédito:</td>
                        <td colspan="3"><b>R$<?php echo number_format($Limite['limite_credito'],2,',','.');?></b></td>                       
                      </tr> 
                      <tr>
                        <td colspan="4"><hr></td>                        
                      </tr>                       
                      <tr>
                        <td width="25%">Duplicatas em Aberto:</td>
                        <td width="25%"><b>R$<?php echo number_format($DupliAb['dup'],2,',','.');?></b></td>                       
                        <td width="25%">Duplicatas Vencidas:</td>
                        <td width="25%"><b>R$<?php echo number_format($DupliVenc['dup'],2,',','.');?></b></td>                       
                      </tr>  
                      <tr>
                        <td colspan="4"><hr></td>                        
                      </tr>  
                      <tr>
                        <td colspan="4"><h3>Totais Pagos</h3></td>                 
                      </tr>    
                      <tr>
                        <td width="25%">30 Dias: <b>R$<?php echo number_format($Pag30['dup'],2,',','.');?></b></td>
                        <td width="25%">60 Dias: <b>R$<?php echo number_format($Pag60['dup'],2,',','.');?></b></td>
                        <td width="25%">90 Dias: <b>R$<?php echo number_format($Pag90['dup'],2,',','.');?></b></td>
                        <td width="25%"></td>
                      </tr> 
                      <tr>
                        <td colspan="4"><hr></td>                        
                      </tr>  
                      <tr>
                        <td width="25%">Pedidos N. Efetivados:</td>
                        <td width="25%"><b>R$<?php echo number_format($NEfet['total_pedidos'],2,',','.');?></b></td>                       
                        <td width="25%" bgcolor="#EEEEEE">Saldo Livre:</td>
                        <td width="25%" bgcolor="#EEEEEE"><b><font color="red">R$<?php echo $Livre;?></font></b></td>                       
                      </tr>   
                      <tr>
                        <td colspan="4"><hr></td>                        
                      </tr>                        
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
