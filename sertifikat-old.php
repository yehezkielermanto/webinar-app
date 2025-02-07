<?php
date_default_timezone_set('Asia/Jakarta'); //define local time
$tanggal_sekarang = date("Y-m-d ");
// echo $tanggal_sekarang ;

       session_start();

       if (!isset($_SESSION["email"])) {
			header("Location:session.php");
           exit;
       }
      $nama_lengkap = $_SESSION["nama_lengkap"];
      $id_peserta = $_SESSION["user"]["id"];
    $koneksi = null;
      include "koneksi.php";

 // result sertificate
 $result_sertificate = $koneksi->query("SELECT a.* , b.* FROM event_participants a, events b WHERE user_id =$id_peserta and a.status = 1 and a.event_id = b.id and '$tanggal_sekarang'>= b.date");

 $const_locate_sertificate = "asset/TSP.jpg";

 // result feedback 
 $result_feed = $koneksi->query("SELECT a.* , b.* FROM event_participants a, events b WHERE user_id =$id_peserta and a.status = 0 and a.event_id = b.id and '$tanggal_sekarang'> b.date");


 //
 if (isset($_POST['isi_feed'])){
    $id_psr = $_POST['id_psr'];
    $id_evn = $_POST['id_evn'];
    $link_feed = $_POST['link_feed'];
    // echo $id_psr;
    // echo $id_evn;
    // echo $link_feed;
    //update psrevn status
    mysqli_query($koneksi , "UPDATE event_participants SET status=1 WHERE event_id=$id_evn and user_id =$id_psr"); 
    header('Location: '.$link_feed.'');
}

 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>DC-Event | Certificate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/certif.css">

</head>

<body>

    <div class="container-login" style="background-image: url('images/bg05.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-10 p-b-30" style="min-height:95vh;">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <!--<div id="navpro">
					<ul>
						<li></li>
						<p><img src="#" style="width: 190px; height: 230px;"></p>
					</ul>
				</div>-->
                <a href="beranda.php">Home</a>
                <a href="event.php">Webinar</a>
                <a href="sertifikat.php">Certificate</a>
                <a href="ganti-password.php">Ganti Password</a>
                <a href="profile/index.php">Profile</a>
                <a href="logout.php">Keluar</a>
            </div>
            <span style="font-size:25px;cursor:pointer; float: right;" onclick="openNav()">&#9776;</span>
            <span class="title p-t-8" style="float:left; font-size:20px;"><?php echo $nama_lengkap;?></span>
            <br>
            <hr>
            <div class="txt2 text-center mb-3">
                Sertifikat Webinar
            </div>


            <!-- Feedback -->
            <?php
                         while ($row = $result_feed->fetch_assoc())
                         { 
                                $id_event = $row['id'];
                                $id_peserta_event = $row['user_id'];

                                $judul = $row['title'];
                                $avatar_event = $row['poster_url'];
                                $tanggal = $row['date'];
                                $alamat_sertifikat =$row['certificate_url'];
                                $date_format = date("d F Y",strtotime($tanggal));
                                // TODO :
                                // feedback is not here need to change the query later.
                                // just need to query the `event_feedbacks`
                                $feedback = $row['feedback'];
                                
                              

                                // echo "$id_event";


                                echo '<div class="card mb-3" style="width: 18rem; background-color: aliceblue;  border-radius: 15px; box-shadow: 0 5px 20px 0px rgb(126, 128, 127);" >
                                <img class="card-img-top " style="height: 150px;"src="asset/tsps/'.$id_event."/".$alamat_sertifikat.'" alt="Gambaran Sertifikat">
                                <div class="card-body">
                                  <h5 class="card-title">'.$judul.'</h5>
                                  <p class="card-text">'.$tanggal.'</p>

                                  <div class="container-login-form-btn p-t-20 p-b-10">
                                  <form action = "sertifikat.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_psr" value="'.$id_peserta.'">
                                    <input type="hidden" name="id_evn" value="'.$id_event.'">
                                    <input type="hidden" name="link_feed" value="'.$feedback.'">
                                   
                                    <input type="submit" value="isi feedback" name="isi_feed" style="color: white; cursor:pointer;" class="login-form-btn" ></input>
                                  </form>
                                  
                                  </div>

                                </div>
                              </div>';
                            

                        };
                        ?>

            <!--Sertificate  -->
            <?php
                         while ($row = $result_sertificate->fetch_assoc()){
                            if (is_null($row ['user_id']))
                            {
                                echo $event_empty;
                            }
                            else {
                                $id_event = $row['event_id'];
                                $id_peserta_event = $row['user_id'];

                                $judul = $row['title'];
                                $avatar_event = $row['poster_url'];
                                $tanggal = $row['date'];
                                $alamat_sertifikat =$row['certificate_url'];
                                $date_format = date("d F Y",strtotime($tanggal));

                                // echo "$id_event";


                                echo '<div class="card mb-3" style="width: 18rem; background-color: aliceblue;  border-radius: 15px; box-shadow: 0 5px 20px 0px rgb(126, 128, 127);" >
                                <img class="card-img-top " style="height: 150px;"src="asset/tsps/'.$id_event."/".$alamat_sertifikat.'" alt="Gambaran Sertifikat">
                                <div class="card-body">
                                  <h5 class="card-title">'.$judul.'</h5>
                                  <p class="card-text">'.$tanggal.'</p>

                                  <div class="container-login-form-btn p-t-20 p-b-10">
                                  <a href="donwload-certificate.php?l='.$alamat_sertifikat.'&e='.$id_event.'" style="color: white;" class="login-form-btn">Donwload Sertifikat</a>
                                  </div>

                                </div>
                              </div>';
                            }

                };
                        ?>

        </div>
    </div>

    <!-- script java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script>

</body>

</html>
