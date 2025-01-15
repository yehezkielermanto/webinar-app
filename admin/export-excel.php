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

if(isset($_POST["export"])){
	$id_event = $_POST["id"];
}
?>
<input type="text" name="id" value='<?php echo ""?>'>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Peserta.xls");
?>
<!-- Awal Row -->
<div class="row mt-2">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Event Hari Ini : [<?= date("d-m-Y"); ?>]</h6>
        </div>
        <div class="card-body">
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