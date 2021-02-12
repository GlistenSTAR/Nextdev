<?php
session_start();

if($_SESSION['LogaUser']){
  session_destroy();
}

HEADER("Location: ../index.php");
?>