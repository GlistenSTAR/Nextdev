<?php
session_start();
$id_vendedor = $_SESSION[id_vendedor];
##############################################################
##
##                     PERFIL
##
###############################################################
$SiteUrl = "http://www.perfilcondutores.com.br/novo/";
$str_conexao= "host=db5.backup dbname=db5 port=5432 user=user password=password"; //tecnet
###############################################################
if(!($db=pg_connect($str_conexao))) {
  echo "N�foi poss�l estabelecer uma conex�com o banco de dados";
  exit;
}
$MensagemDbError = "A opera� n�foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao in�o e tente novamente : <BR>";
$data_hoje = date(m."/".d."/".Y);
include_once("funcoes.php");
?>
