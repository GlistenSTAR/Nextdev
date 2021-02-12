<?php
session_start();
$id_vendedor = $_SESSION[id_vendedor];
##############################################################################
##
## Dados para contagem de tempo de login, toda vez que executar algo grava log
##
##############################################################################

if($_SERVER[SERVER_NAME]=="192.168.10.3" || $_SERVER[SERVER_NAME]=="tnlink1.dyndns.org"){
  $Host = "db1.backup";
}else{
  $Host = "localhost";
}

if (!($db=pg_connect("host=$Host dbname=db1 port=5432 user=user password=passoword"))) {
  echo "<center>N�o foi poss�vel estabelecer uma conex�o com o banco de dados<BR><BR>
  Nossos servidores est�o em manuten��o, por favor tente novamente mais tarde.";
  exit;
}

pg_set_client_encoding($db, ' SQL_ASCII');

if (!$_SESSION[uid]){
  $Log = pg_query("select id from usuarios where nome = '".strtoupper($_SESSION[usuario])."' and senha='".strtoupper($_SESSION[senha])."'");
  $us = pg_fetch_array($Log);
  $_SESSION[uid] = $us[id];
}
$TL = "Update usuarios set tempo_login='".time()."' where id='$_SESSION[uid]'";
pg_query($TL);
$SiteUrl = "http://200.153.32.226/desenvolvimento/cobaia/";
###############################################################
$str_conexao= "host=".$_SESSION[bd][host]." dbname=".$_SESSION[bd][base]." port=".$_SESSION[bd][porta]." user=".$_SESSION[bd][usuario]." password=".$_SESSION[bd][senha]."";
$base = $_SESSION[bd][descricao];
//echo $str_conexao;
##############################################################
##
##    Defini��es para acesso e utiliza��o do sistema
##
## S�o defini��es em vetor, tem que ser v�lidas a cada verifica��o
## Conferir se j� existe a chave antes de criar uma nova.
###############################################################
  #### Configs
    #VERSAO
    $_SESSION['config']['versao'] = "1.2 de 30/04/2009"; //Vers�o do sistema, conferido para autenticar as mudan�as
    #VENDAS
    if ($_SESSION[bd][base]=="connex"){
      $_SESSION['config']['vendas']['VendedorCliente'] = true; //Confere se o vendedor � o mesmo do cliente no pedido
    }else{
      $_SESSION['config']['vendas']['VendedorCliente'] = false; //Confere se o vendedor � o mesmo do cliente no pedido
    }
    $_SESSION['config']['vendas']['UltimosItensPedido'] = true; //Abre janela com itens das vendas anteriores no pedido
    $_SESSION['config']['vendas']['QtdUltimosItensPedido'] = "3"; //Qtd de itens das vendas anteriores no pedido requer $_SESSION['config']['vendas']['UltimosItensPedido'] = true
    if (!$_SESSION['config']['vendas']['PedidoComplementar']){
      $_SESSION['config']['vendas']['PedidoComplementar'] = false; //Se o pedido � complementar o c�lculo de valor minimo � anulado.
    }
    #Cadastros
    $_SESSION['config']['cadastros']['VendedorCliente'] = false; //Confere se o vendedor � o mesmo do cliente no cadastro de clientes
###############################################################
//echo $str_conexao;
if(!($db=pg_connect($str_conexao))) {
  echo "N�o foi poss�vel estabelecer uma conex�o com o banco de dados";
  exit;
}
pg_set_client_encoding($db, ' SQL_ASCII');
$MensagemDbError = "A opera��o n�o foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao in�cio e tente novamente : <BR>";
$data_hoje = date(m."/".d."/".Y);
$Emissao = date("H:i:s");
include_once("funcoes.php");

?>
