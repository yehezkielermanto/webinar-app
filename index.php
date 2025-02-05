<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login Portal DC-EVENT</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/logo_IF_square.png" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>

    <div class="container-login" style="background-image: url('images/bg08.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-1 p-b-30" style="min-height:95vh;">
            <form class="login-form validate-form" action="index.php" method="POST">
                <span>
                    <img class="image p-l-48 p-t-1 p-b-1" src="images/logo_IF_square.png" style="max-width: 225px;">
                </span>
                <span class="login-form-title p-b-30">
                    Portal Webinar<br>IF Darma Cendika
                </span>
                <div class="row text-center justify-content-center">
                    Selamat datang di website informatika UKDC. Silahkan masuk atau buat akun terlebih dahulu.
                </div>

                <div class="container-login-form-btn p-t-30 p-b-15">
                    <button class="login-form-btn " name="login"><a style="color:white;">Masuk</a></button>
                </div>

                <div class="container-login-form-btn p-t-15 p-b-40">
                    <button class="login-form-btn " name="register"><a style="color: white;">Daftar</a>
                    </button>
              </div>
            </form>
        </div>
      	<!-- tombol bantuan
        <div style="position:fixed; bottom:0; right:0;color:black;background-color:white;margin:10px;padding:4px;border-radius:5px;">
          <a href="https://wa.me/6289529633429" target="_blank" style="text-decoration:underline;">Klik untuk bantuan</a>
        </div> -->
    </div>
  	
  

    <!-- script java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
<?php
if (isset($_POST['login'])) {
    header('Location: login.php');
}
if (isset($_POST['register'])) {
    header('Location: register.php');
}


session_start();
if (isset($_SESSION["email"])) {
    header("Location: beranda.php");
}
?>
