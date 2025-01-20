<?php
// aktifkan session
session_start();

// panggil koneksi database
$koneksi = null;
include 'koneksi.php';

$pass = md5($_POST['password']);
$user = mysqli_escape_string($koneksi, $_POST['username']);
$password = mysqli_escape_string($koneksi, $pass);

$login = mysqli_query($koneksi, "SELECT * FROM users where username = '$user' and password = '$password' and status = 1");
$data = mysqli_fetch_array($login);

// Uji jika user dan pass ditemukan atau sesuai
if ($data) {
    $_SESSION['id_user'] = $data['user_id'];
    $_SESSION['user'] = $data['username'];
    $_SESSION['pass'] = $data['password'];
    $_SESSION['email'] = $data['email'];

    // arahkan ke halaman admin
    header('location:index.php');
} else {
    echo "<script>
        alert('Maaf, Login Gagal. Pastika Username dan Password anda benar!!!');
        document.location = 'login.php';
        </script>";
}
