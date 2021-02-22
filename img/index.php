<?php
include "../inc/verifica.php";
?>
<HTML>
 <HEAD>
  <TITLE>Visualizador de Imagens - Perfil</TITLE>
  <SCRIPT>
   function op() {
   }
   function exampleFunction(message) {
     alert("TreeView nodes can call JavaScript functions\n" + message)
   }
   function windowWithoutToolbar(urlStr, width, height) {
     window.open(urlStr, '_blank', 'location=no,status=no,scrollbars=no,menubar=no,toolbar=no,directories=no,resizable=no,width=' + width + ',height=' + height) 
   }
  </SCRIPT>
<link rel="alternate stylesheet" title="lytebox" type="text/css" href="lytebox.css" />
<script language="JavaScript" src="lytebox.js"></script>
 </HEAD>
 <FRAMESET cols="350,*" onResize="if (navigator.family == 'nn4') window.location.reload()">
  <FRAMESET rows="*,50">
   <FRAME src="esquerda.php" name="treeframe">
   <FRAME SRC="menu.html" name="menu" SCROLLING="no">
  </FRAMESET> 
  <FRAME SRC="direita.html" name="basefrm">
 </FRAMESET> 

</HTML>
