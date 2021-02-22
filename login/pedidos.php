<?php
include_once ("inc/common.php");
include "inc/verifica.php";
$_SESSION['pagina'] = "pedidos.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td valign="top" align="center" class="titulo1">
      <img src="icones/pedidos.gif" border="0"><BR>
      <b>Menu de opção para Pedidos.</b>
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
            <a href="#" onclick="Acha('cadastrar_pedidos.php','','Conteudo');">
              <img src="icones/cadastrar.gif" border="0"><BR><b>Cadastrar</b>
            </a>
          </td>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('listar_pedidos.php','','Conteudo');">
              <img src="icones/editar.gif" border="0"><BR><b>Listar</b>
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
