<?php
include 'db.php';

// Ambil data dari form
$event_id = $_POST['event_id'];
$user_id = $_POST['user_id'];
$event_role = $_POST['event_role'];
$status = $_POST['status'];

// Validasi apakah user_id ada di tabel users
$user_check_query = "SELECT user_id FROM users WHERE user_id = ?";
$stmt_check = $conn->prepare($user_check_query);
$stmt_check->bind_param("i", $user_id);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows === 0) {
    // Jika user_id tidak ditemukan
    die("User ID tidak valid. Pastikan user ID ada di tabel users.");
}

$stmt_check->close();

// Query untuk menambahkan peserta/panitia
$stmt = $conn->prepare("INSERT INTO event_participants (event_id, user_id, event_role, status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iisi", $event_id, $user_id, $event_role, $status);

if ($stmt->execute()) {
    echo "Peserta/Panitia berhasil ditambahkan.";
} else {
    echo "Gagal menambahkan peserta/panitia: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect kembali ke event_details.php
header("Location: event_details.php?event_id=$event_id");
exit();
?>