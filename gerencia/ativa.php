<?php
include ("include/common.php");
session_start();
if($_SESSION['LogaUser']){

			//insiro dados na tabela tabela usuarios
			$BuscoUser  = pg_query($conexao2, "SELECT id, nome, cgc FROM clientes WHERE id='".$id."'");
			$ResultUser = pg_fetch_array($BuscoUser); 


			$ChecoCadastro = pg_query($conexao,"SELECT nome FROM usuarios WHERE nome='".$ResultUser['cgc']."'");
			$Linhas = pg_num_rows($ChecoCadastro);

			if($Linhas =="0"){
							$UltimoId   = pg_query($conexao, "SELECT MAX(id::integer) AS ultimo_id FROM usuarios");
							$RetUltimo  = pg_fetch_array($UltimoId);

							$Id      = trim($RetUltimo['ultimo_id']+1);
							$Senha   = trim($id);
							$Ativo   = "1";
							$Nivel   = "1";
							$Cgc     = trim($ResultUser['cgc']);
							$Cliente = trim($ResultUser['nome']);

							$Usuarios = "INSERT INTO usuarios(id, nome, senha, ativo, nivel, cgc, cliente) VALUES ('$Id', '$Cgc', '$Senha', '$Ativo', '$Nivel', '$Cgc', '$Cliente')";
							//echo $Usuarios;
							pg_query($conexao, $Usuarios) or die("Ops, Erro ao inserir dados na tabela Usuarios");


							//insiro dados na tabela acesso
							$UltimoIdA   = pg_query($conexao, "SELECT MAX(id::integer) AS ultimo_id FROM acesso");
							$RetUltimoA  = pg_fetch_array($UltimoIdA);
							
							$IdA      = trim($RetUltimoA['ultimo_id']+1);
							
							$Acesso = "INSERT INTO acesso(id, id_usuario, id_dados, nivel) VALUES ('$IdA', '$Id', '1', '1')";
							//echo "<br>".$Acesso;
							pg_query($conexao, $Acesso) or die("Ops, Erro ao inserir dados na tabela Acesso");
							echo "<div align='center' class='texto' style='width:100%;height:20px;position:relative;margin-top:-10px;border:1px solid;background:green;color:#FFF;font-size:15px;'>
													<b>Usuário cadastrado com sucesso</b>
													</div>";

								
							echo "<br><br><br><br><br><br><span class='texto'>Nome:<b>". $Cliente."</b><br>
												Usuario:<b>".$Cgc."</b><br>
												Senha:<b>".$id."</b></span><br><br><br><br><br><br>";
			}else{
							echo "<br><br><br><br><br><div align='center' class='texto' style='width:550px;height:50px;position:relative;margin-top:-10px;border:2px solid #dc0606;background:red url(images/alerta.png) no-repeat;color:#FFF;font-size:15px;'>
													<br>Usuário <b>$ResultUser[nome] </b>já cadastrado.<br><br>
													</div>";
													
							echo "<span class='texto'><br>
												Usuario:<b>".$ResultUser[cgc]."</b><br>
												Senha:<b>".$id."</b></span><br><br><br><br><br><br>";										
			}	

}else{
  include"include/login.php";
}	
?>