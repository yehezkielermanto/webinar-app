<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
}

$koneksi = null;
include "koneksi.php";

$user_id = $_SESSION["user"]["id"];
$currentdate = date("Y-m-d"); 
$query = "SELECT * FROM events WHERE date >= '$currentdate' order by date";
$result = mysqli_query($koneksi, $query);
$row = array();
while ($r = $result->fetch_assoc()) {
    array_push($row, $r);
}

$query2 = "
select e.*
from event_participants ep
join events e on ep.event_id = e.id
where ep.user_id = $user_id and e.date >= '$currentdate'
order by e.date
";
$result2 = mysqli_query($koneksi, $query2);
$row2 = array();
while ($r = $result2->fetch_assoc()) {
    array_push($row2, $r);
}

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Beranda</title>
        <link href="css/profile.css" rel="stylesheet">
        <link href="css/beranda.css" rel="stylesheet">
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
                    <div class='hamburg-btn'><i class='accent-cf mr-5 nf nf-fa-gear'></i> <a href='/webinar-app/koordinator/event_list.php'>Koordinator</a></div>
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
                    <!--<button id="toggle-notif" class="notif-button accent-cf"><i class="nf nf-md-bell"></i></button>-->
                    <button class="notif-button accent-cf" onclick="window.location.href='notif.php'"><i class="nf nf-md-bell"></i></button>
                </div>
                <div class="inner-content">
                    <div class="webinar-grid-outter">
                        <p class="accent-cf bold-f drops-f xl-f">Halo, <?= $_SESSION["user"]["fullname"] ?></p>
                        <br>
                        <p class="m-f accent-cf bold-f drops-f">Webinar yang tersedia</p>
                        <div class="coming-container">
                            <!-- start here -->
                            <?php
                            if (count($row) <= 0) {
                            echo "<p>Tidak ada webinar yang tersedia.</p>";
                            } else {
                            foreach ($row as $card) {
                            $poster_url = $card["poster_url"];
                            $title = $card["title"];
                            $speaker = $card["speaker"];
                            $tanggal = $card["date"];
                            $time = $card["start_time"];
                            $id = $card["id"];
                            echo "
                            <a class='webinar white-cf' href='/webinar-app/webinar_info.php?event_id=$id'>
                            <div class='card-upper'>
                            <div class='wimg-container'>
                            <img class='responsive-image2' src='$poster_url'/>
                            </div>
                            </div>
                            <div class='beranda-card-bottom'>
                            <p class='m-f bold-f mb-5 mb-0'>$title</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-calendar'></i> $tanggal</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-clock'></i> $time</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-people'></i> $speaker</p>
                            </div>
                            </a>
                            ";
                            }
                            }
                            ?>
                            <!-- end here -->
                        </div>
                        <!-- container list webinar yang diikuti mau datang -->
                        <p class="m-f accent-cf bold-f drops-f">Webinar yang akan datang</p>
                        <div class="coming-container">
                            <!-- start here -->
                            <?php
                            if (count($row2) <= 0) {
                            echo "<p>Tidak ada webinar yang kamu ikuti.</p>";
                            } else {
                            foreach ($row2 as $card) {
                            $poster_url = $card["poster_url"];
                            $title = $card["title"];
                            $speaker = $card["speaker"];
                            $tanggal = $card["date"];
                            $time = $card["start_time"];
                            $id = $card["id"];
                            echo "
                            <a class='webinar white-cf' href='/webinar-app/webinar_info.php?event_id=$id'>
                            <div class='card-upper'>
                            <div class='wimg-container'>
                            <img class='responsive-image2' src='$poster_url'/>
                            </div>
                            </div>
                            <div class='beranda-card-bottom'>
                            <p class='m-f bold-f mb-5 mb-0'>$title</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-calendar'></i> $tanggal</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-clock'></i> $time</p>
                            <p class='s-f mb-0'> <i class='nf nf-oct-people'></i> $speaker</p>
                            </div>
                            </a>
                            ";
                            }
                            }
                            ?>
                            <!-- end here -->
                        </div>
                    </div>

                </div>
            </div>
            <div class="footer white-cf">
                <p class="m-f bold-f">Hubungi Kami</p>
                <div class="footer-entry">
                    <p class="s-f foot"><i class="nf nf-fa-building"></i> <a href="https://maps.app.goo.gl/TS4wXL4TqFEHyiuD7">JL. IR.H. Soekarno no.201, Surabaya</a> &nbsp</p>
                    <p class="s-f foot"><i class="nf nf-fa-phone"></i> (031) 5914157, 5946482 &nbsp</p>
                    <p class="s-f foot"><i class="nf nf-md-email"></i> <a href="mailto:info@ukdc.ac.id">info@ukdc.ac.id(informasi)</a>, <a href="mailto:pmb@ukdc.ac.id">pmb@ukdc.ac.id(pmb)</a></p>
                </div>
            </div>
        </div>
        <div id="notif-menu" class="floating-notif" hidden>
            <div class="webinar-notif">
                <p>Event</p>
                <p class="notif-datetime">Date and time</p>
            </div>
        </div>
    </body>
</html>

