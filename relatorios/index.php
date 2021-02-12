<?
include "../inc/verifica.php";
include "../inc/config.php";
$_SESSION[pagina] = "relatorios/index.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td valign="top" align="center">
      <table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
        <tr>
          <td colspan="2" align="center">
            <img src="icones/report.jpg" borde="0"><BR>
            <b>Relatórios</b>
          </td>
        </tr>
        <tr>
          <td colspan="2" ><hR></td>
        </tr>
        <tr>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('listar_clientes.php','','Conteudo')">
              <img src="icones/clientes.gif" border="0"><BR><b>Listar Clientes</b>
            </a>
          </td>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('listar_pedidos.php','','Conteudo');">
              <img src="icones/editar.gif" border="0"><BR><b>Listar Pedidos</b>
            </a>
          </td>
        </tr>
        <tr>
          <td><BR><BR></td>
        </tr>
        <tr>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('relatorios/pedidos_clientes.php','','Conteudo');">
              <img src="icones/pedidos.jpg" border="0"><BR><b>Pedidos por cliente</b>
            </a>
          </td>
          <td valign="top" align="center">
            <a href="#" onclick="Acha('relatorios/faturamento.php','','Conteudo');">
              <img src="icones/pedidos.jpg" border="0"><BR><b>Faturamento</b>
            </a>
          </td>
        </tr>
        <tr>
          <td><BR><BR></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

