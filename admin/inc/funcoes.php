<?
function left($string, $count){
  return substr($string, 0, $count);
}
function LimpaString($Valor){
  $Invalidos = array("´", "`", "'", ",");
  return str_replace($Invalidos, "", $Valor);
}
function FormataCasas($Valor, $QtdCasas, $MostraCifrao){
  if ($MostraCifrao){
    return "R$ ".number_format($Valor, $QtdCasas, ",", ".");
  }else{
    return number_format($Valor, $QtdCasas, ",", ".");
  }
}
?>
