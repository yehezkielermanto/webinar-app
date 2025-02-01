<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi database tersedia

// Ambil notifikasi dari database
$id_peserta = $_SESSION['id_peserta']; // Sesuaikan dengan sesi pengguna
$currentdate = date("Y-m-d"); 
$query = "SELECT * FROM events WHERE date >= '$currentdate'";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Webinar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 650px;
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8rem;
            font-weight: 700;
            color: #4e73df;
            margin-bottom: 20px;
        }
        .header-title i {
            font-size: 2.2rem;
        }
        .list-group-item {
            transition: all 0.3s ease;
            border-left: 5px solid #4e73df;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .list-group-item:hover {
            background-color: #e9f1fd;
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .list-group-item .details {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .btn-back {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            background-color: #4e73df;
            color: white;
            border-radius: 8px;
            padding: 8px 15px;
        }
        .btn-back:hover {
            background-color: #3e5bb3;
        }
        .list-group-item .time {
            font-size: 0.8rem;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header-title text-center mb-4">
            <i class="fa-solid fa-bell"></i> Notifikasi Anda
        </div>
        
        <div class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <a href="detail_webinar.php?id=<?= $row['event_id']; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($row['title']); ?></strong>
                        <p class="details"><?= htmlspecialchars($row['description']); ?></p>
                        <small class="time"><i class="fa-solid fa-calendar"></i> <?= date('d M Y, H:i', strtotime($row['start_time'])); ?></small>
                    </div>
                    <i class="fa-solid fa-arrow-right text-primary"></i>
                </a>
            <?php endwhile; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="beranda.php" class="btn btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</body>
</html>
