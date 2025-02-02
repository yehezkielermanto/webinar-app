<?php
include 'db.php';

$event_id = $_POST['event_id'];

// Proses upload sertifikat peserta
if (isset($_FILES['participant_certificate']) && $_FILES['participant_certificate']['error'] == 0) {
    $participant_certificate = $_FILES['participant_certificate'];
    $participant_certificate_path = 'certificates/' . basename($participant_certificate['name']);
    move_uploaded_file($participant_certificate['tmp_name'], $participant_certificate_path);

    // Update URL sertifikat peserta di database
    $stmt = $conn->prepare("UPDATE event_participants SET certificate_url = ? WHERE event_id = ? AND event_role = 'participant'");
    $stmt->bind_param("si", $participant_certificate_path, $event_id);
    $stmt->execute();
    $stmt->close();
}

// Proses upload sertifikat panitia
if (isset($_FILES['committee_certificate']) && $_FILES['committee_certificate']['error'] == 0) {
    $committee_certificate = $_FILES['committee_certificate'];
    $committee_certificate_path = 'certificates/' . basename($committee_certificate['name']);
    move_uploaded_file($committee_certificate['tmp_name'], $committee_certificate_path);

    // Update URL sertifikat panitia di database
    $stmt = $conn->prepare("UPDATE event_participants SET certificate_url = ? WHERE event_id = ? AND event_role = 'committee'");
    $stmt->bind_param("si", $committee_certificate_path, $event_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect kembali ke event_details.php dengan parameter event_id
header("Location: event_details.php?event_id=$event_id");
exit();
?>