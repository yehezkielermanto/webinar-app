<!-- Header -->
<?php include "header.php"; ?>
<!-- Penomoran Otomatis -->
<?php
// hubungkan ke database
include 'koneksi.php';

// mengambil data ID event yang tertinggi 
$query = mysqli_query($koneksi, "SELECT max(id_event) as IDTerbesar FROM master_event");
$data = mysqli_fetch_array($query);
$IDTerbesar = $data['IDTerbesar'];

$urutan = (int) substr($IDTerbesar, 3, 3);

$urutan++;

$huruf = "EVN";
$IDTerbesar = $huruf . sprintf("%03s", $urutan);
?>

<div class="head text-white text-center">
    <img src="assets/img/logo_IF.png" alt="" width="100">
    <h2 class="text-center">Web Pendaftaran Prodi Ilmu Informatika <br>WebIF</h2>
</div>
<!-- Awal Row -->
<div class="row mt-2">
    <!-- col-lg-7 -->
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradient-light">
            <!-- card body -->
            <div class="card-body">

                <div class="pt-1">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Update Event</h1>
                    </div>
                    <?php
                    include 'koneksi.php';
                    // errornya disini
                    $id = $_GET["id"];
                    $data = mysqli_query($koneksi, "SELECT * FROM master_event where id_event = '$id'");
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                        <form class="user" method="POST" action="aksi_update.php" enctype="multipart/form-data">
                            <div class="form-group">
								<p><small>Masukkan Flyer Webinar</small></p>
                                <input type="file" name="flyer_event" value="<?= $d['avatar_event'] ?>">

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="id_event" placeholder="Masukkan ID Event..." value="<?= $d['id_event']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="judul_event" placeholder="Masukkan Judul Event..." value="<?= $d['judul']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="jenis_event" placeholder="Masukkan Jenis Event..." value="<?= $d['jenis_event']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="pembicara" placeholder="Masukkan Pembicara..." value="<?= $d['pembicara']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-user" name="tanggal" placeholder="Masukkan Tanggal Event..." value="<?= $d['tanggal']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="time" class="form-control form-control-user" name="jam_mulai" placeholder="Masukkan Jam Mulai dari Event..." value="<?= $d['jam_mulai']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="time" class="form-control form-control-user" name="jam_selesai" placeholder="Masukkan Jam Selesai dari Event..." value="<?= $d['jam_selesai']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="link_meeting" placeholder="Masukkan Link Meeting dari Event..." value="<?= $d['link']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="deskripsi" placeholder="Masukkan Deskripsi Event..." value="<?= $d['deskripsi']; ?>">
                            </div>
							 <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="feedback" placeholder="Masukkan Link feedback..." value="<?= $d['feedback']; ?>">
                            </div>
                            <div class="form-group">
								<p><small>Masukkan virtual background</small></p>
                                <input type="file" name="upload_vb" value="<?= $d['temp_background']; ?>">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="bupdate" class="btn btn-danger btn-user">Update Event</button>
                                <a href="index.php" class="btn btn-primary btn-user">Kembali</a>
                            </div>
                        </form>
                    <?php } ?>
                    <hr>

                    <div class="text-center">
                        <a class="small" href="#">By DCInformatics | <?= date('Y'); ?></a>
                    </div>

                </div>
            </div>
            <!-- end card body -->
        </div>
    </div>
    <!-- Akhir col-lg-7 -->


    <?php include "footer.php"; ?>