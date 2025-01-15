<!-- Header -->
<?php include "header.php"; ?>
<!-- Penomoran Otomatis -->
<?php
// hubungkan ke database
include 'koneksi.php';

$id_event = "";
if(isset($_POST["detail_peserta"])){
	$id_event = $_POST["category"];
}

?>
<a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i>Logout</a><br>
<div class="head text-white text-center">
    <img src="assets/img/logo_IF.png" alt="" width="100">
    <h2 class="text-center">Web Pendaftaran Prodi Ilmu Informatika <br>WebIF</h2>
</div>
<!-- Awal Row -->
<div class="row mt-2">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Event Hari Ini : [<?= date("d-m-Y"); ?>]</h6>

        </div>
        <div class="card-body">
			<a href="jumlah-peserta-event.php" class="btn btn-success mb-3"><i class="fa fa-user"></i>Jumlah Peserta Event</a>
			<form action="export-excel.php" method="post">
			    <?php $id=$id_event?>
				<input type="text" name="id" value="<?php echo $id;?>" readonly />
				<button class="btn btn-success mb-3" name="export"><i class="fa fa-download"></i>Export Excel</button>
			</form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
							<th>No</th>
                            <th>Absen </th>
                            <th>id_peserta</th>
                            <th>id_peserta_event</th>
                            <th>id_event</th>
                            <th>nama_lengkap</th>
							<th>email</th>
							<th>Asal Institusi</th>
							<th>Verifikasi</th>
							<th>Lokasi Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tgl = date('Y-m-d');   //2021-10-19
                        $tampil = mysqli_query($koneksi, "SELECT a.* , b.id_event, c.nama_lengkap, c.email, c.verifikasi, c.asal_institusi FROM peserta_event a,master_event b, master_peserta c WHERE a.id_event = b.id_event AND b.id_event = '$id_event' AND c.id_peserta = a.id_peserta");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($tampil)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $data["absen"]; ?></td>
                                <td><?= $data["id_peserta"]; ?></td>
                                <td><?= $data["id_peserta_event"]; ?></td>
                                <td><?= $data["id_event"]; ?></td>
                                <td><?= $data["nama_lengkap"]; ?></td>
								<td><?= $data["email"]; ?></td>
								<td><?= $data["asal_institusi"]; ?></td>
								<td><?= $data["verifikasi"]; ?></td>
								<td><?= $data["lokasi_sertifikat"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <?php include "footer.php"; ?>