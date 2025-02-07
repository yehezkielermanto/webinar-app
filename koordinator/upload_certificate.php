<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email']) || $_SESSION['user']['role'] !== 'ADMIN') {
    header("Location: /webinar-app/beranda.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST["event_id"]);
    $fullname = trim($_POST["fullname"]);
    $event_role = $_POST["event_role"] ?? "PARTICIPANT"; // Default: participant

    // Debugging: Cek nilai event_role
    var_dump($event_role); // Tambahkan ini untuk melihat nilai event_role

    // Cek apakah user sudah ada di tabel users
    $user_check = $conn->prepare("SELECT id FROM users WHERE fullname = ?");
    $user_check->bind_param("s", $fullname);
    $user_check->execute();
    $user_result = $user_check->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user["id"];
    } else {
        // Jika user belum ada, tambahkan ke tabel users
        $insert_user = $conn->prepare("INSERT INTO users (fullname) VALUES (?)");
        $insert_user->bind_param("s", $fullname);
        if ($insert_user->execute()) {
            $user_id = $insert_user->insert_id;
        } else {
            header("Location: event_details.php?id=$event_id&add_error=db");
            exit();
        }
    }

    // Cek apakah user sudah menjadi panitia di event ini
    $check_participant = $conn->prepare("SELECT * FROM event_participants WHERE event_id = ? AND user_id = ? AND event_role = ?");
    $check_participant->bind_param("iis", $event_id, $user_id, $event_role);
    $check_participant->execute();
    $result_check = $check_participant->get_result();

    if ($result_check->num_rows > 0) {
        header("Location: event_details.php?id=$event_id&add_error=exists");
        exit();
    }

    // Tambahkan panitia ke event
    $status_default = "active"; // Sesuaikan jika ada aturan status
    $insert_participant = $conn->prepare("INSERT INTO event_participants (event_id, user_id, event_role, status, certificate_url) VALUES (?, ?, ?, ?, '')");
    $insert_participant->bind_param("iiss", $event_id, $user_id, $event_role, $status_default);

    if ($insert_participant->execute()) {
        // Sekarang simpan ke certificate_templates
        $insert_certificate = $conn->prepare("INSERT INTO certificate_templates (event_id, user_id, event_role, other_columns) VALUES (?, ?, ?, ?)");
        $insert_certificate->bind_param("iiss", $event_id, $user_id, $event_role, $other_value); // Ganti $other_value dengan nilai yang sesuai

        if ($insert_certificate->execute()) {
            // Berhasil menyimpan ke certificate_templates
        } else {
            // Tangani kesalahan saat menyimpan ke certificate_templates
            header("Location: event_details.php?id=$event_id&add_error=certificate");
            exit();
        }
    } else {
        // Tangani kesalahan saat menambahkan peserta
        header("Location: event_details.php?id=$event_id&add_error=participant");
        exit();
    }
}
?>
