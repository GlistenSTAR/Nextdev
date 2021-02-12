<?php	
	session_start();
	$conn = "host=tnteste.c1etmptv6ioq.sa-east-1.rds.amazonaws.com dbname=cep port=13662 user=postgres password=tndanils";
	
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