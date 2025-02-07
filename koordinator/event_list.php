<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: /webinar-app/index.php");
}

if (!isset($_SESSION["is_admin"])) {
    if ($_SESSION["is_admin"] != "ADMIN") {
        header("Location: /webinar-app/beranda.php");
    }
}

$conn = null;
include 'db.php';

// Ambil semua event
$result = $conn->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event</title>
    <link rel="stylesheet" href="event_list.css">
</head>
<body>
    <h1>Daftar Event</h1>
    
    <a href="index.php">Tambah Event</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Tipe</th>
            <th>Link</th>
            <th>Pembicara</th>
            <th>Internal</th>
            <th>Tipe Kehadiran</th>
            <th>Status</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Feedback</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['event_name'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['start_time'] ?></td>
                <td><?= $row['end_time'] ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= $row['link'] ?></td>
                <td><?= $row['speaker'] ?></td>
                <td><?= $row['is_internal'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['attendance_type'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td>
                    <a href="../admin/create_feedback_template.php?event_id=<?= $row['id'] ?>">Buat/Edit Template</a>
                    <a href="../admin/view_feedback.php?event_id=<?= $row['id'] ?>">Lihat Tanggapan</a>
                </td>
                <td>
                    <a href="index.php?edit=<?= $row['id'] ?>">Edit</a>
                    <a href="event_details.php?event_id=<?= $row['id'] ?>">Detail</a> 
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
