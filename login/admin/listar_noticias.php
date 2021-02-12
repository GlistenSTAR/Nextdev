<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_noticias.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<?php
if ($_REQUEST['acao']=="Excluir"){
  ?>
  <?php
}
?>
<table border="0" cellspacing="1" cellpadding="1" class="adminform"  width="100%" height="350">
  <tr>
    <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/noticias.gif" border="0" align="left">
      <center><h3>Listagem de notícias</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td>
      <?php
      if ($_REQUEST['acao']=="Excluir"){
        $SqlDeletaNoticia = pg_query("Delete from noticias where id='".$_REQUEST['id']."'");
      }
      if ($_REQUEST['data_inicia'l]){
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
      if ($_REQUEST['ordem']){
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
                <table border="0" cellspacing="1" cellpadding="1" class="texto1" valign="top">
                  <tr>
                    <td>Data Inicial:</td>
                    <td><input name="data_inicial" id="data_inicial"  type="text" size="20" maxlength="20" value="<?php echo $DataInicial;?>" onclick="MostraCalendario(document.listar.data_inicial,'dd/mm/yyyy',this)"></td>
                    <td>Data Final:</td>
                    <td><input name="data_final" id="data_final"  type="text" size="20" maxlength="20" value="<?php echo $DataFinal;?>" onclick="MostraCalendario(document.listar.data_final,'dd/mm/yyyy',this)"></td>
                    <td>
                      <img align="center" src="icones/filtrar.png" onclick="if (document.listar.data_inicial.value){ Acha('listar_noticias.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');}" name="Incluir" value="Incluir" style="border: 0pt none ; cursor: pointer;" title="Clique para filtrar"><BR>
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
              $lista = "Select * from noticias where $FiltroData $Ordem";
              $lista1 = pg_query("Select * from noticias where $FiltroData $Ordem");
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
                <td width="200"><b>Titulo</b></td>
                <td width="350"><b>Texto</b></td>
                <td width="40"><a href='#' onclick="Acha('listar_noticias.php','pagina=<?php echo $pagina;?>&ordem=data&pos=<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'','Conteudo');"><b>Data</b><img src="../icones/<?php if ($_REQUEST['ordem']=="data"){ echo $pos;}else{echo $pos1;}?>.png" border="0" width="10" height="10"></a></td>
                <td width="20"><b>Excluir</b></td>
              </tr>
              <?php
              while ($r = pg_fetch_array($not1)){

                if ($Cor=="#EEEEEE"){
                  $Cor="#FFFFFF";
                }else{
                  $Cor="#EEEEEE";
                }
                ?>
                <tr bgcolor="<?php echo $Cor;?>">
                  <td valign="top">
                    <a href="#" onclick="Acha('cadastrar_noticias.php','localizar_numero=<?php echo $r['id'];?>','Conteudo');"><?php echo $r['titulo'];?></a>
                  </td>
                  <td valign="top">
                    <?php
                    $Texto = $r['texto'];
                    if (strlen($Texto)>100) {
                    $Texto = substr($Texto,0,100)."";
                    }
                    echo $Texto;
                    ?>
                  </td>
                  <td valign="top">
                    <?php
                    $da = $r['data'];
                    $d = explode("-", $da);
                    echo "".$d[2]."/".$d[1]."/".$d[0]."";
                    ?>
                  </td>
                  <td>
                    <img src="icones/excluir.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o ítem" onclick="if (confirm('Deseja realmente excluir essa notícia?')){ Acha('listar_noticias.php', 'acao=Excluir&id=<?php echo $r['id'];?>', 'Conteudo')}">
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
                        echo "<a href='#' onclick=\"Acha('listar_noticias.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                        echo "  |  ";
                      }else{
                          echo " <- Anterior ";
                          echo "  |  ";
                      }
                      for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                        echo "<a href='#' onclick=\"Acha('listar_noticias.php','pagina=$p&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
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
                          echo " <a href='#' onclick=\"Acha('listar_noticias.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
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
        </div>
      </form>
      <?php
      $_SESSION['pagina'] = "inicio.php";
      ?>
    </td>
  </tr>
</table>

