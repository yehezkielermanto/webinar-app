<!-- Header -->
<?php include "../admin/header.php"; ?>
<!-- Penomoran Otomatis -->
<?php
// hubungkan ke database
$koneksi = null;
include '../koneksi.php';

// mengambil data ID event yang tertinggi 
$query = mysqli_query($koneksi, "SELECT max(id) as IDTerbesar FROM events");
$data = mysqli_fetch_array($query);
$IDTerbesar = $data['IDTerbesar'];

$urutan = (int) substr($IDTerbesar, 3, 3);

$urutan++;

$huruf = "EVN";
$IDTerbesar = $huruf . sprintf("%03s", $urutan);
?>
<a href="/logout.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i>Logout</a><br>
<div class="head text-white text-center">
    <img src="/assets/img/logo_IF.png" alt="" width="100">
    <h2 class="text-center">Web Pendaftaran Prodi Ilmu Informatika <br>WebIF</h2>
</div>
<div>
    <form method="POST" action="action.php" enctype="multipart/form-data">
        <input type="text" name="event_name" readonly placeholder="event id" value="<?= $IDTerbesar ?>">
        <input type="text" name="post_url" placeholder="URL Poster">
        <input type="text" name="bg-ol-url" placeholder="URL Background zoom">
        <input type="text" name="title" placeholder="Title">
        <input type="text" name="desc" placeholder="Description">
        <input type="date" name="date">
        <input type="time" name="start">
        <input type="time" name="end">
        <!-- type -->
        <input type="radio" name="type" value="webinar">Webinar
        <input type="radio" name="type" value="workshop">Workshop

        <input type="text" name="link" placeholder="Link Zoom">
        <input type="text" name="speaker" placeholder="Pembicara">
        <!-- is_internal -->
        <input type="radio" name="internal" value="1">Internal
        <input type="radio" name="internal" value="0">Eksternal

        <input type="text" name="status" placeholder="status"><br>
        <!-- online ? -->
        <input type="radio" name="at-type" value="online">Online
        <input type="radio" name="at-type" value="offline">Offline

        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<?php include "../admin/footer.php"; ?>
