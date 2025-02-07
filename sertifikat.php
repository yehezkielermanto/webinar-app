<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
}

$koneksi = null;
include "koneksi.php";
$user_id = $_SESSION['user']['id'];
date_default_timezone_set('Asia/Jakarta');
$currentdate = date("Y-m-d");

$certarray = array();

function create_empty_dialog() {
    echo "<div class='empty-event'>";
    echo "<p>Tidak ada sertifikat yang tersedia, silahkan ikuti webinar yang ada.</p>";
    echo "<button class='simp-btn bold-f s-f accent-cf' onclick='window.location.href=\"event.php\"'>Cari event.</button>";
    echo "</div>";
}

function create_sertif_card(array $a) {
    $name = $a["title"];
    $cerurl = $a["certificate_url"];
    $path = $a["certificate_url"];
    $event_id = $a["event_id"];

    if ($cerurl != "") {
        echo "
            <a href='/webinar-app/donwload-certificate.php?l=$path&e=$event_id' class='sertifikat-card'>
                <div class='sertifikat-card-upper'>
                    <img class='cert-img' src='$cerurl'>
                </div>
                <div class='sertifikat-card-bottom'>
                    <p class='accent-cf bold-f m-f certname'>$name</p>
                </div>
            </a>
        ";
        return true;
    }
    return false;
}

$query = "
    select e.*, ep.certificate_url, ep.event_id
    from events e
    join event_participants ep
    on e.id = ep.event_id
    where ep.status = 1 and ep.user_id = $user_id and e.date <= '$currentdate'
    -- where ep.status = 1 and ep.user_id = $user_id
";
$result = mysqli_query($koneksi, $query);
while ($row = $result->fetch_assoc()) {
    array_push($certarray, $row);
}

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sertifikat</title>
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
                        <?php
                        if (count($certarray) <= 0) {
                            create_empty_dialog();
                        } else {
                            $counter = 0;
                            foreach ($certarray as $elm) {
                                if (create_sertif_card($elm)) {
                                    $counter += 1;
                                }
                            }
                            if ($counter <= 0) {
                                create_empty_dialog();
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
