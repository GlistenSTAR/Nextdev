<?php
include ("include/common.php");
session_start();
if($_SESSION['LogaUser']){
include "include/config.php";
?>

<script language="JavaScript">

  function ValidaCampos(){
      var Msg="";
      if (!document.cad.usuario.value){
       Msg += "Informe um usuário   \n";
      }
      
      if (!document.cad.senha.value){
       Msg += "Informe a senha   \n";
      }

      if (!document.cad.status.value){
       Msg += "Selecione um status   \n";
      }

      if (!document.cad.nivel.value){
       Msg += "Selecione um nível   \n";
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

<?php
   $SQLVendedor = pg_query($conecta, "SELECT nome FROM vendedores WHERE id='".$_REQUEST['vendedores']."'");
   $ResVend = pg_fetch_array($SQLVendedor); 
   echo str_repeat("<br>", 3); 
   
?>
   
<form  name="cad" action="?pg=grava" method="post" enctype="multipart/form-data">

<!-- AQUI PEGO OS VALORES DA TELA ANTERIOR PARA UTILIZA-LOS NO UPDATE -->
<input type="hidden" name="busca" id="busca" value="<?php echo $_REQUEST['busca'];?>">
<input type="hidden" name="vendedores" id="vendedores" value="<?php echo $_REQUEST['vendedores'];?>">   

<table cellpadding="2" cellspacing="0" border="0" width="550px"  style="background:URL('images/bg_form_vendedor.png')repeat-x">
  <tr style="background: URL('#images/bg_nome_vendedor.png');">
    <td colspan="4" style="background:URL('images/seta_01.png') no-repeat;"><b><?php echo str_repeat("&nbsp;", 3).$ResVend['nome'];?></b></td>
  </tr> 
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>         
  <tr class="texto">
    <td>&nbsp;Usuário:</td>
    <td><input type="text" name="usuario" id="usuario" style="width:150px;" maxlength="10"></td>
    <td>&nbsp;Senha:</td>
    <td><input type="password" name="senha" id="senha" style="width:150px;"></td>
  </tr>
  <tr class="texto">
    <td>&nbsp;Status:</td>
    <td>
      <select id="status" name="status" style="width:150px;" >
        <option value=""></option>
        <option value="1">ATIVO</option>
        <option value="0">INATIVO</option>
      </select>
    </td>
    <td>&nbsp;Nível:</td>
    <td>
      <select id="nivel" name="nivel" style="width:150px;">
        <option value=""></option>
        <option value="0">USUÁRIO</option>
        <option value="1">INTERMEDIÁRIO</option>
        <option value="2">ADMINISTRADOR</option>
      </select>       
    </td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>      
  <tr>
    <td colspan="4" align="center">
     <input type="hidden"  >
     <input type="submit" value="Grava" id="avancar" name="avancar" onClick="return ValidaCampos();submit();">
    </td>
  </tr>  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>         
</table>
</form>

<?php
echo str_repeat("<br>", 5);
}else{
  include"include/login.php";
}		
?>