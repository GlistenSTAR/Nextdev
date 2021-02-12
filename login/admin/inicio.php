<?php
include ("inc/common.php");
include ("inc/verifica.php");
?>
<table class="adminform" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
      <?php
      setphplocale(LC_TIME,'pt_BR','ptb');
      ?>
      Até agora <?php echo ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y')))); ?> foram lançados
      <?php
      include_once("inc/config.php");
      $sql = "Select count(numero) as quantos from pedidos where data>'2007-01-01' and numero_internet <> 0";
      //$sql = "Select count(numero) as quantos from pedidos where data>'".date("Y-m-d")."' and numero_internet <> null";
      $SqlAchaPedidosHoje = pg_query($sql);
      $rel = pg_fetch_array($SqlAchaPedidosHoje);
      echo "<b>$rel[quantos]</b>";
      ?>
      pedidos.
    </td>
  </tr>
  <tr>
    <td>
      <table align="center" width="100%">
        <tr>
          <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/vendas.gif" border="0" align="left">
            <center><h3>Últimos pedidos lançados</h3></center><hr></hr>
          </td>
        </tr>
        <tr>
          <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <?php
      if ($_REQUEST['acao']=="Excluir"){
        ?>
        <?php
      }
      if ($_REQUEST['data_inicial']){
        $DataInicial = $_REQUEST['data_inicial'];
      }else{
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
      if ($_REQUEST[ordem]){
        $Ordem = "order by $_REQUEST[ordem] $pos";
      }else{
        $Ordem = "order by data DESC";
      }
      ?>
      <form name="listar">
        <div id="listar">
          <table border="0" cellspacing="1" cellpadding="4" class="texto1" valign="top" align="center">
            <tr>
              <td colspan="5" valign="top">
                <table border="1" cellspacing="1" cellpadding="1" class="adminform texto1" valign="top" width="100%">
                  <tr>
                    <td>Data Inicial:</td>
                    <td><input name="data_inicial" id="data_inicial"  type="text" size="20" maxlength="20" value="<?php echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                    <td>Data Final:</td>
                    <td><input name="data_final" id="data_final"  type="text" size="20" maxlength="20" value="<?php echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)"></td>
                    <td align="center" rowspan="2">
                      <img align="center" src="icones/filtrar.png" onclick="if (document.listar.data_inicial.value){ Acha('inicio.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&cliente_id='+document.listar.cliente_id.value+'&cliente_cc='+document.listar.cliente_cc.value+'','Conteudo');}" name="Incluir" value="Incluir" style="border: 0pt none ; cursor: pointer;" title="Clique para Gravar esse ítem"><BR>
                      Todos
                    </td>
                    <td align="center" rowspan="2">
                      <img src='../icones/enviado.png' width='13' height='13' align='center' onclick="if (document.listar.data_inicial.value){ Acha('inicio.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&enviados=1&cliente_id='+document.listar.cliente_id.value+'&cliente_cc='+document.listar.cliente_cc.value+'','Conteudo');}" name="enviados" value="enviados" style="border: 0pt none ; cursor: pointer;" title="Listar somente os enviados"><BR>
                      Somente os enviados
                    </td>
                  </tr>
                  <tr>
                    <td>Cliente:</td>
                    <td colspan="3">
                      <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $_REQUEST['cliente_id'];?>">
                      <input type="text" size="60" name="cliente_cc" id="cliente_cc" value="<?php echo $_REQUEST['cliente_cc'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');">
                      <BR>
                      <div id="listar_cliente" style="position:absolute;"></div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <?php
            if (($_REQUEST['data_inicial']) and ($_REQUEST['data_final'])){
              $di = explode("/", $DataInicial);
              $df = explode("/", $DataFinal);
              $FiltroData = " data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
            }else{ //Mês atual
              $di = explode("/", $DataInicial);
              $df = explode("/", $DataFinal);
              $FiltroData = " data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
            }
            if ($FiltroData){
              if ($_REQUEST['enviados']){
                $Filtro = $Filtro." and enviado=1";
              }
              if (($_REQUEST['cliente_id']) and ($_REQUEST['cliente_cc'])){
                $Filtro = $Filtro." and id_cliente='".$_REQUEST['cliente_id']."'";
              }
              $lista = "Select numero, cgc, cliente, data, enviado from pedidos_internet_novo where $FiltroData $Filtro $Ordem";
              $lista1 = pg_query("Select numero, cgc, cliente, data, enviado from pedidos_internet_novo where $FiltroData $Filtro $Ordem");
              $ccc = pg_num_rows($lista1);
              $total_reg = "10";
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
                <td width="70"><a href='#' onclick="Acha('inicio.php','pagina=<?php echo $pagina;?>&ordem=numero&pos=<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Numero</b><img src="../icones/<?php if ($_REQUEST['ordem']=="numero"){ echo $pos;}else{echo $pos1;}?>.png" border="0" width="10" height="10"></a></td>
                <td width="70"><a href='#' onclick="Acha('inicio.php','pagina=<?php echo $pagina;?>&ordem=cgc&pos=<?php if ($_REQUEST['ordem']=="cgc"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>CNPJ / CPF</b><img src="../icones/<?php if ($_REQUEST['ordem']=="cgc"){ echo $pos;}else{echo $pos1;};?>.png" border="0" width="10" height="10"></a></td>
                <td width="350"><a href='#' onclick="Acha('inicio.php','pagina=<?php echo $pagina;?>&ordem=cliente&pos=<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Cliente</b><img src="../icones/<?php if ($_REQUEST['ordem']=="cliente"){ echo $pos;}else{echo $pos1;}?>.png" border="0" width="10" height="10"></a></td>
                <td width="40"><a href='#' onclick="Acha('inicio.php','pagina=<?php echo $pagina;?>&ordem=data&pos=<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b><img src="../icones/<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>.png" border="0" width="10" height="10"></a></td>
                <td width="30"><b>Status</b></td>
              </tr>
              <?php
              while ($r = pg_fetch_array($not1)){

                if ($Cor=="#EEEEEE"){
                  $Cor="#FFFFFF";
                }else{
                  $Cor="#EEEEEE";
                }
                if ($r[enviado]=="1"){
                  $Status = "<img src='../icones/enviado.png' width='13' height='13' align='center' title='Pedido já enviado, não é possível editar'>";
                }else{
                  //$Status = "<input type='checkbox' name='enviar_pedidos[]' id='enviar_pedidos[]' value='".$r['numero']."'>";
                  $Status = "<img src='../icones/duvida.png' width='13' height='13' align='center' title='Pedido somente gravado (Rascunho do vendedor)'>";
                }
                ?>
                <tr bgcolor="<?php echo $Cor;?>">
                  <td valign="top">
                    <a href="#" onclick="Acha('cadastrar_pedidos.php','localizar_numero=<?php echo $r['numero'];?>','Conteudo'); <?php echo $Desativa;?>"><?php echo $r['numero'];?></a>
                  </td>
                  <td valign="top">
                    <?php echo $r['cgc'];?>
                  </td>
                  <td valign="top">
                    <?php echo $r['cliente'];?>
                  </td>
                  <td valign="top">
                    <?php
                    $da = $r['data'];
                    $d = explode("-", $da);
                    echo "".$d[2]."/".$d[1]."/".$d[0]."";
                    ?>
                  </td>
                  <td align="center">
                    <?php echo $Status;?>
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
              <td colspan="5" valign="top" height="100%">
                &nbsp;
              </td>
            </tr>
            <tr>
              <td align="center" colspan="5"> <hr>
                <table width="100%" border="0" class="texto1">
                  <?php
                  if ($ccc<>""){
                    ?>
                    <tr>
                      <td height="25" align="center">
                      <?php
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      $qtd_paginas = $ccc / $total_reg;
                      $ultima_pagina = $pc + 6;
                      $primeira_pagina = $pc - 6;
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      if ($pc>1) {
                        echo "<a href='#' onclick=\"Acha('inicio.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                        echo "  |  ";
                      }else{
                          echo " <- Anterior ";
                          echo "  |  ";
                      }
                      for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                        echo "<a href='#' onclick=\"Acha('inicio.php','pagina=$p&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
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
                          echo " <a href='#' onclick=\"Acha('inicio.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
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
            <!--
              <tr>
                <td colspan="5" valign="top" height="100%" align="right">
                  <?php
                  //Aqui envia os dados para a gravação, estou criando a classe dos pedidos.
                  ?>

                  <input type="button" name="Enviar" value="Enviar" onclick="acerta_campos('listar','Conteudo','teste1.php',false);">

                </td>
              </tr>
            -->
          </table>
        </div>
      </form>
      <?php
      $_SESSION['pagina'] = "inicio.php";
      ?>
    </td>
  </tr>
</table>

