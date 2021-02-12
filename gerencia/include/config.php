<?php

//base nextweb
$Host    = "localhost";
$DbName  = "db1.backup";
$Nextweb  = pg_connect("host=$Host dbname=$DbName user=user port=5432 password=password") or die ("Ops, algo deu errado ao tentar conectar na base de dados. Tente novamente.");

//busco base dinamica
$conecta = pg_connect("host=db1.backup dbname=$_REQUEST[busca] user=user port=5432 password=password");

$teste = pg_connect("host=db2.backup dbname=db2 user=user port=5432 password=password");

?>