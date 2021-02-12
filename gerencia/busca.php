<?php
include ("include/common.php");
session_start();
if($_SESSION['LogaUser']){
?>
<script language="JavaScript">

function ValidaCampos(){
  		var Msg="";
  		if (!document.cad.busca.value){
  			Msg += "Selecione a base de dados   \n";
  		}

    if (document.cad.busca.value){
       if (!document.cad.vendedores.value){
        Msg += "Selecione um vendedor   \n";
       }
  		}


  		if (Msg){
      alert(Msg);
      return false;
  		}else{
      document.cad.submit();
      return false;
  		}
  }

</script>
<form id="cad" name="cad" action="?pg=cadastra" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
 <tr>
   <td height="41" align="center" style="background: URL('images/bg_busca.png');">
   
   <div id="geral" align="center" style="width:770px; height:20px;border:0 solid;" class="texto">
   
       <div id="base" style="float:left;" align="center">
          &nbsp;Base de Dados:   			
          <select name="busca" id="busca" style="width:150px;height:25px;" onchange="carregar()">
           <option value=""></option>
           <?php
            $SQL = pg_query($Nextweb, "SELECT id, base, descricao FROM dados WHERE codigo_empresa = '".$_SESSION['LogaEmpresa']."'");
            while($Lista = pg_fetch_array($SQL)){
           ?>
             <option value="<?php echo $Lista['base'];?>"><?php echo $Lista['descricao'];?></option>    
           <?php
            }
           ?>
          </select>
       </div>
       
       <div id="resultados" style="float:left;">
           &nbsp;Vendedor:
           <select id="vendedores" name="vendedores" >
              <option value="">- Selecione primeiro a base de dados -</option>
           </select>   
       </div>
       
       <div id="resultados" style="float:left;" align="left" valign="middle">
           &nbsp;|&nbsp;<input type="submit" value="Prosseguir" id="avancar" name="avancar" onClick="return ValidaCampos();">
       </div>
   
   </div>
   
			</td>		
	</tr>
</table>
</form>

<?php
echo str_repeat("<br>", 11);
}else{
  include"include/login.php";
}		
?>