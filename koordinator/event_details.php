<?php
include 'db.php';

// Validasi event_id
if (!isset($_GET['event_id']) || !is_numeric($_GET['event_id'])) {
    die("Event ID tidak valid.");
}

$event_id = intval($_GET['event_id']); // Pastikan event_id adalah integer

// Ambil data event
$event_result = $conn->query("SELECT * FROM events WHERE event_id = $event_id");

// Validasi apakah event ditemukan
if ($event_result->num_rows === 0) {
    die("Event tidak ditemukan.");
}

$event = $event_result->fetch_assoc();

// Query untuk mengambil data peserta dengan nama lengkap
$participants_query = "
    SELECT ep.*, u.fullname 
    FROM event_participants ep
    JOIN users u ON ep.user_id = u.user_id
    WHERE ep.event_id = $event_id AND ep.event_role = 'participant'
";
$participants_result = $conn->query($participants_query);

// Query untuk mengambil data panitia dengan nama lengkap
$committee_query = "
    SELECT ep.*, u.fullname 
    FROM event_participants ep
    JOIN users u ON ep.user_id = u.user_id
    WHERE ep.event_id = $event_id AND ep.event_role = 'committee'
";
$committee_result = $conn->query($committee_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <link rel="stylesheet" href="event_details.css">
</head>
<body>
    <a href="event_list.php">Kembali</a>
    <h1>Detail Event: <?= htmlspecialchars($event['event_name']) ?></h1>
    <h2>Daftar Peserta</h2>
    <table>
        <tr>
            <th>ID Peserta</th>
            <th>User ID</th>
            <th>Nama Lengkap</th>
            <th>Status</th>
            <th>Role</th>
            <th>URL Sertifikat</th>
        </tr>
        <?php while ($participant = $participants_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($participant['event_participant_id']) ?></td>
                <td><?= htmlspecialchars($participant['user_id']) ?></td>
                <td><?= htmlspecialchars($participant['fullname']) ?></td>
                <td><?= $participant['status'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                <td><?= htmlspecialchars($participant['event_role']) ?></td>
                <td><?= htmlspecialchars($participant['certificate_url']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Panitia</h2>
    <table class="table-container">
        <tr>
            <th>ID Panitia</th>
            <th>User ID</th>
            <th>Nama Lengkap</th>
            <th>Status</th>
            <th>Role</th>
            <th>URL Sertifikat</th>
        </tr>
        <?php while ($committee = $committee_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($committee['event_participant_id']) ?></td>
                <td><?= htmlspecialchars($committee['user_id']) ?></td>
                <td><?= htmlspecialchars($committee['fullname']) ?></td>
                <td><?= $committee['status'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                <td><?= htmlspecialchars($committee['event_role']) ?></td>
                <td><?= htmlspecialchars($committee['certificate_url']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="boks">
        <div class="boks">
            <h2>Upload Sertifikat</h2>
            <form action="upload_certificate.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                
                <label for="participant_certificate">Sertifikat Peserta:</label>
                <input type="file" name="participant_certificate" id="participant_certificate">
                
                <label for="committee_certificate">Sertifikat Panitia:</label>
                <input type="file" name="committee_certificate" id="committee_certificate">
                
                <button type="submit">Upload</button>
            </form>
        </div>

        <div class="boks">
            <h2>Tambah Peserta/Panitia</h2>
            <form action="add_participant.php" method="post">
                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                
                <label for="user_id">User ID:</label>
                <input type="number" name="user_id" id="user_id" required>
                
                <label for="event_role">Role:</label>
                <select name="event_role" id="event_role" required>
                    <option value="participant">Peserta</option>
                    <option value="committee">Panitia</option>
                </select>
                
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>