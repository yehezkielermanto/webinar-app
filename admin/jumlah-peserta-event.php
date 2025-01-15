<!-- Header -->
<?php include "header.php"; ?>

<?php
// hubungkan ke database
include 'koneksi.php';

?>
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


    <div class="card-body">
        <h1 align="center">Jumlah Peserta Event</h1>
        <br />

        <div class="table-responsive">
          	<form action="count.php" method="POST">
            <table id="product_data" class="table table-bordered table-striped">
              <input type="submit" value="Detail" class="btn btn-success mb-3" name="detail_peserta">
                <thead>
                    <tr>
                        <th>ID peserta event</th>
                        <th>ID peserta</th>
                        <th>
                            <select name="category" id="category" class="form-control">
                                <option value="">Event Search</option>
                                <?php
                           $result = mysqli_query($koneksi, "SELECT * FROM master_event order by id_event asc");
                            
                            while($row = mysqli_fetch_array($result))
                            {
                            echo '<option value="'.$row["id_event"].'">'.$row["id_event"].'</option>';
                            }
                            ?>
                            </select>
                        </th>
                        <th>Absen</th>
                    </tr>
                </thead>
            </table>
              </form>
        </div>
    </div>
</div>





<script type="text/javascript" language="javascript">
$(document).ready(function() {

    load_data();

    function load_data(is_category) {
        var dataTable = $('#product_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetch.php",
                type: "POST",
                data: {
                    is_category: is_category
                }
            },
            "columnDefs": [{
                "targets": [2],
                "orderable": false,
            }, ],
        });
    }

    $(document).on('change', '#category', function() {
        var category = $(this).val();
        $('#product_data').DataTable().destroy();
        if (category != '') {
            load_data(category);
        } else {
            load_data();
        }
    });
});
</script>



<?php include "footer.php"; ?>