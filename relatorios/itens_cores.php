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
  $Ordem = "order by numero_pedido $pos";
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
          <b>Listagem de Itens por cor</b>
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
                      <table width="580" border="0" cellspacing="0" cellpadding="0" class="texto1" valign="top">
                        <tr>
                          <td colspan="10" valign="top">
                            <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" valign="top">
                              <tr>
                                <td>Cliente:</td>
                                <td>
                                  <input type="hidden" name="pedidos_clientes_id" id="pedidos_clientes_id" value="<?php echo "$_REQUEST[pedidos_clientes_id]";?>">
                                  <input type="text" title="Digite o nome do cliente que deseja procurar." size="40" name="pedidos_clientes_cc" id="pedidos_clientes_cc" value="<?php echo "$_REQUEST[pedidos_clientes_cc]";?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');}else{if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else { if (this.value.length>3){Acha1('listar.php','tipo=pedidos_clientes&valor='+this.value+'','listar_pedidos_clientes');}}}">
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
                                        <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 20px; height: 16px;"  onclick="listarpedidos('itens_cores');">
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="10"><hr></hr></td>
                        </tr>
                        <?php
                        $FiltraVendedor = " codigo_vendedor = '".$_SESSION['id_vendedor']."'";
                        if (($_REQUEST['data_inicial']) and ($_REQUEST['data_final'])){
                          $di = explode("/", $DataInicial);
                          $df = explode("/", $DataFinal);
                          $Filtro = " data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
                        }
                        if ($_REQUEST['pedidos_clientes_id']){
                          $Filtro .= " and id_cliente='$_REQUEST[pedidos_clientes_id]'";
                        }
                        if ($Filtro){
                          if ($_REQUEST['numero_pedido']){
                            $Filtro = " numero='$_REQUEST[numero_pedido]' ";
                          }
                          $lista = "Select codigo, numero_pedido, sum(qtd) as qtd, sum(preto) as preto, sum(branco) as branco, sum(azul) as azul, sum(verde) as verde, sum(vermelho) as vermelho, sum(amarelo) as amarelo, sum(marrom) as marrom, sum(outra) as outra, sum(rosa) as rosa, sum(violeta) as violeta, sum(laranja) as laranha, sum(cinza) as cinza  from itens_do_pedido_vendas where numero_pedido in (Select numero from pedidos where codigo_vendedor = '".$_SESSION['id_vendedor']."' and $Filtro $NumeroPedido) group by numero_pedido, codigo $Ordem";
                          $lista1 = pg_query($lista);
                          //echo $lista;
                          $ccc = pg_num_rows($lista1);
                          $total_reg = "25";
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
//                          echo $sql;
                          $not1  = pg_query($sql);
                          ?>
                          <tr>
                            <td width="90" align="center">
                              <a href='#'
                               onclick="Acha('relatorios/itens_cores.php','pagina=<?php echo $pagina;?>&pedidos_clientes_id=<?php echo $_REQUEST['pedidos_clientes_id']?>&pedidos_clientes_cc=<?php echo $_REQUEST['pedidos_clientes_cc']?>&ordem=codigo&pos=<?php if ($_REQUEST['ordem']=="codigo"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');">
                                <b>Código</b>
                                <img src="icones/<?php if ($_REQUEST['ordem']=="codigo"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10">
                              </a>
                            </td>
                            <td width="30" align="center">
                              <a href='#'
                               onclick="Acha('relatorios/itens_cores.php','pagina=<?php echo $pagina;?>&pedidos_clientes_id=<?php echo $_REQUEST['pedidos_clientes_id']?>&pedidos_clientes_cc=<?php echo $_REQUEST['pedidos_clientes_cc']?>&ordem=qtd&pos=<?php if ($_REQUEST['ordem']=="qtd"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');">
                                <b>Qtd</b>
                                <img src="icones/<?php if ($_REQUEST['ordem']=="qtd"){ echo $pos;}else{echo $pos1;}?>.gif" border="0" width="10" height="10">
                              </a>
                            </td>
                            <td width="30" align="center" valign="top"><b>Preto</b></td>
                            <td width="30" align="center" valign="top"><b>Branco</b></td>
                            <td width="30" align="center" valign="top"><b>Azul</b></td>
                            <td width="30" align="center" valign="top"><b>Verde</b></td>
                            <td width="30" align="center" valign="top"><b>Vermelho</b></td>
                            <td width="30" align="center" valign="top"><b>Amarelo</b></td>
                            <td width="30" align="center" valign="top"><b>Marrom</b></td>
                            <td width="50" align="center" valign="top"><b>Outra</b></td>
                            <!--
                            <td width="30" valign="top"><?php echo $r[rosa]?></td>
                            <td width="30" valign="top"><?php echo $r[violeta]?></td>
                            <td width="30" valign="top"><?php echo $r[prlaranjaeto]?></td>
                            <td width="30" valign="top"><?php echo $r[cinza]?></td>
                            -->
                          <tr>
                            <td colspan="10"><hr></hr></td>
                          </tr>
                          <?php
                          while ($r = pg_fetch_array($not1)){
                            if ($Cor=="#EEEEEE"){
                              $Cor="#FFFFFF";
                            }else{
                              $Cor="#EEEEEE";
                            }
                            $i++;
                            if ($UltimoNumero!=$r[numero_pedido]){
                              if ($i>1){
                                echo "</table></fieldset></td></tr>";
                              }
                              ?>
                              <tr>
                                <td colspan="10">
                                  <fieldset>
                                    <legend class="texto1">Pedido: <?php echo $r['numero_pedido']?></legend>
                                    <table width="100%" class="texto1">
                              <?php
                            }
                            ?>
                            <tr bgcolor="<?php echo "$Cor";?>" onMouseOver="this.bgColor = '#C0C0C0'" onMouseOut ="this.bgColor = '<?php echo $Cor?>'">
                              <td width="60" valign="top"><?php echo $r['codigo']?></td>
                              <td width="30" valign="top"><?php echo $r['qtd']?></td>
                              <td width="30" valign="top"><?php echo $r['preto']?></td>
                              <td width="30" valign="top"><?php echo $r['branco']?></td>
                              <td width="30" valign="top"><?php echo $r['azul']?></td>
                              <td width="30" valign="top"><?php echo $r['verde']?></td>
                              <td width="30" valign="top"><?php echo $r['vermelho']?></td>
                              <td width="30" valign="top"><?php echo $r['amarelo']?></td>
                              <td width="30" valign="top"><?php echo $r['marrom']?></td>
                              <td width="30" valign="top"><?php echo $r['outra']?></td>
                              <!--
                              <td valign="top"><?php echo $r[rosa]?></td>
                              <td valign="top"><?php echo $r[violeta]?></td>
                              <td valign="top"><?php echo $r[prlaranjaeto]?></td>
                              <td valign="top"><?php echo $r[cinza]?></td>
                              -->
                            </tr>
                            <?php
                            $UltimoNumero=$r['numero_pedido'];
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
                          <td colspan="10" valign="top" height="100%">
                            &nbsp;
                          </td>
                        </tr>
                        <tr>
                          <td align="center" colspan="10">
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
                                    echo "<a href='#' onclick=\"Acha('relatorios/itens_cores.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pedidos_clientes_id=$_REQUEST[pedidos_clientes_id]&pedidos_clientes_cc=$_REQUEST[pedidos_clientes_cc]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                                    echo "  |  ";
                                  }else{
                                      echo " <- Anterior ";
                                      echo "  |  ";
                                  }
                                  for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                                    echo "<a href='#' onclick=\"Acha('relatorios/itens_cores.php','pagina=$p&ordem=$_REQUEST[ordem]&pedidos_clientes_id=$_REQUEST[pedidos_clientes_id]&pedidos_clientes_cc=$_REQUEST[pedidos_clientes_cc]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
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
                                      echo " <a href='#' onclick=\"Acha('relatorios/itens_cores.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pedidos_clientes_id=<?php echo $_REQUEST[pedidos_clientes_id]?>&pedidos_clientes_cc=<?php echo $_REQUEST[pedidos_clientes_cc]?>&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
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
      <tr>
        <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
      </tr>
    </table>
  </div>
</form>
<?php
$_SESSION['pagina'] = "relatorios/index.php";
?>
