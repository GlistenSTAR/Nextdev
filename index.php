<?
session_start();
if (!$_SESSION[usuario]){
//  echo "haha";
//  exit;
  HEADER("Location: login/index.php");
}else{
  if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
  ?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
  <head>
  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <META HTTP-EQUIV="Expires" CONTENT="-1">
  <META NAME="AUTHOR" CONTENT="TN Sistemas">
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META NAME="COPYRIGHT" CONTENT="&copy; 2009 TN Sistemas">
  <META NAME="DESCRIPTION" CONTENT="Sistema de pedidos online">
  <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jan 2009 11:12:01 GMT">
  <META NAME="ROBOTS" CONTENT="NONE">
  <META NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
  <?
  header( 'Expires: Mon, 22 Jan 2009 11:12:01 GMT' );
  header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
  header( 'Cache-Control: no-store, no-cache, must-revalidate' );
  header( 'Cache-Control: post-check=0, pre-check=0', false );
  header( 'Pragma: no-cache' );
  ?>
  <link type="text/css" rel="stylesheet" href="inc/css.css" media="screen">
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <? include ("inc/cm.php"); ?>
  <table width="778" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="772" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fd_r2_c1.gif">
          <tr>
            <td height ="400" valign="top" align="center">
              <table width="772" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td width="7">&nbsp;</td>
                  <td width="148" valign="top" align="center">
                    <? include ("inc/es.php"); ?>
                    <div id="carregando" align="center" style="position: relative; display: none;" class="texto1">
                       <img src="images/carregando.gif" alitn="right">
                    </div>
                  </td>
                  <td width="7">&nbsp;</td>
                  <td align="center" width="610" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td align="center">
                          <div id="Conteudo"></div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div id="Inicio">
                            <?
                            if (!@include($_SESSION[pagina])){
                              include "inicio.php";
                              ?>
                              <span class="arial11" valign="bottom" align="center">
                                <? include "versao.php"; ?>
                              </span>
                              <?
                            }
                            ?>
                          </div>
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
      <td><? include ("inc/bx.php"); ?></td>
    </tr>
  </table>
  </body>
  </html>
  <script language="JavaScript" src="inc/scripts/funcoes_0.2.0.js"></script>
  <script language="JavaScript" src="inc/scripts/calendario_0.0.2.js"></script>
  <script language="JavaScript" src="inc/scripts/ie_0.0.3.js"></script>
  <script language="JavaScript" src="inc/scripts/mascara_0.0.1.js"></script>
  <script type="text/javascript" src="inc/scripts/wz_tooltip.js"></script>
  <?
}
?>
