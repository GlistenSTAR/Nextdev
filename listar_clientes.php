<?php
include_once ("inc/common.php");
 session_start();
 include "inc/verifica.php";
 include "inc/config.php";
?>
<style type="text/css">
<!--
 #Cabecalho{
  font-size:12px;
  font-family: Arial, Verdana;
  color:#555;
  font-weight:Bold;
  text-decoration:none;
  margin-top:5px;  
 }

 #menu{
  width: 600px; 
  height:30px; 
  font-size:12px;
  font-family: Arial, Verdana;   
 }

 #ok{
  width:30px;
  height:20px;
  cursor:pointer;
 }

 #listar{
  width:600px; 
  font-size:12px;
  font-family: Arial, Verdana;   
  background:URL("#images/bg_topo_impressao.jpg") repeat-x;
  border:1px solid transparent; 
  border-radius: 6px;
 }

 #geral{
   border:1px solid #dbdbdb; 
   border-radius:6px; 
   width:600px; 
   max-width:600px;
   height:360px; 
   max-height:360px; 
   #margin-top: 0.5em;
 }

 .titulos{
   font-family:Arial, Verdana;
   font-size: 12px;
   font-weight: Bold;
   color: #000;  
 }

 .resultado{
   font-family:Arial, Verdana;
   font-size: 11px;  
   color: #333;  
 }
 -->
</style>

<form name="listar">
  <div id="listar" align="left">    
    <div id="Cabecalho" align="center">Listagem de Clientes<br><span style="color:#CCCCCC;"><?php echo str_repeat(' -',85);?></span></div>
    
    <!-- Monto os dados do cabeçalho da página -->
    <form name="menu" align="left" method="POST" accept-charset="ISO-8859-1">
       <a href="imprimir_clientes.php?filtro=<?php echo $_REQUEST['filtro']?>" target="_blank"><img src="icones/imprimir1.gif" border="0">&nbsp;&nbsp;Versão Impressa</a>
       
       &nbsp;&nbsp;|&nbsp;&nbsp;
       
       Mostrar:
       <select id="filtro" name="filtro">
         <?php
         if ($_REQUEST['filtro']=="INATIVOS"){
           ?>
           <option value="INATIVOS">INATIVOS</option>
           <option value="TODOS">TODOS</option>
           <option value="ATIVOS">ATIVOS</option>
           <?php
         }elseif ($_REQUEST['filtro']=="ATIVOS"){
           ?>
           <option value="ATIVOS">ATIVOS</option>
           <option value="TODOS">TODOS</option>
           <option value="INATIVOS">INATIVOS</option>
           <?php
         }else{
           ?>
           <option value="TODOS">TODOS</option>
           <option value="ATIVOS">ATIVOS</option>
           <option value="INATIVOS">INATIVOS</option>           
           <?php
         }
         ?>
       <select>
       
       &nbsp;&nbsp;|&nbsp;&nbsp;
       <input type="submit" id="ok" name="ok" value="OK">
       
    </form>
    
    <!-- Monta o resultado -->
    <div id="geral">
    <br>      
      <table width="600px" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="titulos">
        <tr>
          <td width="20%" align="left">&nbsp;CNPJ <img src="icones/DESC.gif" width="10px"></td>
          <td width="60%" align="left">&nbsp;Nome <img src="icones/DESC.gif" width="10px"></td>
          <td width="15%" align="left">&nbsp;Telefone <img src="icones/DESC.gif" width="10px"></td>
          <!--<td width="5%"  align="center"><img src="icones/pesquisar.png"></td>-->
        </tr>  
      </table>      
      
    <table width="600px" border="0" cellpadding="0" cellspacing="1" class="resultado">      
      <?php
      if ($_REQUEST['filtro']){
        if ($_REQUEST['filtro']=="ATIVOS"){
          $Filtro = " AND inativo='0'";
        }elseif ($_REQUEST['filtro']=="INATIVOS"){
          $Filtro = " AND inativo='1'";
        }
      }
      
        //if ($_SESSION[nivel]=="2"){
								if (($_SESSION['login']=="LAILA") AND ($_SESSION['nivel']=="2")){
          $lista = "Select nome, endereco, cidade, estado, telefone, cgc, cep from clientes WHERE inativo='0' $Filtro order by nome ASC";
        }else{     
           if($_SESSION['id_vendedor']=="77"){ //Regra Groupack         
             $lista = "Select nome, endereco, cidade, estado, ddd, telefone, cgc from clientes WHERE codigo_vendedor = '87' AND inativo='0' $Filtro order by nome ASC";          
           }else{
             $lista = "Select nome, endereco, cidade, estado, ddd, telefone, cgc from clientes WHERE codigo_vendedor = '".$_SESSION['id_vendedor']."' AND inativo='0' $Filtro order by nome ASC";          
           }           
        }   
        
        if($_SESSION['codigo_empresa']<> "2"){ //se não for groupack
          if ($_SESSION['nivel']=="2"){
             $lista = "Select nome, endereco, cidade, estado, telefone, cgc, cep from clientes WHERE inativo='0' $Filtro order by nome ASC";
          }else{
             $lista = "Select nome, endereco, cidade, estado, ddd, telefone, cgc from clientes WHERE codigo_vendedor = '".$_SESSION['id_vendedor']."' AND inativo='0' $Filtro order by nome ASC";          
          }
        }
          
        //echo $lista;
        //echo $_SESSION[codigo_empresa];
        $Linhas = pg_query($lista);
        $ccc = pg_num_rows($Linhas);
        $total_reg = "13";
        $pagina = $_REQUEST['pagina'];
        if (!$pagina){
          $inicio = "0";
          $pc = "1";
          $pagina = 1;
        }else{
          if (is_numeric($pagina)){
            $q_pagina = $ccc / $pagina;
            if ($pagina>$q_pagina){
              $pagina = 1;
            }
          }else{
            $pagina = 1;
          }
          $pc = $pagina;
          $inicio = $pc - 1;
          $inicio = $inicio * $total_reg;
        }
        $sql = "$lista  LIMIT $total_reg OFFSET $inicio";        
        $not1  = pg_query($sql);        
        //echo $lista;
        $lista = pg_query($lista);
        while($Resultado = pg_fetch_array($not1)){

       if ($Cor=="#EEEEEE"){
         $Cor="#FFFFFF";
       }else{
         $Cor="#EEEEEE";
       }
       ?>
       <tr height="20px" bgcolor="<?php echo $Cor;?>" onMouseOver="this.bgColor='#dfe9f3';Tip('<b>Endereço: </b><?php echo $Resultado['endereco']?><br><b>Cidade: </b><?php echo $Resultado['cidade']." - ".$Resultado['estado']?><br><b>CEP: </b><?php echo $Resultado['cep']?>')" onMouseOut ="this.bgColor='<?php echo $Cor;?>';UnTip()">
          <td width="20%" align="left">&nbsp;<?php echo $Resultado['cgc'];?></td>
          <td width="60%" align="left">&nbsp;<?php echo $Resultado['nome'];?></td>
          <td width="15%" align="left">&nbsp;<?php echo "(".$Resultado['ddd'].") ".$Resultado['telefone'];?></td>
          <!--<td width="5%"  align="center"><a href="#"><img src="icones/pesquisar.png" border="0"></a></td>-->
       </tr>       
       <?php
         if ($pagina){
           if (!$qtd_registros){
             $qtd_registros = $qtd_registros + $inicio + 1;
           }else{
             $qtd_registros = $qtd_registros +  1;
           }
         }      
        }
       ?>
    </table>
    <hr> 
    <div align="center">
     <?php
     if ($ccc<>""){
         $anterior = $pc -1;
         $proximo = $pc +1;
         $qtd_paginas = $ccc / $total_reg;
         $ultima_pagina = $pc + 6;
         $primeira_pagina = $pc - 6;
         $anterior = $pc -1;
         $proximo = $pc +1;
         if ($pc>1) {
           echo "<a href='#' onclick=\"Acha('listar_clientes.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]&filtro=$_REQUEST[filtro]','Conteudo');\"> <- Anterior </a>";
           echo "  |  ";
         }else{
           echo " <- Anterior ";
           echo "  |  ";
         }
         for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
           echo "<a href='#' onclick=\"Acha('listar_clientes.php','pagina=$p&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]&filtro=$_REQUEST[filtro]','Conteudo');\">";
           if ($pc==$p){
             echo "<strong>";
           }
           if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
             echo $p."&nbsp;";
           }else{
             if (!$ret){
               echo "...";
               $ret = true;
             }
           }
           if ($pc==$p){
             echo "</strong>";
           }
           echo "</a>";
         }
         $fim = $ccc / $total_reg;
         if ($pc<$fim) {
           echo " | ";
           echo " <a href='#' onclick=\"Acha('listar_clientes.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos=$pos1&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]&vendedor2_id=$_REQUEST[vendedor2_id]&tipo=$_REQUEST[tipo]&status_pedido=$_REQUEST[status_pedido]&tipo_data=$_REQUEST[tipo_data]','Conteudo'); return false;\"> Próxima -> </a>";
         }else{
           echo " | ";
           echo " Próxima ->";
         }
         ?>
         
         <div>
           <?php
           echo "<div>Mostrando registro <strong>";
           echo $inicio + 1;
           echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong></div>";
           ?>
         </div>
     <?php
     }
     ?>     
    </div>  
    
   </div>
  </div>
</form>
<?php
 //gero seção da pagina em questão
 $_SESSION['pagina'] = "listar_clientes.php";
?>
