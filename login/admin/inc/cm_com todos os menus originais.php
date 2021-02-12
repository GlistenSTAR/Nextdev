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
<div id="carregando" style="position: absolute; background: red; color: #FFFFFF;display: none;">Carregando...</div>
<div id="preloader"><div id="preloadIMG"><img src="icones/ajax-loader.gif" alt="" /></div></div>
<div id="wrapper">
	<div id="header">
			<div id="joomla">
     <table width="100%" cellspacing="0" cellpadding="0">
       <tr><th class="form-block cpanel" align="center">Administrador</th></tr>
     </table>
   </div>
	</div>
</div>
<table class="menubar" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
	<td class="menubackgr" style="padding-left: 5px;">
					<div id="myMenuID">
       <table summary="main menu" class="ThemeOfficeMenu" cellspacing="0">
         <tbody>
           <tr>
             <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',0)" onmousedown="cmItemMouseDown (this,0)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,0)">
               <span class="ThemeOfficeMainItemLeft">&nbsp;</span>
               <span class="ThemeOfficeMainItemText">Home</span>
               <span class="ThemeOfficeMainItemRight">&nbsp;</span>
             </td>
             <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',1)" onmousedown="cmItemMouseDown (this,1)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,1)">&nbsp;</td>
             <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID1','hbr',2)" onmousedown="cmItemMouseDown (this,2)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,2)">
               <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
               <span class="ThemeOfficeMainFolderText">Site</span>
               <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
             </td>
             <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',21)" onmousedown="cmItemMouseDown (this,21)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,21)">&nbsp;</td>
             <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID6','hbr',22)" onmousedown="cmItemMouseDown (this,22)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,22)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Menu</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',29)" onmousedown="cmItemMouseDown (this,29)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,29)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID7','hbr',30)" onmousedown="cmItemMouseDown (this,30)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,30)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Content</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',54)" onmousedown="cmItemMouseDown (this,54)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,54)">&nbsp;
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID12','hbr',55)" onmousedown="cmItemMouseDown (this,55)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,55)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Components</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',71)" onmousedown="cmItemMouseDown (this,71)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,71)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID17','hbr',72)" onmousedown="cmItemMouseDown (this,72)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,72)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Modules</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',75)" onmousedown="cmItemMouseDown (this,75)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,75)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID18','hbr',76)" onmousedown="cmItemMouseDown (this,76)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,76)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Mambots</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',78)" onmousedown="cmItemMouseDown (this,78)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,78)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID19','hbr',79)" onmousedown="cmItemMouseDown (this,79)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,79)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Installers</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',87)" onmousedown="cmItemMouseDown (this,87)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,87)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID20','hbr',88)" onmousedown="cmItemMouseDown (this,88)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,88)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">Messages</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',91)" onmousedown="cmItemMouseDown (this,91)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,91)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,'cmSubMenuID21','hbr',92)" onmousedown="cmItemMouseDown (this,92)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,92)">
             <span class="ThemeOfficeMainFolderLeft">&nbsp;</span>
             <span class="ThemeOfficeMainFolderText">System</span>
             <span class="ThemeOfficeMainFolderRight">&nbsp;</span>
           </td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',96)" onmousedown="cmItemMouseDown (this,96)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,96)">&nbsp;</td>
           <td class="ThemeOfficeMainItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',1,null,'hbr',97)" onmousedown="cmItemMouseDown (this,97)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,97)">
             <span class="ThemeOfficeMainItemLeft">&nbsp;</span>
             <span class="ThemeOfficeMainItemText">Help</span>
             <span class="ThemeOfficeMainItemRight">&nbsp;</span>
           </td>
         </tr>
       </tbody>
     </table>
     <div style="top: 67px; left: 45px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID1">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',3)" onmousedown="cmItemMouseDown (this,3)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,3)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/config.png"></td><td class="ThemeOfficeMenuItemText">Global Configuration</td><td class="ThemeOfficeMenuItemRight">
               <img alt="" src="inc/scripts/ThemeOffice/blank.png">
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID2','vbr',4)" onmousedown="cmItemMouseDown (this,4)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,4)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/language.png"></td>
             <td class="ThemeOfficeMenuFolderText">Language Manager</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',6)" onmousedown="cmItemMouseDown (this,6)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,6)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/media.png"></td>
             <td class="ThemeOfficeMenuItemText">Media Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID3','vbr',7)" onmousedown="cmItemMouseDown (this,7)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,7)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/preview.png"></td>
             <td class="ThemeOfficeMenuFolderText">Preview</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID4','vbr',11)" onmousedown="cmItemMouseDown (this,11)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,11)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/globe1.png"></td>
             <td class="ThemeOfficeMenuFolderText">Statistics</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID5','vbr',13)" onmousedown="cmItemMouseDown (this,13)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,13)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/template.png"></td>
             <td class="ThemeOfficeMenuFolderText">Template Manager</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',19)" onmousedown="cmItemMouseDown (this,19)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,19)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/trash.png"></td>
             <td class="ThemeOfficeMenuItemText">Trash Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',20)" onmousedown="cmItemMouseDown (this,20)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,20)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/users.png"></td>
             <td class="ThemeOfficeMenuItemText">User Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="left: 193px; top: 89px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID2">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',5)" onmousedown="cmItemMouseDown (this,5)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,5)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/language.png"></td>
             <td class="ThemeOfficeMenuItemText">Site Languages</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID3">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',8)" onmousedown="cmItemMouseDown (this,8)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,8)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/preview.png"></td>
             <td class="ThemeOfficeMenuItemText">In New Window</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',9)" onmousedown="cmItemMouseDown (this,9)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,9)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/preview.png"></td>
             <td class="ThemeOfficeMenuItemText">Inline</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',10)" onmousedown="cmItemMouseDown (this,10)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,10)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/preview.png"></td>
             <td class="ThemeOfficeMenuItemText">Inline with Positions</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID4">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',12)" onmousedown="cmItemMouseDown (this,12)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,12)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/search_text.png"></td>
             <td class="ThemeOfficeMenuItemText">Search Text</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID5">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',14)" onmousedown="cmItemMouseDown (this,14)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,14)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/template.png"></td>
             <td class="ThemeOfficeMenuItemText">Site Templates</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',15)" onmousedown="cmItemMouseDown (this,15)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,15)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',16)" onmousedown="cmItemMouseDown (this,16)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,16)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/template.png"></td>
             <td class="ThemeOfficeMenuItemText">Administrator Templates</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',17)" onmousedown="cmItemMouseDown (this,17)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,17)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',18)" onmousedown="cmItemMouseDown (this,18)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,18)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/template.png"></td><td class="ThemeOfficeMenuItemText">Module Positions</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 76px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID6">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',23)" onmousedown="cmItemMouseDown (this,23)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,23)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/menus.png"></td>
             <td class="ThemeOfficeMenuItemText">Menu Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',24)" onmousedown="cmItemMouseDown (this,24)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,24)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',25)" onmousedown="cmItemMouseDown (this,25)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,25)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/menus.png"></td>
             <td class="ThemeOfficeMenuItemText">mainmenu</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',26)" onmousedown="cmItemMouseDown (this,26)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,26)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/menus.png"></td>
             <td class="ThemeOfficeMenuItemText">othermenu</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',27)" onmousedown="cmItemMouseDown (this,27)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,27)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/menus.png"></td>
             <td class="ThemeOfficeMenuItemText">topmenu</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',28)" onmousedown="cmItemMouseDown (this,28)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,28)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/menus.png"></td>
             <td class="ThemeOfficeMenuItemText">usermenu</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 115px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID7">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID8','vbr',31)" onmousedown="cmItemMouseDown (this,31)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,31)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuFolderText">Content by Section</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',44)" onmousedown="cmItemMouseDown (this,44)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,44)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',45)" onmousedown="cmItemMouseDown (this,45)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,45)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">All Content Items</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',46)" onmousedown="cmItemMouseDown (this,46)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,46)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Static Content Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',47)" onmousedown="cmItemMouseDown (this,47)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,47)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',48)" onmousedown="cmItemMouseDown (this,48)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,48)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/add_section.png"></td>
             <td class="ThemeOfficeMenuItemText">Section Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',49)" onmousedown="cmItemMouseDown (this,49)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,49)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/add_section.png"></td>
             <td class="ThemeOfficeMenuItemText">Category Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',50)" onmousedown="cmItemMouseDown (this,50)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,50)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',51)" onmousedown="cmItemMouseDown (this,51)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,51)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/home.png"></td>
             <td class="ThemeOfficeMenuItemText">Front Page Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',52)" onmousedown="cmItemMouseDown (this,52)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,52)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Archive Manager</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',53)" onmousedown="cmItemMouseDown (this,53)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,53)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/globe3.png"></td>
             <td class="ThemeOfficeMenuItemText">Page Impressions</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID8">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID9','vbr',32)" onmousedown="cmItemMouseDown (this,32)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,32)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/document.png"></td>
             <td class="ThemeOfficeMenuFolderText">News</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID10','vbr',36)" onmousedown="cmItemMouseDown (this,36)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,36)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/document.png"></td>
             <td class="ThemeOfficeMenuFolderText">Newsflashes</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID11','vbr',40)" onmousedown="cmItemMouseDown (this,40)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,40)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/document.png"></td>
             <td class="ThemeOfficeMenuFolderText">FAQs</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID9">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',33)" onmousedown="cmItemMouseDown (this,33)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,33)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">News Items</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',34)" onmousedown="cmItemMouseDown (this,34)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,34)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/backup.png"></td>
             <td class="ThemeOfficeMenuItemText">News Archives</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',35)" onmousedown="cmItemMouseDown (this,35)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,35)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/add_section.png"></td>
             <td class="ThemeOfficeMenuItemText">News Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
         </table>
         </div>
         <div class="ThemeOfficeSubMenu" id="cmSubMenuID10">
         <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
           <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',37)" onmousedown="cmItemMouseDown (this,37)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,37)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Newsflashes Items</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',38)" onmousedown="cmItemMouseDown (this,38)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,38)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/backup.png"></td>
             <td class="ThemeOfficeMenuItemText">Newsflashes Archives</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',39)" onmousedown="cmItemMouseDown (this,39)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,39)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/add_section.png"></td>
             <td class="ThemeOfficeMenuItemText">Newsflashes Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID11">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',41)" onmousedown="cmItemMouseDown (this,41)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,41)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">FAQs Items</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',42)" onmousedown="cmItemMouseDown (this,42)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,42)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/backup.png"></td>
             <td class="ThemeOfficeMenuItemText">FAQs Archives</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',43)" onmousedown="cmItemMouseDown (this,43)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,43)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/add_section.png"></td>
             <td class="ThemeOfficeMenuItemText">FAQs Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 165px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID12">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID13','vbr',56)" onmousedown="cmItemMouseDown (this,56)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,56)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/component.png"></td>
             <td class="ThemeOfficeMenuFolderText">Banners</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID14','vbr',59)" onmousedown="cmItemMouseDown (this,59)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,59)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/user.png"></td>
             <td class="ThemeOfficeMenuFolderText">Contacts</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',62)" onmousedown="cmItemMouseDown (this,62)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,62)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/mass_email.png"></td>
             <td class="ThemeOfficeMenuItemText">Mass Mail</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID15','vbr',63)" onmousedown="cmItemMouseDown (this,63)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,63)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/component.png"></td>
             <td class="ThemeOfficeMenuFolderText">News Feeds</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',66)" onmousedown="cmItemMouseDown (this,66)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,66)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/component.png"></td>
             <td class="ThemeOfficeMenuItemText">Polls</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',67)" onmousedown="cmItemMouseDown (this,67)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,67)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/component.png"></td>
             <td class="ThemeOfficeMenuItemText">Syndicate</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,'cmSubMenuID16','vbr',68)" onmousedown="cmItemMouseDown (this,68)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,68)">
             <td class="ThemeOfficeMenuFolderLeft"><img src="inc/scripts/ThemeOffice/globe2.png"></td>
             <td class="ThemeOfficeMenuFolderText">Web Links</td>
             <td class="ThemeOfficeMenuFolderRight"><img alt="" src="inc/scripts/ThemeOffice/arrow.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID13">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',57)" onmousedown="cmItemMouseDown (this,57)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,57)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Manage Banners</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',58)" onmousedown="cmItemMouseDown (this,58)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,58)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/categories.png"></td>
             <td class="ThemeOfficeMenuItemText">Manage Clients</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID14">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',60)" onmousedown="cmItemMouseDown (this,60)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,60)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Manage Contacts</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',61)" onmousedown="cmItemMouseDown (this,61)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,61)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/categories.png"></td>
             <td class="ThemeOfficeMenuItemText">Contact Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID15">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',64)" onmousedown="cmItemMouseDown (this,64)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,64)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Manage News Feeds</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',65)" onmousedown="cmItemMouseDown (this,65)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,65)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/categories.png"></td>
             <td class="ThemeOfficeMenuItemText">Manage Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID16">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',69)" onmousedown="cmItemMouseDown (this,69)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,69)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/edit.png"></td>
             <td class="ThemeOfficeMenuItemText">Web Link Items</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',70)" onmousedown="cmItemMouseDown (this,70)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,70)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/categories.png"></td>
             <td class="ThemeOfficeMenuItemText">Web Link Categories</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID17">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',73)" onmousedown="cmItemMouseDown (this,73)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,73)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/module.png"></td>
             <td class="ThemeOfficeMenuItemText">Site Modules</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',74)" onmousedown="cmItemMouseDown (this,74)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,74)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/module.png"></td>
             <td class="ThemeOfficeMenuItemText">Administrator Modules</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div class="ThemeOfficeSubMenu" id="cmSubMenuID18">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',77)" onmousedown="cmItemMouseDown (this,77)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,77)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/module.png"></td>
             <td class="ThemeOfficeMenuItemText">Site Mambots</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 347px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID19">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',80)" onmousedown="cmItemMouseDown (this,80)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,80)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Templates - Site</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',81)" onmousedown="cmItemMouseDown (this,81)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,81)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Templates - Admin</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',82)" onmousedown="cmItemMouseDown (this,82)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,82)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Languages</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',83)" onmousedown="cmItemMouseDown (this,83)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,83)">
             <td class="ThemeOfficeMenuItemLeft"></td>
             <td colspan="2">
               <div class="ThemeOfficeMenuSplit"></div>
             </td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',84)" onmousedown="cmItemMouseDown (this,84)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,84)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Components</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',85)" onmousedown="cmItemMouseDown (this,85)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,85)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Modules</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',86)" onmousedown="cmItemMouseDown (this,86)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,86)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/install.png"></td>
             <td class="ThemeOfficeMenuItemText">Mambots</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 403px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID20">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',89)" onmousedown="cmItemMouseDown (this,89)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,89)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/messaging_inbox.png"></td>
             <td class="ThemeOfficeMenuItemText">Inbox</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',90)" onmousedown="cmItemMouseDown (this,90)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,90)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/messaging_config.png"></td>
             <td class="ThemeOfficeMenuItemText">Configuration</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
     </div>
     <div style="top: 67px; left: 466px; visibility: hidden;" class="ThemeOfficeSubMenu" id="cmSubMenuID21">
       <table summary="sub menu" class="ThemeOfficeSubMenuTable" cellspacing="0">
         <tbody>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',93)" onmousedown="cmItemMouseDown (this,93)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,93)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/joomla_16x16.png"></td>
             <td class="ThemeOfficeMenuItemText">Version Check</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',94)" onmousedown="cmItemMouseDown (this,94)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,94)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/sysinfo.png"></td>
             <td class="ThemeOfficeMenuItemText">System Info</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
           <tr class="ThemeOfficeMenuItem" onmouseover="cmItemMouseOverOpenSub (this,'ThemeOffice',0,null,'vbr',95)" onmousedown="cmItemMouseDown (this,95)" onmouseout="cmItemMouseOut (this,500)" onmouseup="cmItemMouseUp (this,95)">
             <td class="ThemeOfficeMenuItemLeft"><img src="inc/scripts/ThemeOffice/checkin.png"></td>
             <td class="ThemeOfficeMenuItemText">Global Checkin</td>
             <td class="ThemeOfficeMenuItemRight"><img alt="" src="inc/scripts/ThemeOffice/blank.png"></td>
           </tr>
         </tbody>
       </table>
      </div>
    </div>

			<script language="JavaScript" type="text/javascript">
			var myMenu =
			[
						[null,'Home','index.php',null,'Painel de Controle'],
				_cmSplit,
							[null,'Site',null,null,'Administração do Site',
					['<img src="inc/scripts/ThemeOffice/config.png" />','Global Configuration','index2.php?option=com_config&hidemainmenu=1',null,'Configuration'],
					['<img src="inc/scripts/ThemeOffice/language.png" />','Language Manager',null,null,'Manage languages',
	  					['<img src="inc/scripts/ThemeOffice/language.png" />','Site Languages','index2.php?option=com_languages',null,'Manage Languages'],
	   				],
					['<img src="inc/scripts/ThemeOffice/media.png" />','Media Manager','index2.php?option=com_media',null,'Manage Media Files'],
						['<img src="inc/scripts/ThemeOffice/preview.png" />', 'Preview', null, null, 'Preview',
						['<img src="inc/scripts/ThemeOffice/preview.png" />','In New Window','http://10.1.1.200/desenvolvimento/testes/joomla/index.php','_blank','http://10.1.1.200/desenvolvimento/testes/joomla'],
						['<img src="inc/scripts/ThemeOffice/preview.png" />','Inline','index2.php?option=com_admin&task=preview',null,'http://10.1.1.200/desenvolvimento/testes/joomla'],
						['<img src="inc/scripts/ThemeOffice/preview.png" />','Inline with Positions','index2.php?option=com_admin&task=preview2',null,'http://10.1.1.200/desenvolvimento/testes/joomla'],
					],
					['<img src="inc/scripts/ThemeOffice/globe1.png" />', 'Statistics', null, null, 'Site Statistics',
						['<img src="inc/scripts/ThemeOffice/search_text.png" />', 'Search Text', 'index2.php?option=com_statistics&task=searches', null, 'Search Text']
					],
					['<img src="inc/scripts/ThemeOffice/template.png" />','Template Manager',null,null,'Change site template',
	  					['<img src="inc/scripts/ThemeOffice/template.png" />','Site Templates','index2.php?option=com_templates',null,'Change site template'],
	  					_cmSplit,
	  					['<img src="inc/scripts/ThemeOffice/template.png" />','Administrator Templates','index2.php?option=com_templates&client=admin',null,'Change admin template'],
	  					_cmSplit,
	  					['<img src="inc/scripts/ThemeOffice/template.png" />','Module Positions','index2.php?option=com_templates&task=positions',null,'Template positions']
	  				],
					['<img src="inc/scripts/ThemeOffice/trash.png" />','Trash Manager','index2.php?option=com_trash',null,'Manage Trash'],
					['<img src="inc/scripts/ThemeOffice/users.png" />','User Manager','index2.php?option=com_users&task=view',null,'Manage users'],
				],
				_cmSplit,
				[null,'Menu',null,null,'Menu Management',
					['<img src="/inc/scripts/ThemeOffice/menus.png" />','Menu Manager','index2.php?option=com_menumanager',null,'Menu Manager'],
					_cmSplit,
					['<img src="/inc/scripts/ThemeOffice/menus.png" />','mainmenu','index2.php?option=com_menus&menutype=mainmenu',null,''],
					['<img src="inc/scripts/ThemeOffice/menus.png" />','othermenu','index2.php?option=com_menus&menutype=othermenu',null,''],
					['<img src="inc/scripts/ThemeOffice/menus.png" />','topmenu','index2.php?option=com_menus&menutype=topmenu',null,''],
					['<img src="inc/scripts/ThemeOffice/menus.png" />','usermenu','index2.php?option=com_menus&menutype=usermenu',null,''],
				],
				_cmSplit,
				[null,'Content',null,null,'Content Management',
					['<img src="inc/scripts/ThemeOffice/edit.png" />','Content by Section',null,null,'Content Managers',
						['<img src="inc/scripts/ThemeOffice/document.png" />','News', null, null,'News',
							['<img src="inc/scripts/ThemeOffice/edit.png" />', 'News Items', 'index2.php?option=com_content&sectionid=1',null,null],
							['<img src="inc/scripts/ThemeOffice/backup.png" />', 'News Archives','index2.php?option=com_content&task=showarchive&sectionid=1',null,null],
							['<img src="inc/scripts/ThemeOffice/add_section.png" />', 'News Categories', 'index2.php?option=com_categories&section=1',null, null],
						],
						['<img src="inc/scripts/ThemeOffice/document.png" />','Newsflashes', null, null,'Newsflashes',
							['<img src="inc/scripts/ThemeOffice/edit.png" />', 'Newsflashes Items', 'index2.php?option=com_content&sectionid=2',null,null],
							['<img src="inc/scripts/ThemeOffice/backup.png" />', 'Newsflashes Archives','index2.php?option=com_content&task=showarchive&sectionid=2',null,null],
							['<img src="inc/scripts/ThemeOffice/add_section.png" />', 'Newsflashes Categories', 'index2.php?option=com_categories&section=2',null, null],
						],
						['<img src="../inc/scripts/scripts/ThemeOffice/document.png" />','FAQs', null, null,'FAQs',
							['<img src="inc/scripts/ThemeOffice/edit.png" />', 'FAQs Items', 'index2.php?option=com_content&sectionid=3',null,null],
							['<img src="inc/scripts/ThemeOffice/backup.png" />', 'FAQs Archives','index2.php?option=com_content&task=showarchive&sectionid=3',null,null],
							['<img src="inc/scripts/ThemeOffice/add_section.png" />', 'FAQs Categories', 'index2.php?option=com_categories&section=3',null, null],
						],
					],
					_cmSplit,
						['<img src="inc/scripts/ThemeOffice/edit.png" />','All Content Items','index2.php?option=com_content&sectionid=0',null,'Manage Content Items'],
	  				['<img src="inc/scripts/ThemeOffice/edit.png" />','Static Content Manager','index2.php?option=com_typedcontent',null,'Manage Typed Content Items'],
	  				_cmSplit,
	  				['<img src="inc/scripts/ThemeOffice/add_section.png" />','Section Manager','index2.php?option=com_sections&scope=content',null,'Manage Content Sections'],
					['<img src="inc/scripts/ThemeOffice/add_section.png" />','Category Manager','index2.php?option=com_categories&section=content',null,'Manage Content Categories'],
					_cmSplit,
	  				['<img src="inc/scripts/ThemeOffice/home.png" />','Front Page Manager','index2.php?option=com_frontpage',null,'Manage Front Page Items'],
	  				['<img src="inc/scripts/ThemeOffice/edit.png" />','Archive Manager','index2.php?option=com_content&task=showarchive&sectionid=0',null,'Manage Archive Items'],
	  				['<img src="inc/scripts/ThemeOffice/globe3.png" />', 'Page Impressions', 'index2.php?option=com_statistics&task=pageimp', null, 'Page Impressions'],
				],
				_cmSplit,
				[null,'Components',null,null,'Component Management',
					['<img src="inc/scripts/ThemeOffice/component.png" />','Banners',null,null,'Banner Management',
					['<img src="inc/scripts/ThemeOffice/edit.png" />','Manage Banners','index2.php?option=com_banners',null,'Active Banners'],
					['<img src="inc/scripts/ThemeOffice/categories.png" />','Manage Clients','index2.php?option=com_banners&task=listclients',null,'Manage Clients']
				],
				['<img src="inc/scripts/ThemeOffice/user.png" />','Contacts',null,null,'Edit contact details',
					['<img src="inc/scripts/ThemeOffice/edit.png" />','Manage Contacts','index2.php?option=com_contact',null,'Edit contact details'],
					['<img src="inc/scripts/ThemeOffice/categories.png" />','Contact Categories','index2.php?option=categories&section=com_contact_details',null,'Manage contact categories']
				],
				['<img src="inc/scripts/ThemeOffice/mass_email.png" />','Mass Mail','index2.php?option=com_massmail&hidemainmenu=1',null,'Send Mass Mail'
				],
				['<img src="inc/scripts/ThemeOffice/component.png" />','News Feeds',null,null,'News Feeds Management',
					['<img src="inc/scripts/ThemeOffice/edit.png" />','Manage News Feeds','index2.php?option=com_newsfeeds',null,'Manage News Feeds'],
					['<img src="inc/scripts/ThemeOffice/categories.png" />','Manage Categories','index2.php?option=com_categories&section=com_newsfeeds',null,'Manage Categories']
				],
				['<img src="inc/scripts/ThemeOffice/component.png" />','Polls','index2.php?option=com_poll',null,'Manage Polls'
				],
				['<img src="inc/scripts/ThemeOffice/component.png" />','Syndicate','index2.php?option=com_syndicate&hidemainmenu=1',null,'Manage Syndication Settings'
				],
				['<img src="inc/scripts/ThemeOffice/globe2.png" />','Web Links',null,null,'Manage Weblinks',
					['<img src="inc/scripts/ThemeOffice/edit.png" />','Web Link Items','index2.php?option=com_weblinks',null,'View existing weblinks'],
					['<img src="inc/scripts/ThemeOffice/categories.png" />','Web Link Categories','index2.php?option=categories&section=com_weblinks',null,'Manage weblink categories']
				],
				],
				_cmSplit,
				[null,'Modules',null,null,'Module Management',
					['<img src="scripts/ThemeOffice/module.png" />', 'Site Modules', "index2.php?option=com_modules", null, 'Manage Site modules'],
					['<img src="scripts/ThemeOffice/module.png" />', 'Administrator Modules', "index2.php?option=com_modules&client=admin", null, 'Manage Administrator modules'],
				],
				_cmSplit,
				[null,'Mambots',null,null,'Mambot Management',
					['<img src="scripts/ThemeOffice/module.png" />', 'Site Mambots', "index2.php?option=com_mambots", null, 'Manage Site Mambots'],
				],
					_cmSplit,
				[null,'Installers',null,null,'Installer List',
					['<img src="scripts/ThemeOffice/install.png" />','Templates - Site','index2.php?option=com_installer&element=template&client=',null,'Install Site Templates'],
					['<img src="scripts/ThemeOffice/install.png" />','Templates - Admin','index2.php?option=com_installer&element=template&client=admin',null,'Install Administrator Templates'],
					['<img src="scripts/ThemeOffice/install.png" />','Languages','index2.php?option=com_installer&element=language',null,'Install Languages'],
					_cmSplit,
					['<img src="scripts/ThemeOffice/install.png" />', 'Components','index2.php?option=com_installer&element=component',null,'Install/Uninstall Components'],
					['<img src="scripts/ThemeOffice/install.png" />', 'Modules', 'index2.php?option=com_installer&element=module', null, 'Install/Uninstall Modules'],
					['<img src="scripts/ThemeOffice/install.png" />', 'Mambots', 'index2.php?option=com_installer&element=mambot', null, 'Install/Uninstall Mambots'],
				],
				_cmSplit,
	  			[null,'Messages',null,null,'Messaging Management',
	  				['<img src="scripts/ThemeOffice/messaging_inbox.png" />','Inbox','index2.php?option=com_messages',null,'Private Messages'],
	  				['<img src="scripts/ThemeOffice/messaging_config.png" />','Configuration','index2.php?option=com_messages&task=config&hidemainmenu=1',null,'Configuration']
	  			],
				_cmSplit,
	  			[null,'System',null,null,'System Management',
	  				['<img src="scripts/ThemeOffice/joomla_16x16.png" />', 'Version Check', 'http://www.joomla.org/latest10', '_blank','Version Check'],
	  				['<img src="scripts/ThemeOffice/sysinfo.png" />', 'System Info', 'index2.php?option=com_admin&task=sysinfo', null,'System Information'],
						['<img src="scripts/ThemeOffice/checkin.png" />', 'Global Checkin', 'index2.php?option=com_checkin', null,'Check-in all checked-out items'],
				],
				_cmSplit,
				[null,'Help','index2.php?option=com_admin&task=help',null,null]
			];
			cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
			</script>
		</td>
	<td class="menubackgr" style="padding-right: 5px;" align="right">

		<a href="index2.php?option=logout" style="color: rgb(51, 51, 51); font-weight: bold;">
			Logout</a>
		<strong>admin</strong>
	</td>
</tr>
</tbody>
</table>
<table class="adminheading" border="0">
		<tbody>
    <tr>
  			 <th class="cpanel">
    		 	Control Panel
	  		 </th>
    </tr>
  </tbody>
</table>
