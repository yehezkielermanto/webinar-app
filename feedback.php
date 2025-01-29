<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location:session.php");
    exit;
}

include 'koneksi.php';

$eventID = $_GET["event_id"];
$userID = $_SESSION["user_id"];

$resEvent = $koneksi->query("SELECT * FROM events WHERE event_id = '$eventID'");
$event = mysqli_fetch_assoc($resEvent);

//var_dump($event);

// Get user's event participant ID
$resEventParticipant = $koneksi->query("SELECT * FROM event_participants WHERE event_id = '$eventID' AND user_id = '$userID'");
$eventParticipant = mysqli_fetch_assoc($resEventParticipant);

$eventParticipantID = $eventParticipant["event_participant_id"];

// Get the feedback template of the webinar
$resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_template WHERE event_id = '$eventID'");
$eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

$feedbackTemplateID = $eventFeedbackTemplate["feedback_template_id"];
$feedback = json_decode($eventFeedbackTemplate["field"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Pengisian Feedback</title>
</head>
<body>
    <div
        style="background-color: #F6F6F6; padding-inline: 1rem; padding-block: 0.5rem;
        margin-inline: 2rem; margin-block: 1rem; border-radius: 1rem;"
    >
        <h1 style="color: #A987FF;">FORM PENGISIAN FEEDBACK - <?= $event['title']; ?></h1>
        <p>Informasi akun anda akan disimpan dengan jawaban Anda.</p>
        <hr style="border-color: #EAEAEA; margin-block: 1rem;" />

        <form>
        <?php
        foreach ($feedback as $c) { // feedback categories
            ?>
            <div
                style="margin-bottom: 1rem; background-color: #EAEAEA;
                border-radius: 1rem; padding-block: 0.5rem; padding-inline: 1rem; ">
            <?php
                if (strlen($c->category) > 0) { 
            ?>
                <h3 style="color: #A987FF; padding-bottom: 0.25rem;"><?= $c->category; ?></h3>
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
                            class="fs-16"
                            style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                            border: 1px solid; border-radius: 0.5rem; width: 50%; margin-bottom: 0.5rem;
                            display: block;"
                            <?php echo $q->required ? "required" : ""; ?>>
                    <?php
                    } else if ($q->input_type == "textarea") {
                    ?>
                        <textarea
                            id="<?= $q->html_name; ?>"
                            name="<?= $q->html_name; ?>"
                            rows="3"
                            class="fs-16"
                            style="padding-block: 0.5rem; padding-inline: 0.5rem; border-color: #000000;
                            border: 1px solid; border-radius: 0.5rem; width: 50%; margin-bottom: 0.5rem;
                            display: block;"
                            <?php echo $q->required ? "required" : ""; ?>></textarea>
                    <?php
                    } else if ($q->input_type == "checkbox") {
                        foreach ($q->check_choices as $option) {
                        ?>
                            <div class="fs-16">
                                <input
                                    type="checkbox"
                                    id="<?= $q->html_name; ?>_<?= $option; ?>"
                                    name="<?= $q->html_name; ?>"
                                    value="<?= $option; ?>"
                                    style="margin-bottom: 0.125rem;">
                                <label for="<?= $q->html_name; ?>_<?= $option; ?>">
                                    <?= $option; ?>
                                </label>
                            </div>
                        <?php
                        }
                    } else if ($q->input_type == "radio") {
                        foreach ($q->radio_choices as $option) {
                        ?>
                            <div class="fs-16">
                                <input
                                    type="radio"
                                    id="<?= $q->html_name; ?>_<?= $option; ?>"
                                    name="<?= $q->html_name; ?>"
                                    value="<?= $option; ?>"
                                    style="margin-bottom: 0.125rem;">
                                <label for="<?= $q->html_name; ?>_<?= $option; ?>">
                                    <?= $option; ?>
                                </label>
                            </div>
                        <?php
                        }
                    } else if ($q->input_type == "radio_scale") {
                    ?>
                        <div class="fs-16" style="width: 50%; display: flex; justify-content: center; align-items: flex-end;">
                            <p class="fs-16" style="padding-inline: 0.25rem;"><?= $q->radio_text_low; ?></p>
                            <table class="text-center">
                                <tr>
                                <?php
                                    for ($i = $q->radio_range_low; $i <= $q->radio_range_high; $i++) {
                                    ?>
                                    <td style="border-bottom: 1px solid black; padding-inline: 0.5rem;"><label for="<?= $q->html_name; ?>_<?= $i; ?>"><?= $i; ?></label></td>
                                    <?php
                                    }
                                ?>
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
                                            style="margin-bottom: 0.125rem; padding-inline: 0.5rem;">
                                    </td>
                                    <?php
                                    }
                                ?>
                                </tr>
                            </table>
                            <p class="fs-16" style="padding-inline: 0.25rem;"><?= $q->radio_text_high; ?></p>
                        </div>
                    <?php
                    }
                    //var_dump($q);
                    echo "<br>";
                }
                ?>
            </div>
            <?php
        }
        ?>
            <button type="submit">submit</button>
        </form>
    </div>
</body>
</html>