 <?php
 include ("inc/common.php");
 include_once("inc/config.php"); 
 
 $_REQUEST['desconto'] = str_replace(',','.',$_REQUEST['desconto']);
 
 if(is_numeric($_REQUEST['desconto']) AND $_REQUEST['numero']){
   $SqlItens = pg_query ($db,"SELECT SUM(valor_total) AS valor_total FROM itens_do_pedido_internet WHERE numero_pedido='".$_REQUEST['numero']."'");
   $Vl = pg_fetch_array($SqlItens);
   
   $Desconto = $_REQUEST['desconto'];
   $Desconto = number_format($Desconto, 2, '.', '');
   
   $TotalCDesc = ($Vl['valor_tota'l] - $Desconto);
   $TotalCDesc = number_format($TotalCDesc, 2, '.', '');
   
 }elseif(!is_numeric($_REQUEST['desconto']) AND $_REQUEST['desconto'] <>""){
   $Msg = "Se informar, informe um desconto válido.";
 } 

 if(isset($p['desconto_pedido'])){
   $Desconto = number_format($p['desconto_pedido'], 2, '.', '');
   $TotalCDesc= number_format(($p['total_com_desconto'] - $p['desconto_pedido']), 2, '.', '');
 }
 
 ?>
 <table width="580" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
   <tr>
     <td valign="top" width="95px">Desconto R$:</td>
     <td valign="top">
       <input type="text" name="DescDest" id="DescDest" value="<?php echo $Desconto;?>" style="width:80px;" onblur="Acha('desconto_destacado.php','desconto='+document.getElementById('DescDest').value+'&numero='+document.ped.numero.value+'','GridDestacado')">
       <?php echo "<font color='red'>".$Msg."</font>";?>
     </td>
  </tr> 
   <tr height="5px">
     <td colspan="2"></td>
  </tr>   
   <tr>
     <td valign="top">Total C/ Desconto:</td>
     <td valign="top">
       <input type="button" name="at" id="at" value="<?php echo $TotalCDesc;?>" style="width:80px; text-align:left;">       
     </td>
  </tr> 
   <tr>
     <td colspan="2" style="color:red;";><hr></td>
  </tr>     
 </table>