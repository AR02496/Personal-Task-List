<?php 
include("koneksi.php");
session_start();

session_destroy();

// Delete cookie
setcookie("remember_email", "", time() - 3600, "/");
header("location:login.php");


?>
