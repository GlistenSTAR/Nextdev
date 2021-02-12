<?php
include ("inc/common.php");
include "inc/config.php";
$SQL = "UPDATE pedidos_internet_novo SET especificado = 1 WHERE numero = ".$_REQUEST['numero_cores'];
pg_query($db,$SQL);
if ($erro == 0){
  $consulta = "UPDATE itens_do_pedido_internet set ";
  if ($_REQUEST["preto"] <> "") {
    $consulta = $consulta."preto =".$_REQUEST["preto"];
    $divisor = ",";
  }
  if ($_REQUEST["branco"] <> "") {
    $consulta = $consulta.$divisor."branco =".$_REQUEST["branco"];
    $divisor = ",";
  }
  if ($_REQUEST["azul"] <> "") {
    $consulta = $consulta.$divisor."azul =".$_REQUEST["azul"];
    $divisor = ",";
  }
  if ($_REQUEST["verde"] <> "") {
    $consulta = $consulta.$divisor."verde =".$_REQUEST["verde"];
    $divisor = ",";
  }
  if ($_REQUEST["vermelho"] <> "") {
    $consulta = $consulta.$divisor."vermelho =".$_REQUEST["vermelho"];
    $divisor = ",";
  }
  if ($_REQUEST["amarelo"] <> "") {
    $consulta = $consulta.$divisor."amarelo =".$_REQUEST["amarelo"];
    $divisor = ",";
  }
  if ($_REQUEST["marrom"] <> "") {
    $consulta = $consulta.$divisor."marrom =".$_REQUEST["marrom"];
    $divisor = ",";
  }
  if ($_REQUEST["cinza"] <> "") {
    $consulta = $consulta.$divisor."cinza =".$_REQUEST["cinza"];
    $divisor = ",";
  }
  if ($_REQUEST["laranja"] <> "") {
    $consulta = $consulta.$divisor."laranja =".$_REQUEST["laranja"];
    $divisor = ",";
  }
  if ($_REQUEST["rosa"] <> "") {
    $consulta = $consulta.$divisor."rosa =".$_REQUEST["rosa"];
    $divisor = ",";
  }
  if ($_REQUEST["violeta"] <> "") {
    $consulta = $consulta.$divisor."violeta =".$_REQUEST["violeta"];
    $divisor = ",";
  }
  if ($_REQUEST["bege"] <> "") {
    $consulta = $consulta.$divisor."bege =".$_REQUEST["bege"];
    $divisor = ",";
  }
  if ($_REQUEST["outra"] <> "") {
    $consulta = $consulta.$divisor."outra =".$_REQUEST["outra"];
    $divisor = ",";
  }
  $consulta = $consulta.",especificado=1 ";
  $consulta = $consulta." WHERE numero_pedido=".$_REQUEST['numero_cores']." AND codigo='".$_REQUEST['codigo_cores']."'";
  pg_query ($db,$consulta);
}
?>
