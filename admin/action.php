<?php
session_start();
$koneksi = null;
include 'koneksi.php';

if (isset($_POST["submit"])) {
    $event_id = $_POST["event_id"];
    $post_url = $_POST["post_url"];
    $event_name = $_POST["event_name"];
    $bg_ol_url = $_POST["bg-ol-url"];
    $title = $_POST["title"];
    $desc = $_POST["desc"];
    $date = $_POST["date"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $type = $_POST["type"];
    $link = $_POST["link"];
    $speaker = $_POST["speaker"];
    $internal = $_POST["internal"];
    $status = $_POST["status"];
    $at_type = $_POST["at-type"];
    // read type is_internal and attendance_type

    $query = "INSERT INTO events (event_id, poster_url, event_name, background_online_url, title, description, date, start_time, end_time, type, link, speaker, published, is_internal, status, attendance_type) VALUES ($event_id, '$post_url', '$event_name', '$bg_ol_url', '$title', '$desc', '$date', '$start', '$end', '$type', '$link', '$speaker', 1, '$internal', $status, '$at_type')";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "yes";
    } else {
        echo "Gagal";
    }
}
?>
