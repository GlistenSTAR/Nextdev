<?php
include ("include/common.php");
session_start();

if(!$_SESSION['LogaUser']){
  include "include/login.php";
}else{
 HEADER("Location:index.php?pg=busca");
}		

?>