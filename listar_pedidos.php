<?
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

<?
if ($_REQUEST[acao]=="Excluir"){
  $Sql = "Delete from pedidos_internet_novo where numero='$_REQUEST[numero_orcamento]'";

  $SqlExcluir = pg_query($Sql);
  $_REQUEST[tipo] = "rascunhos";
}
if ($_REQUEST[data_inicial]){
  $DataInicial = $_REQUEST[data_inicial];
}else{
  //$DataInicial = date("d/m/Y");
  $DataInicial = date("d/m/Y", mktime(0,0,0, date("m")-1, date("d"), date("Y"))); //Mês + 1
}
if ($_REQUEST[data_final]){
  $DataFinal = $_REQUEST[data_final];
}else{
  $DataFinal = date("d/m/Y", mktime(0,0,0, date("m")+1, date("d"), date("Y"))); //Mês + 1
}

if ($_REQUEST[status_pedido]){
  switch ($_REQUEST[status_pedido]){
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
if ($_REQUEST[ordem]){
  $Ordem = "order by $_REQUEST[ordem] $pos";
}else{
  $Ordem = "order by data DESC";
}

//faço algumas checagens para filtro por data emissão ou data prevista entrega
if($_REQUEST[tipo_data] == ""){
  $Tipo_Data = "data";
  $Sel =  "<option value='data'>EMISSÃO</option>
											<option value='data_prevista_entrega'>ENTREGA</option>
											<option value='data_efetivacao'>EFETIVAÇÂO</option>";
}else{
  $Tipo_Data = $_REQUEST[tipo_data]; 
}

if($_REQUEST[tipo_data] =="data"){
  $TipoData = "EMISSÂO";
  $Sel =  "<option value='data_prevista_entrega'>ENTREGA</option>";
		$Sel2 =  "<option value='data_efetivacao'>EFETIVAÇÂO</option>";
}else

if($_REQUEST[tipo_data] =="data_prevista_entrega"){
  $TipoData = "ENTREGA"; 
  $Sel =  "<option value='data'>EMISSÃO</option>";
		$Sel2 =  "<option value='data_efetivacao'>EFETIVAÇÂO</option>";		
}

if($_REQUEST[tipo_data] =="data_efetivacao"){
  $TipoData = "EFETIVAÇÂO"; 
  $Sel =  "<option value='data'>EMISSÃO</option>";
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
            <a href="#" onclick="window.open('imprimir_pedidos.php','_blank')"><img src="icones/imprimir1.gif" border="0"> Versão impressa </a>
            <? if (($PermitirSalvarRascunho) and ($_SESSION[nivel]>"0")){ ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" onclick="listarpedidos('rascunhos');"><img src="icones/orcamentos.gif" border="0"> Orçamentos </a>
            <? } ?>
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
                                <td valign="top"><input name="data_inicial" id="data_inicial"  type="text" size="12" maxlength="20" value="<? echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                                <td valign="top">Data Final:</td>
                                <td valign="top">
                                  <input name="data_final" id="data_final"  type="text" size="12" maxlength="20" value="<? echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)">
                                  » <select name="tipo_data" id="tipo_data" style="width:60px;">                                     
                                     <option value="<?= $_REQUEST[tipo_data];?>"><?= $TipoData;?></option>                                     
                                     <?= $Sel.$Sel2;?>
                                  </select>
                                </td>
                                <td valign="top">Número:</td>
                                <td valign="top"><input name="numero_pedido" id="numero_pedido"  type="text" size="8" maxlength="20" value="<? echo $_REQUEST[numero_pedido];?>"></td>
                                <td valign="top">
                                  <div id="cpanel">
                                    <div style="float: left;">
                                     	<div class="icon">
                                        <?
                                        if ($_REQUEST[tipo]=="rascunhos"){
                                          ?>
                                          <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 30px;"  onclick="listarpedidos('rascunhos');">
                                          <?
                                        }else{
                                          ?>
                                          <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 30px;"  onclick="listarpedidos('normal');">
                                          <?
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
                        <?
                        if ($_SESSION[nivel]=="2"){
                          ?>
                          <tr>
                            <td width="20%">
                            <div id="box-vendedor">
                            Vendedor:
                            </div></td>
                            <td width="80%" colspan="5">
                            <div id="box-vendedor2">
                              <select name="vendedor2_id" size="1" id="vendedor2_id">
                                <?
                                echo "a".$_REQUEST[vendedor2_id];
                                if ($_REQUEST[vendedor2_id]){
                                  $SqlCarregaVend = pg_query("SELECT nome FROM vendedores where codigo='$_REQUEST[vendedor2_id]'");
                                  $Vend = pg_fetch_array($SqlCarregaVend);
                                  echo "<option value='$_REQUEST[vendedor2_id]'>$Vend[nome]</option>";
                                  echo "<option></option>";
                                  $RetiraCP = " where codigo<>'$_REQUEST[vendedor2_id]' ";
                                }else{
                                  echo "<option></option>";
                                }
                                $SqlCarregaCondpag = pg_query("SELECT codigo, nome FROM vendedores $RetiraCP order by nome ASC");
                                while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                  echo "<option value='$cp[codigo]'>$cp[nome]</option>";
                                }                              
                                                                 
                                ?>
                              </select>
                              &nbsp;&nbsp;&nbsp;Status: 
                              <select name="status_pedido" id="status_pedido" size="1">
                                <option value="<?=$_REQUEST[status_pedido];?>"><?=$_REQUEST[status_pedido];?></option>
                                <option value="Aprovado">Aprovado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Faturado">Faturado</option>
                                <option value="Pendente">Pendente</option>
                                <option value="TODOS">TODOS</option>
                              </select>                              
                            </td> 
                           </div>
                          </tr>
                          <?
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
                                <option value="<?=$_REQUEST[status_pedido];?>"><?=$_REQUEST[status_pedido];?></option>
                                <option value="Aprovado">Aprovado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Faturado">Faturado</option>
                                <option value="Pendente">Pendente</option>
                                <option value="TODOS">TODOS</option>
                              </select>  
                              <input type="hidden" name="vendedor2_id" id="vendedor2_id"> 
                              <!--<input type="hidden" name="status_pedido" id="status_pedido" value="<?=$_REQUEST[status_pedido];?>">                      -->                              
                            </td> 
                           </div>
                          </tr>  
                          
                          <?
                        }
                        ?>
                        <tr>
                          <td colspan="7"><hr></hr></td>
                        </tr>                       

                        <?
                        if (($_REQUEST[data_inicial]) and ($_REQUEST[data_final])){
                          $di = explode("/", $DataInicial);
                          $df = explode("/", $DataFinal);                          
                          $FiltroData = $Tipo_Data.">='".$di[2]."-".$di[1]."-".$di[0]."' and ".$Tipo_Data."<='".$df[2]."-".$df[1]."-".$df[0]."'";
                        }
                        if ($_REQUEST[numero_pedido]){
                          $NumeroPedido = " and numero='$_REQUEST[numero_pedido]' ";
                        }
                        if ($_REQUEST[vendedor2_id]){
                          $Filtro = " and codigo_vendedor = '$_REQUEST[vendedor2_id]' and ";
                        }else{
                          if ($_SESSION[nivel]=="2"){
                            $Filtro = " and ";
                          }else{
                            if($_SESSION[id_vendedor]=="77"){ //Regra Groupack
                              $Filtro = " and codigo_vendedor = '87' and ";
                            }else{
                              $Filtro = " and codigo_vendedor = '$_SESSION[id_vendedor]' and ";
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
                          $pagina = $_REQUEST[pagina];
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
                            <td width="60"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<? echo $pagina;?>&ordem=numero&pos=<? if ($_REQUEST[ordem]=="numero"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Numero</b><img src="icones/<? if ($_REQUEST[ordem]=="numero"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="40" align="center"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<? echo $pagina;?>&ordem=data&pos=<? if ($_REQUEST[ordem]=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b><img src="icones/<? if ($_REQUEST[ordem]=="data"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="230"><a href='#' onclick="Acha('listar_pedidos.php','pagina=<? echo $pagina;?>&ordem=cliente&pos=<? if ($_REQUEST[ordem]=="cliente"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Cliente</b><img src="icones/<? if ($_REQUEST[ordem]=="cliente"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10"></a></td>
                            <td width="50" align="right"><b>Valor </b>&nbsp;&nbsp;</td>
                            <td width="30" align="center"><b>Status</b></td>
                            <td width="25" colspan="2"><b>Consultar</b></td>
                            <? if ($_REQUEST[tipo]=="rascunhos"){?>
                              <td width="25"><b>Excluir</b></td>
                            <?}else{?>
                              <td width="25"><b>Obs</b></td>
                            <?}?>
                          </tr>
                          <?
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
                            # Retiramos o IPI mas não temos certeza de ser a melhor opção
                            if ($_REQUEST[tipo]=="rascunhos"){
                              $SqlIpiItens = pg_query("Select sum(valor_ipi) as valor_ipi from itens_do_pedido_internet where numero_pedido='$r[numero]'");
                              $iipi = pg_fetch_array($SqlIpiItens);
                              $ValorPedido = $r[total_com_desconto] + $iipi[valor_ipi];
                            }else{
                              $SqlIpiItens = pg_query("Select sum(valor_ipi) as valor_ipi from itens_do_pedido_vendas where numero_pedido='$r[numero]'");
                              $iipi = pg_fetch_array($SqlIpiItens);
                              $ValorPedido = $r[total_com_desconto] + $iipi[valor_ipi];
                            }
                            */
                            $ValorPedido = $r[total_com_desconto];
                            ?>
                            <tr bgcolor="<? echo "$Cor";?>" onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '<?=$Cor?>'">
                              <td valign="top">
                                <?
                                if ($_REQUEST[tipo]=="rascunhos"){
                                  ?>
                                  <a href="#" onclick="Acha('cadastrar_pedidos.php','localizar_numero=<? echo $r[numero];?>','Conteudo'); <? echo $Desativa;?>" title="Clique para alterar o Orçamento"><? echo "$r[numero]";?></a>
                                  <?
                                }else{
                                  echo $r[numero];
                                }
                                ?>
                              </td>
                              <td valign="top">
                                <?
																																if($_REQUEST[tipo_data] =="data_prevista_entrega"){
																																		$d = explode(" ", $r[data_prevista_entrega]);
																																}else{
																																		$d = explode(" ", $r[data]);
																																}																																
                                $d = explode("-", $d[0]);
                                echo "".$d[2]."/".$d[1]."/".$d[0]."";
                                ?>
                              </td>
                              <td valign="top">
                                <?
                                echo substr($r[cliente],0,33)."";
                                ?>
                              </td>
                              <td valign="top" align="right">
                                <? echo number_format($ValorPedido, 2, ",", ".");?>
                              </td>
                              <td align="center">
                                <?
                                if ($Status=="Cancelado"){
                                  echo " <font color=red>";
                                  echo $Status;
                                  echo "</font>";
                                  ?>
                                  </td><tr onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '#FFFFFF'"><td colspan=5>Motivo Cancelamento: <font color=red><? echo "$r[motivo_cancelamento]";?></font>
                                  <?
                                }else{
                                  echo $Status;
                                }
                                ?>
                              </td>
                              <td valign="top" align="center" width="13">
                                <? if ($_REQUEST[tipo]=="rascunhos"){?>
                                  <img align="center" src="icones/pesquisar.gif" border="0" title="Impressão 1" onclick="window.open('impressao2.php?numero=<? echo "$r[numero]";?>&t=1','_blank')" style="border: 0pt none ; cursor: pointer;">
                                <?}else{?>
                                  <img align="center" src="icones/pesquisar.gif" border="0" title="Impressão 1" onclick="window.open('impressao.php?numero=<? echo "$r[numero]";?>&t=1','_blank')" style="border: 0pt none ; cursor: pointer;">
                                <?}?>
                              </td>                              
                              <td valign="top" align="center" width="13">
                                <?
                                if ($r[desconto_cliente]>0){
                                  ?>
                                  <? if ($_REQUEST[tipo]=="rascunhos"){?>
                                    <img align="center" src="icones/pesquisar.gif" border="0" title="Impressão 2" onclick="window.open('impressao2.php?numero=<? echo "$r[numero]";?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">
                                  <?}else{?>
                                    <img align="center" src="icones/pesquisar.gif" border="0" title="Impressão 2" onclick="window.open('impressao.php?numero=<? echo "$r[numero]";?>&t=0','_blank')" style="border: 0pt none ; cursor: pointer;">
                                  <?}?>
                                  <?
                                }else{
                                  ?>
                                  &nbsp;
                                  <?
                                }
                                ?>
                              </td>
                              <? if ($_REQUEST[tipo]=="rascunhos"){?>
                                <td valign="top" align="center" width="13">
                                  <img src="icones/excluir.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o ítem" onclick="if (confirm('Deseja realmente excluir esse orçamento?')){ Acha('listar_pedidos.php','acao=Excluir&numero_orcamento=<? echo $r[numero];?>','Conteudo'); listarpedidos('rascunhos'); }">
                                </td>
                              <?}else{?> 
                                <td valign="top" align="center" width="13">
                                  <img src="icones/obs.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para inserir uma Obervação" onclick="Acha('obs_pedido.php','numero=<? echo $r[numero];?>','campoobs'); document.getElementById('obs').style.display = 'inline';">
                                </td>                              
                              <?}?>
                            </tr>
                            <?
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
							<?
								$SqlSubTotal = "Select sum(total_com_desconto) As total_geral FROM (SELECT total_com_desconto FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem LIMIT $total_reg OFFSET $inicio) as sub";
								//echo $SqlSubTotal;
								$SqlSubTotal = pg_query($SqlSubTotal);
								$SubTotal = pg_fetch_array($SqlSubTotal);
							?>
                            Sub-Total: <b>R$ <?= number_format($SubTotal[total_geral], 2, ",", ".");?></b>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" align="right" height="100%">
							<?
								$SqlTIpi = "Select sum(total_ipi) As total_ipi FROM (SELECT total_ipi FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido $Ordem LIMIT $total_reg OFFSET $inicio) as sub_ipi";
								//echo $SqlTIpi."<br>";
								$SqlTIpi = pg_query($SqlTIpi);
								$SubTotalIpi = pg_fetch_array($SqlTIpi);
								$SubSemIPI = number_format(($SubTotal[total_geral] - $SubTotalIpi[total_ipi]), 2, ",", ".");
							?>
                            Sub-Total Sem IPI: <b>R$ <?=  $SubSemIPI ;?></b>
                          </td>
                        </tr>																								
                        <tr>
                          <td colspan="4" align="right" height="100%"><br>
							<?
								$SqlTotalGeral = "Select sum(total_com_desconto) As total_geral FROM (SELECT total_com_desconto FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido) as sub";
								//echo $SqlTotalGeral."<br>";
								$SqlTotalGeral = pg_query($SqlTotalGeral);
								$TotalGeral = pg_fetch_array($SqlTotalGeral);
							?>
                            Total-Geral: <b>R$ <?= number_format($TotalGeral[total_geral], 2, ",", ".");?></b>
                          </td>
                        </tr>	
                        </tr>																								
                        <tr>
                          <td colspan="4" align="right" height="100%">
							<?
								$SqlTGIpi = "Select sum(total_ipi) As total_ipi FROM (SELECT total_ipi FROM pedidos where numero>0  $SqlExtra $Filtro $FiltroData $NumeroPedido) as sub";
								//echo $SqlTGIpi."<br>";
								$SqlTGIpi = pg_query($SqlTGIpi);
								$TotalGeralSIpi = pg_fetch_array($SqlTGIpi);
								$TotGSIpi = number_format(($TotalGeral[total_geral] - $TotalGeralSIpi[total_ipi]), 2, ",", ".");
							?>
                            Total-Geral Sem IPI: <b>R$ <?= $TotGSIpi ;?></b>
                          </td>
                        </tr>																										
                        <tr>
                          <td align="center" colspan="7">
                            <table width="100%" border="0" class="texto1">
                              <?
                              if ($ccc<>""){
                                ?>
                                <tr>
                                  <td height="25" align="center">
                                   <hr>
                                  <?
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
                                      echo "$p&nbsp;";
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
                                    echo " <a href='#' onclick=\"Acha('listar_pedidos.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]','Conteudo'); return false;\"> Próxima -> </a>";
                                  }else{
                                    echo " | ";
                                    echo " Próxima ->";
                                  }
                                  ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="25" align="center" valign="top"><div>
                                    <?
                                    echo "<div>Mostrando registro <strong>";
                                    echo $inicio + 1;
                                    echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong></div>";
                                    ?>
                                    </div>
                                  </td>
                                </tr>
                                <?
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
<?
$_SESSION[pagina] = "listar_pedidos.php";
?>
