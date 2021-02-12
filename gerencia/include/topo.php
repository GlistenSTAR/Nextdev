<?php
session_start();
?>
<table cellpadding="0" cellspacing="0" border="0" width="980px" align="center">
 <tr>
	  <td style="background:url(images/bg_topo.jpg);"><a href="index.php?pg=busca"><img src="images/logo.png" border="0"></a></td>
	</tr>
 <tr style="background:url(images/bg_menu_topo.jpg);">
	  <td height="40px" align="right" class="data"><?php include "data.php"; ?></td>			
	</tr>
	<?php
	 if($_SESSION['LogaUser']){
	?>
	<tr>
			<td height="40px" align="right" class="data"><?php include "include/menu.php"; ?></td>	
	</tr>
	<?php
	 }
	?>
</table>