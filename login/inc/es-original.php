<link href="inc/css.css" rel="stylesheet" type="text/css">
  <table align="center" border="0" cellspacing="0" cellpadding="0" class="texto1" style="background: #FFFFFF;" width="120">
    <tr>
      <td valign="top">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
              <table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="3" valign="top">
                    <span style="" name="menu-corpo1" id="menu-corpo1">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr id="titulo_frame">
                          <td>
                            <table border="0" cellspacing="0" cellpadding="1">
                              <?
                              if ($_SESSION[codigo_empresa]<>"95"){
                                ?>
                                <tr>
                                  <td valign="top">
                                    <div id="botao-menu">
                                       	<div class="icon">
                                     	    <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                                            <b>Cad. Clientes</b>
                                       			</a>
                                       	</div>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div id="botao-menu">
                                      <div >
                                       	<div class="icon">
                                     	    <a href="#" onclick="Acha('cadastrar_pedidos.php','','Conteudo');">
                                           <b> Criar Pedidos</b>
                                       			</a>
                                       	</div>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <?
                              }else{
                                ?>
                                <tr>
                                  <td>
                                    <div id="botao-menu">
                                      <div >
                                       	<div class="icon">
                                     	    <a href="#" onclick="Acha('listar_orcamentos.php','','Conteudo');">
                                           <b>Cons. Orçam.</b>
                                       			</a>
                                       	</div>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div id="botao-menu">
                                      <div >
                                       	<div class="icon">
                                     	    <a href="#" onclick="Acha('listar_produtos.php','','Conteudo');">
                                           <b>Cons. Produtos</b>
                                       			</a>
                                       	</div>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <?
                              }
                              ?>
                              <tr>
                                <td valign="top">
                                  <div id="botao-menu">
                                     	<div class="icon">
                                   	    <a href="#" onclick="Acha('listar_clientes.php','','Conteudo');">
                                          <b>Cons. Clientes</b>
                                     			</a>
                                     	</div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div id="botao-menu">
                                    <div >
                                     	<div class="icon">
                                   	    <a href="#" onclick="Acha('listar_pedidos.php','','Conteudo');">
                                          <b>Cons. Pedidos</b>
                                     			</a>
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div id="botao-menu">
                                    <div >
                                     	<div class="icon">
                                   	    <a href="#" onclick="Acha('alteracoes.php','','Conteudo');">
                                          <b>Alterações</b>
                                     			</a>
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <!--
                              <tr>
                                <td>
                                  <div id="botao-menu">
                                    <div >
                                     	<div class="icon">
                                   	    <a href="#" onclick="Acha('login.php','','Conteudo');">
                                          <b>Trocar Base</b>
                                     			</a>
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              -->
                              <tr>
                                <td>
                                  <div id="botao-menu">
                                    <div >
                                     	<div class="icon">
                                   	    <a href="#" onclick="location.href='inc/verifica.php?acao=SAIR'">
                                          <b>Sair</b>
                                     			</a>
                                     	</div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
