<?php
$host = "localhost"; 
$user = "yehezkiel"; 
$pass = "123"; 
$dbname = "db_webinar"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
