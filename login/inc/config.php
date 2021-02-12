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
  echo "<center>Não foi possível estabelecer uma conexão com o banco de dados<BR><BR>
  Nossos servidores estão em manutenção, por favor tente novamente mais tarde.";
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
##    Definições para acesso e utilização do sistema
##
## São definições em vetor, tem que ser válidas a cada verificação
## Conferir se já existe a chave antes de criar uma nova.
###############################################################
  #### Configs
    #VERSAO
    $_SESSION['config']['versao'] = "1.2 de 30/04/2009"; //Versão do sistema, conferido para autenticar as mudanças
    #VENDAS
    if ($_SESSION[bd][base]=="connex"){
      $_SESSION['config']['vendas']['VendedorCliente'] = true; //Confere se o vendedor é o mesmo do cliente no pedido
    }else{
      $_SESSION['config']['vendas']['VendedorCliente'] = false; //Confere se o vendedor é o mesmo do cliente no pedido
    }
    $_SESSION['config']['vendas']['UltimosItensPedido'] = true; //Abre janela com itens das vendas anteriores no pedido
    $_SESSION['config']['vendas']['QtdUltimosItensPedido'] = "3"; //Qtd de itens das vendas anteriores no pedido requer $_SESSION['config']['vendas']['UltimosItensPedido'] = true
    if (!$_SESSION['config']['vendas']['PedidoComplementar']){
      $_SESSION['config']['vendas']['PedidoComplementar'] = false; //Se o pedido é complementar o cálculo de valor minimo é anulado.
    }
    #Cadastros
    $_SESSION['config']['cadastros']['VendedorCliente'] = false; //Confere se o vendedor é o mesmo do cliente no cadastro de clientes
###############################################################
//echo $str_conexao;
if(!($db=pg_connect($str_conexao))) {
  echo "Não foi possível estabelecer uma conexão com o banco de dados";
  exit;
}
pg_set_client_encoding($db, ' SQL_ASCII');
$MensagemDbError = "A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>";
$data_hoje = date(m."/".d."/".Y);
$Emissao = date("H:i:s");
include_once("funcoes.php");

?>
