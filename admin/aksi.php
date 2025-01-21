<?php
include 'koneksi.php';
// pengujian apabila tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    // untuk avatar event
    $flyer_event = $_FILES['flyer_event']['name'];
    // pengisian normal
    $ID_event = htmlspecialchars($_POST['ID_event'], ENT_QUOTES);
    $judul_event = htmlspecialchars($_POST['judul_event'], ENT_QUOTES);
    $jenis_event = htmlspecialchars($_POST['jenis_event'], ENT_QUOTES);
    $pembicara = htmlspecialchars($_POST['pembicara'], ENT_QUOTES);
    $tgl = $_POST['tanggal'];
    $convert_date = date('Y-m-d', strtotime($tgl));
    $jam_mulai = htmlspecialchars($_POST['jam_mulai'], ENT_QUOTES);
    $jam_selesai = htmlspecialchars($_POST['jam_selesai'], ENT_QUOTES);
    $link_meet = htmlspecialchars($_POST['link_meeting'], ENT_QUOTES);
    $deskripsi = htmlspecialchars($_POST['deskripsi'], ENT_QUOTES);
	$feedback = htmlspecialchars($_POST['feedback'], ENT_QUOTES);
    // upload VB
    $upload_vb = $_FILES['upload_vb']['name'];

    //if ($flyer_event != "" and $ID_event != "" and $judul_event != "" and $jenis_event != "" and $pembicara != "" and $convert_date != "" and $jam_mulai != "" and $jam_selesai != "" and $link_meet != "" and $deskripsi != "" and $upload_vb != "") {
        // flyer
  if ($flyer_event != "" and $ID_event != "" and $judul_event != "" and $jenis_event != "" and $pembicara != "" and $convert_date != "" and $jam_mulai != "" and $jam_selesai != "" and $deskripsi != "") {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $x = explode('.', $flyer_event);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['flyer_event']['tmp_name'];
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak . '-' . $flyer_event;
        // VB
        $ekstensi_diperbolehkan2 = array('png', 'jpg', 'jpeg');
        $x2 = explode('.', $upload_vb);
        $ekstensi2 = strtolower(end($x2));
        $file_tmp2 = $_FILES['upload_vb']['tmp_name'];
        $angka_acak2 = rand(1, 999);
        $nama_gambar_baru2 = $angka_acak2 . '-' . $upload_vb;
        if (in_array($ekstensi, $ekstensi_diperbolehkan) == true && in_array($ekstensi2, $ekstensi_diperbolehkan2) == true) {
            // flyer
            move_uploaded_file($file_tmp, '../avatar/flyer/' . $nama_gambar_baru);
            // VB
            move_uploaded_file($file_tmp2, '../avatar/VB/' . $nama_gambar_baru2);
            $simpan = mysqli_query($koneksi, "INSERT INTO events VALUES ('$nama_gambar_baru','$deskripsi','$ID_event','$jam_mulai', '$jam_selesai', '$jenis_event', '$judul_event', '$link_meet', '$pembicara',1, '$convert_date', '$nama_gambar_baru2', '$feedback')");
            if ($simpan) {
                echo "<script>
                    alert('Simpan Event Sukses, Terima kasih');
                    document.location='index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Simpan Event Gagal, Terima kasih');
                    document.location='index.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('EKSTENSI TIDAK DIPERBOLEHKAN!!!');
                document.location='index.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('MOHON MAAF EVENT INI BELUM DIISI!!!');
            document.location='index.php';
        </script>";
    }

    // $simpan = mysqli_query($koneksi, "INSERT INTO master_event VALUES ('$flyer_event','$ID_event','$judul_event','$jenis_event','$pembicara','$convert_date','$jam_mulai','$jam_selesai','$link_meet','$deskripsi')");

    // if ($simpan) {
    //     echo "<script>
    //         alert('Simpan Event Sukses, Terima kasih');
    //         document.location='admin.php';
    //     </script>";
    // } else {
    //     echo "<script>
    //         alert('Simpan Event Gagal, Terima kasih');
    //         document.location='?';
    //     </script>";
    // }
}
