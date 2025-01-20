<!-- Header -->
<?php include "header.php"; ?>
<!-- Penomoran Otomatis -->
<?php
// hubungkan ke database
$koneksi = null;
include 'koneksi.php';

// mengambil data ID event yang tertinggi 
$query = mysqli_query($koneksi, "SELECT max(id_event) as IDTerbesar FROM events");
$data = mysqli_fetch_array($query);
$IDTerbesar = $data['IDTerbesar'];

$urutan = (int) substr($IDTerbesar, 3, 3);

$urutan++;

$huruf = "EVN";
$IDTerbesar = $huruf . sprintf("%03s", $urutan);
?>
<a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i>Logout</a><br>
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
                        <h1 class="h4 text-gray-900 mb-4">Daftar Event</h1>
                    </div>
                    <form class="user" method="POST" action="aksi.php" enctype="multipart/form-data">
                        <div class="form-group">
							<p><small>Masukkan Flyer Webinar</small><span style="color:red;";>*</span></p>
                            <input type="file" name="flyer_event">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="ID_event" placeholder="Masukkan ID Event..." value="<?= $IDTerbesar; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="judul_event" placeholder="Masukkan Judul Event...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="jenis_event" placeholder="Masukkan Jenis Event...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="pembicara" placeholder="Masukkan Pembicara...">
                        </div>

                        <div class="form-group">
                            <input type="date" class="form-control form-control-user" name="tanggal" placeholder="Masukkan Tanggal Event...">
                        </div>
                        <div class="form-group">
                            <input type="time" class="form-control form-control-user" name="jam_mulai" placeholder="Masukkan Jam Mulai dari Event...">
                        </div>
                        <div class="form-group">
                            <input type="time" class="form-control form-control-user" name="jam_selesai" placeholder="Masukkan Jam Selesai dari Event...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="link_meeting" placeholder="Masukkan Link Meeting dari Event...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="deskripsi" placeholder="Masukkan Deskripsi Event...">
                        </div>
						<div class="form-group">
                            <input type="text" class="form-control form-control-user" name="feedback" placeholder="Masukkan Link feedback...">
                        </div>
                        <div class="form-group">
							<p><small>Masukkan virtual background</small><span style="color:red;";>*</span></p>
                            <input type="file" name="upload_vb">
                        </div>
                        <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Event</button>

                    </form>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Event Hari Ini : [<?= date("d-m-Y"); ?>]</h6>

        </div>
        <div class="card-body">
            <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table"></i>Rekapitulasi Event</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No. </th>
                            <th>Flyer Event</th>
                            <th>ID Event</th>
                            <th>Judul</th>
                            <th>Jenis Event</th>
                            <th>Pembicara</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Link</th>
							<th>Feedback</th>
                            <th>Deskripsi</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tgl = date('Y-m-d');   //2021-10-19
                        $tampil = mysqli_query($koneksi, "SELECT * FROM master_event where '$tgl' <= tanggal order by id_event asc");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($tampil)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><img src="https://webinar.ukdc.ac.id/avatar/flyer/<?= $data["avatar_event"]; ?>" alt="" width="50"></td>
                                <td><?= $data["id_event"]; ?></td>
                                <td><?= $data["judul"]; ?></td>
                                <td><?= $data["jenis_event"]; ?></td>
                                <td class="text-center"><?= $data["pembicara"]; ?></td>
                                <td><?= $data["status"]; ?></td>
                                <td><?= $data["tanggal"]; ?></td>
                                <td><?= $data["jam_mulai"]; ?></td>
                                <td><?= $data["jam_selesai"]; ?></td>
                                <td><?= $data["link"]; ?></td>
								<td><?= $data["feedback"]; ?></td>
                                <td><?= $data["deskripsi"]; ?></td>
                                <td>
                                    <a class="btn btn-primary" href="update.php?id=<?= $data["id_event"]; ?>" role="button">Update</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
