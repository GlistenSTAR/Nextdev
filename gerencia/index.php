<?php
include ("include/common.php");
include "include/config.php";
include "css/css.php";
?>

<script language="JavaScript" src="script/ajax.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body background="images/bg.jpg">
<title>ADMIN - NEXTWEB</title>
<table width="980" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF">
 <tr>
	 <td align="center"><?php include("include/topo.php");?></td>
	</tr>
 <tr>
	 <td align="center" background="images/root.jpg">		
				<?php
					if (!@include($_REQUEST['pg']).".php"){
								if(!$_SESSION['LogaUser']){
										include "include/login.php";
								}else{
									include"index.php?pg=busca";
								}		
					}
				?>	
		</td>
	</tr>
 <tr>
	 <td align="center"><?php include("include/baixo.php");?></td>
	</tr>	
</table>