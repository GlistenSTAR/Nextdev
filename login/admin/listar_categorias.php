<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_categorias.php";
?>
<link href="inc/css_print.css" rel="stylesheet" type="text/css" media="print">
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<?php
if ($_REQUEST['acao']=="Excluir"){
  ?>
  <?php
}
?>
<table width="603" border="0" cellspacing="1" cellpadding="1" class="texto1">
  <div class="noPrint">
    <tr>
      <td width="350"><b>Nome</b></td>
      <td width="200"><b>Descrição</b></td>
    </tr>
  </div>
  <?php
  $lista = "Select * from categorias order by nome ASC";
  $lista1 = pg_query("Select * from categorias order by nome ASC");
  $ccc = pg_num_rows($lista1);
  $total_reg = "20";
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
  while ($r = pg_fetch_array($not1)){
    if ($Cor=="#EEEEEE"){
      $Cor="#FFFFFF";
    }else{
      $Cor="#EEEEEE";
    }
    if ((!$r[ativo]) or ($r[ativo]=="0")){
      $Cor = "red \" title='Categoria Inativa'\"";
    }
    ?>
    <tr bgcolor="<?php echo $Cor;?>">
      <td valign="top">
        <a href="#" onclick="Acha('cadastrar_categorias.php','localizar_numero=<?php echo $r['id'];?>','Conteudo');"><?php echo $r['nome'];?></a>
      </td>
      <td valign="top">
        <?php echo $r['descricao'];?>
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
  ?>
  <tr>
    <td align="center" colspan="4"> <hr>
      <div id="listagem_categorias">
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
                echo "<a href='#' onclick=\"Acha('listar_categorias.php','pagina=$anterior','Conteudo');\"> <- Anterior </a>";
                echo "  |  ";
              }else{
                  echo " <- Anterior ";
                  echo "  |  ";
              }
              for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                echo "<a href='#' onclick=\"Acha('listar_categorias.php','pagina=$p','Conteudo');\">";
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
                  echo " <a href='#' onclick=\"Acha('listar_categorias.php','pagina=$proximo','Conteudo');\"> Próxima -> </a>";
              }else{
                  echo " | ";
                  echo " Próxima ->";
              }
              ?>
              </td>
            </tr>
            <div id="paginacao" class="noPrint">
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
            </div>
            <?php
          }
          ?>
        </table>
      </div>
    </td>
  </tr>
</table>
<?php
$_SESSION['pagina'] = "listar_categorias.php";
?>
