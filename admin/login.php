<?
session_start();
$usuario = strtoupper($_REQUEST["usuario_admin"]);
$senha = strtoupper($_REQUEST["senha_admin"]);
if (($usuario=="LAILA") and ($senha=="00")){
  $_SESSION[usuario] = $usuario;
  Header("Location: index.php");
}else{
  $_SESSION[Erro] = "Usuário ou Senha inválidos";
  Header("Location: index.php");
}
?>
