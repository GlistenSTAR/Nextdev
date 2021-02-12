<?
session_start();
if($_SESSION['LogaUser']){
?>
<script language="JavaScript">

function ValidaCampos(){
  		var Msg="";
  		if (!document.cad.busca.value){
  			Msg += "Selecione a base de dados   \n";
  		}

  		if (Msg){
      alert(Msg);
      return false;
  		}else{
      document.cad.submit();
      return false;
  		}
  }
<!--
function abreJanela(URL) {
  location.href = URL; // se for popup utiliza o window.open
}
//-->
</script>
  
  
<div id="FiltroBase" style="margin-left: 2.5em; margin-top: 2px;position: absolute;float:left;">

  <form action="?pg=listar" name="cad" method="post" enctype="multipart/form-data">  
    &nbsp;<b>Base de Dados:</b>
    <select name="busca" class="texto" id="busca" style="width:150px;height:25px;" onchange="carregar()">   
     <option value="<?= $_REQUEST[busca];?>"><?= strtoupper($_REQUEST[busca]);?></option>
     <?
      $SQL = pg_query($Nextweb, "SELECT id, base, descricao FROM dados WHERE codigo_empresa = '$_SESSION[LogaEmpresa]' AND base <>'$_REQUEST[busca]'");
      while($Lista = pg_fetch_array($SQL)){
     ?>
       <option value="<?= $Lista['base'];?>"><?= $Lista['descricao'];?></option>    
     <?
      }
     ?>
    </select>
    &nbsp;|&nbsp;<input type="submit" value="Listar" id="lista" name="lista" onClick="return ValidaCampos();">

  
</div>

<div style="border:1px solid #CCCCCC;width:980px;height:300px;overflow:no;">
<div style="border:1px solid #CCCCCC;width:900px;height:240px;overflow:no;margin:30px;background:#f0f0f0;">
<table width="900" cellpadding="0" cellspacing="1" border="0" align="center">
 <tr class="texto" bgcolor="#c2c2c2" height="25px">
	 <td width="400px">&nbsp;<b>Nome</b></td>
		<td width="100px">&nbsp;<b>Usuário</b></td>
		<td width="100px">&nbsp;<b>Senha</b></td>
  <td width="100px">&nbsp;<b>Nivel / Atualizar</b></td>
		<td width="50px" align="center">&nbsp;<b>Ação</b></td>		
	</tr>
</table>

<div style="border:0px solid #CCCCCC;width:920px;height:210px;overflow:auto;">
<table width="900" cellpadding="0" cellspacing="1" border="0" align="left">	
<?
//aqui inativo o usuario
if($_REQUEST[inativa] !==""){
  $Inativar = "UPDATE vendedores SET ativo='0' WHERE id = '$_REQUEST[inativa]'";
		//echo $Inativar;
  pg_query($conecta, $Inativar);
}

//aqui ativo o usuario
if($_REQUEST[ativa] !==""){
  $Ativar = "UPDATE vendedores SET ativo='1' WHERE id = '$_REQUEST[ativa]'";
		//echo $Ativar;
  pg_query($conecta, $Ativar);
}				

//aqui mudo nivel
if($id !==""){
  $Nivel = "UPDATE vendedores SET nivel_site='$_REQUEST[nivel]' WHERE id = '$_REQUEST[id]'";
		//echo $Nivel;
  pg_query($conecta, $Nivel);
}			

$Vendedores = pg_query($conecta,"SELECT id, nome, login, senha, ativo, nivel_site FROM vendedores WHERE login <>'' ORDER BY nome");
$Linhas = pg_num_rows($Vendedores);

if($Linhas <"0"){
  $Aviso = "<br><br><br><br><center><span class='texto' style='color:red;'>Nada encontrado na pesquisa atual.</span></center><br>";
}
while($Resultado = pg_fetch_array($Vendedores)){

if($Resultado['ativo']=="1"){
  $Acao = "<a href='?pg=listar&inativa=$Resultado[id]&busca=$_REQUEST[busca]' title='Inativar Usuário'><img src='images/inativa_user.png' border='0'></a>";
}else{
  $Acao = "<a href='?pg=listar&ativa=$Resultado[id]&busca=$_REQUEST[busca]' title='Ativar Usuário'><img src='images/ativa_user.png' border='0'></a>";
}

If($Cor !=="#CCCCCC"){
   $Cor = "#FFFFFF"; 
}else{
   $Cor = "#CCCCCC"; 
}

switch($Resultado['nivel_site']){
 case 0:
   $Status  = "Usuário"; 
   $Status2 = "<option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=1'>Intermed</option>
               <option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=2'>Admin.</option>   
              ";
              
   break;
 case 1:
    $Status = "Intermed."; 
    $Status2 = "<option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=0'>Usuário</option>
                <option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=2'>Admin.</option>   
               ";    
    break;
 case 2:
    $Status = "Admin.";
    $Status2 = "<option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=0'>Usuário</option>
                <option value='?pg=listar&id=$Resultado[id]&busca=$_REQUEST[busca]&nivel=1'>Intermed</option>  
               ";    
    
    break;
}

?>

 <tr class="texto" bgcolor="<?= $Cor;?>" onMouseOver="javascript:this.style.backgroundColor='#d2e2f1'" onMouseOut="javascript:this.style.backgroundColor=''">
	 <td width="400px">&nbsp;<?= $Resultado['nome'];?></td>
		<td width="100px">&nbsp;<font color="red"><b><?= $Resultado['login'];?></b></font></td>
		<td width="100px">&nbsp;<font color="red"><b><?= $Resultado['senha'];?></b></font></td>
  <td width="100px">&nbsp;<font color="red">
    <select id="nivel" name="nivel" style="width:100px;" onchange="javascript: abreJanela(this.value)">
      <option value="<?= $Resultado['nivel_site'];?>"><?= $Status;?></option>
      <option value=""> - - - - - - - - -</option>
      <?= $Status2;?>
    </select>    
  </td>
		<td width="50px" align="center"><?= $Acao;?></td>		
	</tr>
<?
}
echo $Aviso;
?>
</table>
</form>
</div>
</div>
</div>
<?
}else{
  include"include/login.php";
}		
?>