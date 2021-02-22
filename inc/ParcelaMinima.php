<?php
include_once ("common.php");
include "config.php";
if ($_REQUEST['cod_pag']){
  $Sql = pg_query("Select vezes from condicao_pagamento where codigo='".$_REQUEST['cod_pag']."'");
  $cp = pg_fetch_array($Sql);
  ?>
  <input type="hidden" name="vezes" id="vezes" value="<?php echo $cp['vezes']; ?> - <?php echo $_REQUEST['ven_cas']?>">
  <?php
  $_SESSION['venda_casada'] = ($_REQUEST['ven_cas']) ? true : false;
}elseif ($_REQUEST['cod_pag2']){
  $Sql = pg_query("Select vezes from condicao_pagamento where codigo='".$_REQUEST['cod_pag2']."'");
  $cp = pg_fetch_array($Sql);
  ?>
  <input type="hidden" name="vezes2" id="vezes2" value="<?php echo $cp['vezes']; ?>">
  <?php
}
?>

