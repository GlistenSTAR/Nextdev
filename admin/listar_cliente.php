<?php
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_clientes.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table border="0" cellspacing="1" cellpadding="1" class="adminform"  width="100%" height="350">
  <tr>
    <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/usuarios.png" border="0" align="left">
      <center><h3>Listagem de clientes</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td>
      <?php
      if ($_REQUEST['acao']=="Excluir"){
        $SqlDeletaNoticia = pg_query($db2,"Delete from clientes where id='".$_REQUEST['id']."'");
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
        $Ordem = "order by nome ASC";
      }
      ?>
      <form name="listar">
        <div id="listar">
          <table border="0" cellspacing="1" cellpadding="4" class="texto1" valign="top" align="center">
            <?php
            if (!$FiltroData){
              $lista = "Select * from clientes where habilitado_site=1 and inativo=0 and codigo_bloqueio=0 $Ordem";
              $lista1 = pg_query($db2,$lista);
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
              $not1  = pg_query($db2,$sql);
              ?>
              <tr>
                <td width="200"><b>Nome</b></td>
                <td width="350"><b>CPF / CNPJ</b></td>
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
                    <a href="#" onclick="Acha('cadastrar_vendedor.php','localizar_numero=<?php echo $r['codigo'];?>','Conteudo');"><?php echo $r['nome'];?></a>
                  </td>
                  <td valign="top">
                    <?php
                    echo $r['cgc'];
                    ?>
                  </td>
                  <td>
                    <img src="icones/excluir.png" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o vendedor" onclick="if (confirm('Deseja realmente excluir esse vendedor?')){ Acha('listar_vendedor.php', 'acao=Excluir&id=<?php echo $r['id'];?>', 'Conteudo')}">
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
                        echo "<a href='#' onclick=\"Acha('listar_vendedor.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
                        echo "  |  ";
                      }else{
                          echo " <- Anterior ";
                          echo "  |  ";
                      }
                      for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                        echo "<a href='#' onclick=\"Acha('listar_vendedor.php','pagina=$p&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
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
                          echo " <a href='#' onclick=\"Acha('listar_vendedor.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Próxima -> </a>";
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

