<?php
include 'db.php';

// Validasi apakah ada parameter event_participant_id
if (!isset($_GET['event_participant_id']) || !is_numeric($_GET['event_participant_id'])) {
    die("Sertifikat tidak ditemukan.");
}

$event_participant_id = intval($_GET['event_participant_id']); // Pastikan event_participant_id adalah integer

// Query untuk mengambil sertifikat dari tabel certificate_template
$query = "
    SELECT template
    FROM certificate_template
    WHERE event_participant_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_participant_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($template);
$stmt->fetch();

// Validasi apakah sertifikat ditemukan
if (!$template) {
    die("Sertifikat tidak ditemukan.");
}

// Tentukan header berdasarkan jenis file yang diupload
// Misalnya, jika file adalah PDF:
header("Content-Type: application/pdf"); // Header untuk PDF

// Jika file adalah gambar, gunakan Content-Type berikut:
 // header("Content-Type: image/jpeg");  // Untuk gambar JPEG
 // header("Content-Type: image/png");   // Untuk gambar PNG

// Tampilkan file sertifikat
echo $template;
exit();
?>
