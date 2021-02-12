<?php
include ("inc/common.php");
include "inc/verifica.php";
$_SESSION['pagina'] = "pedidos.php";
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td valign="top" align="center" class="titulo1">
      <BR><BR>
      <img src="icones/pedidos.gif" border="0"><BR>
      <b>Menu de opção  para Pedidos.</b>
    </td>
  </tr>
  <tr>
    <td valign="top" align="center">
      <BR><BR>
      <hr></hr>
      <BR><BR><BR>
      <table align="center" width="80%" border="0" cellspacing="0" cellpadding="0" class="texto1">
        <tr>
          <?php
            //if (($_SESSION[nivel]="1") AND ($_SESSION[nivel]="2")){
            if ($_SESSION['nivel']>"0"){
            ?>
            <td valign="top" width="50%" align="center">
              <a href="#" onclick="Acha('cadastrar_pedidos.php','','Conteudo');">
                <img src="icones/cadastrar.gif" border="0"><BR><b>Cadastrar</b>
              </a>
            </td>
            <?php
          }
          ?>
          <td valign="top" width="50%" align="center">
            <a href="#" onclick="Acha('listar_pedidos.php','','Conteudo');">
              <img src="icones/editar.gif" border="0"><BR><b>Listar / Imprimir</b>
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php
//echo "  $_SESSION[us][codigo_empresa]<BR>
//  $_SESSION[codigo_empresa]<BR>
//  $_SESSION[host]<BR>
//  $_SESSION[bd][base]<BR>
//  $_SESSION[bd][usuario]<BR>
//  $_SESSION[bd][senha]<BR>
//  $_SESSION[bd][descricao]<BR>
//  $_SESSION[bd][porta]<BR>";