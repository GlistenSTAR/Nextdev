<?php
session_start();
$id_vendedor = $_SESSION['id_vendedor'];
##############################################################
##          CHECA CLIENTE         -          TNINFO
###############################################################
$IpServer = $_SERVER[SERVER_NAME];
$Host = "db5.backup";      $Db = "db5"; $Porta = "5433"; $CodigoEmpresa = "75";  $Empresa = "perplug"; //tecnet
$User = "user";
$Password="password";
$CaixaFechada = true;              // Define se o sistema vai levar em conta caixas abertas ou fechadas.
$FatoresPedido = true;             // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
$PermitirSalvarRascunho = false;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
$ConfereMinimo = true;             // Define se o valor unit�rio pode ser abaixo do minimo, false = sem checagem
###################################################################################
$str_conexao= "host=$Host dbname=$Db port=$Porta user=$User password=$Password";
$SiteUrl = "http://$IpServer/novo/";
###############################################################
//echo $str_conexao;
//exit;
if(!($db=pg_connect($str_conexao))) {
  echo "N�o foi poss�vel estabelecer uma conex�o com o banco de dados";
  exit;
}
$MensagemDbError = "A opera��o n�o foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao in�cio e tente novamente : <BR>";
$data_hoje = date(m."/".d."/".Y);
include_once("funcoes.php");
$teclas = array("'","'","'","/","-",".","�","`","�");
?>
