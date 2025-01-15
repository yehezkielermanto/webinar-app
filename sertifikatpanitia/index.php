<?php 
$tanggal_sekarang = date("Y-m-d ");
if (isset($_POST["masuk"])) {
    require_once __DIR__ .'/get-connection.php';

$connection = getConnection();

$serial_pass = $_POST["serial"];

$sql = "SELECT * FROM panitia_event WHERE  serial_pass = ?";
$prepareStatement = $connection->prepare($sql);
$prepareStatement->bindParam(1, $serial_pass);
$prepareStatement->execute();

$success = false;
$find_user = null;
foreach ($prepareStatement as $row){
    //Sukses
    
    $find_event = $row["id_event"];
    $find_tgl_start = $row["tgl_start"];
    $find_tgl_end = $row["tgl_end"];
    
    
    if ($tanggal_sekarang >= $find_tgl_start && $tanggal_sekarang <= $find_tgl_end) {
        
        session_start();
        $_SESSION["find_event"] = $find_event ;
       
        $success = true;
    }
    
}

if($success){
    // echo "sukses login : " . $find_event .PHP_EOL;
    header("location:form-certificate.php");
}else {
    echo '<div class="alert fixed-top alert-danger alert-dismissible fade show" role="alert">
    <strong>Serial Password tidak valid!</strong> Silahkan ulangi atau hubungi admin.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    // echo "Gagal Login " . PHP_EOL;
}
$connection = null;
}


?>

<!-- <form action="index.php" method="post">
    <p>Masukkan Serial Password</p>
    <input type="text" name="serial" />

    <br>
    <br>
    <button name="masuk">Masuk</button>

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

    <title>Masuk | Sertifikat Panitia</title>

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
            <div class="row mt-5 "><span class="text-center"
                    style="font-size: 40px; color: rgb(255, 255, 255); ">Selamat Datang di Generate Certificate!</span>
            </div>
            <div class="row mb-5"><span class="text-center"
                    style="font-size: 60px; color: rgb(255, 255, 255); font-style: bold; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;">UNIVERSITAS
                    KATOLIK DARMA CENDIKA</span></div>


            <form action="index.php" method="post">
                <div class="row justify-content-center">

                    <div class="col-md-4 text-center">
                        <div class="col">
                            <span class="text-center" style="font-size: 20px; color: rgb(255, 255, 255);"> Masukkan
                                Serial Password </span>

                            <input style="width: 240px;" type="password" name="serial" Required />
                        </div>


                        <button name="masuk" style="color: white; font-style: bold;"
                            class="btn btn-warning text-uppercase btn-lg mt-3 mb-5 text-center">Masuk</button>
                    </div>
                </div>

            </form>

        </div>
    </section>
    <footer class="fixed-bottom" style=" padding-top: 20px;padding-bottom: 20px; background-color: #343A40; ">
        <div class=" container">
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