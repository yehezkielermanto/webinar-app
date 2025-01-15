<?php
    include "koneksi.php";
    session_start();
    $sukses=NULL;
    $kunci=NULL;
    if($_SESSION["email"]!=""){
        if(isset($_POST["submit"])){
            $email = $_SESSION["email"];
            //inisialisasi karakter
            $password = $_POST["pass_1"];
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChar = preg_match('[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?~]', $password);

            if($_POST["pass_1"]!="" && $_POST["pass_2"]!=""){
                if($_POST["pass_1"] == $_POST["pass_2"]){
                    if(!$uppercase || !$lowercase || !$number || $specialChar || strlen($password) < 8){
                        $kunci= "Password harus ada 8 karakter, harus memuat satu huruf kapital, angka, dan karakter spesial";
                    }else{
                        //$kunci = "Password Strong";
                        $Password = md5($password);
                        $query = "UPDATE master_peserta SET password ='$Password' WHERE email='$email'";
                        $result = mysqli_query($koneksi,$query);
                        // remove all session variables
                        session_unset();

                        // destroy the session
                        session_destroy();
                        $sukses =
                        '<div class="alert alert-success" role="alert">
                        Password berhasil diubah klik <a href="masuk.php" class="alert-link">link ini</a> untuk login
                        </div>';
                        //header("Location:masuk.php");                    
                    }
                }else{
                $sukses =
                '<div class="alert alert-danger" role="alert">
                Password tidak sama
                </div>';
                }
            }
        }
    }else{
        header("Location:input_email.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Password | Change Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<style>
#message {
    background: #f1f1f1;
    color: #000;
    padding: 5px;
    margin: 0px;
    margin-top: 8px;
}

#message p {
    padding: 0px 35px;
    font-size: 12px;
    text-align: center;
}

.valid {
    color: green;
}

.valid:before {
    position: relative;
    left: -10px;
    content: "\2713";
}

.invalid {
    color: red;
}

.invalid:before {
    position: relative;
    left: -10px;
    content: "\0D7";
}

#letter {
    float: left;
}

#number {
    float: left;
}
</style>

<body>

    <div class="container-login" style="background-image: url('images/bg08.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-45 p-b-30" style="min-height:95vh;">
            <div class="row justify-content-center"><?php echo $sukses;?></div>
            <form class="login-form validate-form" action="reset_pass.php" method="POST">

                <span class="login-form-title p-b-30">
                    Ganti Password
                </span>

                <span class="txt2">Masukkan Password Baru</span>
                <div class="wrap-input validate-input m-b-25" data-validate="Masukkan password baru">
                    <input class="input" type="text" name="pass_1" placeholder="" id="pass">
                    <span class="focus-input"></span>
                </div>
                <div id="message">
                    <p>Password harus terdiri dari: </p>
                    <p id="letter" class="invalid"><b>Huruf kecil</b></p>
                    <p id="capital" class="invalid"><b>Huruf besar</b></p>
                    <p id="number" class="invalid"><b>Nomor</b></p>
                    <p id="length" class="invalid"><b>8 karakter</b></p>
                    <p id="spechar" class="invalid" style="text-align:left;"><b>Karakter khusus</b>
                    </p>
                </div>

                <span class="txt2">Konfirmasi Password Baru</span>
                <div class="wrap-input validate-input m-b-25" data-validate="Konfirmasi password">
                    <input class="input" type="text" name="pass_2" placeholder="">
                    <span class="focus-input"></span>
                </div>

                <div class="container-login-form-btn p-t-15 p-b-40">
                    <button class="login-form-btn " name="submit">
                        Ganti
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- script java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    var myInput = document.getElementById("pass");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var spechar = document.getElementById("spechar");
    var length = document.getElementById("length");

    myInput.onblur = function() {
        document.getElementById("message").style.display = "block";
    }

    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        //specials character
        var spechars = /[!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?~]/;
        if (myInput.value.match(spechars)) {
            spechar.classList.remove("invalid");
            spechar.classList.add("valid");
        } else {
            spechar.classList.remove("valid");
            spechar.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
    </script>
</body>

</html>