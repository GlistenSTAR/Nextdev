<?php
include "config.php";
?>
<Head>
<title>Administração</title>
<div id="dhtmltooltip"></div>
<script language="JavaScript" src="inc/scripts/ajax.js"></script>
<script language="JavaScript" src="inc/scripts/iscpfcnpj.js"></script>
<script language="JavaScript" src="inc/scripts/isempty.js"></script>
<script language="JavaScript" src="inc/scripts/valores.js"></script>
<script language="JavaScript" src="inc/scripts/tip.js"></script>
<script language="JavaScript" src="inc/scripts/calendario.js?random=20060118"></script>
<link type="text/css" rel="stylesheet" href="inc/css.css?random=20073010" media="screen"></LINK>
<link type="text/css" rel="stylesheet" href="inc/admin.css?random=20073010" media="screen"></LINK>
<link type="text/css" rel="stylesheet" href="inc/theme.css?random=20073010" media="screen"></LINK>
<script language="JavaScript" src="inc/scripts/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="inc/scripts/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="inc/scripts/joomla.javascript.js" type="text/javascript"></script>
<script type="text/javascript" src="inc/scripts/upload.js"></script>
<script language="javascript">
  function checa(campo, caminho){
    if(!isCPFCNPJ(campo,0)){
      alert("Por favor informe um CPF/CNPJ válido");
      setTimeout(caminho+".focus()",50);
      return false;
    }
    return true;
  }
  function checaCodigo(campo, caminho){
    if(isEmpty(campo,0)){
      alert("Por favor informe o código");
      setTimeout(caminho+".focus()",50);
      return false;
    }
    return true;
  }
  window.onload = function() { preload(); }
  window.document.write("<style type=\"text/css\">#preloader { display: block !important; }</style>");
</script>
</Head>
<table width="772" border="0" align="center" cellpadding="0" cellspacing="0">
<div id="carregando" style="position: absolute; background: red; color: #FFFFFF; display: none; font-size: 12px;">Carregando...</div>
<div id="preloader"><div id="preloadIMG"><img src="icones/ajax-loader.gif" alt="" /></div></div>
<div id="wrapper">
	<div id="header">
			<div id="joomla">
     <table width="100%" cellspacing="0" cellpadding="0">
       <tr>
         <th class="form-block cpanel" align="center">
           Administrador
           <?php
           if ($_SESSION['usuario']){
             ?>
             &nbsp;&nbsp;&nbsp;&nbsp;Olá <b><?php echo $_SESSION['usuario'];?></b> <a href="inc/verifica.php?acao=SAIR">(sair)</a>
             <div align="right">
               Selecione a base de dados:
               <select id="id_base" name="id_base" onchange="return SelecionaBase();">
                 <option value=""></option>
                 <option value="3">Envase</option>
                 <option value="1">Fábrica</option>
                 <option value="4">RSA</option>
               </select>
             </div>
             <?php
           }
           ?>
         </th>
       </tr>
     </table>
   </div>
	</div>
</div>
<?php
if ($_SESSION['usuario']){
  ?>
  <table class="adminheading" border="0">
  		<tbody>
      <tr>
    			 <th class="cpanel">
          Painel de Controle
  	  		 </th>
      </tr>
    </tbody>
  </table>
<?php
}
?>
