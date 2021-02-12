<?php
include ("inc/common.php");
//echo "<br><br><br>DESCONTO_CORES: $_REQUEST[descontocores2]<br><br><br><br>";
//exit;
##############################################################################################################################
#
#                         NORMAL - 
#
##############################################################################################################################
$Desconto = $_REQUEST['descontocores2'] / 100;
include "inc/config.php";
$SQL = "UPDATE pedidos_internet_novo SET especificado = 1 WHERE numero = ".$_REQUEST['numero_cores'];
pg_query($db,$SQL);
  $consulta = "UPDATE itens_do_pedido_internet set ";
  if ($_REQUEST["preto"] <> "") {
    $consulta = $consulta."preto =".$_REQUEST["preto"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["branco"] <> "") {
    $consulta = $consulta.$divisor."branco =".$_REQUEST["branco"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["azul"] <> "") {
    $consulta = $consulta.$divisor."azul =".$_REQUEST["azul"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["verde"] <> "") {
    $consulta = $consulta.$divisor."verde =".$_REQUEST["verde"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["vermelho"] <> "") {
    $consulta = $consulta.$divisor."vermelho =".$_REQUEST["vermelho"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["amarelo"] <> "") {
    $consulta = $consulta.$divisor."amarelo =".$_REQUEST["amarelo"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["marrom"] <> "") {
    $consulta = $consulta.$divisor."marrom =".$_REQUEST["marrom"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["cinza"] <> "") {
    $consulta = $consulta.$divisor."cinza =".$_REQUEST["cinza"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["laranja"] <> "") {
    $consulta = $consulta.$divisor."laranja =".$_REQUEST["laranja"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["rosa"] <> "") {
    $consulta = $consulta.$divisor."rosa =".$_REQUEST["rosa"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["violeta"] <> "") {
    $consulta = $consulta.$divisor."violeta =".$_REQUEST["violeta"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["bege"] <> "") {
    $consulta = $consulta.$divisor."bege =".$_REQUEST["bege"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["outra"] <> "") {
    $consulta = $consulta.$divisor."outra =".$_REQUEST["outra"] * $Desconto;
    $divisor = ",";
  }
  $consulta = $consulta.",especificado=1 ";
  $consulta = $consulta." WHERE numero_pedido=".$_REQUEST['numero_cores']." AND codigo='".$_REQUEST['codigo_cores']."' and especial='1';";
  //echo "<br><br><br><br><br><br>SQL : $consulta<br><br><br><br><br><br><br><br><br>";
  $_SESSION['sql_cores'] = $consulta;
##############################################################################################################################
#
#                         ESPECIAL - 
#
##############################################################################################################################
$Desconto = 1 - ($_REQUEST['descontocores2'] / 100);
$divisor = "";
  $consulta = "UPDATE itens_do_pedido_internet set ";
  if ($_REQUEST["preto"] <> "") {
    $consulta = $consulta."preto =".$_REQUEST["preto"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["branco"] <> "") {
    $consulta = $consulta.$divisor."branco =".$_REQUEST["branco"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["azul"] <> "") {
    $consulta = $consulta.$divisor."azul =".$_REQUEST["azul"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["verde"] <> "") {
    $consulta = $consulta.$divisor."verde =".$_REQUEST["verde"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["vermelho"] <> "") {
    $consulta = $consulta.$divisor."vermelho =".$_REQUEST["vermelho"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["amarelo"] <> "") {
    $consulta = $consulta.$divisor."amarelo =".$_REQUEST["amarelo"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["marrom"] <> "") {
    $consulta = $consulta.$divisor."marrom =".$_REQUEST["marrom"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["cinza"] <> "") {
    $consulta = $consulta.$divisor."cinza =".$_REQUEST["cinza"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["laranja"] <> "") {
    $consulta = $consulta.$divisor."laranja =".$_REQUEST["laranja"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["rosa"] <> "") {
    $consulta = $consulta.$divisor."rosa =".$_REQUEST["rosa"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["violeta"] <> "") {
    $consulta = $consulta.$divisor."violeta =".$_REQUEST["violeta"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["bege"] <> "") {
    $consulta = $consulta.$divisor."bege =".$_REQUEST["bege"] * $Desconto;
    $divisor = ",";
  }
  if ($_REQUEST["outra"] <> "") {
    $consulta = $consulta.$divisor."outra =".$_REQUEST["outra"] * $Desconto;
    $divisor = ",";
  }
  $consulta = $consulta.",especificado=1 ";
  $consulta = $consulta." WHERE numero_pedido=".$_REQUEST['numero_cores']." AND codigo='".$_REQUEST['codigo_cores']."' and especial='0';";
//  echo "<br><br>SQL : $consulta<br><br><hr>";

  $_SESSION['sql_cores'] = $_SESSION['sql_cores'].$consulta;  
//  echo "<br><br>SQL * : $_SESSION[sql_cores]<br><br>";
//  exit;
  //pg_query ($db,$consulta);
?>
