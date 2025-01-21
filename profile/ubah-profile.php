<?php
session_start();
$koneksi = null;
include '../koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location:/masuk.php");
    exit;
}

if (isset($_POST['email']) &&
    isset($_POST['phone']) &&
    isset($_POST['name']) &&
    isset($_POST['instansi'])){

    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $instansi = $_POST['instansi'];
    $id = $_SESSION['id_peserta'];

    $hasil = $koneksi->query("UPDATE users SET phone='$phone', fullname='$name', institution='$instansi' WHERE user_id=$id");
    if (!$hasil) {
        echo "Gagal mengubah data";
        exit;
    } else {
        $_SESSION['nama_lengkap'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['institution'] = $instansi;
    }
    /*while ($row = mysqli_fetch_assoc($hasil)) {*/
    /*    $_SESSION['nama_lengkap'] = $row['fullname'];*/
    /*    $_SESSION['email'] = $row['email'];*/
    /*    $_SESSION['phone'] = $row['phone'];*/
    /*}*/
}
header("Location:/profile/index.php");
exit;
?>
