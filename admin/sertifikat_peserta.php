<?php 
      include "koneksi.php";
	ini_set('max_execution_time', 0);
      // //penyesuain 
      // $nama ="Antonius Bun Wijaya";
      // $no = "PSR001EVN002";
      // header('content-type:image/jpeg');
      //   $font='C:\Windows\Fonts\georgia.ttf';
      //   $font_no = 'C:\Windows\Fonts\arial.ttf';      
      //   $const_locate_sertificate = 'temp/TSP1.jpg';
      //   $image=imagecreatefromjpeg($const_locate_sertificate);
      //   $color=imagecolorallocate($image,255,255,255);

      //   $font_size_nama=100;
      //   $font_size_no =40;
      //   $angle =0;

      //   // Get image dimensions
      //   $image_width = imagesx($image);
      //   $image_height = imagesy($image);
      //   //
      //   $text_bound = imageftbbox($font_size_nama, $angle, $font, $nama);

      //   //Get the text upper, lower, left and right corner bounds
      //   $lower_left_x =  $text_bound[0];
      //   $lower_left_y =  $text_bound[1];
      //   $lower_right_x = $text_bound[2];
      //   $lower_right_y = $text_bound[3];
      //   $upper_right_x = $text_bound[4];
      //   $upper_right_y = $text_bound[5];
      //   $upper_left_x =  $text_bound[6];
      //   $upper_left_y =  $text_bound[7];
      //   //Get Text Width and text height
      //   $text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
      //   $text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y
      //   //Get the starting position for centering
      //   $start_x_offset = ($image_width - $text_width) / 2;
      //   $start_y_offset = ($image_height - $text_height) / 2;
      //   // Add text to image
      //   // imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $color, $font, $text);
      //   imagettftext($image, $font_size_nama, $angle, $start_x_offset, 1170, $color, $font, $nama);

      //   // ---------------------------------------------------
      //   $text_bound_no = imageftbbox($font_size_no, $angle, $font, $no);
      //   $lower_left_x_no =  $text_bound_no[0];
      //   $lower_right_x_no = $text_bound_no[2];
      //   $upper_right_x_no = $text_bound_no[4];
      //   $upper_left_x_no =  $text_bound_no[6];

      //   $text_width_no =  $lower_right_x_no - $lower_left_x_no;
      //   $start_x_offset_no = ($image_width - $text_width_no) / 2;
      //   imagettftext($image, $font_size_no, $angle,1850 , 800, $color, $font_no, $no);
        
        
      
      //   imagejpeg($image);
      //   imagedestroy($image);
        
      // result event
     
      $id_event="EVN021";
      $res=mysqli_query($koneksi,"select a.* , b.* , c.* from peserta_event a, master_event b, master_peserta c where a.id_event = '$id_event' AND a.id_event = b.id_event AND a.id_peserta= c.id_peserta");
      // while($row=mysqli_fetch_assoc($res)){
      //     echo $row['id_peserta_event'].'<br>';
      //     echo $row['absen'].'<br>';
      //     echo $row['nama_lengkap'].'<br>';
      //     echo $row['id_event'].'<br>';
      //     echo "<br>";
      //     echo "<br>";
      //     echo "<br>";
          
      // }
      
      if(mysqli_num_rows($res)>0){
        echo 'lagi proses';
        
        while($row=mysqli_fetch_assoc($res)){
			header('content-type:image/png');      
			$const_locate_sertificate = "temp/TSP11.png";
			$image=imagecreatefrompng($const_locate_sertificate);
                  // change font color
			$color=imagecolorallocate($image,112,48,160);
			$color2=imagecolorallocate($image,255,200,0);
			$font='../font-s/Georgia.ttf';
			//$font_no = 'C:\Windows\Fonts\arial.ttf';
			
          	//ukuran font
			$font_size_nama=40;
			//$font_size_no =40;
			$angle =0;
          $nama=$row['nama_lengkap'];
          //$no = $row['id_peserta_event'];
          $id_peserta = $row['id_peserta'];
          // Get image dimensions
          $image_width = imagesx($image);
          $image_height = imagesy($image);
          //
          $text_bound = imageftbbox($font_size_nama, $angle, $font, $nama);

          //Get the text upper, lower, left and right corner bounds
          $lower_left_x =  $text_bound[0];
          $lower_left_y =  $text_bound[1];
          $lower_right_x = $text_bound[2];
          $lower_right_y = $text_bound[3];
          $upper_right_x = $text_bound[4];
          $upper_right_y = $text_bound[5];
          $upper_left_x =  $text_bound[6];
          $upper_left_y =  $text_bound[7];
          //Get Text Width and text height
          $text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
          $text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y
          //Get the starting position for centering
          $start_x_offset = ($image_width - $text_width) / 2;
          $start_y_offset = ($image_height - $text_height) / 2;
          // Add text to image
          // imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $color, $font, $text);
          imagettftext($image, $font_size_nama, $angle, $start_x_offset, 550, $color, $font, $nama);
          //---------------------------------------------------
          //$text_bound_no = imageftbbox($font_size_no, $angle, $font, $no);
         // $lower_left_x_no =  $text_bound_no[0];
          //$lower_right_x_no = $text_bound_no[2];
          //$upper_right_x_no = $text_bound_no[4];
          //$upper_left_x_no =  $text_bound_no[6];

          //$text_width_no =  $lower_right_x_no - $lower_left_x_no;
          //$start_x_offset_no = ($image_width - $text_width_no) / 2;
          //imagettftext($image, $font_size_no, $angle,1195 , 414, $color2, $font_no, $no);
          
          
          $file=$row['id_peserta_event'];
          imagejpeg($image,'../asset/tsps/'.$id_event.'/'.$file.'.png');
          
          $lokasi_jadi = ''.$file.'.png';
          mysqli_query($koneksi , "UPDATE peserta_event SET lokasi_sertifikat='$lokasi_jadi' WHERE id_event ='$id_event' and id_peserta ='$id_peserta'");
              // header('Location: '.$link_feed.'');
			imagedestroy($image);
        }
		imagedestroy($image);
      }else{
      	echo 'terjadi kesalahan' ;
      }