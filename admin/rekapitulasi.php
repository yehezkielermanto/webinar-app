<?php include 'header.php'; ?>
<!-- Awal row -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Event</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" action="" class="text-center">
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari</label>
                                <input class="form-control" type="date" name="tanggal_awal" value="<?= isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari</label>
                                <input class="form-control" type="date" name="tanggal_akhir" value="<?= isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary form-control" name="btampil"><i class="fa fa-search"></i>Tampilkan</button>
                        </div>
                        <div class="col-md-2">
                            <a href="index.php" class="btn btn-danger form-control"><i class="fa fa-backward"></i>Kembali</a>
                        </div>
                    </div>
                </form>

                <?php
                if (isset($_POST['btampil'])) :
                ?>
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
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Link</th>
                                    <th>Deskripsi</th>
                                    <th colspan="2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tgl1 = $_POST['tanggal_awal'];
                                $tgl2 = $_POST['tanggal_akhir'];
                                // $tgl = date('Y-m-d');   //2021-10-19
                                $tampil = mysqli_query($koneksi, "SELECT * FROM master_event where tanggal BETWEEN '$tgl1' AND '$tgl2' order by ID_event asc");
                                $no = 1;
                                while ($data = mysqli_fetch_assoc($tampil)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><img src="assets/img/<?= $data["avatar_event"]; ?>" alt="" width="50"></td>
                                        <td><?= $data["id_event"]; ?></td>
                                        <td><?= $data["judul"]; ?></td>
                                        <td><?= $data["jenis_event"]; ?></td>
                                        <td><?= $data["pembicara"]; ?></td>
                                        <td><?= $data["tanggal"]; ?></td>
                                        <td><?= $data["jam_mulai"]; ?></td>
                                        <td><?= $data["jam_selesai"]; ?></td>
                                        <td><?= $data["link"]; ?></td>
                                        <td><?= $data["deskripsi"]; ?></td>
                                        <td>
                                            <a class="btn btn-primary" href="#" role="button">Update</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Akhir row -->

<?php include 'footer.php'; ?>