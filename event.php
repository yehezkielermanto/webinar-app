<?php 
       session_start();

       if (!isset($_SESSION["email"])) {
            header("Location:session.php");
           exit; 
       }    
      $nama_lengkap = $_SESSION["nama_lengkap"];
      include "koneksi.php";
?>
<!DOCTYPE html>
<html>

<head>
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
<style>
@supports(display: grid) {
    .event {
        position: relative;
        width: 100%;
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        transition: all 0.2s;
        transform: scale(0.98);
        will-change: transform;
        user-select: none;
    }

    .event.active {
        background: rgba(255, 255, 255, 0.3);
    }
}
</style>

<body>

    <div class="container-login" style="background-image: url('images/bg05.jpg');">
        <div class="wrap-login p-l-40 p-r-40 p-t-20 p-b-20 " style="min-height:95vh;">
            <div id="mySidenav" class="sidenav">
                <div id="kanan"><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></div>
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
                <a href="logout.php">Keluar</a>
            </div>
            <span style="font-size:25px;cursor:pointer; float: right;" onclick="openNav()">&#9776;</span>
            <span class="title p-t-8" style="float:left; font-size:20px;"><?php echo $nama_lengkap;?></span>
            <br>
            <hr>
            <p class="txt2">Webinar Lainnya</p>
            <br>
            <!-- <div id="cards" class="col-md-11 min-vh-75"> -->
            <div class="event">
                <?php
                        $message = null;
                        $info = null;
                                $result = $koneksi->query("SELECT * FROM master_event WHERE status=1 ORDER BY tanggal ASC");
                                $rowcount=mysqli_num_rows($result);
                                if ($rowcount <=0 ){
                                    $message =  "Belum ada Event untuk saat ini";
                                }else{
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_event'];      
                                        $Date =  $row['tanggal'];
                                        $newdate= date("j", strtotime($Date));
                                        $newdate2= date("F", strtotime($Date));
                                        echo '<style>.event-item {display: inline-block;background: skyblue;min-height: 100px;min-width: 100px;margin:10px;font-size:30px;border-radius:20px;text-align:center;  background-color: #00FA9A;
                                            cursor:pointer;
                                            padding: 10px;
                                           
                                            border-radius: 15px;
                                            background: rgba(62, 250, 153,0.8);
                                          
                                            box-shadow: 0 10px 30px 0px rgb(62, 250, 153);
                                            -moz-box-shadow: 0 10px 30px 0px rgb(62, 250, 153);
                                            -webkit-box-shadow: 0 10px 30px 0px rgb(62, 250, 153);
                                            -o-box-shadow: 0 10px 30px 0px rgb(62, 250, 153);
                                            -ms-box-shadow: 0 10px 30px 0px rgb(62, 250, 153);}
                                        @media screen and (max-width: 500px) {min-height: 200px;min-width: 200px;}.radio {
                                            font-size: inherit;
                                            margin: 0;right: 20px;top:8px;display:none;}
                                            .radio:checked + .event-item{
                                                box-shadow: 0 10px 30px 0px rgb(62, 250, 153);
                                            }
                                            label{
                                                width:50%;
                                            }
                                            </style>
                                            <label>
                                            <input name="plan" class="radio" type="radio" onclick="showdetails()" value="'.$id.'" />
                                            <div class="event-item">';
                                            echo $newdate. '<br>' .$newdate2;
                                        echo '</div>
                                        </label>';
                        ?>
                <?php 
                        }}?>
                <script>
                function showdetails() {
                    const rbs = document.querySelectorAll('input[name="plan"]');
                    for (const rb of rbs) {
                        if (rb.checked) {
                            var selectedValue = rb.value;
                            window.location.assign("event.php?id_event=" + selectedValue)
                        }
                    }
                }
                </script>
            </div>

            <!-- </div> -->
            <div class="txt2 pt-4">
                <?php 
                    echo $message;
                    // grab ide event from header link
                        if(isset($_GET['id_event'])){
                            $id_event = $_GET['id_event'];
                           
                            $result = $koneksi->query("SELECT * FROM master_event WHERE id_event='$id_event'");
                            while ($row = $result->fetch_assoc()) {
                                echo '<h4 style="margin-top:20px;">'.$row["judul"].'</h4>';
                                echo "Pembicara: ".$row["pembicara"].'<br>';
                                echo "Tanggal: ".date("j F Y", strtotime($row["tanggal"])).'<br>'; 
                                echo "Pukul: ".$row["jam_mulai"].'<br>';
                              	echo "<small>".$row["deskripsi"].'</small><br>';
                                echo '<form method="POST">';
                                echo '  <div class="container-login-form-btn p-t-20 p-b-10"><input type="submit" class="login-form-btn" style="color: white;cursor:pointer;" name="daftar" value="Daftar" > </div>';
                                echo '</form>';
                            }
                        }
                        if(isset($_POST['daftar'])){
                            $email = $_SESSION['email'];
                            $id_peserta = $_SESSION["id_peserta"];
                            $id_peserta_event = "$id_peserta$id_event";
                            $result = $koneksi->query("SELECT a.* , b.* FROM peserta_event a,master_event b WHERE a.id_peserta ='$id_peserta' AND a.id_event = '$id_event'");
                            $rowcount2 = mysqli_num_rows($result);
                            if($rowcount2 > 0){
                                $info =  "<div class='alert alert-danger text-center'>Anda sudah terdaftar di webinar ini</div>";
                            }else{
                                // echo "Anda belum terdaftar di event ini";
                                $insert = $koneksi -> query("INSERT INTO peserta_event (id_peserta_event,id_peserta,id_event) VALUES('$id_peserta_event','$id_peserta','$id_event')"); 
                                if($insert){
                                    $info =  "<div class='alert alert-danger'>Anda berhasil terdaftar di webinar ini</div>";
                                }else{
                                    $info =  "<div class='alert alert-danger'>Gagal daftar webinar</div>";
                                }
                            }
                        }
                        ?>
            </div>
            <br>
            <?php echo $info;?>

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
        <script>
        const slider = document.querySelector('.event');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 3; //scroll-fast
            slider.scrollLeft = scrollLeft - walk;
            console.log(walk);
        });
        </script>
</body>

</html>