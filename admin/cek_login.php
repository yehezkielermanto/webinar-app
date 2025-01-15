<?php
// aktifkan session
session_start();

// panggil koneksi database
include 'koneksi.php';

$pass = md5($_POST['password']);
$user = mysqli_escape_string($koneksi, $_POST['username']);
$password = mysqli_escape_string($koneksi, $pass);

$login = mysqli_query($koneksi, "SELECT * FROM tuser where user = '$user' and pass = '$password' and status = 'Aktif'");

$data = mysqli_fetch_array($login);

// Uji jika user dan pass ditemukan atau sesuai
if ($data) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['user'] = $data['user'];
    $_SESSION['pass'] = $data['pass'];

    // arahkan ke halaman admin
    header('location:index.php');
} else {
    echo "<script>
        alert('Maaf, Login Gagal. Pastika Username dan Password anda benar!!!');
        document.location = 'login.php';
        </script>";
}
