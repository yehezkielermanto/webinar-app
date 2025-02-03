<?php

// take the env from the parent dir.
foreach (file('../.env') as $line) {
    list($key, $value) = explode('=', trim($line), 2);
    putenv("$key=$value");
}

$server = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_DATABASE');

$koneksi = mysqli_connect($server, $username, $password, $database);
