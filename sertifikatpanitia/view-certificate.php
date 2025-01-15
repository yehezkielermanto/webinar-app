<?php 
    session_start();
    if (empty($_SESSION["find_event"])) {
        header('location:index.php');
    }
    $no = $_SESSION["find_event"];
    require_once __DIR__ . '/get-connection.php';

    $connection = getConnection();
    $evn=$no;
    
    
    $sql = "SELECT * FROM master_event WHERE id_event = :id_event ";
    $prepareStatement = $connection->prepare($sql);
    $prepareStatement->bindParam("id_event", $evn);
    $prepareStatement->execute();
    
    if($row = $prepareStatement->fetch()){
        // echo "Sukses  : " . $row["id_event"] . PHP_EOL;
        // echo $row["judul"];
        // echo $row["tanggal"];
        $nama= $_SESSION["name"];
        $judul = '" '.$row['judul'].' "' ;
        $jabatan = $_SESSION['partisipasi'];
        $tanggal = date("d F Y",strtotime($row["tanggal"])) ;

        // echo $nama.$judul.$jabatan.$tanggal;
        // die;
        
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
          
          imagejpeg($image);
          // $file=$no.time();
          // imagejpeg($image,'certificate/'.$file.'.jpg');
    }else {
        echo "Gagal " . PHP_EOL;
    }
    
    // var_dump($prepareStatement->fetch());
    
    
    
    $connection = null;
    
   
          
         

?>