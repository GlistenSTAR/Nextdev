<?php
include ("inc/common.php");
session_start();
$usuario = strtoupper($_REQUEST["usuario_admin"]);
$senha = strtoupper($_REQUEST["senha_admin"]);
if (($usuario=="ADMIN") and ($senha=="123")){
  $_SESSION['usuario'] = $usuario;
  Header("Location: index.php");
}else{
  $_SESSION['Erro'] = "Usu�rio ou Senha inv�lidos";
  Header("Location: index.php");
}
?>
