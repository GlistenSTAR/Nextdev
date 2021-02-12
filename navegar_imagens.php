<?
include "inc/verifica.php";
include "inc/config.php";
$_SESSION[pagina] = "listar_imagens.php";
?>
<link href="inc/css_print.css" rel="stylesheet" type="text/css" media="print">
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<?
if ($_REQUEST[acao]=="excluir"){
  $SqlExcluir = pg_query("Update imagens set ativo=0 where id='$_REQUEST[id]'");
}
if ($_REQUEST[localizar]=="sub"){
  $SqlCarregaCat = pg_query("Select * from categorias_sub where id_categoria='$_REQUEST[id_categoria]' order by nome");
  while ($c = pg_fetch_array($SqlCarregaCat)){
    ?>
      <span id="categoriasub" style="cursor: pointer;" onclick="Acha('navegar_imagens.php','localizar=subsub&id_categoria=<? echo $_REQUEST[id_categoria];?>&id_categoria_sub=<? echo $c[id];?>','categoria_sub_sub<? echo $_REQUEST[id_categoria];?>');">
          [+] <? echo "$c[nome]";?>
      </span>
    <?
  }
}
if ($_REQUEST[id_categoria]){
  ?>
  <td>
  <table border="0" cellspacing="1" cellpadding="1" width="100" valign="top" class="texto1">
    <tr>
      <?
      $qtd = 5;
      $Sql = pg_query("Select * from imagens where id_categoria='$_REQUEST[id_categoria]' and ativo<>'0' order by id");
      while ($i = pg_fetch_array($Sql)){
        ?>
        <td>
          <img src="imagens/<? echo $i[thumb];?>" width="80" height="80"><BR>
        </td>
        <?
        $atual++;
        if ($atual==$qtd){
          echo "</tr><tr>";
          $atual = "";
        }
      }
      ?>
    </tr>
    <tr>
      <td height="100%">&nbsp;</td>
    </tr>
  </table>
  </td>
  <?
}
if ($_REQUEST[localizar]=="subsub"){
  ?>
    <td>Selecione a sub-sub-categoria</td>
    <td>
      <select name='id_categoria_sub_sub' id='id_categoria_sub_sub'>
        <option value='todos'>TODOS</option>
          <?
          $Sql = "Select * from categorias_sub_sub where id_categoria_sub='$_REQUEST[id_categoria_sub]' order by nome";
          //echo $Sql;
          $SqlCarregaCat = pg_query($Sql);
          while ($c = pg_fetch_array($SqlCarregaCat)){
            echo "<option value='$c[id]'>$c[nome]</option>";
          }
          ?>
      </select>
    </td>
  <?
}
if (!$_REQUEST[localizar]){
  ?>
  <form name="listar">
  <table border="0" cellspacing="1" cellpadding="1" class="adminform texto1"  width="100%" height="350" valign="top">
    <tr>
      <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
    </tr>
    <tr>
      <td colspan="4" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<img src="admin/icones/imagens.gif" border="0" align="left">
        <center><h3>Imagens de produtos</h3></center><hr></hr>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
    </tr>
    <tr>
      <td valign="top">Categorias</td>
    </tr>
    <tr>
      <td valgin="top">
        <table border="1" cellspacing="1" cellpadding="1" width="100" valign="top" class="texto1">
          <tr>
            <td valign="top">
              <table border="0" cellspacing="1" cellpadding="1" width="100" valign="top" class="texto1">
                <?
                $Sql = pg_query("Select * from categorias order by nome");
                while ($c = pg_fetch_array($Sql)){
                  ?>
                  <tr>
                    <td valign="top" id="categoria">
                      <span style="cursor: pointer;" onclick="Acha('navegar_imagens.php','localizar=sub&id_categoria=<? echo $c[id];?>','categoria_sub<? echo $c[id];?>');Acha('navegar_imagens.php','localizar=sub&id_categoria=<? echo $c[id];?>','imagens');">
                        [+] - <? echo "$c[nome]";?>
                      </span>
                      <BR>
                      <span id="categoria_sub<? echo $c[id];?>"></span>
                      <span id="categoria_sub_sub<? echo $c[id];?>"></span>
                    </td>
                  </tr>
                  <?
                }
                ?>
              </table>
            </td>
            <td valign="top">
              <table border="0" cellspacing="1" cellpadding="1" width="100" valign="top" class="texto1">
                <tr id='imagens'>
                  Imagensss
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td height="100%">&nbsp;</td>
    </tr>
  </table>
  <?
}
$_SESSION[pagina] = "listar_imagens.php";
?>
