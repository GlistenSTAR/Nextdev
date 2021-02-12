<div class="texto1">
<BR>
Versão - <b> 3.1 </b> de 10/01/2011
<BR>
<div align="left">
  <i>
  <b>Novos recursos:</b><BR>
  * Upgrade nos relatórios e correções nas listagens de pedidos e clientes;<BR>
  </i>
</div>
<?
if ($_REQUEST[versoes_anteriores]){
  ?>
  <BR>
  Versão - <b> 3.0 </b> de 10/01/2010
  <BR>
  <div align="left">
    <i>
    <b>Novos recursos:</b><BR>
    * Integração com o Next2000;<BR>
    </i>
  </div>
  <BR>
  Versão - <b> 2.0.6 </b> de 26/05/2009
  <BR>
  <div align="left">
    <i>
    <b>Novos recursos:</b><BR>
    * Os relatórios foram organizados e ajustados em um link só;<BR>
    * Incluído filtro para clientes bloqueados;<BR>
    </i>
  </div>
  <BR>
  Versão - <b> 2.0.5 </b> de 22/01/2009
  <BR>
  <div align="left">
    <i>
    <b>Novos recursos:</b><BR>
    * Pesquisa de produtos;<BR>
    * Usar pontos para separar valores;<BR>
    * Acerescentada opção de armazenar orçamento (botão somente gravar);<BR>
    </i>
  </div>
  <HR>
  Versão - <b> 2.0.4 </b> de 14/01/2009
  <BR>
  <div align="left">
    <i>
    <b>Correções:</b><BR>
    * Retirado envio de e-mails;<BR>
    * Corrigido lançamento de pedidos;<BR>
    * Arrumado opção de venda casada para impressão;<BR>
    * Incluída visualização da classificação fiscal do ítem no lançamento do pedido;<BR>
    * Criação de atalho para impressão de pedidos logo após a gravação.
    </i>
  </div>
  <HR>
  Versão - <b> 2.0.3 </b> de 06/11/2008
  <BR>
  <div align="left">
    <i>
    <b>Correções:</b><BR>
    * Corrigido envio de e-mails.<BR>
    </i>
  </div>
  <HR>
  Versão - <b> 2.0.2 </b> de 27/10/2008
  <BR>
  <div align="left">
    <i>
    <b>Correções:</b><BR>
    <?if($CodigoEmpresa=="75"){/*Perlex*/?>
    * Venda Casada.<BR>
    <?}?>
    </i>
  </div>
  <HR>
  Versão - <b> 2.0.1 </b> de 01/10/2008
  <BR>
  <div align="left">
    <i>
    <b>Correções:</b><BR>
    * Bug na paginação;<BR>
    <?if($CodigoEmpresa=="75"){/*Perlex*/?>
    * Venda casada;<BR>
    * Tipo de Pedido;<BR>
    * Termo de responsabilidade.<BR>
    <?}?>
    </i>
  </div>
  <?
}else{
  ?>
  <div style="float: right;">
    <a href="#" onclick="Acha('versao.php','versoes_anteriores=true','Conteudo')">Versões anteriores</a>
  </div>
  <?
}
?>
</div>
