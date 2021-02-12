<link href="inc/css.css" rel="stylesheet" type="text/css">
  <table align="left" border="0" cellspacing="0" cellpadding="0" class="texto1">
    <tr>
      <td valign="top">
        <div id="divAbaGeral-menu" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaTopo-menu" background="images/l1_r2_c1.gif" width="750">
            <div style="cursor: pointer;" id="menu-corpoAba1" name="menu-corpoAba1" class="divAbaAtiva">
              <a onclick="trocarAba('menu-',1,4)">Vendas</a>
            </div>
            <div id="menu-aba1" name="menu-aba1"><div class="divAbaAtivaFim"></div></div>
            <div style="cursor: pointer;" id="menu-corpoAba2" name="menu-corpoAba3" class="divAbaInativa">
              <a onclick="trocarAba('menu-',2,4);">Finanças</a>
            </div>
            <div id="menu-aba2" name="menu-aba2"><div class="divAbaInativaFim"></div></div>
            <div style="cursor: pointer;" id="menu-corpoAba3" name="menu-corpoAba3" class="divAbaInativa">
              <a onclick="trocarAba('menu-',3,4);">Estoque</a>
            </div>
            <div id="menu-aba3" name="menu-aba3"><div class="divAbaInativaFim"></div></div>
            <div style="cursor: pointer;" id="menu-corpoAba4" name="menu-corpoAba4" class="divAbaInativa">
              <a onclick="trocarAba('menu-',4,4);">Compras</a>
            </div>
            <div id="menu-aba4" name="menu-aba4"><div class="divAbaInativaFim"></div></div>
          </div>
          <div id="divAbaMeio">
             <table border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td valign="top" background="images/l1_r2_c1.gif">
                   <table border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td colspan="3" valign="top">
                         <span style="" name="menu-corpo1" id="menu-corpo1">
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 Escolha a opção desejada para o módulo - VENDAS
                               </td>
                             </tr>
                           </table>
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 <table width="148" border="0" cellspacing="0" cellpadding="1">
                                   <tr>
                                     <td valign="top">
                                       <div id="botao-menu">
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                                               <span class="texto1">Cad. Clientes</span>
                                          			</a>
                                          	</div>
                                       </div>
                                     </td>
                                     <td>
                                       <div id="botao-menu">
                                         <div >
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('cadastrar_pedidos.php','','Conteudo');">
                                               <span class="texto1">Criar Pedidos</span>
                                          			</a>
                                          	</div>
                                         </div>
                                       </div>
                                     </td>
                                     <td valign="top">
                                       <div id="botao-menu">
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('listar_clientes.php','','Conteudo');">
                                               <span class="texto1" title="Consulta de clientes">Cons. Clientes</span>
                                          			</a>
                                          	</div>
                                       </div>
                                     </td>
                                     <td>
                                       <div id="botao-menu">
                                         <div >
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('listar_pedidos.php','','Conteudo');">
                                               <span class="texto1" title="Consulta de pedidos">Cons. Pedidos</span>
                                          			</a>
                                          	</div>
                                         </div>
                                       </div>
                                     </td>
                                     <td>
                                       <div id="botao-menu">
                                         <div >
                                          	<div class="icon">
                                        	    <a href="#" onclick="location.href='inc/verifica.php?acao=SAIR'">
                                               <span class="texto1">Sair</span>
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
                         <span name="menu-corpo2" id="menu-corpo2" style="display: none;">
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 Escolha a opção desejada para o módulo - FINANÇAS
                               </td>
                             </tr>
                           </table>
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 <table width="148" border="0" cellspacing="0" cellpadding="1">
                                   <tr>
                                     <td valign="top">
                                       <div id="botao-menu">
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                                               <span class="texto1">Cad. Clientes</span>
                                          			</a>
                                          	</div>
                                       </div>
                                     </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                           </table>
                         </span>
                         <span name="menu-corpo3" id="menu-corpo3" style="display: none;">
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 Escolha a opção desejada para o módulo - ESTOQUE
                               </td>
                             </tr>
                           </table>
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 <table width="148" border="0" cellspacing="0" cellpadding="1">
                                   <tr>
                                     <td valign="top">
                                       <div id="botao-menu">
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                                               <span class="texto1">Cad. Clientes</span>
                                          			</a>
                                          	</div>
                                       </div>
                                     </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                           </table>
                         </span>
                         <span name="menu-corpo4" id="menu-corpo4" style="display: none;">
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 Escolha a opção desejada para o módulo - COMPRAS
                               </td>
                             </tr>
                           </table>
                           <table width="148" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr id="titulo_frame">
                               <td>
                                 <table width="148" border="0" cellspacing="0" cellpadding="1">
                                   <tr>
                                     <td valign="top">
                                       <div id="botao-menu">
                                          	<div class="icon">
                                        	    <a href="#" onclick="Acha('cadastrar_clientes.php','','Conteudo');">
                                               <span class="texto1">Cad. Clientes</span>
                                          			</a>
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
          </div>
        </div>
      </td>
    </tr>
  </table>
