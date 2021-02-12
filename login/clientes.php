<?
include "inc/verifica.php";
$_SESSION[pagina] = "clientes.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td valign="top" align="center" class="titulo1">
      <img src="icones/clientes.gif" border="0"><BR>
      <b>Menu de opção para Clientes.</b>
    </td>
  </tr>
  <tr>
    <td valign="top" align="center">
      <BR>
      <hr></hr>
      <BR>
      <table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
        <tr>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
              <img src="icones/cadastrar.gif" border="0"><BR><b>Cadastrar / Editar</b>
            </a>
          </td>
          <td valign="top" align="center">
            <a href="#" onclick="window.open('imprimir_clientes.php','_blank')">
              <img src="icones/editar.gif" border="0"><BR><b>Listar</b>
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

