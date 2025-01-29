<?php
// TEMPORARY EDIT - CAN BE DISCARDED ON MERGE

$error = null;

session_start();
include 'koneksi.php';
if (isset($_POST['masuklogin'])) {
    $emailpass = $_POST['emailpass'];
    $password = md5($_POST['password']);
    //echo "$emailpass + $password";

    $sql =
        "SELECT * from users WHERE email='" .
        $emailpass .
        "' AND password='" .
        $password .
        "' limit 1";
    $hasil = mysqli_query($koneksi, $sql);
    $jumlah = mysqli_num_rows($hasil);

    if ($jumlah > 0) {
        $row = mysqli_fetch_assoc($hasil);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['email'] = $row['email'];
        if ($row['status_verification'] == 1) {
            header('location:beranda.php');
        } else {
            $error = '<div class="alert alert-danger text-center" role="alert">
				<strong>Akun anda belum terverifikasi</strong>
				</div>';
        }
    } else {
        $error = '<div class="alert alert-danger text-center" role="alert">
				<strong>Email atau password salah.</strong>
			</div>';
    }
}
if (isset($_POST['lupapassword'])) {
    header('location:lupa_pass.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login Portal DC-EVENT</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>
    <div class="container-login" style="background-image: url('images/bg08.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-1 p-b-30 " style="min-height:95vh;">
            <div><?php echo $error; ?></div>
            <form class="login-form validate-form" action="masuk.php" method="POST">
                <span>
                    <img class="image p-l-48 p-t-1 p-b-1" src="images/logo_IF_square.png" style="max-width: 225px;">
                </span>
                <span class="login-form-title p-b-30">
                    Masuk Portal<br>DC-Event
                </span>

                <div class="wrap-input validate-input m-b-20" data-validate="Masukkan Email">
                    <input class="input" type="email" name="emailpass" placeholder="Email">
                    <span class="focus-input"></span>
                </div>

                <div class="wrap-input validate-input m-b-25" data-validate="Masukkan password">
                    <input class="input" type="password" name="password" placeholder="password">
                    <span class="focus-input"></span>
                </div>
                <div class="text-center">
                    <a href="lupa_pass.php" class="txt2 hov1">
                        Lupa Password
                    </a>
                </div>

                <div class="container-login-form-btn p-t-15 p-b-40">
                    <button class="login-form-btn" name="masuklogin">
                        Masuk
                    </button>
                </div>

                <div class="text-center">
                    <a href="index.php" class="txt2 hov1">
                        < kembali </a>
                </div>
            </form>
        </div>
    </div>

    <!-- script java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>