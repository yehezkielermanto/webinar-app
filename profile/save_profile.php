<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: /index.php");
}

$user_id = $_SESSION["id_pengguna"];

header('Content-Type: application/json');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

try {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData);

    if (!$data || !isset($data->image) || !isset($data->filename)) {
        throw new Exception('Invalid data received');
    }

    $base64_string = $data->image;
    
    $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);
    
    $image_data = base64_decode($base64_string);
    
    if ($image_data === false) {
        throw new Exception('Invalid base64 data');
    }

    if (strlen($image_data) > MAX_FILE_SIZE) {
        throw new Exception('File too large');
    }

    $finfo = finfo_open();
    $mime_type = finfo_buffer($finfo, $image_data, FILEINFO_MIME_TYPE);
    finfo_close($finfo);

    if (!in_array($mime_type, ALLOWED_TYPES)) {
        throw new Exception('Invalid file type');
    }

    $upload_dir = 'uploads/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $path_info = pathinfo($data->filename);
    $extension = $path_info['extension'];
    /*$filename = uniqid() . '_' . basename($data->filename);*/
    $filename = $user_id . '_pfp.' . $extension;
    $file_path = $upload_dir . $filename;

    if (file_put_contents($file_path, $image_data)) {
        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully',
            'filename' => $filename
        ]);
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
