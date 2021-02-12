<?php
include ("inc/common.php");
//echo "<span class=erro><h2> - ATENÇÃO - <BR><BR>OS DADOS NÃO FORAM ARMAZENADOS, ENTRE EM CONTATO COM O SUPORTE.</h2></span>";
//echo pg_last_error();
$corpo = "URL: ".$_SERVER['HTTP_REFERER']."<BR><BR>";
$corpo = $corpo.pg_last_error()."<BR><BR>";
$corpo = $corpo."IP: ".$REMOTE_ADDR."<BR><BR>";
$corpo = $corpo."Conexão: ".$str_conexao."<BR><BR>";
$corpo = $corpo."Tela: ".$PHP_SELF."<BR><BR>";
//echo "Corpo: $corpo";
mail("uoposto@gmail.com", "ERRO", $corpo , "From: Erro <erros@nextweb.com>\nContent-type: text/html\n");
?>
