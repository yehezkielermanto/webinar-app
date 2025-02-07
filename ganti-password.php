<!--Backend Start Here-->
<?php
session_start();

if (!isset($_SESSION["email"])) {
header("Location: login.php");
}

$koneksi = null;
include "koneksi.php";

$error="";
$kunci=NULL;
$sukses=NULL;
$email = $_SESSION["email"];

// Mengambil Password user dan Syarat Password
$password = $_SESSION["password"];
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number = preg_match('@[0-9]@', $password);
$specialChar = preg_match('@[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?~]@', $password);

if(isset($_POST["submit"])){
    // Ambil data dari yang di input user
    $cryptKey="";
    $password_lama = $_POST["password_lama"];
    $password_baru = $_POST["password_baru"];
    $konfirmasi_password_baru = $_POST["konfirmasi_password_baru"];

    // Cek bahwa password ini tidak kosong
    if($password_lama!="" && $password_baru!="" && $konfirmasi_password_baru!=""){
        $query = "SELECT password FROM users WHERE email='$email'";
        $result = mysqli_query($koneksi, $query);
        while ($row = mysqli_fetch_array($result)) {
        $cryptKey = $row['password'];
        }

        // Cek apakah password lama sesuai
        if($password_lama == $cryptKey){
            // Cek lagi apakah pass baru dan konfirmasi sesuai
            if($password_baru == $konfirmasi_password_baru){
                // Cek lagi untuk syarat password
                if(!$uppercase || !$lowercase || !$number || !$specialChar || strlen($password_baru) < 8){
                $kunci= "Password harus ada 8 karakter, harus memuat satu huruf kapital, angka, dan karakter spesial";
                // Kalau Memenuhi syarat
                } else{
                    $tmp_password = $password_baru;
                    $query = "UPDATE users SET password ='$tmp_password' WHERE email='$email'";
                    $result = mysqli_query($koneksi, $query);
                    session_unset();
                    session_destroy();
                    $sukses = 'Password berhasil diubah klik <a href="login.php" class="alert-link">link ini</a> untuk login';
                }
            } else{
                $sukses = '<strong>Password dan konfirmasi tidak sesuai</strong>';
            }
        } else{
            $sukses = '<strong>Password tidak sama dengan password lama anda</strong>';
        }
    } else{
    $error = '<strong>Password tidak sama dengan password lama Anda</strong>';
    }
}

?>
<!--Backend End Here-->

<!--Frontend Start Here-->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link href="css/profile.css" rel="stylesheet">
        <link href="css/beranda.css" rel="stylesheet">
        <link href="css/ganti-password.css" rel="stylesheet">
        <script src="js/beranda.js"></script>
    </head>
    <body>
        <div class="floating-menu">
            <div class="hamburg-menu" id="hmenu" hidden>
                <div class="hamburg-inner m-f">
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-home"></i> <a href="/webinar-app/beranda.php">Home</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-lightning_bolt"></i> <a href="/webinar-app/event.php">Webinar</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-certificate"></i> <a href="/webinar-app/sertifikat.php">Certificate</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-key"></i> <a href="/webinar-app/ganti-password.php">Ganti Password</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-headset"></i> <a href="/webinar-app/support.php">Support</a></div>
                    <hr>
                    <?php
                    if (isset($_SESSION["is_admin"])) {
                    if ($_SESSION["is_admin"] == "ADMIN") {
                    echo "
                    <div class='hamburg-btn'>,<i class='accent-cf mr-5 nf nf-fa-gear'></i> <a href='/webinar-app/koordinator/event_list.php'>Koordinator</a></div>
                    <hr>
                    ";
                    }
                    }
                    ?>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-account"></i> <a href="/webinar-app/profile/index.php">Profile</a></div>
                </div>
            </div>
            <div class="floating-hamburg" id="toggle-menu">
                <p class="accent-cf bold-f">
                    <i class="nf nf-md-menu"></i>
                </p>
            </div>
        </div>

        <div class="container">
            <div class="inner-container">
                <div class="inner-header">
                    <div class="inner-left">
                        <img class="if-logo" src="./images/logo_IF_square.png">
                        <p class="xl-f accent-cf bold-f page-title">DC-Webinar</p>
                    </div>
                </div>
                <div class="inner-content">
                    <p class="accent-cf bold-f drops-f xl-f">Halo, <?= $_SESSION["user"]["fullname"] ?></p>
                    <p class="m-f accent-cf bold-f drops-f p-this">Ganti Password</p>
                    <form action="ganti-password.php" method="POST">
                        <table>
                            <tr>
                                <th>Password Lama</th>
                            </tr>
                            <tr>
                                <td><input type="password" name="password_lama" autocomplete="off" required></td>
                            </tr>
                            <tr>
                                <th>Password Baru</th>
                            </tr>
                            <tr>
                                <td><input type="password" name="password_baru" autocomplete="off" required></td>
                            </tr>
                            <tr>
                                <th>Konfirmasi Password Baru</th>
                            </tr>
                            <tr>
                                <td><input type="password" name="konfirmasi_password_baru" autocomplete="off" required></td>
                            </tr>
                        </table>
                        <button type="submit" class="submit-change" name="submit" value="Ganti Password">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<!--Frontend Stop Here-->
