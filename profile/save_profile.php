<?php
header('Content-Type: application/json');

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

    $upload_dir = 'uploads/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filename = uniqid() . '_' . basename($data->filename);
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
