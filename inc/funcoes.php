<?
//set_error_handler('trataErro');
//
//function trataErro($msg,$errno,$errstr,$errfile,$errline) {
//   $msg ="<pre>
//              nErro....: [$errno] - $errstr
//              nDate....: ".date("d/m/Y H:i:s") . "
//              nFile....: <b>$errfile</b> : <b>$errline</b>n
//          </pre>
//          <h2>Roll Back: </h2$gt;";
//
//       $trace = debug_backtrace(); //pegando o backtrace da execução
//       foreach ($trace as $k=>$v) {
//           if ($v['function'] == "trataErro") continue;
//           $msg .=  "<ul><li>Função: <b style=\" color: green\">" . $v['function'] . "</b></li></ul>
//                   <ol>File: " . $v['file'] ."</ol>
//                   <ol>Linha: " . $v['line'] ."</ol>";
//
//           if (isset($v['args'])) {
//               $msg .=  "Argumentos:<ul>";
//               foreach ($v['args'] as $a) {
//                   $msg .=  "<li>$a</li>";
//               }
//               $msg .=  "</ul>";
//           }
//       }
//
//    ob_start(); //ligando buffer de saida
//    echo "<h1> Variáveis Globais </h1>";
//    echo "<h2> _SERVER </h2>";
//    echo "<pre>n";print_r($_SERVER);echo"</pre>";
//    echo "<h2> _POST </h2>";
//    echo "<pre>n";print_r($_POST);echo"</pre>";
//    echo "<h2> _GET </h2>";
//    echo "<pre>n";print_r($_GET);echo"</pre>";
//    $msg .= ob_get_contents(); //pegando o conteúdo do buffer de saida
//    ob_end_clean(); //limpando o buffer de saida
//    echo $msg;
//    die; //Se algum erro existir ele aborta a execução do script
//}
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
function AdicionarDias($datahoje, $dias) {

  $anohoje = substr ( $datahoje, 0, 4 );
  $meshoje = substr ( $datahoje, 4, 2 );
  $diahoje = substr ( $datahoje, 6, 2 );

  $prazo = mktime ( 0, 0, 0, $meshoje, $diahoje + $dias, $anohoje );

  return strftime("%Y%m%d", $prazo);
}
function is_utf8($str) {
/// RETIRADO sob condição de criar uma rotina que permita gravar o e-mail da forma correta.
    // From http://w3.org/International/questions/qa-forms-utf-8.html
    return preg_match('%^(?:
          [\x09\x0A\x0D\x20-\x7E]            # ASCII
        | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
        |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
        |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $str);
  return $str;
}
function if_utf8($str) {
/// RETIRADO sob condição de criar uma rotina que permita gravar o e-mail da forma correta.
  return (is_utf8($str))? utf8_decode($str):$str;
  return $str;
}
/*
//////function TrocaCaracteres($str){
//////  return strtoupper(html_entity_decode(preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/','$1', htmlentities($str))));
//////}
Nova função criada em 22/06/2009 devido a solicitação da Sara (Perfil), a função anterior não funcionava corretamente em
todos os casos, vamos ver como fica essa, PAC 334
*/
function TrocaCaracteres($str, $enc = 'UTF-8'){
/// RETIRADO sob condição de criar uma rotina que permita gravar o e-mail da forma correta.
  $acentos = array(
      'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
      'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
      'C' => '/&Ccedil;/',
      'c' => '/&ccedil;/',
      'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
      'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
      'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
      'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
      'N' => '/&Ntilde;/',
      'n' => '/&ntilde;/',
      'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
      'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
      'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
      'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
      'Y' => '/&Yacute;/',
      'y' => '/&yacute;|&yuml;/',
      'a.' => '/&ordf;/',
      'o.' => '/&ordm;/'
  );
  return preg_replace($acentos, array_keys($acentos), htmlentities($str,ENT_NOQUOTES, $enc));
//  return $str;
}
function VerificarEmail($email){
   $mail_correcto = false;
   //verifico umas coisas
   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
         //vejo se tem caracter .
         if (substr_count($email,".")>= 1){
            //obtenho a terminação do dominio
            $term_dom = substr(strrchr ($email, '.'),1);
            //verifico que a terminação do dominio seja correcta
            if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
               //verifico que o de antes do dominio seja correcto
               $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
               $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
               if ($caracter_ult != "@" && $caracter_ult != "."){
                  $mail_correcto = true;
               }
            }
         }
      }
   }
   return $mail_correcto;
}

//verifico email NFE
function VerificarEmailNfe($email){
   $mail_correcto = false;
   //verifico umas coisas
   if ((strlen($email) >= 6) && (substr_count($email,"@") >= 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
         //vejo se tem caracter .
         if (substr_count($email,".")>= 1){
            //obtenho a terminação do dominio
            $term_dom = substr(strrchr ($email, '.'),1);
            //verifico que a terminação do dominio seja correcta
            if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
               //verifico que o de antes do dominio seja correcto
               $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
               $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
               if ($caracter_ult != "@" && $caracter_ult != "."){
                  $mail_correcto = true;
               }
            }
         }
      }
   }
   return $mail_correcto;
}
?>
