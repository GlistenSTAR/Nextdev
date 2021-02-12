<?php
session_start();
if(isset($_POST['acessa'])){

$Usuario = trim(strtoupper($_POST['login']));
$Senha   = trim(strtoupper($_POST['senha']));

$SQL = pg_query($Nextweb, "SELECT nivel, codigo_empresa, usuario FROM admin WHERE ativo = '1' AND usuario='$Usuario' AND senha='$Senha'");
$Res = pg_num_rows($SQL);
$Result = pg_fetch_array($SQL);

	if($Res <= "0"){
   echo "<div align='center' class='texto' style='width:100%;height:20px;position:relative;margin-top:-10px;border:1px solid;background:red;color:#FFF;font-size:15px;'>
			     <b>Usuário ou Senha incorretos.</b>
			     </div>";
	}else{   
			$_SESSION['LogaUser']    =  $Usuario;			
 		$_SESSION['LogaNivel']   =  $Result['nivel'];
			$_SESSION['LogaEmpresa'] =  $Result['codigo_empresa'];
			//HEADER("Location: index.php");
			
			//aqui ele irá direcionar a pagina atual após o login
			$URL = substr($_SERVER['REQUEST_URI'], 27, 200);
			echo "<meta http-equiv='refresh' content='0; url=index.php?pg=busca'>";
			//echo "<meta http-equiv='refresh' content='0; url=index.php$URL'>";
	}
   
}
?>

<div id="login" align="center" style="background:URL(images/bg_login.jpg) no-repeat;width:407px;height:151px;margin:100px;"> 
<br><br>

		<form action="" method="POST">
			<table border="0" width="260px" align="right" cellpadding="0" cellspacing="00">
				<tr>
						<td class="texto">Login:</td>
						<td><input type="text" id="login" name="login"></td>			
				</tr>
				<tr>
						<td class="texto">Senha:</td>
						<td><input type="password" id="senha" name="senha"></td>			
				</tr>
				<tr>
						<td></td>
						<td>
							<input type="submit" id="acessa" name="acessa" value="Acessar">
						</td>			
				</tr>		
			</table>
		</form>

</div>