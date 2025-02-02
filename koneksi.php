<?php
date_default_timezone_set('Asia/Jakarta'); //define local time
// $servername = "localhost";
// $database = "ifukdcco_webinar";
// $username = "ifukdcco_webinar";
// $password = "hhR2I2n2k2";
 
// // Create connection
 
// $koneksi = mysqli_connect($servername, $username, $password, $database);
 
// // Check connection
 
// if (!$koneksi) {
 
//     die("Connection failed: " . mysqli_connect_error());
 
// }
// mysqli_close($koneksi);
/*$server = "localhost";*/
/*$username = "ifukdcco_webinar";*/
/*$password = "";*/
/*$database = "ifukdcco_webinar";*/
foreach (file('.env') as $line) {
    list($key, $value) = explode('=', trim($line), 2);
    putenv("$key=$value");
}

$server = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_DATABASE');
$koneksi = mysqli_connect($server, $username, $password, $database);
