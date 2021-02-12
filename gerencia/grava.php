<?php
include ("include/common.php");
session_start();
if($_SESSION['LogaUser']){
include "include/config.php";
   if($_REQUEST['busca'] ==""){
     //SE OS VALORES VIERAM VAZIOS RETORNO A TELA ANTERIOR
     echo "<meta http-equiv='refresh' content='0; url=index.php?pg=busca'>";   
   }else{
   
     echo str_repeat("<br>", 8);     
     if(isset($_POST)){
     
        $User   = trim(strtoupper($_REQUEST['usuario']));
        $Senha  = trim(strtoupper($_REQUEST['senha'])); 
      
        //gravo dados na tabela vendedores
        $UpVendedor = "UPDATE vendedores SET 
                       login       = '".$User."', 
                       senha       = '".$Senha."', 
                       ativo       = '".$_REQUEST['status']."',
                       nivel_site  = '".$_REQUEST['nivel']."'
                       WHERE id    = '".$_REQUEST['vendedores']."'
                       ";    
                       
         pg_query($conecta, $UpVendedor) OR DIE ("Ops, algo deu errado. Copie o texto e envie a tnsistemas".$UpVendedor.$err++);   
         
         
         //faço a busca do ultimo id poi spreciso do memso na tabela usuários e acessos
         $SqlId = pg_query($Nextweb, "SELECT MAX(id) AS ultimo_id FROM usuarios");
         $ID = pg_fetch_array($SqlId);
         $UltimoID = $ID['ultimo_id'] + 1;    
         
         //Checo se usuários já está cadastrado
         $Checagem = pg_query($Nextweb, "SELECT id FROM usuarios WHERE nome='".$User."' AND senha='".$Senha."'");
         $Check = pg_num_rows($Checagem);
         
         if($Check <="0" OR $Check ==""){
            //se já não estiver cadastradi gravo dados na tabela usuários
            $InsertUser = "INSERT INTO usuarios(id, nome, senha, ativo, nivel, codigo_empresa) 
                           VALUES('".$UltimoID."', '".$User."', '".$Senha."', '".$_REQUEST['status']."', '".$_REQUEST['nivel']."', '".$_SESSION['LogaEmpresa']."')";
            pg_query($Nextweb, $InsertUser) OR DIE("Ops, algo deu errado. Copie o texto e envie a tnsistemas".$InsertUser.$err++);
         }          
           
         //busco o id do banco de dados
         $SqlDados = pg_query($Nextweb, "SELECT id FROM dados WHERE base='".$_REQUEST['busca']."'");
         $Dados= pg_fetch_array($SqlDados);            
           
           
         //gravo dados na tabela acesso
         $InsertAces = "INSERT INTO acesso(id_usuario, id_dados, nivel)
                        VALUES('$UltimoID','$Dados[id]','$_REQUEST[nivel]')";       
         pg_query($Nextweb, $InsertAces) OR DIE("Ops, algo deu errado. Copie o texto e envie a tnsistemas".$InsertAces.$err++);
         
        if(!$err){ 
           echo "<div align='center' class='texto' style='float:left;width:980px;height:20px;position:absolute;margin-top:-5em;border:1px solid;background:green;color:#FFF;font-size:15px;'>
                <b>Usuário Cadastrado com sucesso!!!.</b>
                </div>";               
        }     
     }  
  }   
  echo str_repeat("<br>", 5); 
}else{
  include"include/login.php";
}		 
?>