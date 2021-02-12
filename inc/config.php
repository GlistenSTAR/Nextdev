<?php
  
##############################################################
##                     CHECA CLIENTE
###############################################################
  $IpServer = $_SERVER['SERVER_NAME'];
  $Host = $_SESSION['bd']['host'];
  $Db = $_SESSION['bd']['base'];
  $Porta = $_SESSION['bd']['porta'];
  $CodigoEmpresa = $_SESSION['codigo_empresa'];
  $Empresa = $_SESSION['bd']['descricao'];
###############################################################
  $User = $_SESSION['bd']['usuario'];
  $Password= $_SESSION['bd']['senha'];
  switch ($CodigoEmpresa) {
    case "2":   //Groupack
      $CONF['CaixaFechada'] = true;      // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;   // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = false;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;    // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;            // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                   // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "";   // Usado nos reports
      $CONF['logotipo_site'] = "";           // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = false;     // Busca de produtos arquivo listar.php    
    break;
    case "168":  //Force
      $CONF['CaixaFechada'] = false;    // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;  // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = true;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;           // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                  // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "";   // Usado nos reports
      $CONF['logotipo_site'] = "";      // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = false;     // Busca de produtos arquivo listar.php
    break;
      case "49":  //H8
      $CONF['CaixaFechada'] = true;     // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;  // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = true;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;           // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                  // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "";   // Usado nos reports
      $CONF['logotipo_site'] = "";      // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = true;      // Busca de produtos arquivo listar.php
    break;
      case "1":  //DEMO
      $CONF['CaixaFechada'] = false;    // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;  // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = true;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;           // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                  // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "logo2.gif";   // Usado nos reports
      $CONF['logotipo_site'] = "";      // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = false;     // Busca de produtos arquivo listar.php
    break;
      case "215":  //NUTROPICA
      $CONF['CaixaFechada'] = false;    // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;  // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = true;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;           // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                  // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "logo2.gif";   // Usado nos reports
      $CONF['logotipo_site'] = "";      // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = false;     // Busca de produtos arquivo listar.php				
    break;
      case "203":  //KIBELEZA
      $CONF['CaixaFechada'] = false;    // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $CONF['ValorParcelaMinima'] = 0;  // Define se o sistema vai levar em conta caixas abertas ou fechadas.
      $FatoresPedido = true;            // Define se o sistema vai contar com a op��o de selecionar fatores de desconto
      $PermitirSalvarRascunho = true;   // Permite o vendedor salvar rascunhos dos pedidos para consultas e envios futuros
      $ConfereMinimo = false;           // Define se o valor unitario pode ser abaixo do minimo, false = sem checagem
      $Comissao = "0";                  // Define o valor da comiss�o fixa para todos os vendedores
      $FatMin = "0";
      $CONF['arredondamento'] = "100";  // 2 casas
      $CONF['logotipo_empresa'] = "logo2.gif";   // Usado nos reports
      $CONF['logotipo_site'] = "";      // Usado na Página inicial do site
      $CONF['logotipo_report'] = "";    // Usado nos reports (Logo de grupo ou algo assim)
      $CONF['UsaQtdCaixa'] = false;     // Busca de produtos arquivo listar.php				
    break;  
  }
###################################################################################
$str_conexao= "host=tnteste.c1etmptv6ioq.sa-east-1.rds.amazonaws.com dbname=$Db port=$Porta user=$User password=$Password";
$SiteUrl = "http://$IpServer/";
###############################################################
//echo $str_conexao;die;
if(!($db=pg_connect($str_conexao))) {
	//echo $str_conexao;
  echo "N�o foi poss�vel estabelecer uma conex�o com o banco de dados";
  exit;
}
pg_set_client_encoding($db, ' SQL_ASCII');
$MensagemDbError = "A opera��o n�o foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao in�cio e tente novamente : <BR>";
$data_hoje = date("m/d/Y");
include_once("funcoes.php");
$teclas = array("'", "�", "-");

//Busca Informa��o se empresa utiliza ou n�o limite de cr�dito
$SQlLimite = pg_query("SELECT COALESCE(checa_limite_credito,0) AS checa_limite FROM referencias");
$Limite = pg_fetch_array($SQlLimite);
$LimiteCredito =  $Limite['checa_limite'];