<?php
include ("inc/common.php");
  #####################################################################################################################
  #  20/01/2021 - Documenta��o Login
  #
  #  � necess�rio que o usuario esteja cadastrado na tabela usuarios da base nextweb
  #  e tbm na tabela de vendedores da base que ele vai conectar
  #  com o mesmo usuario e senha � claro.
  #
  #
  #  A Valida��o � feita em dois pontos, evitando invas�o a base de dados principal
  #
  #  Primeiro autentica o usu�rio, depois a base e s� ai conecta ele a base de dados oficial
  #  Os dados das bases est�o na tabela dados em nextweb
  #
  #  ERM
  ##################################################################################################################
  if(!isset($_SESSION))session_start();
  ###############################################################
  #  Conecta ao banco - NEXT WEB
  ###############################################################

  if(($_SERVER['SERVER_NAME'] == "18.228.36.12")  or ($_SERVER['SERVER_NAME'] == "teste1.tnsistemas.com.br")){
    $Host = "tnteste.c1etmptv6ioq.sa-east-1.rds.amazonaws.com";
  }else{
    $Host = "tnteste.c1etmptv6ioq.sa-east-1.rds.amazonaws.com";
  }
  
  //you can chnage your postgresql user and password
  if(!($db=pg_connect("host=$Host dbname=nextweb port=13662 user=postgres password=tndanils"))) {
    echo "N�o foi poss�vel estabelecer uma conex�o com o banco de dados";
    exit;
  }

  pg_set_client_encoding($db, ' SQL_ASCII');
  if (isset($_REQUEST['id_base'])){      //J� selecionou a base para conectar
    if($_SERVER['SERVER_NAME']=="192.168.10.20"){
      $SqlBase = "select * from dados where id='100'"; 
    } else {
      $SqlBase = "select * from dados where id='$_REQUEST[id_base]'";  
  }

  $ArrayBase = pg_query($SqlBase);
  $b = pg_fetch_array($ArrayBase);

  $_SESSION['us']['codigo_empresa'] = $b['codigo_empresa'];
  $_SESSION['codigo_empresa']       = $b['codigo_empresa'];
  $_SESSION['bd']['host']           = $b['servidor'];
  $_SESSION['bd']['base']           = $b['base'];
  $_SESSION['bd']['usuario']        = $b['usuario'];
  $_SESSION['bd']['senha']          = $b['senha'];
  $_SESSION['bd']['descricao']      = $b['descricao'];
  $_SESSION['bd']['porta']          = $b['porta'];

  $SqlLog = "Insert into log_acesso_site (usuario, ip, data, id_dados, server) values ('$_SESSION[usuario]','$_SERVER[REMOTE_ADDR]','".date("Y/m/d - H:i:s")."','$_REQUEST[id_base]','$_SERVER[SERVER_NAME]')";
  $g = pg_query($SqlLog) or die("Erro na consulta : $SqlLog. " .pg_last_error($db));
  @pg_close($db);

  include "inc/config.php";
  $consulta = "select codigo, nome, senha, login, ultimo_login, qtd_entrada_site, nivel_site from vendedores where login = '".strtoupper($_SESSION['usuario'])."' and senha='".strtoupper($_SESSION['senha'])."' AND ativo='1'";
  
  $SqlLogin = pg_query($db,$consulta) or die("Erro na consulta : $consulta. " .pg_last_error($db));
  $linhas = pg_num_rows($SqlLogin);
  
  if ($linhas == 0) {
    $_SESSION['erro'] = "<font color='red'><center><b>Usu�rio ou senha incorretos</b></center></font>";
  }else{
    $row = pg_fetch_array($SqlLogin);
    $senha = $row['senha'];
	
    if (strtoupper($_SESSION["senha"]) == strtoupper($senha)) {
      $id_vendedor = $row['id_vendedor'];
      $_SESSION['id_vendedor'] = $row['codigo'];
      $_SESSION['usuario'] = $row['nome'];
      $_SESSION['login'] = $row['login'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['ultimo_login'] = $row['ultimo_login'];
      $_SESSION['qtd_entrada_site'] = $row['qtd_entrada_site'] + 1;
      $_SESSION['nivel_site'] = $row['nivel_site'];
      $_SESSION['nivel'] = $row['nivel_site'];
      $id_vendedor = $row['id'];
      $_REQUEST['pg']="menu";
//      echo $_SESSION[id_vendedor];
//      exit;
      $sql = "Update vendedores set ultimo_login='".date("m/d/Y H:i:s")."', qtd_entrada_site='$_SESSION[qtd_entrada_site]' where codigo='$row[codigo]'";
      
//      echo $sql;
//      exit;
      pg_query($db,$sql) or die("Erro na consulta : $consulta. " .pg_last_error($db));
      $_SESSION['erro'] = "";

      Header("Location: ../index.php");
    }else{
      //echo "nao";
      pg_close($db);
      $_SESSION['erro'] = "<font color='red'><center><b>Usu�rio ou senha incorretos</b></center></font>";
    }
  }
//  $helper=&$_SESSION;
//  foreach ($helper as $key => $value){
//    echo "$value: $helper[$key]<BR>";
//  }
//  exit;
//echo "hahaha";
//exit;

}else{
  if (!isset($_SESSION['usuario'])){
    $_SESSION['usuario'] = strtoupper($_REQUEST["usuario"]);
  }
  if (isset($_SESSION['login'])){
    $_SESSION['usuario'] = $_SESSION['login'];
  }
  if (!isset($_SESSION['senha'])){
    $_SESSION['senha'] = strtoupper($_REQUEST["senha"]);
  }
//  echo $_SESSION[usuario];
//  exit;
  $SqlLogin = "select id, descricao from dados where id in (select id_dados from acesso where id_usuario in (select id from usuarios where nome = '".strtoupper($_SESSION['usuario'])."' and senha='".strtoupper($_SESSION['senha'])."')) order by descricao ASC";
//  echo $SqlLogin;
//  exit;
  $ArrayLogin = pg_query($db,$SqlLogin) or die("Erro na consulta : $SqlLogin. " .pg_last_error($db));
  $ccu = pg_num_rows($ArrayLogin);
  if (($ccu == 0) or (strlen($_SESSION['usuario'])<"2")) {
    $_SESSION['erro'] = "<font color='red'><center><b>Usu�rio ou senha incorretos</b></center></font>";
    Header("Location: dados_login.php");
  }else{
    ?>
    <form action="login.php" method="POST" name="logar">
      <table width="200" border="0" cellpadding="2" cellspacing="2" class="arial11" align="center">
        <tr>
          <td width="100"><strong>BASE</strong></td>
          <td width="100">
            <select name="id_base" id="id_base" size="1">
              <?php
              while ($u = pg_fetch_array($ArrayLogin)){
                ?>
                <option value="<?php echo $u['id'];?>"><?php echo "$u[descricao]";?></option>
                <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="button" value=" Entrar " id="Entrar" name="Entrar" style="background-color: #2301DE; border-color: #FFFFFF; color: #FFFFFF; font-weight: bold;" onclick="document.logar.submit();"></td>
        </tr>
      </table>
    </form>
    <?php
  }
}
?>
