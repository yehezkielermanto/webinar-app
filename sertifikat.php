<?php
session_start();

// TO-DO : THIS CERTIFICATE ONLY PLACEHOLDER

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
}

$koneksi = null;
include "koneksi.php";

$email = $_SESSION["user"]["email"];
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link href="css/profile.css" rel="stylesheet">
        <link href="css/beranda.css" rel="stylesheet">
        <link href="css/sertifikat.css" rel="stylesheet">
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
                <div class="sertifikat-content">
                    <p class="accent-cf bold-f drops-f xl-f">Halo, <?= $_SESSION["user"]["fullname"] ?></p>
                    <p class="m-f accent-cf bold-f drops-f p-this">Sertifikat Webinar</p>
                    <div class="list-sertif">
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Hello World !</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                        <div class="sertifikat-card">
                            <div class="sertifikat-card-upper">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstiDzAbJoKeUxG0rnuhguZNMEXYf4fjtcYg&s">
                            </div>
                            <div class="sertifikat-card-bottom">
                                <p>Nama Sertifikat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
