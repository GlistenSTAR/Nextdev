<?php
    $bd = new bd(); //cria uma instância da classe
    $query = $bd->query("select * from tabela"); //Executa a query e coloca o resultado na variável $query
    while ( $linha = $bd->fetch_row( $query ) ) { //coloca na variável linha o array contendo o valor dos campos retornados na consulta para cada registro
        echo $linha[0] . "n"; //mostra o valor do primeiro campo da consulta
    }
    echo "Número de registros retornado: ".$bd->num_rows( $query ); //mostra o total de registros retornados na consulta
?>
