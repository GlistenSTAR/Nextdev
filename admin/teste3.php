<?
extract($_POST, EXTR_PREFIX_ALL, "POST");
echo "<h2>files</h2>";
foreach ($_FILES as $key => $value) {
   echo "<strong>Chave:</strong> $key; <strong>Valor:</strong> $value<br />\n";
   if(is_array($_FILES[$key])){
        foreach ($_FILES[$key] as $key2 => $value2) {
           echo "&nbsp;&nbsp;&nbsp;&nbsp;<strong>Chave:</strong> $key2; <strong>Valor:</strong> $value2<br />\n";
        }
   }
}
echo "<h2>post</h2>";
foreach ($_POST as $key => $value) {
   echo "<strong>Chave:</strong> $key; <strong>Valor:</strong> $value<br /<br />\n";
}
echo "<h2>get</h2>";
foreach ($_GET as $key => $value) {
   echo "<strong>Chave:</strong> $key; <strong>Valor:</strong> $value<br /<br />\n";
}
?>
