<?php include_once ("inc/common.php"); ?>
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
<?php if (isset($_REQUEST['versoes_anteriores'])){ ?>
    <BR>Versão - <b> 3.0 </b> de 10/01/2010<BR>
    <div align="left">
      <i>
        <b>Novos recursos:</b><BR>
        * Integra��o com o Next2000;<BR>
      </i>
    </div>
    
    <BR>Versão - <b> 2.0.6 </b> de 26/05/2009<BR>
    
    <div align="left">
      <i>
      <b>Novos recursos:</b><BR>
      * Os Relatórios foram organizados e ajustados em um link s�;<BR>
      * Inclu�do filtro para clientes bloqueados;<BR>
      </i>
    </div>
    
    <BR>Versão - <b> 2.0.5 </b> de 22/01/2009 <BR>
    <div align="left">
      <i>
      <b>Novos recursos:</b><BR>
      * Pesquisa de produtos;<BR>
      * Usar pontos para separar valores;<BR>
      * Acerescentada op��o de armazenar or�amento (bot�o somente gravar);<BR>
      </i>
    </div>
    <HR>
    Versão - <b> 2.0.4 </b> de 14/01/2009<BR>
    <div align="left">
      <i>
        <b>Corre��es:</b><BR>
        * Retirado envio de e-mails;<BR>
        * Corrigido lan�amento de pedidos;<BR>
        * Arrumado op��o de venda casada para impress�o;<BR>
        * Inclu�da visualiza��o da classifica��o fiscal do �tem no lan�amento do pedido;<BR>
        * Cria��o de atalho para impress�o de pedidos logo apàs a grava��o.
      </i>
    </div>
    <HR>
      Versão - <b> 2.0.3 </b> de 06/11/2008<BR>
    <div align="left">
      <i>
        <b>Corre��es:</b><BR>
        * Corrigido envio de e-mails.<BR>
      </i>
    </div>
    <HR>
    Versão - <b> 2.0.2 </b> de 27/10/2008<BR>

    <div align="left">
      <i>
        <b>Corre��es:</b><BR>
        <?php if($CodigoEmpresa=="75"){  /*Perlex*/?>
          * Venda Casada.<BR>
        <?php } ?>
      </i>
    </div>
    <HR>
    Versão - <b> 2.0.1 </b> de 01/10/2008<BR>
    
    <div align="left">
      <i>
        <b>Corre��es:</b><BR>
        * Bug na pagina��o;<BR>
        <?php  if($CodigoEmpresa=="75"){ /*Perlex*/?>
          * Venda casada;<BR>
          * Tipo de Pedido;<BR>
          * Termo de responsabilidade.<BR>
        <?php }?>
      </i>
    </div>
<?php }else{ ?>
  
  <div style="float: right;">
    <a href="#" onclick="Acha('versao.php','versoes_anteriores=true','Conteudo')">Versões anteriores</a>
  </div>
<?php } ?>
</div>
