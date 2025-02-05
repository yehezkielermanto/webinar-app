<?php
session_start();
$koneksi = null;
include "koneksi.php";

if(!isset($_SESSION['email'])){
    header("Location: /webinar-app/index.php");
    exit;
}

if (!isset($_GET["event_id"])) {
    header("Location: /webinar-app/index.php");
}

$event_id = $_GET["event_id"];
$query = "select * from events where id = $event_id limit 1";
$result = mysqli_query($koneksi, $query);
$result_len = mysqli_num_rows($result);
$obj = [];
while ($row = $result->fetch_assoc()) {
    array_push($obj, $row);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Webinar Page</title>
        <link href="css/profile.css" rel="stylesheet">
        <link href="css/webinar_info.css" rel="stylesheet">
        <script src="js/webinar_info.js"></script>
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
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-account"></i> <a href="">Profile</a></div>
                </div>
            </div>
            <div class="floating-hamburg" id="toggle-menu">
                <p class="accent-cf bold-f">
                <i class="nf nf-md-menu"></i>
                </p>
            </div>
        </div>
        <div class="container" style="flex-direction: column !important; padding: 20px !important;">
            <div style="height: 90vh; display: flex; flex-direction: column; text-align: center; align-items: center">
                <img class="webinar-poster" src="<?= $obj[0]["poster_url"] ?>" style="height: 200px; max-height: 300px"/>
                <h1 class="webinar-title accent-cf"> <?= $obj[0]["title"] ?></h1>
                <div class="info-container">
                <h3 class="webinar-speaker"><i class="nf nf-oct-people"></i> <?= $obj[0]["speaker"] ?></h3>
                <h3 class="webinar-date"><i class="nf nf-oct-calendar"></i> <?= $obj[0]["date"] ?></h3>
                <h3 class="webinar-time"><i class="nf nf-oct-clock"></i> <?= $obj[0]["start_time"] ?></h3>
                </div>
                <hr class="sep">
                <div class="diag-box">
                    <p class="m-f"><?= $obj[0]["description"] ?></p>
                </div>
                <div class="bottom">
                    <button class="bottom-btn">Daftar Webinar</button>
                    <button class="bottom-btn">Unduh Sertifikat</button>
                    <button class="bottom-btn">Isi Feedback</button>
                </div>
            </div>
        </div>
    </body>
</html>
