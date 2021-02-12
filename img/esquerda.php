<?
$SiteUrl = "http://www.perfilcondutores.com.br/web/";
include "../inc/config.php";
###############################################################
if(!($db=pg_connect($str_conexao))) {
  echo "Não foi possível estabelecer uma conexão com o banco de dados";
  exit;
}
?>
<link rel="alternate stylesheet" title="lytebox" type="text/css" href="lytebox.css" />
<script language="JavaScript" src="lytebox.js"></script>
<html>
 <head>
  <style>
   BODY {
     background-color: white;}
   TD {
     font-size: 10pt; 
     font-family: verdana,helvetica;
     text-decoration: none;
     white-space: nowrap;}
   A:link {
     text-decoration: none;
     color: black;}
   A:visited {
     text-decoration: none;
     color: black;}
   A:active {
     text-decoration: none;
     color: black;}
   A:hover {
     text-decoration: none;
     color: blue;}
  </style>
  <script src="ua.js"></script>
  <script src="ftiens4.js"></script>
  <script src="demoFuncsNodes.js"></script>
   <script>
     foldersTree = gFld("<i>Categorias</i>", "direita.html")
     foldersTree.treeID = "Funcs"
     <?
     ////////////////////////////////////////////////////////////////////////////
     // CATEGORIAS
     ////////////////////////////////////////////////////////////////////////////
     $Sql = pg_query("Select * from categorias where ativo<>'0' order by nome");
     while ($c = pg_fetch_array($Sql)){
       ?>
       aux1 = insFld(foldersTree, gFld("<? echo $c[nome];?>", "javascript:parent.op()"));
         <?
         $Sql1 = "Select * from imagens where id_categoria='$c[id]' and id_categoria_sub='' and id_categoria_sub_sub='' and ativo<>'0' order by imagem";
         //echo "//$Sql1";
         $SqlImg = pg_query($Sql1);
         while ($ic = pg_fetch_array($SqlImg)){
           ?>
           insDoc(aux1, gLnk("R", "<? echo "$ic[legenda]";?>", "ver.php?imagem=<? echo "$ic[imagem]";?>&legenda=<? echo "$ic[legenda]";?>"));
           <?
         }
         ////////////////////////////////////////////////////////////////////////////
         // SUB - CATEGORIAS
         ////////////////////////////////////////////////////////////////////////////
         $SqlSub = pg_query("Select * from categorias_sub where id_categoria='$c[id]' and ativo<>'0'  order by nome");
         while ($cs = pg_fetch_array($SqlSub)){
           ?>
           aux2 = insFld(aux1, gFld("<i><? echo "$cs[nome]";?></i>", "javascript:parent.op()"));
           <?
           $SQL = "Select * from imagens where id_categoria='$c[id]' and id_categoria_sub='$cs[id]' and id_categoria_sub_sub='' and ativo<>'0' order by imagem";
           //echo "//sub - $SQL\n\n\n";
           $SqlImgSub = pg_query($SQL);
           while ($ics = pg_fetch_array($SqlImgSub)){
             ?>
             insDoc(aux2, gLnk("R", "<center><div onMouseover=this.style.backgroundColor='#EEEEEE';  onMouseout=this.style.backgroundColor='#ffffff';this.style.color='#000000';><img src='../imagens/thumb/<? echo $ics[imagem];?>' border='0'><BR><? echo $ics[legenda];?></div></center>", "ver.php?imagem=<? echo "$ics[imagem]";?>&legenda=<? echo "$ics[legenda]";?>"));
             <?
           }
           ////////////////////////////////////////////////////////////////////////////
           // SUB - SUB - CATEGORIAS
           ////////////////////////////////////////////////////////////////////////////
           $SqlSubSub = pg_query("Select * from categorias_sub_sub where id_categoria='$c[id]' and id_categoria_sub='$cs[id]' and ativo<>'0'  order by nome");
           while ($css = pg_fetch_array($SqlSubSub)){
             ?>
             aux3 = insFld(aux2, gFld("<i><? echo "$css[nome]";?></i>", "javascript:parent.op()"));
             <?
             $SQL = "Select * from imagens where id_categoria='$c[id]' and id_categoria_sub='$cs[id]' and id_categoria_sub_sub='$css[id]' and ativo<>'0' order by imagem";
             //echo "//SUB-SUB: $SQL\n\n\n";
             $SqlImgSubSub = pg_query($SQL);
             while ($icss = pg_fetch_array($SqlImgSubSub)){
               ?>
               insDoc(aux3, gLnk("R", "<center><div onMouseover=this.style.backgroundColor='#EEEEEE';  onMouseout=this.style.backgroundColor='#ffffff';this.style.color='#000000';><img src='../imagens/thumb/<? echo $icss[imagem];?>' border='0'><BR><? echo $icss[legenda];?></div></center>", "ver.php?imagem=<? echo "$icss[imagem]";?>&legenda=<? echo "$icss[legenda]";?>"));
               <?
             }
           }
         }
     }
  	  ?>
  </script>
 </head>
 <body topmargin="16" marginheight="16">
  <div style="position:absolute; top:0; left:0; "><table border="0"><tr><td><font size="-2"><a style="font-size:7pt;text-decoration:none;color:silver;" href="http://www.treemenu.net/" target="_blank"></a>Visualizador de Imagens</font></td></tr></table></div>
  <? echo $SQl;?>
   <SCRIPT>initializeDocument()</SCRIPT>
   <NOSCRIPT>
     A tree for site navigation will open here if you enable JavaScript in your browser.
   </NOSCRIPT>
 </body>
</html>
