<?php
include 'db.php';

if (isset($_GET['event_id']) && isset($_GET['role'])) {
    $event_id = intval($_GET['event_id']);
    $role = $_GET['role'];

    $certificate_template = null;
    // Ambil sertifikat dari database
    $stmt = $conn->prepare("SELECT template FROM certificate_templates WHERE event_id = ? AND event_role = ?");
    $stmt->bind_param("is", $event_id, $role);
    $stmt->execute();
    $stmt->bind_result($certificate_template);
    $stmt->fetch();

    if ($certificate_template) {
        // Set header untuk file download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=certificate_$role.pdf");
        echo $certificate_template; // Mengirimkan konten sertifikat
    } else {
        echo "Sertifikat tidak ditemukan.";
    }
}
?>
