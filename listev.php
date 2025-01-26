<?php
session_start();

if(!isset($_SESSION["email"])){
    header("Location: masuk.php");
    exit(); 
}

$user_id = $_SESSION["id_peserta"];
$koneksi = null;
include 'koneksi.php';


$particapated = array();
$available = array();

$query = "select * from event_participants where user_id = ".$user_id;
$result = mysqli_query($koneksi, $query);
$result_len = mysqli_num_rows($result);
if ($result_len > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($particapated, $row);
    }
}

$query = "select * from events";
$result = mysqli_query($koneksi, $query);
$result_len = mysqli_num_rows($result);
if ($result_len > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($available, $row);
    }
}
?>
<html>
    <head>
        <title>Daftar Event</title>
    </head>
    <body>
        <h1>Event yang diikuti</h1>
        <table>
            <tr>
                <td>Nama</td>
                <td>Pembicara</td>
            </tr>
            <tr>
<?php
            if (count($particapated) <= 0) {
                echo "<tr><td colspan='2' style='text-align: center;'>Tidak ada event yang diikuti.</td></tr>";
            } else {
                foreach ($particapated as $entry) {
                    var_dump($entry);
                }
            }
?>
            </tr>
        </table>
        <h1>Event yang tersedia</h1>
        <table>
            <tr>
                <td>Nama</td>
                <td>Pembicara</td>
                <td>Aksi</td>
            </tr>
<?php
            if (count($available) <= 0) {
                echo "<tr><td colspan='3' style='text-align: center;'>Tidak ada event yang diikuti.</td></tr>";
            } else {
                foreach ($available as $entry) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($entry['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($entry['speaker']) . "</td>";
                    echo "<td><button>Daftar</button></td>";
                    echo "</tr>";
                }
            }
?>
        </table>
    </body>
</html>
