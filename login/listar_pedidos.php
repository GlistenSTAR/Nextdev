<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<?php
if ($_REQUEST['acao']=="Excluir"){
  ?>
  <?php
}
if ($_REQUEST['data_inicial']){
  $DataInicial = $_REQUEST['data_inicial'];
}else{
  //$DataInicial = date("d/m/Y");
  $DataInicial = date("d/m/Y", mktime(0,0,0, date("m"), date("d")-7, date("Y"))); //Mês + 1
}
if ($_REQUEST['data_final']){
  $DataFinal = $_REQUEST['data_final'];
}else{
  $DataFinal = date("d/m/Y", mktime(0,0,0, date("m"), date("d"), date("Y"))); //Mês + 1
}
if ($pos=="ASC"){
  $pos1 = "ASC";
  $pos = "DESC";
}else{
  $pos1 = "DESC";
  $pos = "ASC";
}
if ($_REQUEST['ordem']){
  $Ordem = "order by $_REQUEST[ordem] $pos";
}else{
  $Ordem = "order by numero $pos1";
}
?>
<form name="listar">
  <div id="listar">
    <table width="100%" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td align="center"><b>Listagem de Pedidos</b></td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td height="214" valign="top" valign="top" width="750">
          <table width="100%" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
            <tr>
              <td width="100%" colspan="3" valign="top">
                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="texto1" align="center">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="1" cellpadding="1" class="texto1" valign="top">
                        <tr>
                          <td colspan="7" valign="top">
                            <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" class="texto1" valign="top">
                              <tr>
                                <td valign="top">Data Inicial:</td>
                                <td valign="top"><input name="data_inicial" id="data_inicial"  type="text" size="12" maxlength="20" value="<?php echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                                <td valign="top">Data Final:</td>
                                <td valign="top"><input name="data_final" id="data_final"  type="text" size="12" maxlength="20" value="<?php echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)"></td>
                                <td valign="top">Número:</td>
                                <td valign="top"><input name="numero_pedido" id="numero_pedido"  type="text" size="15" maxlength="20" value="<?php echo $_REQUEST['numero_pedido'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){window.open('impressao.php?numero='+document.listar.numero_pedido.value+'&t=1','_blank'); document.listar.numero_pedido.value='';}"></td>
                                <td valign="top" align="center">
                                  <!--
                                  <?php echo $_REQUEST['enviados'];?>
                                  Pedidos enviados:
                                  <input type="checkbox" name="enviados" id="enviados" value="">Sim
                                  </a>

                                 <img src='icones/enviado.png' width='13' height='13' align='center' onclick="if (document.listar.data_inicial.value){ Acha('listar_pedidos.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&enviados=1','Conteudo');}" name="enviados" value="enviados" style="border: 0pt none ; cursor: pointer;" title="Listar somente os enviados"><BR>
                                 Rascunhos
                                 -->
                                </td>
                                <td valign="top">
                                  <!--
                                  <img align="center" src="icones/filtrar.png" onclick="if (document.listar.data_inicial.value){ Acha('listar_pedidos.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&numero_pedido='+document.listar.numero_pedido.value+'','Conteudo');}" name="Incluir" value="Incluir" style="border: 0pt none ; cursor: pointer;" title="Clique aqui para localizar"><BR>
                                  -->
                                  <div id="cpanel">
                                    <div style="float: left;">
                                     	<div class="icon">
                                        <input type="button" name="Ok" value="Listar" border="0" id="Ok" style="width: 80px;"  onclick="if (document.listar.numero_pedido.value){window.open('impressao.php?numero='+document.listar.numero_pedido.value+'&t=1','_blank'); document.listar.numero_pedido.value=''; }else{ Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');}">
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="7"><hr></hr></td>
                        </tr>
                        <?php
                        if (($_REQUEST['data_inicial']) and ($_REQUEST['data_final'])){
                          $di = explode("/", $DataInicial);
                          $df = explode("/", $DataFinal);
                          $FiltroData = " and data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
                        }
                        if ($_REQUEST['numero_pedido']){
                          $NumeroPedido = " and numero='".$_REQUEST['numero_pedido']."' ";
                        }
                        if ($FiltroData){
                          if ($_REQUEST['enviados']){
                            $FiltroData = $FiltroData." and enviado=0";
                            $Tabela = "pedidos_internet_novo";
                            $Extra = "enviado, ";
                          }else{
                            $Tabela = "pedidos";
                          }
                          if ($_SESSION[codigo_empresa]<>"95"){
                            $lista = "Select numero, cgc, $Extra cliente, data, numero_nota, venda_efetivada, cancelado, nota, total_sem_desconto, total_com_desconto, desconto_cliente, numero_internet from $Tabela where codigo_vendedor > '-1' $FiltroData $NumeroPedido $Ordem";
                            $lista1 = pg_query("Select numero, cgc, $Extra cliente, data, numero_nota, venda_efetivada, cancelado, nota, total_sem_desconto, total_com_desconto, desconto_cliente, numero_internet from $Tabela where codigo_vendedor  > '-1' $FiltroData $NumeroPedido $Ordem");
                          }else{
                            $lista = "Select numero, cgc, vendedor, $Extra cliente, data, numero_nota, venda_efetivada, cancelado, nota, total_sem_desconto, total_com_desconto, desconto_cliente, numero_internet from $Tabela where codigo_vendedor in ('3','43','51','52') $FiltroData $NumeroPedido $Ordem";
                            $lista1 = pg_query("Select numero, cgc, vendedor, $Extra cliente, data, numero_nota, venda_efetivada, cancelado, nota, total_sem_desconto, total_com_desconto, desconto_cliente, numero_internet from $Tabela where codigo_vendedor in ('3','43','51','52') $FiltroData $NumeroPedido $Ordem");
                          }
                          //echo $lista;
                          $ccc = pg_num_rows($lista1);
                          $total_reg = "20";
                          $pagina = $_REQUEST['pagina'];
                          if (!$pagina){
                            $inicio = "0";
                            $pc = "1";
                            $pagina = 1;
                          }else{
                            if (is_numeric($pagina)){
                              $q_pagina = $ccc / $pagina;
                              if ($pagina>$q_pagina){
                                $pagina = 1;
                              }
                            }else{
                              $pagina = 1;
                            }
                            $pc = $pagina;
                            $inicio = $pc - 1;
                            $inicio = $inicio * $total_reg;
                          }
                          $sql = "$lista  LIMIT $total_reg OFFSET $inicio";
                          $not1  = pg_query($sql);
                          ?>
                          <tr>
                            <td width="60"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=numero&pos=<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Numero</b>&nbsp;<img src="icones/<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="40"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=data&pos=<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b>&nbsp;<img src="icones/<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="230"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=cliente&pos=<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Cliente</b>&nbsp;<img src="icones/<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <?php
                            if ($_SESSION['codigo_empresa']=="95"){
                              ?>
                              <td width="70" align="right"><b>Vendedor</b></td>
                              <?php
                            }
                            ?>
                            <td width="70" align="right"><b>Valor total</b></td>
                            <td width="40" align="center">&nbsp;&nbsp;&nbsp;&nbsp;<b>Status</b></td>
                            <td width="20" align="center">&nbsp;</td>
                          </tr>
                          <?php
                          while ($r = pg_fetch_array($not1)){

                            if ($Cor=="#EEEEEE"){
                              $Cor="#FFFFFF";
                            }else{
                              $Cor="#EEEEEE";
                            }
                            if ($r[numero_internet]){
                              $Cor="#FFFFC0";
                            }
                            ####################################################
                            # Verificando Status
                            ####################################################
                            if ($r['venda_efetivada'] == 0) {
                              $Status = "<font color=#FF8000>Pendente</font>";
                            }
                            if ($r['venda_efetivada'] != 0 and $r['nota'] == 0) {
                              $Status = "<font color=green>Aprovado<font>";
                            }
                            if ($r['nota'] == 1) {
                              if ($r['numero_nota'] or $r['numero_nota'] != '') {
                                if ($row->entregue != 0)  {
                                  $Status = "Entregue";
                                }else{
                                  $Status = "<font color=green><b>Faturado</b></font>";
                                }
                              }
                            }
                            if ($r['cancelado'] != 0) {
                              $Status = "<font color=red>Cancelado</font>";
                            }
                            if (!$r['numero_internet']){
                              $Numero = $r['numero'];
                            }else{
                              $Numero = $r['numero_internet'];
                            }
                            if ($_SESSION['codigo_empresa']<>"95"){
                              $LinkPedido =  "title='Clique para editar o pedido' onclick=\"Acha('cadastrar_pedidos.php','localizar_numero=$Numero','Conteudo'); $Desativa\"";
                            }else{
                              $LinkPedido =  " $Desativa\"";
                            }
                            ?>
                            <tr bgcolor="<?php echo $Cor;?>" onMouseover="this.style.backgroundColor='lightblue';"  onMouseout="this.style.backgroundColor='<?php echo $Cor;?>';" style="border: 0pt none ; cursor: pointer;">
                              <td valign="top" <?php echo $LinkPedido;?>>
                                <?php
                                if ($r['enviado']=="1"){
                                  $Status = "<img src='icones/enviado.png' width='13' height='13' align='center' title='Pedido já enviado, não é possível editar'>";
                                  ?>
                                  <a title='Pedido já enviado, não é possível editar'><?php echo $r['numero'];?></a>
                                  <?php
                                }else{
                                  echo $r['numero'];
                                }
                                ?>
                              </td>
                              <td valign="top" <?php echo $LinkPedido;?>>
                                <?php
                                $da = $r['data'];
                                $d = explode("-", $da);
                                echo "".$d[2]."/".$d[1]."/".$d[0]."";
                                ?>
                              </td>
                              <td valign="top" <?php echo $LinkPedido;?>>
                                <?php echo $r['cliente'];?>
                              </td>
                              <?php
                              if ($_SESSION['codigo_empresa']=="95"){
                                ?>
                                <td valign="top" align="right" <?php echo $LinkPedido;?>>
                                  <?php echo $r['vendedor'];?>
                                </td>
                                <?php
                              }
                              ?>
                              <td valign="top" align="right" <?php echo $LinkPedido;?>>
                                <?php
                                echo number_format($r['total_sem_desconto'], 2, ",", ".");
                                $SomaValorTotal += $r['total_sem_desconto'];
                                ?>
                              </td>
                              <td align="center" <?php echo $LinkPedido;?>>
                                <?php
                                echo $Status;
                                if ($Status=="Cancelado"){
                                  ?>
                                  </td><tr><td colspan=5>Motivo Cancelamento: <font color=red><?php echo $r['motivo_cancelamento'];?></font>
                                  <?php
                                }
                                ?>
                              </td>
                              <td valign="top" align="center" width="13" onclick="window.open('impressao.php?numero=<?php echo $r['numero'];?>&t=1','_blank'); " style="border: 0pt none ; cursor: pointer;">
                                <img src="icones/pesquisar.gif" border="0" title="Consulta / Impressão" align="center">
                              </td>
                            </tr>
                            <?php
                            if ($pagina){
                              if (!$qtd_registros){
                                $qtd_registros = $qtd_registros + $inicio + 1;
                              }else{
                                $qtd_registros = $qtd_registros +  1;
                              }
                            }
                          }
                        }
                        ?>
                        <tr>
                          <td colspan="3" valign="top" height="100%">
                            &nbsp;
                          </td>
                          <td valign="top" align="right">
                            <b>Total:</b>
                          </td>
                          <td valign="top" align="right" valign="top" height="100%">
                            <?php
                            if ($SomaValorTotal){
                              echo "<b>".number_format($SomaValorTotal, 2, ",", ".")."</b>";
                            }
                            ?>
                          </td>
                          <td colspan="2" valign="top" height="100%">
                            &nbsp;
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" valign="top" height="100%">
                            &nbsp;
                            <?php
                            if ($_SESSION['erro']){
                              //echo $_SESSION[erro];
                              $_SESSION['erro'] = "";
                            }
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" colspan="7">
                            <table width="100%" border="0" class="texto1">
                              <?php
                              if ($ccc<>""){
                                ?>
                                <tr>
                                  <td height="25" align="center">
                                   <hr>
                                  <?php
                                  $anterior = $pc -1;
                                  $proximo = $pc +1;
                                  $qtd_paginas = $ccc / $total_reg;
                                  $ultima_pagina = $pc + 6;
                                  $primeira_pagina = $pc - 6;
                                  $anterior = $pc -1;
                                  $proximo = $pc +1;
                                  if ($pc>1) {
                                    echo "<a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                                    echo "  |  ";
                                  }else{
                                      echo " <- Anterior ";
                                      echo "  |  ";
                                  }
                                  for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                                    echo "<a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$p&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
                                    if ($pc==$p){
                                      echo "<strong>";
                                    }
                                    if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
                                      echo $p."&nbsp;";
                                    }else{
                                      if (!$ret){
                                        echo "...";
                                        $ret = true;
                                      }
                                    }
                                    if ($pc==$p){
                                      echo "</strong>";
                                    }
                                    echo "</a>";
                                  }
                                  $fim = $ccc / $total_reg;
                                  if ($pc<$fim) {
                                      echo " | ";
                                      echo " <a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
                                  }else{
                                      echo " | ";
                                      echo " Próxima ->";
                                  }
                                  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="25" align="center" valign="top"><div>
                                    <?php
                                    echo "<div>Mostrando registro <strong>";
                                    echo $inicio + 1;
                                    echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong></div>";
                                    ?>
                                    </div>
                                  </td>
                                </tr>
                                <?php
                              }
                              ?>
                           </table>
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
    </table>
  </div>
</form>
<?php
$_SESSION['pagina'] = "listar_pedidos.php";
?>
