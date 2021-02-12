<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">

<div id="obs">
  <div id="fechaobs" onclick="document.getElementById('obs').style.display = 'none';"> </div>
    <div id="campoobs">
      <iframe style="border:1px solid; width:485px; height:200px;"></iframe>

  </div>
</div>

<?php
if ($_REQUEST['acao']=="Excluir"){
  $Sql = "Delete from pedidos_internet_novo where numero='".$_REQUEST['numero_orcamento']."'";

  $SqlExcluir = pg_query($Sql);
  $_REQUEST['tipo'] = "rascunhos";
}
if ($_REQUEST['data_inicial']){
  $DataInicial = $_REQUEST['data_inicial'];
}else{
  //$DataInicial = date("d/m/Y");
  $DataInicial = date("d/m/Y", mktime(0,0,0, date("m")-1, date("d"), date("Y"))); //M�s + 1
}
if ($_REQUEST['data_final']){
  $DataFinal = $_REQUEST['data_final'];
}else{
  $DataFinal = date("d/m/Y", mktime(0,0,0, date("m")+1, date("d"), date("Y"))); //M�s + 1
}

if ($_REQUEST['status_pedido']){
  switch ($_REQUEST['status_pedido']){
    case "Aprovado":
      $SqlExtra = " and venda_efetivada<>0 and nota=0 and cancelado=0 ";
      break;
    case "Cancelado":
      $SqlExtra = " and cancelado<>0 ";
      break;
    case "Faturado":
      $SqlExtra = " and nota=1 and numero_nota>'0' and cancelado=0";
      break;
    case "Pendente":
      $SqlExtra = " and venda_efetivada=0 and cancelado=0 ";
      break;
  }
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
  $Ordem = "order by data DESC";
}

//fa�o algumas checagens para filtro por data emiss�o ou data prevista entrega
if($_REQUEST['tipo_data'] == ""){
  $Tipo_Data = "data";
  $Sel =  "<option value='data'>EMISS�O</option>
											<option value='data_prevista_entrega'>ENTREGA</option>
											<option value='data_efetivacao'>EFETIVA��O</option>";
}else{
  $Tipo_Data = $_REQUEST['tipo_data']; 
}

if($_REQUEST['tipo_data'] =="data"){
  $TipoData = "EMISS�O";
  $Sel =  "<option value='data_prevista_entrega'>ENTREGA</option>";
		$Sel2 =  "<option value='data_efetivacao'>EFETIVA��O</option>";
}else

if($_REQUEST['tipo_data'] =="data_prevista_entrega"){
  $TipoData = "ENTREGA"; 
  $Sel =  "<option value='data'>EMISS�O</option>";
		$Sel2 =  "<option value='data_efetivacao'>EFETIVA��O</option>";		
}

if($_REQUEST['tipo_data'] =="data_efetivacao"){
  $TipoData = "EFETIVA��O"; 
  $Sel =  "<option value='data'>EMISS�O</option>";
		$Sel2 =  "<option value='data_prevista_entrega'>ENTREGA</option>";
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
          <b><u>Listagem de Pedidos</u></b>
          <div>
            <a href="#" onclick="window.open('imprimir_pedidos.php','_blank')"><img src="icones/imprimir1.gif" border="0"> Vers�o impressa </a>
            <?php if (($PermitirSalvarRascunho) and ($_SESSION['nivel']>"0")){ ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" onclick="listarpedidos('rascunhos');"><img src="icones/orcamentos.gif" border="0"> Or�amentos </a>
            <?php } ?>
          </div>
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
                <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                  <tr>
                    <td>
                      <table width="580" border="0" cellspacing="1" cellpadding="2" class="texto1" valign="top">
                        <tr>
                          <td colspan="7" valign="top">
                          
                            <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" class="texto1" valign="top">
                              <tr>
                                <td valign="top">Data Inicial:</td>
                                <td valign="top"><input name="data_inicial" id="data_inicial"  type="text" size="12" maxlength="20" value="<?php echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                                <td valign="top">Data Final:</td>
                                <td valign="top">
                                  <input name="data_final" id="data_final"  type="text" size="12" maxlength="20" value="<?php echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)">
                                  � <select name="tipo_data" id="tipo_data" style="width:60px;">                                     
                                     <option value="<?php echo $_REQUEST['tipo_data'];?>"><?php echo $TipoData;?></option>                                     
                                     <?php echo $Sel.$Sel2;?>
                                  </select>
                                </td>
                                <td valign="top">N�mero:</td>
                                <td valign="top"><input name="numero_pedido" id="numero_pedido"  type="text" size="8" maxlength="20" value="<?php echo $_REQUEST['numero_pedido'];?>"></td>
                                <td valign="top">
                                  <div id="cpanel">
                                    <div style="float: left;">
                                     	<div class="icon">
                                        <?php
                                        if ($_REQUEST['tipo']=="rascunhos"){
                                          ?>
                                          <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 30px;"  onclick="listarpedidos('rascunhos');">
                                          <?php
                                        }else{
                                          ?>
                                          <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 30px;"  onclick="listarpedidos('normal');">
                                          <?php
                                        }
                                        ?>
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <?php
                        if ($_SESSION['nivel']=="2"){
                          ?>
                          <tr>
                            <td width="20%">
                            <div id="box-vendedor">
                            Vendedor:
                            </div></td>
                            <td width="80%" colspan="5">
                            <div id="box-vendedor2">
                              <select name="vendedor2_id" size="1" id="vendedor2_id">
                                <?php
                                echo "a".$_REQUEST['vendedor2_id'];
                                if ($_REQUEST['vendedor2_id']){
                                  $SqlCarregaVend = pg_query("SELECT nome FROM vendedores where codigo='".$_REQUEST['vendedor2_id']."'");
                                  $Vend = pg_fetch_array($SqlCarregaVend);
                                  echo "<option value='".$_REQUEST['vendedor2_id']."'>".$Vend['nome']."</option>";
                                  echo "<option></option>";
                                  $RetiraCP = " where codigo<>'".$_REQUEST['vendedor2_id']."' ";
                                }else{
                                  echo "<option></option>";
                                }
                                $SqlCarregaCondpag = pg_query("SELECT codigo, nome FROM vendedores $RetiraCP order by nome ASC");
                                while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                  echo "<option value='".$cp['codigo']."'>".$cp['nome']."</option>";
                                }                              
                                                                 
                                ?>
                              </select>
                              &nbsp;&nbsp;&nbsp;Status: 
                              <select name="status_pedido" id="status_pedido" size="1">
                                <option value="<?php echo $_REQUEST['status_pedido'];?>"><?php echo $_REQUEST['status_pedido'];?></option>
                                <option value="Aprovado">Aprovado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Faturado">Faturado</option>
                                <option value="Pendente">Pendente</option>
                                <option value="TODOS">TODOS</option>
                              </select>                              
                            </td> 
                           </div>
                          </tr>
                          <?php
                        }else{
                          ?>
                          
                          <tr>
                            <td width="13%">
                            <div id="box-Status">
                            Status:
                            </div></td>
                            <td width="87%" colspan="5">
                            <div id="box-vendedor2">                              
                              <select name="status_pedido" id="status_pedido" size="1">
                                <option value="<?php echo $_REQUEST['status_pedido'];?>"><?php echo $_REQUEST['status_pedido'];?></option>
                                <option value="Aprovado">Aprovado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Faturado">Faturado</option>
                                <option value="Pendente">Pendente</option>
                                <option value="TODOS">TODOS</option>
                              </select>  
                              <input type="hidden" name="vendedor2_id" id="vendedor2_id"> 
                              <!--<input type="hidden" name="status_pedido" id="status_pedido" value="<?php echo $_REQUEST['status_pedido'];?>">                      -->                              
                            </td> 
                           </div>
                          </tr>  
                          
                          <?php
                        }
                        ?>
                        <tr>
                          <td colspan="7"><hr></hr></td>
                        </tr>                       

                        <?php
                        if (($_REQUEST['data_inicial']) and ($_REQUEST['data_final'])){
                          $di = explode("/", $DataInicial);
                          $df = explode("/", $DataFinal);                          
                          $FiltroData = $Tipo_Data.">='".$di[2]."-".$di[1]."-".$di[0]."' and ".$Tipo_Data."<='".$df[2]."-".$df[1]."-".$df[0]."'";
                        }
                        if ($_REQUEST['numero_pedido']){
                          $NumeroPedido = " and numero='".$_REQUEST['numero_pedido']."' ";
                        }
                        if ($_REQUEST['vendedor2_id']){
                          $Filtro = " and codigo_vendedor = '".$_REQUEST['vendedor2_id']."' and ";
                        }else{
                          if ($_SESSION['nivel']=="2"){
                            $Filtro = " and ";
                          }else{
                            if($_SESSION['id_vendedor']=="77"){ //Regra Groupack
                              $Filtro = " and codigo_vendedor = '87' and ";
                            }else{
                              $Filtro = " and codigo_vendedor = '".$_SESSION['id_vendedor']."' and ";
                            }                            
                          }
                        }
                        if ($FiltroData){
                          if ($_REQUEST[tipo]=="rascunhos"){
                            $lista = "Select numero, cgc, cliente, data, data_prevista_entrega, total_com_desconto, total_ipi, desconto_cliente from pedidos_internet_novo where enviado=0 $Filtro  $SqlExtra  $FiltroData $NumeroPedido $Ordem";                            
                            $lista1 = pg_query("Select numero, cgc, cliente, data, data_prevista_entrega, total_com_desconto, total_ipi, desconto_cliente from pedidos_internet_novo where enviado=0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem");
                          }else{
                            $lista = "Select numero, cgc, cliente, data, data_prevista_entrega, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, total_ipi, desconto_cliente from pedidos where numero> 0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem";                            
                            $lista1 = pg_query("Select numero, cgc, cliente, data, data_prevista_entrega, numero_nota, venda_efetivada, cancelado, motivo_cancelamento, nota, total_com_desconto, total_ipi, desconto_cliente from pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem");
                          }
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
                          //echo "<tr><td colspan='6'>$sql</td></tr>";
                          $not1  = pg_query($sql);
                          ?>
                          <tr>
                            <td width="60"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=numero&pos=<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Numero</b><img src="icones/<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="40" align="center"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=data&pos=<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b><img src="icones/<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="230"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<?php echo $pagina;?>&ordem=cliente&pos=<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Cliente</b><img src="icones/<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="50" align="right"><b>Valor </b>&nbsp;&nbsp;</td>
                            <td width="30" align="center"><b>Status</b></td>
                            <td width="25" colspan="2"><b>Consultar</b></td>
                            <?php if ($_REQUEST['tipo']=="rascunhos"){?>
                              <td width="25"><b>Excluir</b></td>
                            <?php }else{?>
                              <td width="25"><b>Obs</b></td>
                            <?php }?>
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
                            /*
                            # Retiramos o IPI mas n�o temos certeza de ser a melhor op��o
                            if ($_REQUEST[tipo]=="rascunhos"){
                              $SqlIpiItens = pg_query("Select sum(valor_ipi) as valor_ipi from itens_do_pedido_internet where numero_pedido='".$r['numero']."'");
                              $iipi = pg_fetch_array($SqlIpiItens);
                              $ValorPedido = $r[total_com_desconto] + $iipi[valor_ipi];
                            }else{
                              $SqlIpiItens = pg_query("Select sum(valor_ipi) as valor_ipi from itens_do_pedido_vendas where numero_pedido='".$r['numero']."'");
                              $iipi = pg_fetch_array($SqlIpiItens);
                              $ValorPedido = $r[total_com_desconto] + $iipi[valor_ipi];
                            }
                            */
                            $ValorPedido = $r[total_com_desconto];
                            ?>
                            <tr bgcolor="<?php echo $Cor;?>" onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '<?php echo $Cor?>'">
                              <td valign="top">
                                <?php
                                if ($_REQUEST['tipo']=="rascunhos"){
                                  ?>
                                  <a href="#" onclick="Acha('cadastrar_pedidos.php','localizar_numero=<?php echo $r['numero'];?>','Conteudo'); <?php echo $Desativa;?>" title="Clique para alterar o Or�amento"><?php echo $r['numero'];?></a>
                                  <?php
                                }else{
                                  echo $r['numero'];
                                }
                                ?>
                              </td>
                              <td valign="top">
                                <?php
																																if($_REQUEST['tipo_data'] =="data_prevista_entrega"){
																																		$d = explode(" ", $r['data_prevista_entrega']);
																																}else{
																																		$d = explode(" ", $r['data']);
																																}																																
                                $d = explode("-", $d[0]);
                                echo "".$d[2]."/".$d[1]."/".$d[0]."";
                                ?>
                              </td>
                              <td valign="top">
                                <?php
                                echo substr($r['cliente'],0,33)."";
                                ?>
                              </td>
                              <td valign="top" align="right">
                                <?php echo number_format($ValorPedido, 2, ",", ".");?>
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
                                <?php if ($_REQUEST['tipo']=="rascunhos"){ $numero = $r['numero']; ?>
                                  <img align="center" src="icones/pesquisar.gif" border="0" title="Impress�o 1" onclick="window.open('impressao2.php?numero=<?php echo $numero;?>&t=1','_blank')" style="border: 0pt none ; cursor: pointer;">
                                <?php }else{ $numero = $r['numero']; ?>
                                  <img align="center" src="icones/pesquisar.gif" border="0" title="Impress�o 1" onclick="window.open('impressao.php?numero=<?php echo $numero;?>&t=1','_blank')" style="border: 0pt none ; cursor: pointer;">
                                <?php } ?>
                              </td>                              
                              <td valign="top" align="center" width="13">
                                <?php
                                if ($r['desconto_cliente']>0){
									$numero = $r['numero'];
                                  ?>
                                  <?php if ($_REQUEST['tipo']=="rascunhos"){?>
                                    <img align="center" src="icones/pesquisar.gif" border="0" title="Impress�o 2" onclick="window.open('impressao2.php?numero=<?php echo $numero;?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">
                                  <?php }else{ ?>
                                    <img align="center" src="icones/pesquisar.gif" border="0" title="Impress�o 2" onclick="window.open('impressao.php?numero=<?php echo $numero;?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">
                                  <?php }?>
                                  <?php
                                }else{
                                  ?>
                                  &nbsp;
                                  <?php
                                }
                                ?>
                              </td>
                              <?php if ($_REQUEST['tipo']=="rascunhos"){?>
                                <td valign="top" align="center" width="13">
                                  <img src="icones/excluir.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o �tem" onclick="if (confirm('Deseja realmente excluir esse or�amento?')){ Acha('listar_pedidos.php','acao=Excluir&numero_orcamento=<?php echo $r['numero'];?>','Conteudo'); listarpedidos('rascunhos'); }">
                                </td>
                              <?php }else{?> 
                                <td valign="top" align="center" width="13">
                                  <img src="icones/obs.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para inserir uma Oberva��o" onclick="Acha('obs_pedido.php','numero=<?php echo $r['numero'];?>','campoobs'); document.getElementById('obs').style.display = 'inline';">
                                </td>                              
                              <?php }?>
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
								$SqlSubTotal = "Select sum(total_com_desconto) As total_geral FROM (SELECT total_com_desconto FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem LIMIT $total_reg OFFSET $inicio) as sub";
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
								$SqlTIpi = "Select sum(total_ipi) As total_ipi FROM (SELECT total_ipi FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem LIMIT $total_reg OFFSET $inicio) as sub_ipi";
								//echo $SqlTIpi."<br>";
								$SqlTIpi = pg_query($SqlTIpi);
								$SubTotalIpi = pg_fetch_array($SqlTIpi);
								$SubSemIPI = number_format(($SubTotal['total_geral'] - $SubTotalIpi['total_ipi']), 2, ",", ".");
							?>
                            Sub-Total Sem IPI: <b>R$ <?php echo  $SubSemIPI ;?></b>
                          </td>
                        </tr>																								
                        <tr>
                          <td colspan="4" align="right" height="100%"><br>
							<?php
								$SqlTotalGeral = "Select sum(total_com_desconto) As total_geral FROM (SELECT total_com_desconto FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido) as sub";
								//echo $SqlTotalGeral."<br>";
								$SqlTotalGeral = pg_query($SqlTotalGeral);
								$TotalGeral = pg_fetch_array($SqlTotalGeral);
							?>
                            Total-Geral: <b>R$ <?php echo number_format($TotalGeral['total_geral'], 2, ",", ".");?></b>
                          </td>
                        </tr>	
                        </tr>																								
                        <tr>
                          <td colspan="4" align="right" height="100%">
							<?php
								$SqlTGIpi = "Select sum(total_ipi) As total_ipi FROM (SELECT total_ipi FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido) as sub";
								//echo $SqlTGIpi."<br>";
								$SqlTGIpi = pg_query($SqlTGIpi);
								$TotalGeralSIpi = pg_fetch_array($SqlTGIpi);
								$TotGSIpi = number_format(($TotalGeral['total_geral'] - $TotalGeralSIpi['total_ipi']), 2, ",", ".");
							?>
                            Total-Geral Sem IPI: <b>R$ <?php echo $TotGSIpi ;?></b>
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
                                    echo "<a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]','Conteudo');\"> <- Anterior </a>";
                                    echo "  |  ";
                                  }else{
                                    echo " <- Anterior ";
                                    echo "  |  ";
                                  }
                                  for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                                    echo "<a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$p&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]','Conteudo');\">";
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
                                    echo " <a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]','Conteudo'); return false;\"> Pr�xima -> </a>";
                                  }else{
                                    echo " | ";
                                    echo " Pr�xima ->";
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
$_SESSION['pagina'] = "listar_pedidos.php";
?>
