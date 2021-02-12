<?
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
           <?
           if ($_SESSION[usuario]){
             ?>
             &nbsp;&nbsp;&nbsp;&nbsp;Olá <b><? echo $_SESSION[usuario];?></b> <a href="inc/verifica.php?acao=SAIR">(sair)</a>
             <?
           }
           ?>
         </th>
         </tr>
     </table>
   </div>
	</div>
</div>
<?
if ($_SESSION[usuario]){
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
<?
}
?>
<!--
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
-->
