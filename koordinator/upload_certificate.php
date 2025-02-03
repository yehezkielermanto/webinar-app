<?php
include 'db.php';

// Validasi event_id
if (!isset($_POST['event_id']) || !is_numeric($_POST['event_id'])) {
    die("Event ID tidak valid.");
}

$event_id = intval($_POST['event_id']);
$upload_dir = "uploads/";

// Pastikan folder upload ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Fungsi untuk upload file sertifikat
function uploadCertificate($fileInput, $event_id, $event_role, $conn, $upload_dir) {
    if (!empty($_FILES[$fileInput]['name'])) {
        $filename = basename($_FILES[$fileInput]['name']);
        $filepath = $upload_dir . time() . "_" . $filename; // Gunakan timestamp agar unik

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $filepath)) {
            // Cek apakah sudah ada sertifikat untuk event dan role yang sama
            $check_query = "SELECT id FROM certificate_template WHERE event_id = ? AND event_role = ?";
            $stmt_check = $conn->prepare($check_query);
            $stmt_check->bind_param("is", $event_id, $event_role);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                // Update sertifikat jika sudah ada
                $update_query = "UPDATE certificate_template SET template = ? WHERE event_id = ? AND event_role = ?";
                $stmt_update = $conn->prepare($update_query);
                $stmt_update->bind_param("sis", $filepath, $event_id, $event_role);
                
                if ($stmt_update->execute()) {
                    return true;
                } else {
                    die("Database Error (Update): " . $stmt_update->error);
                }
            } else {
                // Insert sertifikat baru jika belum ada
                $insert_query = "INSERT INTO certificate_template (event_id, template, event_role) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_query);
                $stmt_insert->bind_param("iss", $event_id, $filepath, $event_role);
                
                if ($stmt_insert->execute()) {
                    return true;
                } else {
                    die("Database Error (Insert): " . $stmt_insert->error);
                }
            }
        } else {
            die("Gagal mengunggah file.");
        }
    }
    return false;
}

// Proses upload sertifikat peserta
$participant_uploaded = uploadCertificate('participant_certificate', $event_id, 'participant', $conn, $upload_dir);

// Proses upload sertifikat panitia
$committee_uploaded = uploadCertificate('committee_certificate', $event_id, 'committee', $conn, $upload_dir);

// Redirect dengan notifikasi
if ($participant_uploaded || $committee_uploaded) {
    header("Location: event_details.php?event_id=$event_id&upload_success=1");
} else {
    header("Location: event_details.php?event_id=$event_id&upload_error=1");
}
exit();
?>
