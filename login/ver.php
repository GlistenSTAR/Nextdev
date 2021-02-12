<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7">&nbsp;</td>
    <td width="603">
      <?
      include_once("inc/config.php");
      ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3"></td>
              </tr>
              <tr>
                <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
              </tr>
              <tr>
                <td height="214" valign="top" background="images/l1_r2_c1.gif">
                  <table width="592" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                    </tr>
                    <?
                    $SqlListaNoticia = pg_query("Select * from noticias where id='$_REQUEST[id]'");
                    $r = pg_fetch_array($SqlListaNoticia);
                    ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td width="100%" valgin="top">
                         <span class="titulo1">
                           <strong>
                             <?
                             $Titulo = $r[titulo];
                             echo $Titulo;
                             ?>
                           </strong>
                         </span>
                         <BR><br><br>
                         <span class="texto1">
                           <?
                           $Texto = $r[texto];
                           echo $Texto;
                           ?>
                         </span>
                      </td>
                      <td width="20">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                    </tr>
                    <tr>
                      <td colspan="3" class="texto1" align="right"><BR><BR><a href="#" onclick="Acha('inicio.php','','Conteudo');">Voltar</a></td>
                    </tr>
                    <tr>
                      <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/l1_r4_c1.gif" width="603" height="4"></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td height="100%">&nbsp;</td>
        </tr>
      </table>
    </td>
    <td width="7">&nbsp;</td>
  </tr>
</table>
