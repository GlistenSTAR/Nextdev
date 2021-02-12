<?php
session_start();
include_once("inc/config.php");
$SqlSelecionaBase = pg_query($db,"SELECT * FROM dados WHERE id='$_REQUEST[id_base]'");
$SqlSelecionaBase = pg_fetch_array($SqlSelecionaBase);

$_SESSION[base_selecionada_id]         = $SqlSelecionaBase[id];
$_SESSION[base_selecionada_servidor]   = $SqlSelecionaBase[servidor];
$_SESSION[base_selecionada_base]       = $SqlSelecionaBase[base];
$_SESSION[base_selecionada_usuario]    = $SqlSelecionaBase[usuario];
$_SESSION[base_selecionada_senha]      = $SqlSelecionaBase[senha];
$_SESSION[base_selecionada_porta]      = $SqlSelecionaBase[porta];

include "inc/config.php";
