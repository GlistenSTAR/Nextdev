<?
session_start();
if (($_SESSION[usuario]) and (!$_SESSION[bd][host])){
  session_destroy();
  //Header("Location: index.php");
}
//if ($_SESSION[usuario]){
//  Header("Location: ../index.php");
//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="inc/scripts/ajax.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include ("inc/cm.php");?>
<? include ("inc/bx.php"); ?>
<table width="100%" height="40%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #FFFFFF;">
  <tr>
    <td align="center">
      <table width="100%" height="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top">
            <?
            if (!$_SESSION[usuario]){
              ?>
              <link type="text/css" rel="stylesheet" href="inc/css.css?random=20073010" media="screen"></LINK>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center">
                      <tr>
                        <td class="arialg" align="center"><img src="images/logo.jpg"></td>
                      </tr>
                      <tr>
                        <td height="20" align="center" valign="bottom" class="arial00">
                          <?
                          setlocale(LC_TIME,'pt_BR','ptb');
                          echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
                          ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="100%" class="arial00">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="arial00" align="center">
                      <tr>
                        <td width="5"></td>
                        <td align="center">
                          <div id="carregando" align="center" style="position: relative; background: #FFFFFF; border: 1px dashed #999999; width: 300; height: 150; color: #FFFFFF;display: none; z-index: 13000;"><BR><BR><BR><BR><BR><BR><img src="images/carregando.gif"></div>
                          <?
                          if (!$_SESSION[usuario]){
                            ?>
                            <table width="200" border="0" align="center" cellpadding="0" cellspacing="0" class="arial11">
                              <tr>
                               <td width="5"><img src="images/tp1_r1_c1.jpg" width="5" height="64"></td>
                                <td width="200" align="center" background="images/tp1_r1_c2.jpg">
                                  <div id="login">
                                    <? include "dados_login.php";?>
                                  </div>
                                </td>
                                <td width="5"><img src="images/tp1_r1_c4.jpg" width="5" height="64"></td>
                              </tr>
                            </table>
                            <BR><BR><BR><BR><BR>
                            <?
                          }
                          ?>
                        </td>
                        <td width="5"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <script language="JavaScript">
                <!--
                document.getElementById('usuario').focus();
                //-->
              </script>
              <div id="Inicio"></div>
              <div id="Conteudo"></div>
              <?
            }elseif($_REQUEST[acao]=="sair"){
              include "login.php";
            }else{
              ?>
              <table width="100%" border="0" cellspacing="3" cellpadding="3">
                <tr>
                  <td valign="top">
                    <? include "inc/es.php";?>
                  </td>
                  <td valign="top"><hr size="350" width="1" align="left"></td>
                  <td align="center" width="100%" valign="top">
                    <div id="carregando" align="center" style="position: absolute; background: #FFFFFF; border: 1px dashed #999999; width: 80%; height: 400; color: #FFFFFF;display: none; z-index: 13000;"><BR><BR><BR><BR><BR><BR><BR><BR><BR><img src="images/carregando.gif"></div>
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
                            }
                            ?>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="7">&nbsp;</td>
                </tr>
              </table>
              <?
            }
            ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
