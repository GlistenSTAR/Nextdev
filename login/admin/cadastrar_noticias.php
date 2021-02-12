<?php
include "inc/config.php";
include "inc/verifica.php";
$Modulo_titulo = "Notícias";
$Modulo_link = "noticias";
$_SESSION[pagina] = "listar_noticias.php";
if (is_numeric($_REQUEST[localizar_numero])){
  include_once("inc/config.php");
  $SqlCarregaNoticia = pg_query("Select * from noticias where id='$_REQUEST[localizar_numero]'");
  $ccc = pg_num_rows($SqlCarregaNoticia);
  if ($ccc<>""){
    $n = pg_fetch_array($SqlCarregaNoticia);
  }
}
?>
<html>
<head>
<title><? echo "$Titulo_Admin ";?></title>
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
      if ($_SESSION[usuario]){
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
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="<? echo $site_url;?>icones/noticias.gif" border="0" align="left"><center><h3><? echo "$Modulo_titulo";?></h3></center><hr></hr></td>
              </tr>
              <tr>
                <td valign="top" align="center" width="100%">
                  <?
                  //Verifico se o cara mandou algo pra gravar.
                  if ($_REQUEST[acao]==""){
                    ?>
                    <form method="POST" name="cad" enctype="multipart/form-data">
                      <div id="divAbaMeio">
                      <input type="hidden" name="id_noticia" id="id_noticia" value="<? echo "$n[id]";?>">
                      <input type="hidden" name="posicao" id="posicao" value="<? echo "$_REQUEST[posicao]";?>">
                      <input type="hidden" name="acao" id="acao" value="cadastrar">
                      <table align="center" width="95%" border="0" class="arial11" cellspacing="4" cellspading="4">
                        <tr>
                          <td>Titulo<BR>
                          <textarea rows="4" cols="65" name="titulo" id="titulo" maxlength="120"><? echo "$n[titulo]";?></textarea></td>
                        </tr>
                        <tr>
                          <td>Texto<BR>
                          <textarea rows="8" cols="65" name="texto" id="texto" maxlength="120"><? echo "$n[texto]";?></textarea></td>
                        </tr>
                        <!--
                        <tr>
                          <td>Imagem<BR>
                          <input type="file" name="imagem" id="imagem" size="50" class="botao"></td>
                        </tr>
                        <tr>
                          <td>Legenda<BR>
                          <input type="text" name="legenda" id="legenda" size="40" value="<? echo "$n[legenda]";?>"></td>
                        </tr>
                        -->
                        <tr>
                          <td>Autor<BR>
                          <input type="text" name="autor" id="autor" size="40" value="<? echo "$n[autor]";?>"></td>
                        </tr>
                        <!--
                        <tr>
                          <td>Categoria<BR>
                          <input type="text" name="categoria" id="categoria" size="40" value="<? echo "$n[categoria]";?>"></td>
                        </tr>
                        -->
                        <tr>
                          <td>Publicar<BR>
                            <select name="publicado" id="publicado">
                              <option value="1">Agora</option>
                              <option value="0">Com agendamento</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Data: <? echo "$n[data]";?> <BR>
                           	<select name="dia_inicial" id="dia_inicial" onblur="return VerificaInicial()">
                           		<option value="<? echo date("d");?>"><? echo date("d");?></option>
                           		<option value="01">01</option>
                           		<option value="02">02</option>
                           		<option value="03">03</option>
                           		<option value="04">04</option>
                           		<option value="05">05</option>
                           		<option value="06">06</option>
                           		<option value="07">07</option>
                           		<option value="08">08</option>
                           		<option value="09">09</option>
                           		<option value="10">10</option>
                           		<option value="11">11</option>
                           		<option value="12">12</option>
                           		<option value="13">13</option>
                           		<option value="14">14</option>
                           		<option value="15">15</option>
                           		<option value="16">16</option>
                           		<option value="17">17</option>
                           		<option value="18">18</option>
                           		<option value="19">19</option>
                           		<option value="20">20</option>
                           		<option value="21">21</option>
                           		<option value="22">22</option>
                           		<option value="23">23</option>
                           		<option value="24">24</option>
                           		<option value="25">25</option>
                           		<option value="26">26</option>
                           		<option value="27">27</option>
                           		<option value="28">28</option>
                           		<option value="29">29</option>
                           		<option value="30">30</option>
                           		<option value="31">31</option>
                           	</select>
                            /
                           	<select name="mes_inicial" id="mes_inicial" onblur="return VerificaInicial()">
                            		<option value="<? echo date("m");?>"><? echo date("m");?></option>
                            		<option value="01">01</option>
                            		<option value="02">02</option>
                            		<option value="03">03</option>
                            		<option value="04">04</option>
                            		<option value="05">05</option>
                            		<option value="06">06</option>
                            		<option value="07">07</option>
                            		<option value="08">08</option>
                            		<option value="09">09</option>
                            		<option value="10">10</option>
                            		<option value="11">11</option>
                            		<option value="12">12</option>
                           	</select>
                            /
                           	<select name="ano_inicial" id="ano_inicial" onblur="return VerificaInicial()">
                              <option value="<? echo date("Y");?>"><? echo date("Y");?></option>
                              <option value="2000">2000</option>
                              <option value="2001">2001</option>
                              <option value="2002">2002</option>
                            		<option value="2003">2003</option>
                            		<option value="2004">2004</option>
                            		<option value="2005">2005</option>
                            		<option value="2006">2006</option>
                            		<option value="2007">2007</option>
                            		<option value="2008">2008</option>
                            		<option value="2009">2009</option>
                            		<option value="2010">2010</option>
                           	</select>
                          </td>
                        </tr>
                        <tr>
                          <td>Horário: <? echo "$n[hora_publicacao]";?><BR>
                            <select name="hora" id="hora">
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                            </select>
                            <select name="minuto" id="minuto">
                              <option value="00">00</option>
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <?
                              for($i=10; $i<61;$i++){
                                ?>
                                <option value="<? echo $i;?>"><? echo $i;?></option>
                                <?
                              }
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center">
                            <input type="button" onclick="acerta_campos('divAbaMeio','Conteudo','cadastrar_noticias.php',true)" name="Gravar" value="Gravar">
                            <input type="button" onclick="Acha('noticias.php','','Conteudo');" name="Cancelar" value="Cancelar">
                          </td>
                        </tr>
                      </table>
                      </div>
                    </form>
                    <?
                  }else{
                    //Verifico se o cara mandou algo pra gravar.
                    if ($_FILES['imagem']['name']<>""){
                      $uploaddir = '../imagens/';
                      #FOTO
                      $uploadfile = $uploaddir. $_FILES['imagem']['name'];
                      if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploaddir . $_FILES['imagem']['name'])) {
                          $Foto			= $_FILES['imagem']['name'];
                          //$Foto = $Arquivo;
                          $Foto2 = md5(time().$foton).$Foto;
                          rename($uploaddir."/".$Foto, $uploaddir."/".$Foto2);
                      }else{
                          ?>
                          <table align="center" width="95%" border="0" class="arial11">
                            <tr>
                              <td>
                                Erro ao gravar Imagem, faça a seleção novamente.<BR><BR>
                                <a href="cadastrar_<? echo "$Modulo_link";?>.php">Voltar</a>
                              </td>
                            </tr>
                          </table>
                          <?
                      }
                    }
                    $Titulo_Artigo = str_replace(chr(13),"<br>",$_REQUEST[titulo]);
                    $Texto = str_replace(chr(13),"<br>",$_REQUEST[texto]);
                    $Autor = $_REQUEST[autor];
                    $Categoria = $_REQUEST[categoria];
                    $Legenda = $_REQUEST[legenda];

                    $Posicao = $_REQUEST[posicao];
                    $Publicado = $_REQUEST[publicado];
                    $Data_publicar = "".$_REQUEST[ano_inicial]."-".$_REQUEST[mes_inicial]."-".$_REQUEST[dia_inicial]."";
                    $Hora_publicar = "".$_REQUEST[hora].":".$_REQUEST[minuto]."";
                    if ($_REQUEST[id_noticia]){ //se tiver Id somente atualizo
                      $Grava = "Update $Modulo_link set
                                  titulo='$Titulo_Artigo',
                                  texto='$Texto',
                                  autor='$Autor',
                                  legenda='$Legenda',
                                  categoria='$Categoria',
                                  publicado='$Publicado',
                                  data_publicacao='$Data_publicar',
                                  hora_publicacao='$Hora_publicar'
                                Where id='$_REQUEST[id_noticia]'
                                 ";
                      //echo $Grava;
                      $as = "Edição efetuada por $_SESSION[usuario] - $Modulo_titulo";
                    }else{
                      $Grava = "Insert into $Modulo_link (
                                  titulo,
                                  texto,
                                  foto,
                                  autor,
                                  legenda,
                                  categoria,
                                  data,
                                  publicado,
                                  data_publicacao,
                                  hora_publicacao,
                                  ativo
                                )values(
                                  '$Titulo_Artigo',
                                  '$Texto',
                                  '$Foto2',
                                  '$Autor',
                                  '$Legenda',
                                  '$Categoria',
                                  '$data_hoje',
                                  '$Publicado',
                                  '$Data_publicar',
                                  '$Hora_publicar',
                                  '1'
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
                    <?
                  }
                  ?>
              </tr>
            </table>
          </td>
          <?
      }
      ?>
    </td>
  </tr>
  <tr align="center">
    <td colspan="2" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
</table>
