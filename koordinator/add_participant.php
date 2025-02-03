<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $fullname = $_POST['fullname'];
    $event_role = $_POST['event_role'];

    // Cari user_id berdasarkan nama lengkap
    $user_query = "SELECT user_id FROM users WHERE fullname = '$fullname'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['user_id'];

        // Cek apakah user sudah terdaftar sebagai panitia
        $check_query = "SELECT * FROM event_participants WHERE event_id = $event_id AND user_id = $user_id AND event_role = 'committee'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0) {
            // Jika user sudah ada sebagai panitia
            header("Location: event_details.php?event_id=$event_id&add_error=exists");
            exit();
        } else {
            // Simpan data ke database jika user belum ada
            $sql = "INSERT INTO event_participants (event_id, user_id, event_role) VALUES ($event_id, $user_id, '$event_role')";
            if ($conn->query($sql) === TRUE) {
                // Redirect kembali ke halaman detail event dengan parameter sukses
                header("Location: event_details.php?event_id=$event_id&add_success=1");
                exit();
            } else {
                // Redirect dengan pesan error jika gagal
                header("Location: event_details.php?event_id=$event_id&add_error=1");
                exit();
            }
        }
    } else {
        // Redirect dengan pesan error jika nama tidak ditemukan
        header("Location: event_details.php?event_id=$event_id&add_error=1");
        exit();
    }
}
?>
