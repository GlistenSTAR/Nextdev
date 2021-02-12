<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7">&nbsp;</td>
    <td width="603" height="400">
      <?
//      if (!$_SESSION[erro]){
        include("inc/config.php");
        ?>
        <? include "alteracoes.php";?>
        <!--
        <table width="603" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3"></td>
          </tr>
          <tr>
            <td>
              <table border="0" cellspacing="2" cellpadding="2">
                <tr>
                  <?
                  $SqlListaNoticia = pg_query("Select * from noticias order by id DESC limit 1 OFFSET 0");
                  while ($r = pg_fetch_array($SqlListaNoticia)){
                    ?>
                    <td valgin="top">

                      <img src="imagens/noticia1.gif" width="150" height="120"  border="0" align="left">

                      <a href="#" onclick="Acha('ver.php','id=<? echo $r[id];?>','Conteudo');">
                        <span class="titulo1">
                            <?
                            $Titulo = $r[titulo];
                            if (strlen($Titulo)>60) {
                            $Titulo = substr($Titulo,0,60)."...";
                            }
                            echo $Titulo;
                            ?>
                        </span>
                        <BR><BR>
                        <span class="texto1">
                          <?
                          $Texto = $r[texto];
                          if (strlen($Texto)>500) {
                          $Texto = substr($Texto,0,500)."...";
                          }
                          echo $Texto;
                          ?>
                        </span>
                        <BR>
                        <div align="right" class="texto1">
                          Leia +
                        </div>
                      </a>
                    </td>
                    <?
                    $atual++;
                    if ($atual==$QtdColunas){
                      echo "</tr><tr>";
                      $atual = "";
                    }
                  }
                  ?>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><img src="images/spacer.gif" width="1" height="3"></td>
                </tr>
                <tr>
                  <td><img src="images/l1_r1_c1.gif" width="750" height="4"></td>
                </tr>
                <tr>
                  <td height="214" valign="top" background="images/l1_r2_c1.gif" width="750">
                    <table width="592" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td colspan="3"><img src="images/spacer.gif" width="1" height="10"></td>
                      </tr>
                        <?
                        $SqlListaNoticia = pg_query("Select * from noticias order by id DESC limit 10 OFFSET 1");
                        while ($r = pg_fetch_array($SqlListaNoticia)){
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td width="100%" valgin="top">
                              <a href="#" onclick="Acha('ver.php','id=<? echo $r[id];?>','Conteudo');">
                                <span class="titulo1">
                                  <strong>
                                    <?
                                    $Titulo = $r[titulo];
                                    if (strlen($Titulo)>60) {
                                      $Titulo = substr($Titulo,0,60)."...";
                                    }
                                    echo $Titulo;
                                    ?>
                                  </strong>
                                </span>
                                <BR>
                                <span class="texto1">
                                  <?
                                  $Texto = $r[texto];
                                  if (strlen($Texto)>100) {
                                    $Texto = substr($Texto,0,100)."...";
                                  }
                                  echo $Texto;
                                  ?>
                                </span>
                              </a>
                            </td>
                            <td width="20">&nbsp;</td>
                          </tr>
                          <tr>
                            <td><img src="images/spacer.gif" width="1" height="10"></td>
                          </tr>
                          <tr>
                            <td bgcolor="#CCCCCC" colspan="3"><img src="images/spacer.gif" width="1" height="1"></td>
                          </tr>
                          <tr>
                            <td><img src="images/spacer.gif" width="1" height="10"></td>
                          </tr>
                          <?
                        }
                        ?>
                      <tr>
                        <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><img src="images/l1_r4_c1.gif" width="750" height="4"></td>
          </tr>
          <tr>
            <td height="100%">&nbsp;</td>
          </tr>
        </table>
        -->
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="texto1" align="center"><BR><BR>&nbsp; O site é melhor visualizado em <b>1024x768</b><BR><BR><BR></td>
          </tr>
        </table>
        <?
//      }else{
//        echo "$_SESSION[erro]";
//        $_SESSION[erro] = "";
//        //session_destroy();
//      }
      ?>
    </td>
    <td width="7">&nbsp;</td>
  </tr>
</table>
