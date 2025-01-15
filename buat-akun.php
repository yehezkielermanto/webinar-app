<?php
include "koneksi.php";
ini_set('max_execution_time', '300');

//ambil function smtp_mail
include("asset/library-email/function.php");
$error = null;
$event = null;
$sukses = null;
$kunci = null;
$email_db = null;

//select option
$result = $koneksi->query('SELECT judul,id_event FROM master_event WHERE status=1'
);

if (isset($_POST['submit'])) {
    //Get Data
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $event = $_POST['event'];
    $institusi = $_POST['institusi'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    
    $secret_key = '6Ld3FuYcAAAAANmQI1TzqJxUlb57n13WoOiv9J7J';

        // Disini kita akan melakukan komunkasi dengan google recpatcha
        // dengan mengirimkan scret key dan hasil dari response recaptcha nya
        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
        $response = json_decode($verify);
		
        if ($response->success) {
         echo '<script>alert("Google reCAPTACHA verified")</script>';
        }
    
    
    //cek email apakah sudah ada di database (1 email = 1 kali daftar)
    $sql = "SELECT email FROM master_peserta WHERE email = '$email' LIMIT 1";
    $result2 = $koneksi->query($sql);
    while ($row = mysqli_fetch_array($result2)) {
        $email_db = $row['email'];
    }
    if ($email == $email_db) {
        $sukses = '<div class="  alert alert-danger text-center" role="alert">
                Email sudah terdaftar.
                </div>';
    } else {
        // Secret Key ini kita ambil dari halaman Google reCaptcha
        // $secret_key = '6Ld3FuYcAAAAANmQI1TzqJxUlb57n13WoOiv9J7J';

        // Disini kita akan melakukan komunkasi dengan google recpatcha
        // dengan mengirimkan scret key dan hasil dari response recaptcha nya
        // $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
        // $response = json_decode($verify);
		
        // if ($response->success) {
            // Jika proses validasi captcha berhasil
            $password = $_POST['password'];
            $konfirmasi_password = $_POST['konfirmasi_password'];

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChar = preg_match(
                '[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?~]',
                $password
            );

            if (
                !$uppercase ||
                !$lowercase ||
                !$number ||
                $specialChar ||
                strlen($password) < 8
            ) {
                $kunci =
                    'Password harus ada 8 karakter, harus memuat satu huruf kapital, angka, dan karakter spesial';
            } elseif ($password != $konfirmasi_password) {
                $error =
                    "<div class='alert alert-danger text-center' role='alert'>password kamu tidak sama dengan konfirmasi password</div>";
            } else {
                // form valid
                //Sanitize form data
                $nama = $koneksi->real_escape_string($nama);
                $jenis_kelamin = $koneksi->real_escape_string($jenis_kelamin);
                $event = $koneksi->real_escape_string($event);
                $institusi = $koneksi->real_escape_string($institusi);
                $alamat = $koneksi->real_escape_string($alamat);
                $email = $koneksi->real_escape_string($email);

                $password = $koneksi->real_escape_string($password);
                $konfirmasi_password = $koneksi->real_escape_string(
                    $konfirmasi_password
                );

                //Generate Vkey
                $vkey = md5(time() . $nama);
                // echo $vkey;
                // -----------------------------------------------------------------
                //generate id_peserta
                // mengambil data barang dengan kode paling besar
                $query_id = mysqli_query(
                    $koneksi,
                    'SELECT max(id_peserta) as kodeTerbesar FROM master_peserta'
                );

                $data = mysqli_fetch_array($query_id);
                $noid = $data['kodeTerbesar'];

                // echo $noid;
                // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
                // dan diubah ke integer dengan (int)
                $urutan = (int) substr($noid, 3);

                // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                $urutan++;

                // membentuk kode barang baru
                // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
                // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
                // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya USR
                $huruf = 'PSR';
                $noid = $huruf . sprintf('%03s', $urutan);
                //echo $noid;

                // ---------------------------------------------------------------------
                //Insert to database

                $password = md5($password);
                $insert = $koneksi->query(
                    "INSERT INTO master_peserta(id_peserta,nama_lengkap,jenis_kelamin,asal_institusi,alamat,email,password,vkey) VALUES('$noid','$nama','$jenis_kelamin','$institusi','$alamat','$email','$password','$vkey')"
                );

                if ($event != null) {
                    $peserta_event = "$noid$event";
                    //insert kedua
                    $insert .= $koneksi->query(
                        "INSERT INTO peserta_event (id_peserta_event,id_peserta,id_event) VALUES('$peserta_event','$noid','$event')"
                    );
                }
                if ($insert) {
                    //Send Email
                    $to = $email;
                    $subject = 'Webinar Informatika UKDC ';
                    $message = " 

                                <div style='width : 550px;
                                border : 2px solid black;
                                margin : 20px auto;'>
                                    <div style='border-bottom : 2px solid black;'>
                                        <center><img src = 'https://drive.google.com/uc?id=1cTPc2fgt_RY78klrt6m3mSRnXtdRSAQD' alt = 'DC Informatics' width = '550' height = '175'></center>
                                    </div>
                                    <p  style='font-size : 25px;
                                    font-family : sans-serif;
                                    text-align : center;'> Halo, $email! </p><br> 
                                    <p  style='font-size : 18px;
                                    font-family : sans-serif;
                                    text-align : center;'> Yuk verifikasi email kamu dengan cara <br> klik tombol dibawah ini ya! <br>
                                    </p>
                                    <br>
                                    <br>
                                    <center><a href = 'https://webinar.ukdc.ac.id/verify.php?vkey=$vkey' style='font-family : sans-serif;
                                        font-size : 15px;
                                        background : #2de030;
                                        color : white;
                                        border : white 3px solid;
                                        border-radius : 5px;
                                        padding : 12px 20px;
                                        margin-top : 10px;
                                        text-decoration : none;'> Verifikasi Email </a><center>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <p class = 'p3' style='font-size : 12px;
                                    font-family : sans-serif;
                                    text-align : center;''> &copy; DC Informatics </p>
                                </div>
                                
                                ";
                    $headers = "From:ifukdcco@if-ukdc.com \r \n";

                    smtp_mail($to, $subject, $message, $headers, '', 0, 0, true);

                    $sukses = '<div class="alert alert-danger text-center" role="alert">
                                Sukses buat akun silahkan cek email untuk verifikasi.
                                </div>';
                    //header('location:thankyou.php');
                } else {
                    echo $mysqli->error;
                }
            }
        // } else {
          
        //     // Jika captcha tidak valid
        //     $error ="<div class='alert alert-danger text-center' role='alert'>Silahkan klik kotak I'm not robot (reCaptcha) untuk verifikasi</div>";
        // }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sign Up | DC-Event</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- untuk style font dan layout-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Buat Akun</title>
    <!-- Load Librari Google reCaptcha nya -->
  	<script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>
<style>
#message {
    background: #f1f1f1;
    color: #000;
    padding: 5px;
    margin: 0px;
    margin-top: 8px;
}

#message p {
    padding: 0px 35px;
    font-size: 12px;
}

.valid {
    color: green;
}

.valid:before {
    position: relative;
    left: -10px;
    content: "\2713";
}

.invalid {
    color: red;
}

.invalid:before {
    position: relative;
    left: -10px;
    content: "\0D7";
}

#letter {
    float: left;
}

#number {
    float: left;
}
</style>

<body>

    <div class="container-login" style="background-image: url('images/bg08.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-20 p-b-20" style="min-height:95vh;">
            <div> <?php echo $sukses; ?></div>
            <div> <?php echo $error; ?></div>
            <form class="login-form validate-form" action="buat-akun.php" method="POST">
                <span class="login-form-title p-b-30">
                    Buat Akun
                </span>

                <span class="txt2">Nama Lengkap</span>
                <div class="wrap-input validate-input m-b-20" data-validate="Masukkan Nama">
                    <input class="input" type="text" name="nama">
                    <span class="focus-input"></span>
                </div>
                <p style="font-size: 12px;">Pastikan masukkan nama lengkap untuk sertifikat</p>
                <br>

                <span class="txt2">Gender</span>
                <div class="select2.container">
                    <select class="select2-dropdown" name="jenis_kelamin">
                        <option value="0">Laki-Laki</option>
                        <option value="1">Perempuan</option>
                    </select>
                </div>
                <br>

                <span class="txt2">Email</span>
                <div class="wrap-input validate-input m-b-20" data-validate="Masukkan Email">
                    <input class="input" type="email" name="email">
                    <span class="focus-input"></span>
                </div>

                <span class="txt2">Event</span>
                <div class="select2.container">
                    <div class="mb-3 text-start">
                        <?php
                        echo "<select name='event' class='select2-dropdown' >";
                        $rowcount = mysqli_num_rows($result);
                        if ($rowcount <= 0) {
                            echo '<option value=""></option>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $id_event = $row['id_event'];
                                $judul = $row['judul'];
                                echo '<option value="' .
                                    $id_event .
                                    '"  ><div class ="">' .
                                    $judul .
                                    '</div></option>';
                            }
                        }

                       echo '</select>';
                        ?>
                    </div>

                </div>
                <br>
                <span class="txt2">Asal Instansi</span>
                <div class="wrap-input validate-input m-b-20" data-validate="Masukkan Asal Instansi">
                    <input class="input" type="text" name="institusi" placeholder="">
                    <span class="focus-input"></span>
                </div>

                <span class="txt2">Alamat Rumah</span>
                <div class="wrap-input validate-input m-b-20" data-validate="Masukkan alamat">
                    <input class="input" type="text" name="alamat" placeholder="">
                    <span class="focus-input"></span>
                </div>
                <p style="font-size: 12px;">Alamat Rumah digunakan untuk pengiriman hadiah jika anda beruntung.</p>
                <br>

                <span class="txt2">Password</span>
                <div class="wrap-input validate-input m-b-25" data-validate="Masukkan password">
                    <input class="input" type="password" placeholder="" id="pass" name="password">
                    <span class="focus-input"></span>
                </div>
                <div id="message">
                    <p>Password harus terdiri dari: </p>
                    <p id="letter" class="invalid"><b>Huruf kecil</b></p>
                    <p id="capital" class="invalid"><b>Huruf besar</b></p>
                    <p id="number" class="invalid"><b>Nomor</b></p>
                    <p id="length" class="invalid"><b>8 karakter</b></p>
                    <p id="spechar" class="invalid" style="text-align:left;"><b>Karakter khusus</b></p>
                </div>

                <br>
                <span class="txt2">Konfirmasi Password</span>
                <div class="wrap-input validate-input m-b-25" data-validate="Masukkan password">
                    <input class="input" type="password" name="konfirmasi_password" placeholder="">
                    <span class="focus-input"></span>
                </div>
                <?php echo $kunci; ?>
                <!-- site key -->
              
                <!-- <div class="g-recaptcha mb-3" data-sitekey="6Ld3FuYcAAAAADmklc5SwsdjDSWbwXADHj0V4sQN" data-expired-callback="recaptchaExpired" onload="getReCaptcha()"></div> -->

                <div class="container-login-form-btn p-t-15 p-b-30">
                    <button class="login-form-btn" name="submit">
                        Daftar
                    </button>
                </div>

                <div class="text-center">
                    <a href="index.php" class="txt2 hov1">Kembali</a>
                </div>
                <hr>
            </form>
        </div>
    </div>

    <!-- java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    
</body>
<script>
 // function getReCaptcha(){
   // grecaptcha.ready(function() {
      //  grecaptcha.render('g-recaptcha', {
           //  'sitekey': '6Ld3FuYcAAAAADmklc5SwsdjDSWbwXADHj0V4sQN',
          //   'expired-callback': fnCallback
          // });
    // });
 	//}
 // getReCaptcha();
  //setInterval(function(){getReCaptcha();}, 5*60*100);
      // var fnCallback = function() {
        //  grecaptcha.reset();
      // };
  function recaptchaExpired(){
        alert("Your Recaptcha has expired, please verify it again !");
    	 
    }
var myInput = document.getElementById("pass");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var spechar = document.getElementById("spechar");
var length = document.getElementById("length");

  myInput.onfocus = function() {
     document.getElementById("message").style.display = "block";
 }

myInput.onblur = function() {
    document.getElementById("message").style.display = "block";
}

myInput.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if (myInput.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    //specials character
    var spechars = /[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?~]/;
    if (myInput.value.match(spechars)) {
        spechar.classList.remove("invalid");
        spechar.classList.add("valid");
    } else {
        spechar.classList.remove("valid");
        spechar.classList.add("invalid");
    }

    // Validate length
    if (myInput.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
}
</script>

</html>