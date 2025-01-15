<?php
date_default_timezone_set('Asia/Jakarta'); //define local time

session_start();
if (empty($_SESSION["find_event"])) {
    header('location:index.php');
}


if(isset($_POST['generate'])){
  $no = $_SESSION["find_event"];
  require_once __DIR__ . '/get-connection.php';

  $connection = getConnection();
  $evn=$no;
  
  
  $sql = "SELECT * FROM master_event WHERE id_event = :id_event ";
  $prepareStatement = $connection->prepare($sql);
  $prepareStatement->bindParam("id_event", $evn);
  $prepareStatement->execute();
  
  if($row = $prepareStatement->fetch()){
    
      $nama= $_POST["name"];
      $judul = '" '.$row['judul'].' "' ;
      $jabatan = $_POST['partisipasi'];
      $tanggal = date("d F Y",strtotime($row["tanggal"])) ;
      $file=$no.time();

       // insert history  
       $no_generate = "3";
       $tgl_generate = date("Y-m-d h:i:s");
       
       $hasil_generate = $file.'.jpg';
       $sql = "INSERT INTO history_generate_panitia(nama_generate,jabatan_generate,tgl_generate,hasil_generate) VALUES (:nama_generate,:jabatan_generate,:tgl_generate,:hasil_generate)";
       $prepareStatement = $connection->prepare($sql);
       $prepareStatement->bindParam("nama_generate", $nama);
       $prepareStatement->bindParam("jabatan_generate", $jabatan);
       $prepareStatement->bindParam("tgl_generate", $tgl_generate);
       $prepareStatement->bindParam("hasil_generate", $hasil_generate);
       $prepareStatement->execute();
       //-------------------------
   
       
      header('content-type:image/jpeg');
      $font='font/Playlist-Script/Playlist Script.otf';
      $font_judul = 'font/Poppins-Bold/poppins/Poppins-Bold.ttf';
      $font_jabatan = 'font/Poppins-Bold/poppins/Poppins-Bold.ttf';
      $font_tanggal ='font/Poppins-Bold/poppins/Poppins-Bold.ttf';    
      $const_locate_sertificate = 'asset/sertifikat panitia UKDC.jpg';
      $image=imagecreatefromjpeg($const_locate_sertificate);
      $color=imagecolorallocate($image,255,255,255);
  
      $font_size_nama=60;
      $font_size_judul =27;
      $font_size_jabatan =26;
      $font_size_tanggal =23;
      $angle =0;
             
        // Get image dimensions
        $image_width = imagesx($image);
        $image_height = imagesy($image);
  
   
        //
        $text_bound = imageftbbox($font_size_nama, $angle, $font, $nama);
  
        //Get the text upper, lower, left and right corner bounds
        $lower_left_x =  $text_bound[0];
        // $lower_left_y =  $text_bound[1];
        $lower_right_x = $text_bound[2];
        // $lower_right_y = $text_bound[3];
        $upper_right_x = $text_bound[4];
        // $upper_right_y = $text_bound[5];
        $upper_left_x =  $text_bound[6];
        // $upper_left_y =  $text_bound[7];
        //Get Text Width and text height
        $text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
        // $text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y
        //Get the starting position for centering
        $start_x_offset = ($image_width - $text_width) / 2;
        // $start_y_offset = ($image_height - $text_height) / 2;
        // Add text to image
        // imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $color, $font, $text);
        imagettftext($image, $font_size_nama, $angle, $start_x_offset, 450, $color, $font, $nama);
  
        // ---------------------------------------------------
        $text_bound_judul = imageftbbox($font_size_judul, $angle, $font_judul, $judul);
        $lower_left_x_judul =  $text_bound_judul[0];
        $lower_right_x_judul = $text_bound_judul[2];
        // $upper_right_x_judul = $text_bound_judul[4];
        // $upper_left_x_judul =  $text_bound_judul[6];
  
        $text_width_judul =  $lower_right_x_judul - $lower_left_x_judul;
        $start_x_offset_judul = ($image_width - $text_width_judul) / 2;
        imagettftext($image, $font_size_judul, $angle, $start_x_offset_judul , 650, $color, $font_judul, $judul);
  
  
        //-----------------------------------------------------
        $text_bound_jabatan = imageftbbox($font_size_jabatan, $angle, $font_jabatan, $jabatan);
        $lower_left_x_jabatan =  $text_bound_jabatan[0];
        $lower_right_x_jabatan = $text_bound_jabatan[2];
        // $upper_right_x_jabatan = $text_bound_jabatan[4];
        // $upper_left_x_jabatan =  $text_bound_jabatan[6];
  
        $text_width_jabatan =  $lower_right_x_jabatan - $lower_left_x_jabatan;
        $start_x_offset_jabatan = ($image_width - $text_width_jabatan) / 2;
        imagettftext($image, $font_size_jabatan, $angle,$start_x_offset_jabatan , 800, $color, $font_jabatan, $jabatan);
  
        //-----------------------------------------------------
        $text_bound_tanggal = imageftbbox($font_size_tanggal, $angle, $font_tanggal, $tanggal);
        $lower_left_x_tanggal =  $text_bound_tanggal[0];
        $lower_right_x_tanggal = $text_bound_tanggal[2];
        // $upper_right_x_tanggal = $text_bound_tanggal[4];
        // $upper_left_x_tanggal =  $text_bound_tanggal[6];
  
        $text_width_tanggal =  $lower_right_x_tanggal - $lower_left_x_tanggal;
        $start_x_offset_tanggal = ($image_width - $text_width_tanggal) / 2;
        imagettftext($image, $font_size_tanggal, $angle,$start_x_offset_tanggal ,950, $color, $font_tanggal, $tanggal);
        
        // imagejpeg($image);
        
        
        imagejpeg($image,'certificate/'.$file.'.jpg');
      
       
          
        header("location:donwload-certificate.php?l=$file");

        $connection = null;
  }
}

if(isset($_POST['view'])){
          $nama = $_POST['name'];
          $jabatan = $_POST['partisipasi'];
          session_start();
          $_SESSION["name"]=$nama;
          $_SESSION["partisipasi"]=$jabatan;
        //   echo $_SESSION["name"];
          header("location:view-certificate.php");
}
?>
<!-- <h1>Generate Sertifikat Panitia</h1>
<form action="form-certificate.php" method="post">
    <p>Masukkan Nama Kamu</p>
    <input type="text" name="name" />
    <p>Masukkan Partisipasi Sebagai</p>
    <input type="text" name="partisipasi" />
    <br>
    <br>
    <button name="generate">Generate</button>
    <button name="view" formtarget="_blank">
        View
    </button>
</form> -->



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <title>Beranda | Generate</title>

    <style>

    </style>
</head>

<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark "
        style="background-color: #343A40; padding-top: 30px;padding-bottom: 30px;">
        <div class="container">
            <a class="navbar-brand" href="#"
                style="color: #E5BC31; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-style: italic;">
                Sertifikat Panitia </a>
        </div>
    </nav> -->

    <section style="background-color: black; min-height: 100vh;">
        ` <div class="container">
            <div class="row mt-5 mb-3"><span class="text-center"
                    style="font-size: 40px; color: rgb(255, 255, 255); ">Generate Certificate!</span></div>



            <form action="form-certificate.php" method="post">
                <div class="row justify-content-center">

                    <div class="col-md-4 text-center">
                        <div class="col mb-3">
                            <span class="text-center" style="font-size: 20px; color: rgb(255, 255, 255);"> Masukkan
                                Nama </span>

                            <input style="width: 240px;" type="text" name="name" Required />
                        </div>
                        <div class="col mb-3">
                            <span class="text-center" style="font-size: 20px; color: rgb(255, 255, 255);"> Masukkan
                                Partisipasi </span>

                            <input style="width: 240px;" type="text" name="partisipasi" Required />
                        </div>

                        <button name="generate" style="color: white; font-style: bold; width:125px;"
                            class="btn btn-warning text-uppercase btn-lg mt-3 mb-5 text-center">generate</button>
                        <button name="view" formtarget="_blank" style="color: white; font-style: bold; width: 125px;"
                            class="btn btn-warning text-uppercase btn-lg mt-3 mb-5 text-center">view</button>
                    </div>
                </div>

            </form>

        </div>
    </section>

    <footer class="fixed-bottom" style="padding-top: 20px;padding-bottom: 20px; background-color: #343A40; ">
        <div class="container">
            <div class="row mb-3">
                <div class="col text-center" style="color: white;"><span class="copyright">Copyright © <a
                            style="color: #E5BC31;" href="http://webinar.ukdc.ac.id">webinar.ukdc.ac.id</a> 2021</span>
                </div>

            </div>
        </div>
    </footer>
</body>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>