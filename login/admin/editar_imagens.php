<?php
include ("inc/common.php");
include "inc/config.php";
include "inc/verifica.php";
$Modulo_titulo = "Imagens";
$Modulo_link = "imagens";
$_SESSION['pagina'] = "listar_imagens.php";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $SqlCarregaImagem = pg_query("Select * from imagens where id='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaImagem);
  if ($ccc<>""){
    $f = pg_fetch_array($SqlCarregaImagem);
  }
}
?>
<html>
<head>
<title><?php echo "$Titulo_Admin ";?></title>
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
    -->
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
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/imagens.gif" border="0" align="left"><center><h3><?php echo "$Modulo_titulo";?></h3></center><hr></hr></td>
              </tr>
              <tr>
                <td valign="top" align="center" width="100%">
                  <div id="divAbaMeio">
                    <form name="cad" method="post" enctype="multipart/form-data">
                      <table  border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td>
                            <table border="0" align="center" cellpadding="2" cellspacing="2" class="texto1" width="100%">
                              <tr>
                                <td width='100%'>
                                  <fieldset>
                                    <legend>Foto <?php echo $f['id'];?>: </legend>
                                    <input type="hidden" name="id" value="<?php echo $f['id'];?>">
                                    <input type="hidden" name="imagem_antiga" value="<?php echo $f['imagem'];?>">
                                    <table border=0 align=center cellpadding=2 cellspacing=2 class=texto1>
                                      <tr>
                                        <td>
                                          <img src="../imagens/<?php echo $f['imagem'];?>" border="0" width="250" height="250">
                                          <BR>
                                          <input type="checkbox" name="excluir_antiga"> Excluir essa imagem
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>Enviar nova foto:<BR>
                                          <input type=file name=foto_nova>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <input type=text name=legenda value="<?php echo $f['legenda'];?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><div id=recebe_up_basico class=recebe>&nbsp;</div></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <button onClick="micoxUpload(this.form,'upload_edita.php','recebe_up_basico','Carregando...','Erro ao carregar'); return false;" type=button>Gravar</button>
                                        </td>
                                      </tr>
                                    </table>
                                  </fieldset>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </form>
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
