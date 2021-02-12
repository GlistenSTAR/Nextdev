<?php
include ("inc/common.php");
  require("inc/config.php");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="7">&nbsp;</td>
    <td width="603">
      <?php
      if (!$_SESSION['erro']){
      ?>
      <table width="603" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="images/spacer.gif" width="1" height="3"></td>
        </tr>
        <tr>
          <td>          
            <table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <?php
                  $SqlListaNoticia = pg_query("Select * from noticias where ativo=1 order by id DESC limit 1 OFFSET 0");
                  while ($r = pg_fetch_array($SqlListaNoticia)){
                ?>
	          <!--<td><img src="images/lt3_r1_c1.jpg" width="8" height="214"></td>
                  <td width="378" background="images/lt3_r1_c2.jpg" valgin="top">-->
                  <td valgin="top">
                    <a href="#" onclick="Acha('ver.php','id=<?php echo $r['id'];?>','Conteudo');">
                      <span class="titulo1">                        
                          <?php
                          $Titulo = $r['titulo'];
                          if (strlen($Titulo)>60) {
                          $Titulo = substr($Titulo,0,60)."...";
                          }
                          echo $Titulo;
                          ?>                        
                      </span>
                      <BR><BR>
                      <?php
                      if ($r['foto']){
                        ?>
                        <img src="imagens/<?php echo $r['foto'];?>" border="0" align="left">
                        <?php
                      }
                      ?>
                      <span class="texto1">
                        <?php
                        $Texto = $r['texto'];
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
                  <!--<td><img src="images/lt3_r1_c4.jpg" width="8" height="214"></td>-->
                  <?php
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
          <!-- 
          <td width="7">&nbsp;</td>
          <td width="218" valign="top">
            <table width="218" border="0" align="right" cellpadding="0" cellspacing="0">
                <?php
                $SqlListaNoticia = pg_query("Select * from noticias where ativo=1 order by id DESC limit 1 OFFSET 1");
                while ($r = pg_fetch_array($SqlListaNoticia)){
                  ?>
                  <td><img src="images/lt2_r1_c1.jpg" width="7" height="150"></td>
                  <td width="212" background="images/lt2_r1_c2.jpg">
                    <a href="#" onclick="Acha('ver.php','id=<?php echo $r[id];?>','Conteudo');">
                      <span class="titulo1">                        
                          <?php
                          $Titulo = $r[titulo];
                          if (strlen($Titulo)>60) {
                          $Titulo = substr($Titulo,0,60)."...";
                          }
                          echo $Titulo;
                          ?>                        
                      </span>
                      <BR><BR>
                      <span class="texto1">
                        <?php
                        $Texto = $r[texto];
                        if (strlen($Texto)>120) {
                        $Texto = substr($Texto,0,120)."...";
                        }
                        echo $Texto;
                        ?>
                      </span>
                      <BR>
                      <span align="right">
                        Leia +
                      </span>
                    </a>
                  </td>
                  <td><img src="images/lt2_r1_c4.jpg" width="7" height="150"></td>
                  <?php
                }
                ?>
            </table>
            -->
          </td>
        </tr>
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
                      <td colspan="3"><img src="images/spacer.gif" width="1" height="10"></td>
                    </tr>
                      <?php
                      $SqlListaNoticia = pg_query("Select * from noticias where ativo<>'0' order by id DESC limit 10 OFFSET 1");
                      while ($r = pg_fetch_array($SqlListaNoticia)){
                        ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td width="100%" valgin="top">
                            <a href="#" onclick="Acha('ver.php','id=<?php echo $r['id'];?>','Conteudo');">
                              <span class="titulo1">
                                <strong>
                                  <?php
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
                                <?php
                                $Texto = $r['texto'];
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
                        <?php
                      }
                      ?>
                    <tr>
                      <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                    </tr>
                  </table>
                  <!--
                  <table width="592" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="titulo1" align="center"><img src="images/spacer.gif" width="1" height="5"> <b>�ltimas imagens cadastradas</b></td>
                    </tr>
                    <tr>
                      <td bgcolor="#CCCCCC" ><img src="images/spacer.gif" width="1" height="1"></td>
                    </tr>
                    <tr>
                      <td>                         
                        <table width="592" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <?php
                            $SqlCarregaImagens = pg_query("Select * from imagens where ativo<>0 order by id DESC limit 3");
                            while($i = pg_fetch_array($SqlCarregaImagens)){
                              ?>
                              <td>&nbsp;</td>
                              <td valgin="top">
                                <a href="#" onclick="Acha('ver_imagem.php','id=<?php echo $i[id];?>','Conteudo');">
                                  <span class="titulo1">
                                    <strong>
                                      <?php echo $i[legenda]; ?>
                                    </strong>
                                    <img src="imagens/<?php echo $i[imagem];?>" width="50" height="50" align="left" border="0">
                                  </span>
                                </a>
                              </td>
                              <td width="20">&nbsp;</td>
                              <?php
                            }
                            ?>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3" align="right" class="titulo1"><BR><img src="images/spacer.gif" width="1" height="5"><img src=icones/pesquisar.png>&nbsp;&nbsp;<a href="#" onclick="Acha('pesquisar_imagens.php','','Conteudo');">Procurar outras imagens</a></td>
                    </tr>
                  </table>                  
                </td>
              </tr>
            </table>
            -->
          </td>
        </tr>
        <tr>
          <td><img src="images/l1_r4_c1.gif" width="603" height="4"></td>
        </tr>
        <tr>
          <td height="100%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="texto1" align="center">&nbsp; O site é melhor visualizado em <b>1024x768</b></td>
        </tr>
      </table>
      <?php
      }else{
        echo $_SESSION['erro'];
        session_destroy();
      }
      ?>
    </td>
    <td width="7">&nbsp;</td>
  </tr>
</table>
