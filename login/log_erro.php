<?php
include ("inc/common.php");
//echo "<span class=erro><h2> - ATEN��O - <BR><BR>OS DADOS N�O FORAM ARMAZENADOS, ENTRE EM CONTATO COM O SUPORTE.</h2></span>";
//echo pg_last_error();
$corpo = "URL: ".$_SERVER['HTTP_REFERER']."<BR><BR>";
$corpo = $corpo.pg_last_error()."<BR><BR>";
$corpo = $corpo."IP: ".$REMOTE_ADDR."<BR><BR>";
$corpo = $corpo."Conex�o: ".$str_conexao."<BR><BR>";
$corpo = $corpo."Tela: ".$PHP_SELF."<BR><BR>";
//echo "Corpo: $corpo";
mail("uoposto@gmail.com", "ERRO", $corpo , "From: Erro <erros@nextweb.com>\nContent-type: text/html\n");
?>
