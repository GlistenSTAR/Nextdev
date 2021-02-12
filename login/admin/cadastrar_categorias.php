<?php
include ("inc/common.php");
include "inc/config.php";
include "inc/verifica.php";
$Modulo_titulo = "Categorias";
$Modulo_link = "categorias";
$_SESSION['pagina'] = "listar_categorias.php";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $SqlCarregaCat = pg_query("Select * from categorias where id='$_REQUEST[localizar_numero]'");
  $ccc = pg_num_rows($SqlCarregaCat);
  if ($ccc<>""){
    $n = pg_fetch_array($SqlCarregaCat);
  }
}
?>
<html>
<head>
<title><?php echo "$Titulo_Admin ";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="fonte.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
    <!--
    function MM_reloadPage(init) {  //reloads the window if Nav4 resized
      if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
        document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
      else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
    }
    MM_reloadPage(true);
    function data_valida(dateStr) {
       var data_padrao = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
       var Vetor = dateStr.match(data_padrao);
       if (Vetor == null) {
            alert("Por favor entre com a data no formato dd/mm/yyyy.");
            return false;
       }
       dia = Vetor[1];
       mes = Vetor[3];
       ano = Vetor[5];

       if (mes < 1 || mes > 12) {
            alert("O mes deve estar entre 1 e 12.");
            return false;
       }
       if (dia < 1 || dia > 31) {
            alert("O dia deve estar entre 1 e 31.");
            return false;
       }
       if ((mes==4 || mes==6 || mes==9 || mes==11) && dia==31) {
            alert("O mes " + mes + " nao tem 31 dias!")
            return false;
       }
       if (mes == 2) {
            var bloqueio = (ano % 4 == 0 && (ano % 100 != 0 || ano % 400 == 0));
            if (dia > 29 || (dia==29 && !bloqueio)) {
               alert("Fevereiro " + ano + " nao tem " + dia + " dias!");
               return false;
            }
       }
       return true;
    }
    function VerificaInicial() {
          DiaInicial=document.cad.dia_inicial.value;
          MesInicial=document.cad.mes_inicial.value;
          AnoInicial=document.cad.ano_inicial.value;
          DataInicial=DiaInicial+"/"+MesInicial+"/"+AnoInicial;
          if (!data_valida(DataInicial)) {
               alert("Selecione uma data válida");
               reseta_data = new Date()
               reseta_dia = reseta_data.getDate()
               if (reseta_dia<'10') {
                 reseta_dia = '0'+reseta_dia+'';
               }
               document.cad.dia_inicial.value = reseta_dia;
          }
    }
    //-->
</script>
</head>
<table border="0" cellspacing="1" cellpadding="1" class="adminform"  width="100%" height="350">
  <tr align="center">
      <?php
      if ($_SESSION['usuario']){
          ?>
          <td width="548" valign="top">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="arial11">
              <tr>
                <td width="504" align="center">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="images/spacer.gif" width="1" height="4"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
              </tr>
              <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/categorias.gif" border="0" align="left"><center><h3><?php echo "$Modulo_titulo";?></h3></center><hr></hr></td>
              </tr>
              <tr>
                <td valign="top" align="center" width="100%">
                  <?php
                  //Verifico se o cara mandou algo pra gravar.
                  if ($_REQUEST['acao']==""){
                    ?>
                    <form method="POST" name="cad" enctype="multipart/form-data">
                      <div id="divAbaMeio">
                      <input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo "$n[id]";?>">
                      <input type="hidden" name="acao" id="acao" value="cadastrar">
                      <table align="center" width="95%" border="0" class="arial11" cellspacing="4" cellspading="4">
                        <tr>
                          <td>Nome<BR>
                          <input type="text" name="nome" id="nome" size="40" value="<?php echo "$n[nome]";?>"></td>
                        </tr>
                        <tr>
                          <td>Descrição<BR>
                          <textarea rows="4" cols="65" name="descricao" id="descricao" maxlength="120"><?php echo "$n[descricao]";?></textarea></td>
                        </tr>
                        <tr>
                          <td>Ativo<BR>
                            <select name="ativo" id="ativo" size="1">
                              <?php
                              if (($n['ativo']) or ($n['ativo']=="")){
                                ?>
                                <option value="1">SIM</option>
                                <option value="0">NÃO</option>
                                <?php
                              }else{
                                ?>
                                <option value="0">NÃO</option>
                                <option value="1">SIM</option>
                                <?php
                              }
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center">
                            <input type="button" onclick="acerta_campos('divAbaMeio','Conteudo','cadastrar_categorias.php',true)" name="Gravar" value="Gravar">
                            <input type="button" onclick="Acha('noticias.php','','Conteudo');" name="Cancelar" value="Cancelar">
                          </td>
                        </tr>
                      </table>
                      </div>
                    </form>
                    <?php
                  }else{
                    //Verifico se o cara mandou algo pra gravar.
                    $Nome = utf8_decode($_REQUEST['nome']);
                    $Descricao = utf8_decode(str_replace(chr(13),"<br>",$_REQUEST['descricao']));
                    
                    if ($_REQUEST['id_categoria']){ //se tiver Id somente atualizo
                      $Grava = "Update $Modulo_link set
                                  nome='$Nome',
                                  descricao='$Descricao',
                                  ativo='$_REQUEST[ativo]'
                                Where id='$_REQUEST[id_categoria]'
                                 ";
                      //echo $Grava;
                      $as = "Edição efetuada por $_SESSION[usuario] - $Modulo_titulo";
                    }else{
                      $Grava = "Insert into $Modulo_link (
                                  nome,
                                  descricao,
                                  ativo
                                )values(
                                  '$Nome',
                                  '$Descricao',
                                  '$_REQUEST[ativo]'
                                )
                                 ";
                      //echo $Grava;
                      $as = "Cadastro efetuado por $_SESSION[usuario] - $Modulo_titulo";
                    }
                    pg_query($Grava);
                    ########################################################################
                    # Enviando e-mail
                    ########################################################################
                    $mensagem = "
                    <p>
                        $Modulo_titulo: $site_url/images/$Foto<BR>
                    </p>
                    ";

                    $para = $email_admin;

                    /* Para enviar email HTML, você precisa definir o header Content-type. */
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                    $headers .= "From: $as <$email_admin>\r\n";
                    $headers .= "Bcc: emerson@er7.com.br\r\n";
                    //$headers .= "Cc: emerson@er7.com.br\r\n";
                    //$headers .= "Bcc: uoposto@gmail.com\r\n";

                    $enviou = mail($para, $as, $mensagem, $headers);
                    ########################################################################
                    # E-mail enviado.!
                    ########################################################################
                    ?>
                    <table align="center" width="95%" border="0" class="arial11">
                      <tr>
                        <td align="center" height="200">
                          Dados gravados com sucesso.<BR><BR>
                        </td>
                      </tr>
                    </table>
                    <?php
                  }
                  ?>
              </tr>
            </table>
          </td>
          <?php
      }
      ?>
    </td>
  </tr>
  <tr align="center">
    <td colspan="2" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
</table>
