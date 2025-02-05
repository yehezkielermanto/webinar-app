<?php
include 'db.php';

// Tambah event
if (isset($_POST['tambah'])) {
    $event_name = $_POST['event_name'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $type = $_POST['type'];
    $link = $_POST['link'];
    $speaker = $_POST['speaker'];
    $is_internal = isset($_POST['is_internal']) ? 1 : 0;
    $attendance_type = $_POST['attendance_type'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO events (event_name, date, start_time, end_time, type, link, speaker, is_internal, attendance_type, status, title, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssissss", $event_name, $date, $start_time, $end_time, $type, $link, $speaker, $is_internal, $attendance_type, $status, $title, $description);
    
    if (!$stmt->execute()) {
        die("Gagal menambahkan event: " . $stmt->error);
    }
    
    $stmt->close();
    header("Location: event_list.php");
    exit();
}

// Edit event
if (isset($_POST['edit'])) {
    $event_id = $_POST['id'];
    $event_name = $_POST['event_name'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $type = $_POST['type'];
    $link = $_POST['link'];
    $speaker = $_POST['speaker'];
    $is_internal = isset($_POST['is_internal']) ? 1 : 0;
    $attendance_type = $_POST['attendance_type'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE events SET event_name=?, date=?, start_time=?, end_time=?, type=?, link=?, speaker=?, is_internal=?, attendance_type=?, status=?, title=?, description=? WHERE id=?");
    $stmt->bind_param("sssssssissssi", $event_name, $date, $start_time, $end_time, $type, $link, $speaker, $is_internal, $attendance_type, $status, $title, $description, $event_id);
    
    if (!$stmt->execute()) {
        die("Gagal mengupdate event: " . $stmt->error);
    }
    
    $stmt->close();
    header("Location: event_list.php");
    exit();
}

// Ambil data event untuk diedit
$event = null;
if (isset($_GET['edit'])) {
    $event_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM events WHERE id= $event_id");
    $event = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Event</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Form Event</h1>
    
    <form action="index.php" method="post">
        <?php if ($event): ?>
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
        <?php endif; ?>
        <input type="text" name="event_name" placeholder="Nama Event" value="<?= $event ? $event['event_name'] : '' ?>" required>
        <input type="date" name="date" value="<?= $event ? $event['date'] : '' ?>" required>
        <input type="time" name="start_time" value="<?= $event ? $event['start_time'] : '' ?>" required>
        <input type="time" name="end_time" value="<?= $event ? $event['end_time'] : '' ?>" required>
        <input type="text" name="type" placeholder="Tipe Event" value="<?= $event ? $event['type'] : '' ?>" required>
        <input type="url" name="link" placeholder="Link Event" value="<?= $event ? $event['link'] : '' ?>">
        <input type="text" name="speaker" placeholder="Pembicara" value="<?= $event ? $event['speaker'] : '' ?>">
        <label><input type="checkbox" name="is_internal" <?= $event && $event['is_internal'] ? 'checked' : '' ?>> Internal Event</label>
        <input type="text" name="attendance_type" placeholder="Tipe Kehadiran" value="<?= $event ? $event['attendance_type'] : '' ?>" required>
        <input type="text" name="status" placeholder="Status Event" value="<?= $event ? $event['status'] : '' ?>" required>
        <input type="text" name="title" placeholder="Judul Event" value="<?= $event ? $event['title'] : '' ?>" required>
        <textarea name="description" placeholder="Deskripsi"><?= $event ? $event['description'] : '' ?></textarea>
        <button type="submit" name="<?= $event ? 'edit' : 'tambah' ?>"><?= $event ? 'Update Event' : 'Tambah Event' ?></button>
    </form>
    
    <a href="event_list.php">Lihat Daftar Event</a>
</body>
</html>
