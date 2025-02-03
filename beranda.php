<?php
session_start();
date_default_timezone_set('Asia/Jakarta'); //define local time
$koneksi = null;
include "koneksi.php";

$tanggal_sekarang = date("Y-m-d ");


$event_empty = ' <p class="text-center">Belum ada event yang kamu ikuti
</p>';

$event_empty_future = ' <p class="text-center">
Event masih kosong silahkan daftar event terlebih dahulu
</p>' ;

$materi_empty = ' <p class="text-center">

</p>' ;
$currentdate = date("Y-m-d"); 
$query = "SELECT * FROM events WHERE date >= '$currentdate'";
$result = mysqli_query($koneksi, $query);

       if (!isset($_SESSION["user"])) {
        //    echo "Anda harus masuk dulu <br><a href='masuk.php'>Klik disini</a>";
            header("Location:login.php");
           exit;
       }
       
      $nama_lengkap = $_SESSION["nama_lengkap"];
      $id_peserta = $_SESSION["id_peserta"];
      //result event yang akan datang
$result_event_feature = $koneksi->query(
    "SELECT a.* , b.* FROM event_participants a, events b
    WHERE a.user_id ='$id_peserta' AND b.status=1
    AND a.event_id = b.id AND '$tanggal_sekarang'
    <= b.date ORDER BY b.date LIMIT 1");
      // result event
      $result_event = $koneksi->query("SELECT a.* , b.* FROM event_participants a,events b WHERE a.user_id ='$id_peserta' AND a.event_id = b.id AND '$tanggal_sekarang' <= b.date");


      //result materi
      $result_materi = $koneksi->query("SELECT * FROM event_materials WHERE status = 1");

      //feed and seertifikat and absen

        if (isset($_GET['id-event']) & isset($_GET['feed'])) {
            $nama_lengkap = $_SESSION["nama_lengkap"];
            $id_peserta = $_SESSION["id_peserta"];
            $id_event=$_GET['id-event'];
            $link_feed = $_GET['feed'];
            // result event
            $result_event_absensi = $koneksi->query("SELECT * FROM peserta_event WHERE id_event ='$id_event' and id_peserta ='$id_peserta'");
            $result_absensi=mysqli_fetch_array($result_event_absensi);
            // $resul_sertifikat = $koneksi->query("SELECT * FROM master_event WHERE id_event ='$id_event' ");
            // $result_sertifikat=mysqli_fetch_array($resul_sertifikat);
            if ($result_absensi['absen']==0) {
                mysqli_query($koneksi , "UPDATE peserta_event SET absen=1 WHERE id_event ='$id_event' and id_peserta ='$id_peserta'");
            //     header('content-type:image/jpeg');
            //     $font='C:\Windows\Fonts\georgia.ttf';
            //     $font_no = 'C:\Windows\Fonts\arial.ttf';
            //     $font_tema ='C:\Windows\Fonts\georgia.ttf';
            //     $font_jenis='C:\Windows\Fonts\arial.ttf';
            //     $font_tanggal='C:\Windows\Fonts\arial.ttf';
            //     $font_narasumber="C:\Windows\Fonts\arial.ttf";
            //     $const_locate_sertificate = 'asset/TSP.jpg';

            //     $image=imagecreatefromjpeg($const_locate_sertificate);
            //     $color=imagecolorallocate($image,255,255,255);
            //     $nama=$nama_lengkap;
            //     $tema = ' "'.$result_sertifikat['judul'].'" ';
            //     $const_peserta = 'Sebagai Peserta dalam Acara ';
            //     $jenis_acara = $result_sertifikat['jenis_event'];
            //     $jenis = $const_peserta.$jenis_acara." dengan Tema : ";
            //     $date_no = date("/m/d/y",strtotime($result_sertifikat['tanggal']));
            //     $no = "Nomor : ".$result_absensi['id_peserta_event'].$date_no;
            //     $date_tanggal = date("j F Y",strtotime($result_sertifikat['tanggal']));
            //     $tanggal = "Pada ".$date_tanggal ;
            //     $const_narasumber = "Yang dibawakan oleh Narasumber : ";
	        //     $narasumber = $result_sertifikat['pembicara'];

            //     $font_size_nama=100;
            //     $font_size_no =40;
            //     $font_size_tema =55;
            //     $font_size_jenis =50;
            //     $font_size_tanggal =50;
            //     $font_size_narasumber = 50;
            //     $angle =0;

            // // Get image dimensions
            // $image_width = imagesx($image);
            // $image_height = imagesy($image);
            // //
            // $text_bound = imageftbbox($font_size_nama, $angle, $font, $nama);

            // //Get the text upper, lower, left and right corner bounds
            // $lower_left_x =  $text_bound[0];
            // $lower_left_y =  $text_bound[1];
            // $lower_right_x = $text_bound[2];
            // $lower_right_y = $text_bound[3];
            // $upper_right_x = $text_bound[4];
            // $upper_right_y = $text_bound[5];
            // $upper_left_x =  $text_bound[6];
            // $upper_left_y =  $text_bound[7];
            // //Get Text Width and text height
            // $text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
            // $text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y
            // //Get the starting position for centering
            // $start_x_offset = ($image_width - $text_width) / 2;
            // $start_y_offset = ($image_height - $text_height) / 2;
            // // Add text to image
            // // imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $color, $font, $text);
            // imagettftext($image, $font_size_nama, $angle, $start_x_offset, 1090, $color, $font, $nama);

            // // ---------------------------------------------------
            // $text_bound_no = imageftbbox($font_size_no, $angle, $font, $no);
            // $lower_left_x_no =  $text_bound_no[0];
            // $lower_right_x_no = $text_bound_no[2];
            // $upper_right_x_no = $text_bound_no[4];
            // $upper_left_x_no =  $text_bound_no[6];

            // $text_width_no =  $lower_right_x_no - $lower_left_x_no;
            // $start_x_offset_no = ($image_width - $text_width_no) / 2;
            // imagettftext($image, $font_size_no, $angle,$start_x_offset_no , 620, $color, $font_no, $no);
            // // ---------------------------------------------------
            // $text_bound_jenis = imageftbbox($font_size_jenis, $angle, $font, $jenis);
            // $lower_left_x_jenis =  $text_bound_jenis[0];
            // $lower_right_x_jenis = $text_bound_jenis[2];
            // $upper_right_x_jenis = $text_bound_jenis[4];
            // $upper_left_x_jenis =  $text_bound_jenis[6];

            // $text_width_jenis =  $lower_right_x_jenis - $lower_left_x_jenis;
            // $start_x_offset_jenis = ($image_width - $text_width_jenis) / 2;
            // imagettftext($image, $font_size_jenis, $angle, $start_x_offset_jenis, 1200, $color, $font_jenis, $jenis);
            // //
            // $text_bound_tema = imageftbbox($font_size_tema, $angle, $font, $tema);
            // $lower_left_x_tema =  $text_bound_tema[0];
            // $lower_right_x_tema = $text_bound_tema[2];
            // $upper_right_x_tema = $text_bound_tema[4];
            // $upper_left_x_tema =  $text_bound_tema[6];

            // $text_width_tema =  $lower_right_x_tema - $lower_left_x_tema;
            // $start_x_offset_tema = ($image_width - $text_width_tema) / 2;
            // imagettftext($image, $font_size_tema, $angle, $start_x_offset_tema, 1300, $color, $font_tema, $tema);
            // //
            // $text_bound_tanggal = imageftbbox($font_size_tanggal, $angle, $font, $tanggal);
            // $lower_left_x_tanggal =  $text_bound_tanggal[0];
            // $lower_right_x_tanggal = $text_bound_tanggal[2];
            // $upper_right_x_tanggal = $text_bound_tanggal[4];
            // $upper_left_x_tanggal =  $text_bound_tanggal[6];

            // $text_width_tanggal =  $lower_right_x_tanggal - $lower_left_x_tanggal;
            // $start_x_offset_tanggal = ($image_width - $text_width_tanggal) / 2;
            // imagettftext($image, $font_size_tanggal, $angle, $start_x_offset_tanggal, 1400, $color, $font_tanggal, $tanggal);
            // // ---------------------------------------------------
            // //
            // imagettftext($image, $font_size_narasumber, $angle, 1240, 1500, $color, $font_narasumber, $const_narasumber);
            // //
            // $text_bound_narasumber = imageftbbox($font_size_narasumber, $angle, $font, $narasumber);
            // $lower_left_x_narasumber =  $text_bound_narasumber[0];
            // $lower_right_x_narasumber = $text_bound_narasumber[2];
            // $upper_right_x_narasumber = $text_bound_narasumber[4];
            // $upper_left_x_narasumber =  $text_bound_narasumber[6];

            // $text_width_narasumber =  $lower_right_x_narasumber - $lower_left_x_narasumber;
            // $start_x_offset_narasumber = ($image_width - $text_width_narasumber) / 2;
            // imagettftext($image, $font_size_narasumber, $angle, $start_x_offset_narasumber, 1600, $color, $font_narasumber, $narasumber);
            // //
            // $file=$result_absensi['id_peserta_event'];
            // imagejpeg($image,'asset/tsps/'.$id_event.'/'.$file.'.jpg');
            // imagedestroy($image);
            // $lokasi_jadi = ''.$file.'.jpg';
            // mysqli_query($koneksi , "UPDATE peserta_event SET lokasi_sertifikat='$lokasi_jadi' WHERE id_event ='$id_event' and id_peserta ='$id_peserta'");
            //     header('Location: '.$link_feed.'');
            }
            else {
                header('Location: '.$link_feed.'');
            }
        }

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="utf-8">
    <title>DC-EVENT | Beranda</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/beranda.css">

</head>

<!-- <body>
    
    <div class="container-login" style="background-image: url('images/bg05.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-20 p-b-20" style="min-height:95vh;">
            
 

        <a href="notif.php" style="font-size:24px" class="fa">&#xf0f3;</a>

            <div id="mySidenav" class="sidenav">
                <div id="kanan"><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></div>
                <!--<div id="navpro">
					<ul>
						<li></li>
						<p><img src="#" style="width: 190px; height: 230px;"></p>
					</ul>
				</div>-->
                <!-- <a href="beranda.php">Home</a>
                <a href="event.php">Webinar</a>
                <a href="sertifikat.php">Certificate</a>
                <a href="ganti-password.php">Ganti Password</a>
                <a href="profile/index.php">Profile</a> -->
                <!-- <a href="">Notifikasi</a> -->
                
                <!-- <a href="logout.php">Keluar</a>
            </div>
            <span style="font-size:25px;cursor:pointer; float: right;" onclick="openNav()">&#9776;</span>
            <span class="title p-t-8" style="float:left; font-size:20px;"><?php echo $nama_lengkap;?></span>
            <br>
            <hr>
            <p class="txt2 mb-3">Webinar yang akan datang </p>

            <div class="row justify-content-center ">
                <!-- <?php
                        $rowcount=mysqli_num_rows($result_event_feature);
                            if ($rowcount <=0)
                            {
                                echo $event_empty_future;
                            }
                            else {
                            while ($row = $result_event_feature->fetch_assoc()){
                                $id_event = $row['event_id'];
                                $judul = $row['title'];
                                $tanggal = $row['date'];
                                $jam_mulai = $row['start_time'];
                                $jam_selesai = $row['end_time'];
                                $link = $row['link'];
                                $date_format = date("d F Y",strtotime($tanggal));
                                $time_format_mulai = date("h:i",strtotime($jam_mulai));
                                $time_format_selesai = date("h:i",strtotime($jam_selesai));
                                $background = $row['poster_url'];
                                $feedback = "";
                                // $feedback = $row['feedback'];
                                // echo $feedback;
                                echo '
                                <div  class="col-md-11 text-center">
                                <h6>'.$judul.'</h6>
                                <P>'.$date_format.' '.$time_format_mulai.' - '.$time_format_selesai.' WIB</P>
                                </div>
                                <div class="col-md-9 text-center">
                                <div class="row justify-content-center">
                                    <div class="container-login-form-btn p-t-20 p-b-10">
                                    <a href="'.$link.'" style="color: white;" class="login-form-btn"
                                    target="_blank">Link </a>
                                    <p class ="mb-3 mt-3">Klik Link diatas untuk absen dan masuk Webinar</p>
                                    <a href="donwload-background.php?down-back='.$background.'" style="color: white;" class="login-form-btn">Donwload Background</a>
                                    <p class =" mt-3 mb-3">Klik Donwload Background datas untuk background Webinar</p>
                                    <!-- <a href="beranda.php?feed='.$feedback.'&id-event='.$id_event.'" target="_blank" style="color: white;" class="login-form-btn">Isi Feedback</a> -->
                                    <p class =" mt-3">Klik Untuk mengisi feedback, <br> feeedback akan ditutup tengah malam</p>
                                    </div>
                                </div>
                                </div>';
                                }

                            };
                ?>
            </div>



            <hr>
            <p class="txt2 mb-3">Webinar lainnya yang kamu ikuti </p>

            <?php
                     $rowcount=mysqli_num_rows($result_event);

                            if ($rowcount <=0)
                            {
                                echo $event_empty;
                            }

                            else {
                                while ($row = $result_event->fetch_assoc()){
                                $id_event = $row['event_id'];
                                $judul = $row['title'];
                                // $avatar_event = $row['avatar_event'];
                                $avatar_event = "";
                                $tanggal = $row['date'];
                                $date_format = date("d F Y",strtotime($tanggal));

                                // echo "$id_event";
                                echo '
                                <div  class="col-md-12 mb-4"
                                style="background-color: aliceblue;  border-radius: 15px; box-shadow: 0 5px 20px 0px rgb(126, 128, 127);">
                                <img src="https://webinar.ukdc.ac.id/avatar/flyer/'.$avatar_event.'"
                                    style="width: 100px; height: 80px; border-radius: 10px; float: left; padding-right: 5px; ">
                                <p>'.$judul.'</p>
                                    <br>
                                    <p>
                                        '.$date_format.'
                                    </p>
                                </div>';
                                }
                            };
                ?> -->



            <!-- <span class="txt2">untuk dafar dan melihat event silahkan tekan lihat</span> -->
            <!-- <div class="container-login-form-btn p-t-20 p-b-10">
                <a href="event.php" style="color: white;" class="login-form-btn">Lihat</a>

            </div>
            <hr>



            <p class="txt2 mb-3">Materi Webinar </p> -->

            <!-- materi -->
            <?php
             $rowcount=mysqli_num_rows($result_materi);

             if ($rowcount <=0)
             {
                echo $materi_empty;
             }
             else {
                while ($row = $result_materi->fetch_assoc()){
                    $judul_materi = $row['judul_materi'];
                    $lokasi_materi = $row['lokasi_materi'];
        
                echo '<div class="card mb-3" style="width: 18rem; background-color: aliceblue;  border-radius: 15px; box-shadow: 0 5px 20px 0px rgb(126, 128, 127);" >
                <div class="card-body">
           
                  <p class="card-text text-center">'.$judul_materi.'</p>
    
                  <div class="container-login-form-btn p-t-20 p-b-10">
                  <a href="donwload-materi.php?l='.$lokasi_materi.'" style="color: white;" class="login-form-btn">Donwload Materi</a>
                  </div>
    
                </div>
                </div>';
             }
            
            }
            
             ?>




        </div>

        <!-- script java script -->
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("kanan").style.marginRight = "0";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("kanan").style.marginRight = "0";
        }
        </script>
</body> 

</html> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DC-Webinar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .navbar {
            transition: background-color 0.3s ease;
        }

        .navbar.scrolled {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-social {
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-social:hover {
            transform: scale(1.1);
            background-color: #444;
        }

        .badge {
            animation: bounce 1s infinite alternate;
        }

        @keyframes bounce {
            0% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(10px);
            }
        }

        @media (max-width: 768px) {
            .navbar {
                background-color: rgba(0, 0, 0, 0.9);
            }

            .card img {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>DC-Webinar</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <!-- <a href="beranda.php">Home</a>
                <a href="event.php">Webinar</a>
                <a href="sertifikat.php">Certificate</a>
                <a href="ganti-password.php">Ganti Password</a>
                <a href="profile/index.php">Profile</a> -->
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="beranda.php">
                <i class="fas fa-home me-2"></i> DC-Webinar
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="event.php">
                            <i class="fas fa-video me-1"></i> Webinar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="sertifikat.php">
                            <i class="fas fa-certificate me-1"></i> Certificate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ganti-password.php">
                            <i class="fas fa-key me-1"></i> Ganti Password
                        </a>
                    </li>
                    <!-- Dropdown Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile/index.php">Lihat Profil</a></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i> Keluar</a></li>
                        </ul>
                    </li>
                    <!-- Notifikasi -->
                    <li class="nav-item">
                        <a class="nav-link position-relative text-white" href="notif.php">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3 <!-- Gantilah dengan jumlah notifikasi dinamis -->
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Webinar</h6>
                <h1 class="mb-5">Webinar yang akan datang</h1>
            </div>
            <div class="row g-3">
                
                <?php  while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card mb-4 wow zoomIn" data-wow-delay="0.1s">
                            <img src="images/download.jpeg" class="card-img-top" alt="webinar image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                                <small class="text-muted"><?= date('d M Y, H:i', strtotime($row['start_time'])); ?></small>
                                <a href="detail_webinar.php?id=<?= $row['event_id']; ?>" class="btn btn-primary mt-3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>JL. IR.H. Soekarno no.201, Surabaya</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 888888888</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>ukdc@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Custom Javascript -->
    <script>
        // Navbar Scroll Effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });

        // Initialize WOW.js
        new WOW().init();
    </script>
</body>

</html>
