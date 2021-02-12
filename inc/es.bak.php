<link href="inc/css.css" rel="stylesheet" type="text/css">
<table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
      <table width="148" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr> 
          <td width="5" valign="top"><img src="images/menu_r1_c1.jpg" width="5" height="159"></td>
          <td valign="top" style="background: url(images/menu_r1_c2.jpg) repeat-x;">
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr>
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="Acha('inicio.php','','Conteudo');">Página Principal</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr> 
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="Acha('clientes.php','','Conteudo');">Clientes</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr>
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="return Acha('pedidos.php','','Conteudo');">Pedidos</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr>
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="Acha('credito.php','','Conteudo');">Consulta crédito</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr>
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="Acha('forms/pesquisar_produtos.php','','Conteudo');">Pesquisar produtos</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            <?php
            if ($CodigoEmpresa=="86"){ //Perfil
              //Retirado por indicação do Sérgio
              // Não vão liberar esse tipo de opção, foi uma idéia da Edjane para suprir uma necessidade simples
              ?>
              <!--
              <table width="138" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="138">
                    <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                      <tr>
                        <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                        <td width="120" height="18"><strong>
                          <?php
                          if ($_SESSION[usuario]){
                            ?>
                            <a href="img/" target="_blank">
                              Imagens
                            </a>
                            <?php
                          }else{
                            ?>
                            <a href="#" onclick="Acha('credito.php','','Conteudo');">
                              Imagens
                            </a>
                            <?php
                          }
                          ?>

                        </strong></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td><img src="images/linha_menu.gif" width="138" height="1"></td>
                </tr>
                <tr>
                  <td><img src="images/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
              -->
              <table width="138" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="138">
                    <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                      <tr>
                        <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                        <td width="120" height="18"><strong>
                          <a href="#" onclick="Acha('relatorios/index.php','','Conteudo');">
                            Relatórios
                          </a>
                        </strong></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td><img src="images/linha_menu.gif" width="138" height="1"></td>
                </tr>
              </table>
              <?php
            }
            ?>
            <!--
            E-mail: Wed, Nov 19, 2008 at 11:44 AM
            <table width="138" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="138">
                  <table width="138" border="0" cellpadding="0" cellspacing="0" class="arial11">
                    <tr>
                      <td width="18"><img src="images/icone.gif" width="10" height="8"></td>
                      <td width="120" height="18"><strong><a href="#" onclick="Acha('emails.php','','Conteudo');">Enviar E-mail</a></strong></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td><img src="images/linha_menu.gif" width="138" height="1"></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="5"></td>
              </tr>
            </table>
            -->
          </td>
          <td width="5" valign="top"><img src="images/menu_r1_c4.jpg" width="5" height="159"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
