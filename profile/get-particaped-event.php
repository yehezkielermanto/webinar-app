<?php
session_start();
$koneksi = null;
include __DIR__ . "/../koneksi.php";

if (!isset($_SESSION["email"])) {
    header("Location: /webinar-app/index.php");
    exit();
}

$sortwith = "title";
$sortby = "DESC";

if (isset($_GET["sortwith"])) {
    if ($_GET["sortwith"] == "ASC") {
        $sortby = "ASC";
    }
}

if (isset($_GET["sortby"])) {
    if ($_GET["sortby"] == "date") {
        $sortwith = "date";
    }
}
$sortwith = "e.$sortwith";

$user_id = $_SESSION["user_id"];
$particapated = array();
$query = "";

header('Content-Type: application/json');
if (isset($_GET["inc-feedback"])) {
    $query = "
    SELECT e.*, ep.event_role, 
    COUNT(ef.id) AS feedback_given
    FROM events e
    JOIN event_participants ep ON ep.event_id = e.id
    LEFT JOIN event_feedbacks ef ON ef.event_participant_id = ep.id
    WHERE ep.user_id = $user_id
    GROUP BY e.id;
        ";
} else {
$query = "
    SELECT 
        e.id, 
        e.poster_url, 
        e.event_name, 
        e.background_online_url, 
        e.title, 
        e.description, 
        e.date, 
        e.start_time, 
        e.end_time, 
        e.type, 
        e.link, 
        e.speaker, 
        e.published, 
        e.is_internal, 
        e.status AS event_status, 
        e.attendance_type, 
        e.slug, 
        e.remark, 
        ep.id, 
        ep.user_id, 
        ep.status AS participant_status, 
        ep.event_role, 
        ep.certificate_url
    FROM 
        event_participants ep
    JOIN 
        events e 
    ON 
        ep.event_id = e.id
    WHERE 
        ep.user_id =".$user_id."
    ORDER by $sortwith $sortby";
}

$result = mysqli_query($koneksi, $query);
$result_len = mysqli_num_rows($result);
if ($result_len > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($particapated, $row);
    }
}

echo json_encode($particapated);
?>
