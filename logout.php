<?php 
session_start();
$location = "login.php";
unset($_SESSION["nama_lengkap"]);
unset($_SESSION["email"]);
unset($_SESSION['id_peserta'] );
unset($_SESSION['nama_lengkap'] );
unset($_SESSION['email'] );
unset($_SESSION['phone'] );
unset($_SESSION['gender'] );
unset($_SESSION['institution'] );
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == "admin") {
    unset($_SESSION['is_admin'] );
    $location = "/webinar-app/admin/login.php";
}
session_unset();
session_destroy();
header("Location:" . $location);
?>
