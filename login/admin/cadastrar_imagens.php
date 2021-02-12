<?php
include ("inc/common.php");
include "inc/config.php";
include "inc/verifica.php";
$Modulo_titulo = "Imagens";
$Modulo_link = "imagens";
$_SESSION['pagina'] = "listar_imagens.php";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $SqlCarregaCat = pg_query("Select * from imagens where id='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaCat);
  if ($ccc<>""){
    $n = pg_fetch_array($SqlCarregaCat);
  }
}
?>
<html>
<head>
<title><?php echo $Titulo_Admin;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="fonte.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
    <!--
    function MM_reloadPage(init) {  //reloads the window if Nav4 resized
      if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
        document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
      else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
    }
    MM_reloadPage(true);
    //-->
</script>
</head>
<table border="0" cellspacing="1" cellpadding="1" class="adminform"  width="100%" height="350">
  <tr align="center">
      <?php
      if ($_SESSION['usuario']){
          ?>
          <td width="548" valign="top">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="arial11">
              <tr>
                <td width="504" align="center">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="images/spacer.gif" width="1" height="4"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/categorias.gif" border="0" align="left"><center><h3><?php echo $Modulo_titulo;?></h3></center><hr></hr></td>
              </tr>
              <tr>
                <td valign="top" align="center" width="100%">
                  <div id="divAbaMeio">
                  <?php
                  if (!$_REQUEST['qtd_fotos']){
                     $SqlCarregaCat = pg_query("Select * from categorias order by nome");
                     $SelectCategoria = "
                       <tr>
                         <td>
                           Categoria:
                         </td>
                         <td>
                           <select name=id_cat id=id_cat>
                             <option></option>
                             ";
                              while ($c = pg_fetch_array($SqlCarregaCat)){
                                $SelectCategoria = $SelectCategoria."<option value='".$c['id']."'>".$c['nome']."</option>";
                              }
                              $SelectCategoria = $SelectCategoria."
                           </select>
                         </td>
                       </tr>
                       ";
                    ?>
                    <form name="cad" method="post" enctype="multipart/form-data">
                      <table  border="0" cellspacing="2" cellpadding="2" width="100%">
                        <tr>
                          <td>
                            <table border="0" align="center" cellpadding="2" cellspacing="2" class="unnamed2">
                              <?php
                              echo $SelectCategoria;
                              ?>
                              <tr>
                                <td align="right">Quantas fotos deseja enviar agora:</td>
                                <td><input name="qtd_fotos" id="qtd_fotos" type="text" size="20"></td>
                              </tr>
                              <tr>
                                <td colspan=2 align=center><BR><BR><BR>
                                  <input type="button" onclick="acerta_campos('divAbaMeio','Conteudo','cadastrar_imagens.php',true)" name="proximo" value="Próximo>>">
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </form>
                    <?php
                  }else{
                    ?>
                    <form name="cad" method="post" enctype="multipart/form-data">
                    <input type=hidden name=qtd_fotos value=<?php echo $_REQUEST['qtd_fotos'];?>>
                      <table  border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td>
                          <div id="cadastro_imagem">
                            <table border="0" align="center" cellpadding="2" cellspacing="2" class="texto1" width="100%">
                              <tr>
                                <?php
                                $SqlCarregaCat = pg_query("Select * from categorias order by nome");
                                $SelectCategoria = "
                                  <tr>
                                    <td>Categoria:
                                      <select name=id_cat id=id_cat>
                                        ";
                                         while ($c = pg_fetch_array($SqlCarregaCat)){
                                           if ($_REQUEST['id_cat']==$c['id']){
                                             $SelectCategoria = $SelectCategoria."<option value='".$c['id']."'>".$c['nome']."</option>";
                                           }else{
                                             $SelectCategoria = $SelectCategoria."<option value=''></option>";
                                           }
                                           $SelectCategoria = $SelectCategoria."<option value='".$c['id']."'>".$c['nome']."</option>";
                                         }
                                         $SelectCategoria = $SelectCategoria."
                                      </select>
                                    </td>
                                  </tr>
                                  ";
                                $max = "4"; //qtd de fotos por linha
                                $Width= 100 / $max;
                                $qtd_fotos = $_REQUEST["qtd_fotos"];
                                for ($x=1;$x<=$qtd_fotos;$x++){
                                   echo "<td width='".$Width."%'>
                                           <fieldset>
                                             <legend>Foto $x: </legend>
                                             <table border=0 align=center cellpadding=2 cellspacing=2 class=texto1>
                                               <tr>
                                                 <td>
                                                   Imagem: &nbsp;&nbsp;&nbsp;<input type=file name=f$x>
                                                 </td>
                                               </tr>
                                               $SelectCategoria
                                               <tr>
                                                 <td>
                                                   Legenda: &nbsp;&nbsp;<input type=text name=l$x>
                                                 </td>
                                               </tr>
                                             </table>
                                           </fieldset>
                                         </td>
                                         ";
                                   $atual=$atual+1;
                                   if ($atual==$max){
                                     echo "</tr><tr>";
                                     $atual = "0";
                                   }
                                }
                                ?>
                              </tr>
                            </table>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><div id=recebe_up_basico class=recebe>&nbsp;</div></td>
                        </tr>
                        <tr>
                          <td align="center">
                            <input id="enviar" type="button" onClick="document.getElementById('enviar').style.display='none';document.getElementById('cadastro_imagem').style.display='none'; return true;" value="Enviar" name="enviar">
                          </td>
                        </tr>
                      </table>
                    </form>
                    <?php
                  }
                  ?>
                  </div>
              </tr>
            </table>
          </td>
          <?php
      }
      ?>
    </td>
  </tr>
  <tr align="center">
    <td colspan="2" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
</table>
