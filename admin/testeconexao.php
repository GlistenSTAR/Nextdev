<?php	
	session_start();
	$conn = "host=db3.backup dbname=db3 port=5432 user=user password=password";
	
	try {
		pg_connect($conn);
		echo "Conectou com sucesso";
	} catch (Exception $ex) {
		echo "Erro: " . $ex;	
	}
	
	if(pg_connect($conn)) {
		echo "Tentativa 2 conectou com sucesso";	
	} else {
		echo "Erro, tentativa 2: " . pg_last_error($conn);
	}