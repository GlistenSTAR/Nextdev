<?php
$id_vendedor = $_SESSION['id_vendedor'];

$server   = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
##############################################################
##
##                     PERFIL
##
###############################################################
$SiteUrl   = "http://10.1.2.200/desenvolvimento/espelhos/clientes/admin/";
if($server = "192.168.10.3"){
	$str_conexao = "host=db3.backup dbname=db3 port=5432 user=user password=password"; //grou_web
}else{
	$str_conexao = "host=db3.backup dbname=db3 port=5432 user=user password=password"; //grou_web
}		
###############################################################
if(!($db=pg_connect($str_conexao))) {	
  echo "N�o foi possivel estabelecer uma conex�o com o banco de dados";
  exit;
}

if (($_SESSION['base_selecionada_id']) AND ($_SESSION['base_selecionada_servidor']) AND ($_SESSION['base_selecionada_base']) AND ($_SESSION['base_selecionada_usuario']) AND ($_SESSION['base_selecionada_senha']) AND ($_SESSION['base_selecionada_porta'])){
  $str_conexao2= "host=$_SESSION['base_selecionada_servidor'] dbname=$_SESSION['base_selecionada_base'] port=$_SESSION['base_selecionada_porta'] user=$_SESSION['base_selecionada_usuario'] password=$_SESSION['base_selecionada_senha']";
  echo $str_conexao2; die;
  ###############################################################
  if(!($db2=pg_connect($str_conexao2))) {
    echo "N�o foi possivel estabelecer uma conex�com o banco de dados";
    exit;
  }
  $Tabela = "clientes";
  $Campo = "habilitado_site";
  $Tipo = "integer default 0";
  $Sql = pg_query($db2,"SELECT column_name FROM information_schema.columns WHERE table_name ='".$Tabela."' and column_name='".$Campo."'");
  $ccc = pg_num_rows($Sql);
  if (!$ccc){
    $Sql = "alter table $Tabela add column $Campo $Tipo;";
    pg_query($db2,$Sql);
  }
}
$MensagemDbError = "A opera��o n�o foi realizada, copie esse texto e envie para suporte@tnsistemas.com.br, volte ao in�o e tente novamente : <BR>";
$data_hoje = date(m."/".d."/".Y);
include_once("funcoes.php");
?>
