<?php
include_once ("inc/common.php");
session_start();
?>
<table width="200" border="0" cellpadding="2" cellspacing="2" class="arial11" align="center">
  <tr>
    <td width="100"><strong>USUARIO</strong></td>
    <td width="100"><input tabindex="1" name="usuario" id="usuario" type="text" class="arial00" size="21" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.getElementById('senha').focus();}"></td>
    <td rowspan="2" align="center" valign="top"><input tabindex="3" type="button" value=" Entrar " id="Entrar" name="Entrar" style="width: 50px; background-color: #2301DE; border-color: #FFFFFF; color: #FFFFFF; font-weight: bold;" onclick="acerta_campos('login','login','login.php',true);"></td>
  </tr>
  <tr>
    <td width="100"><strong>SENHA</strong></td>
    <td width="100"><input tabindex="2" name="senha" id="senha" type="password" class="arial00" size="21" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){acerta_campos('login','login','login.php',true);}"></td>
  </tr>
</table>
<?php
  if(isset($_SESSION['erro'])){
    echo $_SESSION['erro'];
    $_SESSION['erro'] = "";
    session_destroy();
  }
?>
