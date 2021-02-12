<?php
include ("inc/common.php");
include "inc/config.php";

if($_REQUEST['edita']=="1"){
  if(pg_query("UPDATE observacao_do_pedido SET observacao = '$_REQUEST[texto]' WHERE numero_pedido='$_REQUEST[numero]'")){
    echo "<div style='margin-top:12.5em; margin-left:15px; position:absolute; color:green;'><b>Gravado com sucesso</b></div>";
  }
}

//Busco obs existente
$SQlObs = pg_query("SELECT * FROM observacao_do_pedido WHERE numero_pedido='$_REQUEST[numero]'");
$ObsPed = pg_fetch_array($SQlObs);
?>

<form action="" method="post" name="grava">
 <table width="450px" cellpadding="6" cellspacing="0" border="0">
  <tr>
    <td>OBSERVAÇÃO DO PEDIDO <b><?php echo $_REQUEST['numero'];?></b></td>
  </tr>
  <tr>
    <td><textarea name="obs" style="width:460px; height:100px; max-height:100px; max-width:460px;" maxlength="300"><?php echo $ObsPed['observacao'];?></textarea></td>
  </tr>
  <tr>
    <td align="right">
      <input type="button" value="Cancelar" name="cancela" onclick="document.getElementById('obs').style.display = 'none';">    
      <input type="button" value="Gravar" name="gravar" onclick="Acha('obs_pedido.php','numero=<?php echo $_REQUEST['numero'];?>&texto='+document.grava.obs.value+'&edita=1','campoobs');">      
    </td>
  </tr> 
 </table>
</form>