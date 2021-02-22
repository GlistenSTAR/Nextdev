<?php
include_once ("include/common.php");
session_start();
include "include/config.php";

$sql = "SELECT id, nome FROM vendedores WHERE ativo='1' AND login is null ORDER BY nome";               
$query = pg_query($conecta, $sql); 
$Linhas = pg_num_rows($query);               

 ?>
 &nbsp;Vendedor:
 <select id="vendedores" name="vendedores" style="width:250px; height:25px;">
   <?php
    if($Linhas >"0"){
   ?>
   <option value="">- Selecione o vendedor -</option>
   <?php
   }else{
   ?>
   <option value="">- Nenhum vendedor encontrado -</option>
   <?php
   }
   ?>
   <option></option>
 <?php
 while($row = pg_fetch_object($query)) {
 ?>            
   <option value="<?php echo $row->id;?>"><?php echo $row->nome;?></option>
<?php  
 }
?>
</select>