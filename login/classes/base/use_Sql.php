<?php
    $bd = new bd(); //cria uma inst�ncia da classe
    $query = $bd->query("select * from tabela"); //Executa a query e coloca o resultado na vari�vel $query
    while ( $linha = $bd->fetch_row( $query ) ) { //coloca na vari�vel linha o array contendo o valor dos campos retornados na consulta para cada registro
        echo $linha[0] . "n"; //mostra o valor do primeiro campo da consulta
    }
    echo "N�mero de registros retornado: ".$bd->num_rows( $query ); //mostra o total de registros retornados na consulta
?>
