<?php
include ("inc/common.php");
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include ("inc/cm.php"); ?>
<?php
if (!$_SESSION['usuario']){
  ?>
  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
    <tr>
      <td align="center">
       	<div class="login">
       		<div class="login-form">
       			<img src="images/login.gif" alt="Login" />
       			<form action="login.php" method="post" name="loginForm" id="loginForm">
       			<div class="form-block">
       				<div class="inputlabel">Usuário</div>
       				<div><input name="usuario_admin" type="text" class="inputbox" size="15" /></div>
       				<div class="inputlabel">Senha</div>
       				<div><input name="senha_admin" type="password" class="inputbox" size="15" /></div>
       				<div align="left"><input type="submit" name="submit" class="button" value="Login" /></div>
       			</div>
       			</form>
       		</div>
       		<div class="login-text">
       			<div class="ctr"><img src="images/security.png" width="64" height="64" alt="security" /></div>
       			<p>Bem-vindo!</p>
       			<p>Use um usuário e senha válidos para entrar no painel de administração.</p>
       		</div>
       		<div class="clr"></div>
        	<?php
        	if ($_SESSION['Erro']){
           ?>
           <BR><BR>
           <div class="form-block"><?php echo $_SESSION['Erro'];?></div>
           <?php
           $_SESSION['Erro'] = "";
        	}
        	?>
       	</div>
     	</td>
   	</tr>
  </table>
 	<?php
}else{
  ?>
  <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
    <tr>
      <td width="7">&nbsp;</td>
      <td align="left" width="130" valign="top"><?php include ("inc/es.php"); ?></td>
      <td width="7">&nbsp;</td>
      <td align="center" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td align="center">
              <div id="Conteudo"></div>
            </td>
          </tr>
          <tr>
            <td align="center">
              <div id="Inicio">
                <?php
                include "inicio.php";
                ?>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <?php include ("inc/bx.php"); ?>
  </body>
  </html>
  <?php
}
?>
