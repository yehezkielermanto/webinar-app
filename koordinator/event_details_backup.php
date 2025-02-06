<?php
include 'db.php';

// Ambil event_id dari URL
$event_id = $_GET['event_id'];

// Ambil data event
$event_result = $conn->query("SELECT * FROM events WHERE event_id = $event_id");
$event = $event_result->fetch_assoc();

// Ambil data peserta
$participants_result = $conn->query("SELECT * FROM event_participants WHERE event_id = $event_id AND event_role = 'participant'");

// Ambil data panitia
$committee_result = $conn->query("SELECT * FROM event_participants WHERE event_id = $event_id AND event_role = 'committee'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Detail Event: <?= $event['event_name'] ?></h1>
    
    <h2>Daftar Peserta</h2>
    <table>
        <tr>
            <th>ID Peserta</th>
            <th>User ID</th>
            <th>Nama Peserta<th>
            <th>Status</th>
            <th>Role</th>
            <th>URL Sertifikat</th>
        </tr>
        <?php while ($participant = $participants_result->fetch_assoc()): ?>
            <tr>
                <td><?= $participant['event_participant_id'] ?></td>
                <td><?= $participant['user_id'] ?></td>
                <td><?= $participant['fullname'] ?></td>
                <td><?= $participant['status'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                <td><?= $participant['event_role'] ?></td>
                <td><?= $participant['certificate_url'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Panitia</h2>
    <table>
        <tr>
            <th>ID Panitia</th>
            <th>User ID</th>
            <th>Nama Panitia<th>
            <th>Status</th>
            <th>Role</th>
            <th>URL Sertifikat</th>
        </tr>
        <?php while ($committee = $committee_result->fetch_assoc()): ?>
            <tr>
                <td><?= $committee['event_participant_id'] ?></td>
                <td><?= $committee['user_id'] ?></td>
                <td><?= $committee['fullname'] ?></td>
                <td><?= $committee['status'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                <td><?= $committee['event_role'] ?></td>
                <td><?= $committee['certificate_url'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Upload Sertifikat</h2>
    <form action="upload_certificate.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="event_id" value="<?= $event_id ?>">
        
        <label for="participant_certificate">Sertifikat Peserta:</label>
        <input type="file" name="participant_certificate" id="participant_certificate">
        
        <label for="committee_certificate">Sertifikat Panitia:</label>
        <input type="file" name="committee_certificate" id="committee_certificate">
        
        <button type="submit">Upload</button>
    </form>
</body>
</html>