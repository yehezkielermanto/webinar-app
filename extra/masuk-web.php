<?php

$koneksi = null;
include __DIR__ ."/../koneksi.php";

session_start();
if (!isset($_SESSION["email"])) {
    header("Location: masuk.php");
}

if (isset($_POST['daftar'])) {
    $user_id = $_SESSION["user"]["id"];
    $event_id = $_POST['eventid'];
    $query = "INSERT INTO `event_participants` (`event_id`, `user_id`, `status`, `event_role`, `certificate_url`) VALUES (".$event_id.", ".$user_id.", '1', 'participant', NULL) ";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
        alert('gagal mendaftar.');
        document.location='index.php';
        </script>";
        exit();
    }
}
?>
