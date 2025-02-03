<?php

foreach (file('../.env') as $line) {
    list($key, $value) = explode('=', trim($line), 2);
    putenv("$key=$value");
}

$host = getenv('DB_HOST'); 
$user = getenv('DB_USERNAME'); 
$pass = getenv('DB_PASSWORD'); 
$dbname = getenv('DB_DATABASE'); 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
