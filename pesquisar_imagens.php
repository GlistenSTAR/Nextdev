<?php
include_once ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_imagens.php";
?>
<link href="inc/css_print.css" rel="stylesheet" type="text/css" media="print">
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<?php
if ($_REQUEST['acao']=="excluir"){
  $SqlExcluir = pg_query("Update imagens set ativo=0 where id='".$_REQUEST['id']."'");
}
?>
<form name="listar">
<table border="0" cellspacing="1" cellpadding="1" class="adminform texto1"  width="100%" height="350" valign="top">
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td colspan="4" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<img src="admin/icones/imagens.gif" border="0" align="left">
      <center><h3>Pesquisa de Imagens</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td valign="top">Legenda:</td>
    <td valign="top"><input type="text" size="60" name="legenda" id="legenda"></td>
    <td valign="top">
      <div id="cpanel">
        <div style="float: left;">
         	<div class="icon">
           	<a  href="#" onclick="Acha1('pesquisar_imagens.php','busca='+document.listar.legenda.value+'','Conteudo');">
         		  	<img src="icones/pesquisar.png" alt="Pesquisar" align="middle" border="0">
         			</a>
         	</div>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td width="50"><b>Imagem</b></td>
    <td width="100"><b>Nome</b></td>
    <td width="200"><b>Descrição</b></td>
    <td width="150"><b>Ver em alta resolução</b></td>
  </tr>
  <?php
  if ($_REQUEST['busca']){
    $lista = "Select * from imagens where ativo<>0 and legenda like '%$_REQUEST[busca]%' order by id DESC";
    $lista1 = pg_query("Select * from imagens where ativo<>0 and legenda like '%$_REQUEST[busca]%' order by id DESC");
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
        <td align="center">
          <span onmouseover="ddrivetip('<img src=imagens/<?php echo $r['imagem'];?> width=150 height=150>','#cccccc','150')" onmouseout="hideddrivetip()"><img src="admin/icones/imagens.gif" border="0" width="15" height="15"></span>
        </td>
        <td valign="top">
          <?php echo $r['imagem'];?>
        </td>
        <td valign="top">
          <?php echo $r['legenda'];?>
        </td>
        <td align="center">
          <img src="icones/alta_resolucao.png" width="20" height="20">
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
    <td align="center" colspan="4"> <hr>
      <div id="listagem_imagens">
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
                echo "<a href='#' onclick=\"Acha('listar_imagens.php','pagina=$anterior','Conteudo');\"> <- Anterior </a>";
                echo "  |  ";
              }else{
                  echo " <- Anterior ";
                  echo "  |  ";
              }
              for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                echo "<a href='#' onclick=\"Acha('listar_imagens.php','pagina=$p','Conteudo');\">";
                if ($pc==$p){
                  echo "<strong>";
                }
                if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
                  echo $p."&nbsp";
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
                  echo " <a href='#' onclick=\"Acha('listar_imagens.php','pagina=$proximo','Conteudo');\"> Próxima -> </a>";
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
  <tr>
    <td height="100%">&nbsp;</td>
  </tr>
</table>
<?php
$_SESSION['pagina'] = "listar_imagens.php";
?>
