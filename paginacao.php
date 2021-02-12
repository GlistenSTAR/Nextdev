<?php
include_once ("inc/common.php");
 session_start();
 include "inc/verifica.php";
 include "inc/config.php";
 
// Page Count 1.0 - Renan Orati
// ----------------------------
// Gerando variáveis de paginas! Legenda:
// $pa - Página Atual
// $nrResult - Indice para ser usado no While, (numero de registros - 1)
// $nrResult - Aqui eu guardo o numero de registros...
// $pags - Número de Páginas.
// nReg - Numero de Registros por pagina!

//Coloque aqui a instrução sql de busca!
$SQL = "Select nome, endereco, cidade, estado, telefone, cgc from clientes order by nome ASC";

//Executando instrução
$EXEC = pg_query($SQL);

// Coloque o numero de registros que deve ser mostrado por paginas
$nReg = 10;
//recebendo pagina atual
$pa = $_GET['pa'];
$pa = (int)$pa;
$nrResult = pg_num_rows($CHECA);
$nrResultX = $nrprof;
// OBS: Pra ficar claro... a função "pg_num_rows" ela retorna o numero
//de registros gerados pelo select... mas na hora de mostrar, como o php 
//gera os resultados apartir de 0 ( 0 .. n ) então eu subtraio 1 no 
//numero de registros para nao mostrar registro a mais!
$nrResult -=1;

//Calculando o numero de paginas
$pags = (int)(($nrResult/$nReg)+1);
//Calculando o registro inicial
$iniciopag = ($nReg*$pa)-$nReg;
//Calculando o registro final
$fimpag = ($nReg*$pa)-1;

//Pronto... voce pode utilizar para qualquer consulta...
//Pra fica mais facil eu vou usar uma consulta de exemplo
?>

<html>
<body>
<table width=200>

<?php
   $i = $iniciopag;
   while(($i<=$nrResult) and ($i<=$fimpag)){
   $nome = pg_result($EXEC,$i,"nome");
   $cidade = pg_result($EXEC,$i,"cidade");
?>

<tr>
   <td width=100><?php echo $nome?></td>
   <td width=100><?php echo $cidade?></td>
</tr>

<?php $i+=1; } ?>

<br>

<?php
//Agora vou mostra o " Paginas - 1 2 3 n "
// $z - é um tipo de contador
// $pagina - pagina atual... caso for mandar para uma outra pagina substitua pelo nome da pagina

$pagina = $_SERVER['SCRIPT_NAME'];
$pagina = substr($aaa,1,255);

$z=1;
while($z<=$pags){

?>

<a href="<?php echo $pagina?>?pa=<?php echo $z?>">
<?php echo $z." "?>
</a>
<?php $z+=1; }?>