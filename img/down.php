<?
 $tamanho = filesize($_REQUEST[i]);
 Header("Content-Type: application/x-octet-stream");
 header("Content-length: $tamanho");
 Header("Content-Disposition: attachment;filename=$_REQUEST[imagem]");
 header("Content-Description: PHP Generated Data");
 readfile($_REQUEST[i]);
?>
