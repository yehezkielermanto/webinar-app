<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:/webinar-app/index.php");
    exit;
}

$koneksi = null;
include 'koneksi.php';

// add check so it wont render on empty GET
if (!isset($_GET["event_id"])) {
    header("Location:session.php");
    exit();
}
$eventID = $_GET["event_id"];
$userID = $_SESSION["user"]["id"];

echo "";

$resEvent = $koneksi->query("SELECT * FROM events WHERE id = '$eventID'");
$event = mysqli_fetch_assoc($resEvent);

// Get user's event participant ID
$resEventParticipant = $koneksi->query("SELECT * FROM event_participants WHERE event_id = '$eventID' AND user_id = '$userID'");
$eventParticipant = mysqli_fetch_assoc($resEventParticipant);

if ($eventParticipant != null) {
    $eventParticipantID = $eventParticipant["id"];
}

// Get the feedback template of the webinar
$resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_templates WHERE event_id = '$eventID'");
$eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

if ($eventFeedbackTemplate != null) {
    $feedbackTemplateID = $eventFeedbackTemplate["id"];
    $feedback = json_decode($eventFeedbackTemplate["field"]);

    // Find if event_feedback answer exists, then redirect to feedback_finished.php
    $resEventFeedback = $koneksi->query("SELECT * FROM event_feedbacks WHERE feedback_template_id = '$feedbackTemplateID' AND event_participant_id = '$eventParticipantID'");

    if (mysqli_num_rows($resEventFeedback) > 0) {
        header("Location:feedback_finished.php?event_id=$eventID");
        exit;
    }
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
        .responsive-answer {
            width: 100%;
        }

        .icon-responsive {
            width: 32px; height: 32px;
        }

        .floating-hamburg, .floating-menu {
            width: 48px;
            height: 48px;
        }

        @media (min-width: 1024px) {
            .responsive-answer {
                width: 50%;
            }

            .icon-responsive {
                width: 64px; height: 64px;
            }
        }
    </style>
    <title>Pengisian Feedback</title>
</head>
<body style="position: relative;">
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
        margin-inline: 2rem; margin-block: 1rem; border-radius: 1rem; filter: drop-shadow(0px 5px 10px rgba(0,0,0,0.3));"
    >
        <div>
            <h1 style="color: rgb(182,163,232);">FORM PENGISIAN FEEDBACK - <?= $event['title']; ?></h1>
            <p>Informasi akun anda akan disimpan dengan jawaban Anda.</p>
        </div>
        <hr style="border-color: rgb(164,164,164); margin-block: 1rem;" />

        <form method="post" action="feedback_finished.php">
            <input
                type="hidden"
                id="event_id"
                name="event_id"
                value="<?= $eventID; ?>" />

            <input
                type="hidden"
                id="feedback_template_id"
                name="feedback_template_id"
                value="<?= $feedbackTemplateID; ?>" />
            
            <input
                type="hidden"
                id="event_participant_id"
                name="event_participant_id"
                value="<?= $eventParticipantID; ?>" />
        
        <?php
        if ($eventFeedbackTemplate != null) {
            foreach ($feedback as $c) { // feedback categories
                ?>
                <div
                    style="margin-bottom: 1rem; border-radius: 1rem; padding-block: 0.5rem;
                    background: linear-gradient(0deg, rgba(164,164,164,0) 50%, rgba(0,0,0,0.05) 100%);
                    padding-inline: 1rem;">
                <?php
                    if (strlen($c->category) > 0) { 
                ?>
                    <h3 style="color: rgb(182,163,232); padding-bottom: 0.25rem;"><?= $c->category; ?></h3>
                <?php
                    }

                    foreach ($c->entries as $q) {
                ?>
                    <div
                        style="margin-bottom: 0.5rem;">
                        <p class="text-black fs-16"><?= $q->question; ?> <?php echo $q->required ? "<span style='color: red'>*</span>" : ""; ?></p>
                    </div>
                    <?php
                        if ($q->input_type == "text" or $q->input_type == "") {
                        ?>
                            <input
                                type="text"
                                id="<?= $q->html_name; ?>"
                                name="<?= $q->html_name; ?>"
                                class="fs-16 responsive-answer"
                                style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                                border: 1px solid; border-radius: 0.5rem; margin-bottom: 0.75rem;
                                display: block;"
                                <?php echo $q->required ? "required" : ""; ?>>
                        <?php
                        } else if ($q->input_type == "number") {
                        ?>
                            <input
                                type="number"
                                id="<?= $q->html_name; ?>"
                                name="<?= $q->html_name; ?>"
                                class="fs-16 responsive-answer"
                                class="fs-16 responsive-answer"
                                style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                                border: 1px solid; border-radius: 0.5rem; margin-bottom: 0.75rem;
                                display: block;"
                                min="<?= $q->num_range_low; ?>"
                                max="<?= $q->num_range_high; ?>"
                                <?php echo $q->required ? "required" : ""; ?>>
                        <?php
                        } else if ($q->input_type == "textarea") {
                        ?>
                            <textarea
                                id="<?= $q->html_name; ?>"
                                name="<?= $q->html_name; ?>"
                                rows="3"
                                class="fs-16 responsive-answer"
                                style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                                border: 1px solid; border-radius: 0.5rem; margin-bottom: 0.75rem;
                                display: block;"
                                <?php echo $q->required ? "required" : ""; ?>></textarea>
                        <?php
                        } else if ($q->input_type == "checkbox") {
                        ?>
                            <div class="responsive-answer" style="margin-bottom: 0.75rem;">
                            <?php
                            foreach ($q->checkbox_options as $option) {
                            ?>
                                <div style="margin-bottom: 0.25rem;">
                                    <input
                                        type="checkbox"
                                        id="<?= $q->html_name; ?>_<?= $option; ?>"
                                        name="<?= $q->html_name; ?>_<?= $option; ?>"
                                        value="<?= $option; ?>"
                                        style="margin-bottom: 0.125rem;">
                                    <label
                                        for="<?= $q->html_name; ?>_<?= $option; ?>"
                                        style="margin-left: 0.125rem; margin-right: 0.5rem;">
                                        <?= $option; ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                        <?php
                        } else if ($q->input_type == "radio") {
                        ?>
                            <div class="responsive-answer" style="margin-bottom: 0.75rem;">
                            <?php
                            foreach ($q->radio_options as $option) {
                            ?>
                                <div style="margin-bottom: 0.25rem;">
                                    <input
                                        type="radio"
                                        id="<?= $q->html_name; ?>_<?= $option; ?>"
                                        name="<?= $q->html_name; ?>"
                                        value="<?= $option; ?>"
                                        style="margin-bottom: 0.125rem;"
                                        <?php echo $q->required ? "required" : ""; ?>>
                                    <label
                                        for="<?= $q->html_name; ?>_<?= $option; ?>"
                                        style="margin-left: 0.125rem; margin-right: 0.5rem;">
                                        <?= $option; ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                            </div>
                        <?php
                        } else if ($q->input_type == "select") {
                        ?>
                            <select
                                id="<?= $q->html_name; ?>"
                                name="<?= $q->html_name; ?>"
                                class="fs-16 responsive-answer"
                                style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                                border: 1px solid; border-radius: 0.5rem; margin-bottom: 0.75rem;
                                display: block;"
                                <?php echo $q->required ? "required" : ""; ?>>
                            <?php
                            foreach ($q->select_options as $option) {
                            ?>
                                <option value="<?= $option; ?>"><?= $option; ?></option>
                            <?php
                            }
                            ?>
                            </select>
                        <?php
                        } else if ($q->input_type == "radio_scale") {
                        ?>
                            <div
                                class="fs-16 responsive-answer"
                                style="display: flex; justify-content: center; align-items: flex-end;
                                margin-bottom: 0.75rem;">
                                <p class="fs-16" style="padding-inline: 0.25rem;"><?= $q->radio_label_low; ?></p>
                                <table class="text-center">
                                    <tr>
                                    <?php
                                        for ($i = $q->radio_range_low; $i <= $q->radio_range_high; $i++) {
                                        ?>
                                        <td style="padding-inline: 0.5rem;">
                                            <label for="<?= $q->html_name; ?>_<?= $i; ?>">
                                                <?= $i; ?>
                                            </label>
                                        </td>
                                        <?php
                                        }
                                    ?>
                                    </tr>
                                    <tr>
                                        <td colspan="<?= $q->radio_range_high - $q->radio_range_low + 1 ?>"><hr /></td>
                                    </tr>
                                    <tr>
                                    <?php
                                        for ($i = $q->radio_range_low; $i <= $q->radio_range_high; $i++) {
                                        ?>
                                        <td>
                                            <input
                                                type="radio"
                                                id="<?= $q->html_name; ?>_<?= $i; ?>"
                                                name="<?= $q->html_name; ?>"
                                                value="<?= $i; ?>"
                                                style="margin-bottom: 0.125rem; padding-inline: 0.5rem;"
                                                <?php echo $q->required ? "required" : ""; ?>>
                                        </td>
                                        <?php
                                        }
                                    ?>
                                    </tr>
                                </table>
                                <p class="fs-16" style="padding-inline: 0.25rem;"><?= $q->radio_label_high; ?></p>
                            </div>
                        <?php
                        }
                        //var_dump($q);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
                <div style="display:flex; justify-content: flex-end;">
                <button
                    type="submit"
                    class="feedback-submit"
                    onclick="return confirm('Jawaban feedback TIDAK AKAN bisa diubah lagi! Apakah yakin menyimpan jawaban feedback Anda?')">
                    SIMPAN
                </button>
                </div>
            <?php
        } else {
            ?>
                <div style="margin-bottom: 1rem; padding-block: 0.5rem; padding-inline: 1rem; text-align: center;">
                    Pertanyaan feedback masih belum dibuat. Silahkan coba lagi nanti.
                </div>
            <?php
        }
        ?>
            
        </form>
    </div>
    <div style="height:1rem;"></div>
</body>
</html>
