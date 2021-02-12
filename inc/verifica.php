<?
session_start();
if ($_GET[acao]=="SAIR"){
    session_destroy();
    session_start();
    Header("Location: ../index.php");
    exit;
}
if (($_SESSION[usuario]=="") || ($_SESSION[id_vendedor]=="")){
    session_destroy();
    Header("Location: ../inicio.php");
}
?>
