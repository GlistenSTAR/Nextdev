<link href="css.css" rel="stylesheet" type="text/css">
<table width="210" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#FFFFFF"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="210" height="45" align="center"><img src="images/Cat_logo.gif" width="190" height="31"></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><img src="images/spacer.gif" width="1" height="1"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <form action="?pg=busca" method="POST">
              <select name="id_categoria" size="1">
                <option value="">Todas</option>
                <?
                $Lista = mysql_query("Select id, nome from $tb_categorias order by nome");
                while ($cat = mysql_fetch_array($Lista)){
                  ?>
                  <option value="<? echo $cat[id];?>"><? echo "$cat[nome]";?></option>
                  <?
                }
                ?>
              </select>
              <input type="text" name="busca" size="10">
              <input type="submit" name="ok" value="ok">
            </form>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? include ("es.php"); ?>
