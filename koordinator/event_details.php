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

// Query untuk mengambil data peserta
$participants_query = "
    SELECT ep.*, u.fullname, u.institution, u.phone, ep.certificate_url
    FROM event_participants ep
    JOIN users u ON ep.user_id = u.user_id
    WHERE ep.event_id = $event_id AND ep.event_role = 'participant'
";
$participants_result = $conn->query($participants_query);

// Query untuk mengambil data panitia
$committee_query = "
    SELECT ep.*, u.fullname, u.institution, u.phone, ep.certificate_url
    FROM event_participants ep
    JOIN users u ON ep.user_id = u.user_id
    WHERE ep.event_id = $event_id AND ep.event_role = 'committee'
";
$committee_result = $conn->query($committee_query);

// Proses delete peserta atau panitia
if (isset($_GET['delete_id']) && isset($_GET['role'])) {
    $delete_id = intval($_GET['delete_id']);
    $role = $_GET['role'];

    if ($role === 'participant' || $role === 'committee') {
        $delete_query = "DELETE FROM event_participants WHERE event_participant_id = $delete_id AND event_id = $event_id AND event_role = '$role'";
        if ($conn->query($delete_query) === TRUE) {
            header("Location: event_details.php?event_id=$event_id&delete_success=1");
            exit();
        } else {
            header("Location: event_details.php?event_id=$event_id&delete_error=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <link rel="stylesheet" href="event_details.css">
    <!-- Sertakan SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <a href="event_list.php">Kembali</a>
    <h1>Detail Event: <?= htmlspecialchars($event['event_name']) ?></h1>

    <h2>Daftar Peserta</h2>
    <table>
        <tr>
            <th>Nomor</th>
            <th>Nama Lengkap</th>
            <th>Institusi</th>
            <th>No Telepon</th>
            <th>Sertifikat</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $index = 1;
        while ($participant = $participants_result->fetch_assoc()): 
        ?>
            <tr>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($participant['fullname']) ?></td>
                <td><?= htmlspecialchars($participant['institution']) ?></td>
                <td><?= htmlspecialchars($participant['phone']) ?></td>
                <td>
                    <?php if (!empty($participant['certificate_url'])): ?>
                        <a href="<?= htmlspecialchars($participant['certificate_url']) ?>" target="_blank">Lihat</a>
                    <?php else: ?>
                        <em>Belum diunggah</em>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" onclick="confirmDelete(<?= $participant['event_participant_id'] ?>, 'participant')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Panitia</h2>
    <table class="table-container">
        <tr>
            <th>Nomor</th>
            <th>Nama Lengkap</th>
            <th>Institusi</th>
            <th>No Telepon</th>
            <th>Sertifikat</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $index = 1;
        while ($committee = $committee_result->fetch_assoc()): 
        ?>
            <tr>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($committee['fullname']) ?></td>
                <td><?= htmlspecialchars($committee['institution']) ?></td>
                <td><?= htmlspecialchars($committee['phone']) ?></td>
                <td>
                    <?php if (!empty($committee['certificate_url'])): ?>
                        <a href="<?= htmlspecialchars($committee['certificate_url']) ?>" target="_blank">Lihat</a>
                    <?php else: ?>
                        <em>Belum diunggah</em>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" onclick="confirmDelete(<?= $committee['event_participant_id'] ?>, 'committee')">Hapus</a>
                </td>
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
            <h2>Tambah Panitia</h2>
            <form action="add_participant.php" method="post">
                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                <input type="hidden" name="event_role" value="committee">
                
                <label for="fullname">Nama Lengkap :</label>
                <input type="text" name="fullname" id="fullname" required>
                
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete(participantId, role) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `event_details.php?event_id=<?= $event_id ?>&delete_id=${participantId}&role=${role}`;
            }
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    
    // Menampilkan notifikasi setelah berhasil upload sertifikat
    if (urlParams.has('upload_success')) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Sertifikat berhasil diunggah.'
        });
    }

    // Menampilkan notifikasi setelah menambahkan panitia
    if (urlParams.has('add_success')) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Panitia berhasil ditambahkan.'
        });
    } else if (urlParams.has('add_error')) {
        let errorMsg = 'Terjadi kesalahan saat menambahkan panitia.';
        if (urlParams.get('add_error') === 'exists') {
            errorMsg = 'User sudah terdaftar sebagai panitia!';
        }
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: errorMsg
        });
    }
    </script>
</body>
</html>
