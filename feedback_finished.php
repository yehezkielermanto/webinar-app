<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:session.php");
    exit;
}

$koneksi = null;
include 'koneksi.php';

$userID = $_SESSION["user"]["id"];
$event = array();

echo "";

if (isset($_POST["feedback_template_id"])) {
    $feedbackTemplateID = $_POST["feedback_template_id"];
    $eventParticipantID = $_POST["event_participant_id"];

    $answerArray = array();

    foreach (array_keys($_POST) as $k) {
        if ($k == "feedback_template_id" or $k == "event_participant_id" or $k == "event_id") continue;

        $answerArray[$k] = $koneksi->real_escape_string($_POST[$k]);
    }

    $answer = json_encode($answerArray);
    $status = 1;

    $query = "INSERT INTO event_feedbacks (feedback_template_id, event_participant_id, answer, created_at, `status`) VALUES ($feedbackTemplateID, $eventParticipantID, '$answer', NOW(), $status)";

    $res = $koneksi->query($query);

    if ($res) {
        $second_query = "UPDATE event_participants SET status = 1 WHERE user_id = $userID and id = $eventParticipantID";
        $res2 = $koneksi->query($second_query);
    }

    // html only
    $eventID = $_POST["event_id"];

    $resEvent = $koneksi->query("SELECT * FROM events WHERE id = '$eventID'");
    $event = mysqli_fetch_assoc($resEvent);

    // Get user's event participant ID
    $resEventParticipant = $koneksi->query("SELECT * FROM event_participants WHERE event_id = '$eventID' AND user_id = '$userID'");
    $eventParticipant = mysqli_fetch_assoc($resEventParticipant);

    $eventParticipantID = $eventParticipant["id"];

    // Get the feedback template of the webinar
    $resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_templates WHERE event_id = '$eventID'");
    $eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

    $feedbackTemplateID = $eventFeedbackTemplate["id"];
}

if (isset($_GET['event_id'])) {
    // html only
    $eventID = $_GET["event_id"];

    $resEvent = $koneksi->query("SELECT * FROM events WHERE id = '$eventID'");
    $event = mysqli_fetch_assoc($resEvent);

    // Get user's event participant ID
    $resEventParticipant = $koneksi->query("SELECT * FROM event_participants WHERE event_id = '$eventID' AND user_id = '$userID'");
    $eventParticipant = mysqli_fetch_assoc($resEventParticipant);

    $eventParticipantID = $eventParticipant["id"];

    // Get the feedback template of the webinar
    $resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_templates WHERE event_id = '$eventID'");
    $eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

    $feedbackTemplateID = $eventFeedbackTemplate["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/icons/" />
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/feedback.css">
        <link rel="stylesheet" type="text/css" href="css/profile.css">
        <script src="js/beranda.js"></script>
    <style>
        .responsive-alignment {
            text-align: left;
        }

        .floating-hamburg, .floating-menu {
            width: 48px;
            height: 48px;
        }

        @media (min-width: 1024px) {
            .responsive-alignment {
                text-align: center;
            }
        }
    </style>
    <title>Feedback</title>
</head>
<body>
        <!-- floating hamburger menu -->
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
    <div
        style="background-color: #F6F6F6; padding-inline: 1rem; padding-block: 0.5rem;
        margin-inline: 2rem; margin-block: 1rem; border-radius: 1rem;"
    >
        <h1 style="color: #A987FF;">FORM PENGISIAN FEEDBACK - <?= $event['title']; ?></h1>
        <p>Informasi akun anda akan disimpan dengan jawaban Anda.</p>
        <hr style="border-color: #EAEAEA; margin-block: 1rem;" />

        <p class="text-black responsive-alignment fs-16" style="padding-bottom: 1rem;">
            Terima kasih untuk menjawab form feedback <?= $event['type']; ?> yang berjudul
            <b><?= $event['title']; ?>!</b>
        </p>

        <p class="text-black responsive-alignment fs-16">
            Kami berharap Anda dapat mengikuti webinar berikutnya!
        </p>

        <div style="display:flex; justify-content: center; padding-block: 1rem;">
            <a href="beranda.php">
                <button
                    type="button"
                    class="feedback-submit">
                    KEMBALI KE BERANDA
                </button>
            </a>
        </div>
    </div>
</body>
</html>
