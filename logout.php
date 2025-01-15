<?php 
session_start();
unset($_SESSION["nama_lengkap"]);
unset($_SESSION["email"]);
header("Location:masuk.php");
?>