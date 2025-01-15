<?php
$info = NULL;
include 'koneksi.php';

   
    if (isset($_GET['vkey'])) {
        //proses verifikasi
        $vkey = $_GET['vkey'];
        // $mysqli = NEW MySQLi ('localhost', 'ifukdcco','admin123','ifukdcco_webinar');
     
        $resultSet = $koneksi->query("SELECT verifikasi,vkey FROM master_peserta WHERE verifikasi= 0 AND vkey = '$vkey' LIMIT 1");
        echo $resultSetl;
        if ($resultSet->num_rows==1) {
            //Validasi email
            $update = $koneksi->query("UPDATE master_peserta SET verifikasi = 1 WHERE vkey ='$vkey' LIMIT 1");
            
            if ($update) {
                $info= '<div class="alert alert-success" role="alert">
                Akun Kamu sudah diverifikasi. Sekarang kamu bisa Login
              </div>';
            }else {
                $koneksi->error;
            }
        }else {
            $info= '
            
            <div class="alert alert-warning" role="alert">
            akun ini tidak valid atau sudah diverifikasi
            
            </div>';
        }

    }else {
        die("ada yang salah");
    }
    
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Portal DC-EVENT | Verifikasi</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/" />
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
            <form class="login-form validate-form">
                <span>
                    <img class="image p-l-48 p-t-1 p-b-1" src="images/logo_if.png" style="max-width: 225px;">
                </span>
                <span class="login-form-title p-b-30">
                    Portal Webinar<br>IF Darma Cendika
                </span>
                <div class="row text-center justify-content-center">
                    <?php echo $info; ?>
                </div>
                <form action="masuk.php" method="GET">
                    <div class="container-login-form-btn p-t-30 p-b-15">
                        <form>
                            <a href="masuk.php" class="login-form-btn">Masuk</a>
                        </form>
                        <!-- <button class="login-form-btn" name="login"><a href="masuk.php" >Masuk</a>
                        </button> -->
                    </div>
                </form>

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