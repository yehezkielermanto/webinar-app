<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: /index.php");
    exit();
}

$koneksi = null;
include "../koneksi.php";

$user_id = $_SESSION["id_peserta"];

header('Content-Type: application/json');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

try {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData);

    if (!$data || !isset($data->image) || !isset($data->filename)) {
        throw new Exception('Invalid data received');
    }

    $base64_string = $data->image;
    
    if (!preg_match('/^data:image\/(\w+);base64,/', $base64_string, $type)) {
        throw new Exception('Invalid image format');
    }
    
    $image_type = strtolower($type[1]);
    
    $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);
    
    $image_data = base64_decode($base64_string, true);
    
    if ($image_data === false) {
        throw new Exception('Invalid base64 data');
    }

    if (strlen($image_data) > MAX_FILE_SIZE) {
        throw new Exception('File too large');
    }

    $image_info = @getimagesizefromstring($image_data);
    if ($image_info === false) {
        throw new Exception('Invalid image data');
    }

    $upload_dir = 'uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filename = $user_id . '_pfp.' . $image_type;
    $file_path = $upload_dir . $filename;

    if (file_put_contents($file_path, $image_data) !== false) {
        if ($_SESSION['pfp'] != "profile_placeholder.png" || $_SESSION['pfp'] != null){
            unlink($_SESSION['pfp']);
        }
        $_SESSION['pfp'] = $file_path;
        
        if (!@getimagesize($file_path)) {
            unlink($file_path); // Delete the invalid file
            throw new Exception('Saved file is not a valid image');
        }
        
        $query = "UPDATE `users` SET `pfp_path` = ? WHERE `users`.`user_id` = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "si", $file_path, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                'success' => true,
                'message' => 'File uploaded successfully',
                'filename' => $filename
            ]);
            exit();
        } else {
            throw new Exception('Failed to update database');
        }
    } else {
        throw new Exception('Failed to save file');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
