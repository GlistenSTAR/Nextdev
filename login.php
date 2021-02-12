<?php
include ("inc/common.php");
include "inc/config.php";
$usuario = strtoupper($_REQUEST["usuario"]);
###############################################################
switch ($CodigoEmpresa) {
  case "75":  //Perlex
    $SqlCamposExtra = " vende_qualquer_produto, caixa_fechada, ";
  break;
  case "86":  //Perfil
    $SqlCamposExtra = " caixa_fechada, ";
  break;
}
###################################################################################

$consulta = "SELECT $SqlCamposExtra email, codigo, nome, senha, login, ultimo_login, qtd_entrada_site, nivel_site FROM vendedores WHERE login = '".strtoupper($usuario)."' AND ativo = 1";
//echo $consulta; exit;
$resultado = pg_query($db,$consulta) or die("Erro na consulta : $consulta. " .pg_last_error($db));
$linhas = pg_num_rows($resultado);
# Acesso administrativo
if ((($usuario=="ADMIN") and (strtoupper($_REQUEST["senha"])=="ADMIN@2009")) and (($IpServer=="192.168.0.2") or ($IpServer=="10.1.2.100") or ($IpServer=="tnlink1.dyndns.org"))){
  $_SESSION['id_vendedor'] = 9999;
  $_SESSION['nivel'] = 2;
  $_SESSION['usuario'] = "Administrador";
  if ($CodigoEmpresa=="75"){
    $_SESSION['email'] = "faturamentoperlex@grupoperlex.com.br";
  }else{
    $_SESSION['email'] = "suporte@tnsistemas.com.br";
  }
  $_SESSION['caixa_fechada'] = false;
  $_SESSION['ultimo_login'] = date("d/m/Y");
  $_SESSION['qtd_entrada_site'] = 100;
  $_SESSION['vende_qualquer_produto'] = 0;
}else{
  # Acesso normal
  if (($linhas == 0) or (strlen($usuario)<"2")) {
    $_SESSION['erro'] = "<font color='red'><center><b>Usu�rio ou senha incorretos</b></center></font>";
  }else{
    $row = pg_fetch_object($resultado, 0);
    $senha = $row->senha;
    if (strtoupper($_REQUEST["senha"]) == strtoupper($senha)) {
      //$id_vendedor = $row->id_vendedor;
      $_SESSION['id_vendedor'] = $row->codigo;
      $_SESSION['vende_especial'] = $row->vende_especial;
      $_SESSION['nivel'] = $row->nivel_site;
      $_SESSION['vende_qualquer_produto'] = $row->vende_qualquer_produto;
      $_SESSION['usuario'] = $row->nome;
      $_SESSION['login'] = $row->login;
      $_SESSION['email'] = $row->email;
      $_SESSION['caixa_fechada'] = $row->caixa_fechada;
      $_SESSION['ultimo_login'] = $row->ultimo_login;
      $_SESSION['qtd_entrada_site'] = $row->qtd_entrada_site + 1;
      $id_vendedor = $row->id;
      $_REQUEST['pg']="menu";
      $sql = "Update vendedores set ultimo_login='".date("m/d/Y H:i:s")."', qtd_entrada_site='$_SESSION[qtd_entrada_site]' where codigo='$row->codigo'";
      //echo $sql;
      pg_query($db,$sql) or die("Erro na consulta : $consulta. " .pg_last_error($db));
    }else{
      pg_close($db);
      $_SESSION['erro'] = " <font color='red'><center><b>Usu�rio ou senha incorretos</b></center></font>";
    }
  }
}
Header("Location: index.php");
?>