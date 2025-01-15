<!-- Header -->
<?php include "header.php"; ?>
<!-- Penomoran Otomatis -->
<a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i>Logout</a><br>
<div class="head text-white text-center">
    <img src="assets/img/logo_IF.png" alt="" width="100">
    <h2 class="text-center">Web Pendaftaran Prodi Ilmu Informatika <br>WebIF</h2>

</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Event Hari Ini : [<?= date("d-m-Y"); ?>]</h6>
    </div>



    <h1 align="center">Riwayat Generate Certificate Panitia</h1>
    <br />

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center">
                        <th>No. </th>
                        <th>No Generate </th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tanggal Generate</th>
                        <th>Hasil Generate</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $tampil = mysqli_query($koneksi, "SELECT * FROM history_generate_panitia  order by tgl_generate desc");
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($tampil)) {
                        ?>
                    <tr>
                        <td><?= $no++; ?>.</td>
                        <td><?= $data["no_generate"]; ?></td>
                        <td><?= $data["nama_generate"]; ?></td>
                        <td><?= $data["jabatan_generate"]; ?></td>
                        <td><?= $data["tgl_generate"]; ?></td>
                        <td><?= $data["hasil_generate"]; ?></td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>