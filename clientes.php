<?
include "inc/verifica.php";
$_SESSION[pagina] = "clientes.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td valign="top" align="center" class="titulo1">
      <BR><BR>
      <img src="icones/clientes.gif" border="0"><BR>
      <b>Menu de opção  para Clientes.</b>
    </td>
  </tr>
  <tr>
    <td valign="top" align="center">
      <BR><BR>
      <hr></hr>
      <BR><BR><BR>
      <table align="center" width="80%" border="0" cellspacing="0" cellpadding="0" class="texto1">
        <tr>
          <?
          //if ($_SESSION[nivel]=="2"){
										if (($_SESSION[login]=="LAILA") AND ($_SESSION[nivel]=="2")){
            ?>
            <td valign="top" width="50%" align="center">
              <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                <img src="icones/cadastrar.gif" border="0"><BR><b>Cadastrar / Editar</b>
              </a>
            </td>
            <?
          }
          ?>
          <td valign="top" width="50%" align="center">
          <a href="#" onclick="Acha('listar_clientes.php','','Conteudo');">
              <img src="icones/editar.gif" border="0"><BR><b>Listar</b>
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>