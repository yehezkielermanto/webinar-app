<?php 
session_start();
unset($_SESSION["nama_lengkap"]);
unset($_SESSION["email"]);
unset($_SESSION['id_peserta'] );
unset($_SESSION['nama_lengkap'] );
unset($_SESSION['email'] );
unset($_SESSION['phone'] );
unset($_SESSION['gender'] );
unset($_SESSION['institution'] );
header("Location:masuk.php");
?>
