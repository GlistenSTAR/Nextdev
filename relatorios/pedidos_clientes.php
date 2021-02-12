<?php
include ("../inc/common.php");
include "../inc/verifica.php";
include "../inc/config.php";
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
  $DataInicial = date("d/m/Y", mktime(0,0,0, date("m")-1, date("d"), date("Y"))); //Mês + 1
}
if ($_REQUEST['data_final']){
  $DataFinal = $_REQUEST['data_final'];
}else{
  $DataFinal = date("d/m/Y", mktime(0,0,0, date("m")+1, date("d"), date("Y"))); //Mês + 1
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
  $Ordem = "order by numero $pos";
}
?>
<form name="listar">
  <div id="listar">
    <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td align="center">
          <b>Listagem de pedidos por cliente</b>
        </td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
      </tr>
      <tr>
        <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
          <table width="580" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
            <tr>
              <td width="580" colspan="3" valign="top">
                <table width="580" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                  <tr>
                    <td>
                      <table width="580" border="0" cellspacing="1" cellpadding="0" class="texto1" valign="top">
                        <tr>
                          <td colspan="7" valign="top">
                            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" valign="top">
                              <tr>
                                <td>Cliente:</td>
                                <td>
                                  <input type="hidden" name="pedidos_clientes_id" id="pedidos_clientes_id" value="<?php echo $_REQUEST['pedidos_clientes_id'];?>">
                                  <input type="text" title="Digite o nome do cliente que deseja procurar." size="40" name="pedidos_clientes_cc" id="pedidos_clientes_cc" value="<?php echo $_REQUEST['pedidos_clientes_cc'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');}else{if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else { if (this.value.length>3){Acha1('listar.php','tipo=pedidos_clientes&valor='+this.value+'','listar_pedidos_clientes');}}}">
                                  <BR>
                                  <div id="listar_pedidos_clientes" style="position:absolute; z-index: 7000;"></div>
                                </td>
                                <td valign="top" nowrap>Data Inicial:</td>
                                <td valign="top"><input name="data_inicial" id="data_inicial"  type="button" size="12" maxlength="20" value="<?php echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                              </tr>
                              <tr>
                                <td valign="top">Número:</td>
                                <td valign="top"><input name="numero_pedido" id="numero_pedido"  type="text" size="15" maxlength="20" value="<?php echo $_REQUEST['numero_pedido'];?>"></td>
                                <td valign="top" nowrap>Data Final:</td>
                                <td valign="top"><input name="data_final" id="data_final"  type="button" size="12" maxlength="20" value="<?php echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)"></td>
                                <td valign="top">
                                  <div id="cpanel">
                                    <div style="float: left;">
                                     	<div class="icon">
                                        <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 20px; height: 16px;"  onclick="listarpedidos('pedidos_clientes');">
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
                          $Filtro = " and data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
                        }
                        if ($_REQUEST['numero_pedido']){
                          $NumeroPedido = " and numero='".$_REQUEST['numero_pedido']."' ";
                        }
                        if ($_REQUEST['pedidos_clientes_id']){
                          $Filtro .= " and id_cliente='".$_REQUEST['pedidos_clientes_id']."'";
                        }
                        
                        if ($Filtro){
//                          if ($_REQUEST[tipo]=="rascunhos"){
//                            $lista = "Select numero, cgc, cliente, data, total_com_desconto, desconto_cliente from pedidos_internet_novo where codigo_vendedor = '".$_SESSION['id_vendedor']."' and enviado=0 $Filtro $NumeroPedido $Ordem";
//                          }else{
                            if (($_SESSION['login']=="LAILA") AND ($_SESSION['nivel']=="2")){
                              $lista = "Select numero, cgc, cliente, data, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, desconto_cliente from pedidos where 1=1 $Filtro $NumeroPedido $Ordem";
                            }else{
                              if($_SESSION['id_vendedor']=="77"){ //Regra Groupack  
                                 $lista = "Select numero, cgc, cliente, data, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, desconto_cliente from pedidos where codigo_vendedor = '87' $Filtro $NumeroPedido $Ordem";
                              }else{
                                 $lista = "Select numero, cgc, cliente, data, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, desconto_cliente from pedidos where codigo_vendedor = '".$_SESSION['id_vendedor']."' $Filtro $NumeroPedido $Ordem";
                              }
                            }    

                            if($_SESSION['codigo_empresa']<> "2"){ //se não for groupack
                              if ($_SESSION['nivel']=="2"){
                                $lista = "Select numero, cgc, cliente, data, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, desconto_cliente from pedidos where 1=1 $Filtro $NumeroPedido $Ordem";
                              }else{
                                $lista = "Select numero, cgc, cliente, data, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, desconto_cliente from pedidos where codigo_vendedor = '".$_SESSION['id_vendedor']."' $Filtro $NumeroPedido $Ordem";
                              }
                            }
                            
//                          }
                          $lista1 = pg_query($lista);
                          //echo $lista;
                          $ccc = pg_num_rows($lista1);
                          $total_reg = "15";
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
                          //echo $sql;
                          $not1  = pg_query($sql);
                          ?>
                          <tr>
                            <td width="60"><a href='#' onclick="Acha('relatorios/pedidos_clientes.php','pagina=<?php echo $pagina;?>&pedidos_clientes_id=<?php echo $_REQUEST['pedidos_clientes_id']?>&pedidos_clientes_cc=<?php echo $_REQUEST['pedidos_clientes_cc']?>&ordem=numero&pos=<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Numero</b><img src="icones/<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="40"><a href='#' onclick="Acha('relatorios/pedidos_clientes.php','pagina=<?php echo $pagina;?>&pedidos_clientes_id=<?php echo $_REQUEST['pedidos_clientes_id']?>&pedidos_clientes_cc=<?php echo $_REQUEST['pedidos_clientes_cc']?>&ordem=data&pos=<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b><img src="icones/<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="230"><a href='#' onclick="Acha('relatorios/pedidos_clientes.php','pagina=<?php echo $pagina;?>&pedidos_clientes_id=<?php echo $_REQUEST['pedidos_clientes_id']?>&pedidos_clientes_cc=<?php echo $_REQUEST['pedidos_clientes_cc']?>&ordem=cliente&pos=<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Cliente</b><img src="icones/<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="70"><b>Valor(1+2)</b></td>
                            <td width="30"><b>Status</b></td>
                            <td width="25"><b>Consultar</b></td>
                          </tr>
                          <tr>
                            <td colspan="7"><hr></hr></td>
                          </tr>
                          <?php
                          while ($r = pg_fetch_array($not1)){

                            if ($Cor=="#EEEEEE"){
                              $Cor="#FFFFFF";
                            }else{
                              $Cor="#EEEEEE";
                            }
                            ####################################################
                            # Verificando Status
                            ####################################################
                            if ($r['venda_efetivada'] == 0) {
                               $Status = "Pendente";
                            }
                            if ($r['venda_efetivada'] != 0 and $r['nota'] == 0) {
                               $Status = "Aprovado";
                            }
                            if ($r['nota'] == 1) {
                               if ($r['numero_nota'] or $r['numero_nota'] != '') {
                                  $NOTASFISCAIS = "select entregue from notas1 where numero_nota = ".$r['numero_nota'];
                                  $notas1 = @pg_query($db, $NOTASFISCAIS);
                                  $row = @pg_fetch_object($notas1, 0);
                                  if ($row->entregue != 0)  {
                                     $Status = "Entregue";
                                  }
                                  else {
                                       $Status = "Faturado";
                                  }
                               }
                            }
                            if ($r['cancelado'] != 0) {
                               $Status = "Cancelado";
                            }
                            ?>
                            <tr bgcolor="<?php echo $Cor;?>" onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '<?php echo $Cor;?>'">
                              <td valign="top">
                                <?php if ($_REQUEST['tipo']=="rascunhos"){?>
                                <a href="#" onclick="Acha('cadastrar_pedidos.php','localizar_numero=<?php echo $r['numero'];?>','Conteudo'); <?php echo $Desativa;?>" title="Clique para alterar o rascunho"><?php echo $r['numero'];?></a>
                                <?php }else{
                                     echo $r['numero'];
                                   }?>
                              </td>
                              <td valign="top">
                                <?php
                                $d = explode(" ", $r['data']);
                                $d = explode("-", $d[0]);
                                echo "".$d[2]."/".$d[1]."/".$d[0]."";
                                ?>
                              </td>
                              <td valign="top">
                                <?php echo $r['cliente'];?>
                              </td>
                              <td valign="top" align="right">
                                <?php echo number_format($r['total_com_desconto'], 2, ",", ".");?>
                              </td>
                              <td align="center">
                                <?php
                                if ($Status=="Cancelado"){
                                  echo " <font color=red>";
                                  echo $Status;
                                  echo "</font>";
                                  ?>
                                  </td><tr onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '#FFFFFF'"><td colspan=5>Motivo Cancelamento: <font color=red><?php echo $r['motivo_cancelamento'];?></font>
                                  <?php
                                }else{
                                  echo $Status;
                                }
                                ?>
                              </td>
                              <td valign="top" align="center" width="13">
                                <img src="icones/pesquisar.gif" border="0" title="Impressão 1" onclick="window.open('impressao.php?numero=<?php echo $r['numero'];?>&t=1','_blank')" style="border: 0pt none ; cursor: pointer;">
                              </td>
                              <!--
                              <td valign="top" align="center" width="13">
                                <?php
                                if ($r[desconto_cliente]>0){
                                  ?>
                                  <img src="icones/pesquisar.gif" border="0" title="Impressão 2" onclick="window.open('impressao.php?numero=<?php echo $r['numero'];?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">
                                  <?php
                                }else{
                                  ?>
                                  &nbsp;
                                  <?php
                                }
                                ?>
                              </td>
                              -->
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
                          <td colspan="5" valign="top" height="100%">&nbsp;
                            
                          </td>
                        </tr>
                       <tr>
                          <td colspan="4" align="right" height="100%">
							<?php
								$SqlSubTotal = "Select sum(total_com_desconto) As total_geral FROM (SELECT total_com_desconto FROM pedidos where numero>0  $Filtro $NumeroPedido $Ordem LIMIT $total_reg OFFSET $inicio) as sub";
								//echo $SqlSubTotal;
								$SqlSubTotal = pg_query($SqlSubTotal);
								$SubTotal = pg_fetch_array($SqlSubTotal);
							?>
                            Sub-Total: <b>R$ <?php echo number_format($SubTotal['total_geral'], 2, ",", ".");?></b>
                          </td>
                        </tr>
                       <tr>
                          <td colspan="4" align="right" height="100%">
							<?php
							if($Filtro){
								$SqlTotalGeral = "SELECT sum(total_com_desconto) as total_geral FROM pedidos where numero>0  $Filtro $NumeroPedido";
								}
								//echo $SqlTotalGeral;
								$SqlTotalGeral = pg_query($SqlTotalGeral);
								$TotalGeral = pg_fetch_array($SqlTotalGeral);
							?>
                            Total-Geral: <b>R$ <?php echo number_format($TotalGeral['total_geral'], 2, ",", ".");?></b>
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
                                    echo "<a href='#' onclick=\"Acha('relatorios/pedidos_clientes.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pedidos_clientes_id=$_REQUEST[pedidos_clientes_id]&pedidos_clientes_cc=$_REQUEST[pedidos_clientes_cc]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                                    echo "  |  ";
                                  }else{
                                      echo " <- Anterior ";
                                      echo "  |  ";
                                  }
                                  for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                                    echo "<a href='#' onclick=\"Acha('relatorios/pedidos_clientes.php','pagina=$p&ordem=$_REQUEST[ordem]&pedidos_clientes_id=$_REQUEST[pedidos_clientes_id]&pedidos_clientes_cc=$_REQUEST[pedidos_clientes_cc]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
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
                                      echo " <a href='#' onclick=\"Acha('relatorios/pedidos_clientes.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pedidos_clientes_id=$_REQUEST[pedidos_clientes_id]&pedidos_clientes_cc=$_REQUEST[pedidos_clientes_cc]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
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
                        <tr>
                          <td colspan="7" valign="top" height="100%">&nbsp;
                            
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
</form>
<?php
$_SESSION['pagina'] = "relatorios/index.php";
?>
