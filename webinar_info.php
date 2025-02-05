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
$user_id = $_SESSION["user"]["id"];
$query = "select * from events where id = $event_id limit 1";
$regresult = mysqli_query($koneksi, $query);
$result_len = mysqli_num_rows($regresult);
$obj = [];
while ($row = $regresult->fetch_assoc()) {
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
            <div style="height: 100%; display: flex; flex-direction: column; text-align: center; align-items: center">
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
            </div>
            <div class="bottom">
                <?php
                // registered
                $regquery = "select count(id) from event_participants where user_id = $user_id and event_id = $event_id";
                $regresult = mysqli_query($koneksi, $regquery);
                $len = mysqli_num_rows($regresult);
                $registered = $len > 0 ? true : false;
                
                // download cert
                $certquery = "select certificate_url from event_participants where user_id = $user_id and event_id = $event_id";
                $certresult = mysqli_query($koneksi, $certquery);
                $certlen = mysqli_num_rows($certresult);
                $row = mysqli_fetch_array($certresult);
                $certregistered = $certlen > 0 ? true : false;
                if ($row != null || count($row) > 0 || $row != "") {
                    $certregistered = true;
                }

                // isi feedback
                $feedquery =
                "SELECT a.*, b.*
                FROM event_feedbacks a 
                JOIN event_feedback_templates b 
                ON a.feedback_template_id = b.id
                WHERE a.event_participant_id = $user_id AND b.event_id = $event_id";
                $feedresult = mysqli_query($koneksi, $feedquery);
                $row = mysqli_fetch_array($feedresult);
                $feedregistered = false;
                if ($row == null) {
                    $feedregistered = true;
                } elseif (count($row) <= 0) {
                    $feedregistered = true;
                }

                ?>
                <form method="POST">
                    <button name="register" class="bottom-btn" <?= $registered == true ? "disabled" : "" ?> ><?= $registered == true ? "Sudah terdaftar" : "Ikuti webinar"?></button>
                    <button name="dcert" class="bottom-btn" <?= $certregistered == false ? "disabled" : "" ?> ><?= $registered == false ? "Unduh sertifikat tidak tersedia" : "Unduh Sertifikat"?></button>
                    <button name="feed" class="bottom-btn" <?= $feedregistered == false ? "disabled" : "" ?> ><?= $feedregistered == false ? "Feedback tidak tersedia" : "Isi feedback"?></button>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
if (isset($_POST["register"])) {
    $email = $_SESSION['email'];
    $id_peserta = $_SESSION["user"]["id"];
    $query = "INSERT INTO `event_participants` (`event_id`, `user_id`, `status`, `event_role`, `certificate_url`) VALUES (".$event_id.", ".$user_id.", '0', 'participant', NULL) ";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "<script>
        alert('gagal mendaftar.');
        document.location='index.php';
        </script>";
        exit();
    }
}

if (isset($_POST["dcert"])) {
    $query = "select certificate_url from event_participants where user_id = $user_id and event_id = $event_id limit 1";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $filename = $row["certificate_url"];
        echo "
        <script>downcert('$filename', $event_id)</script>
        ";
    }
}

if (isset($_POST["feed"])) {
    header("Location: /webinar-app/feedback.php?event_id=$event_id");
}
?>
