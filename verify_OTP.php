<?php
include 'koneksi.php';
session_start();
$sukses = '';
if ($_SESSION['email'] != '') {
    $sukses = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Verifikasi email berhasil, silahkan cek email untuk kode OTP
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
} else {
    header('Location:input_email.php');
}
if (isset($_POST['authenticate'])) {
    $otp = null;
    $digit1 = $_POST['digit-1'];
    $digit2 = $_POST['digit-2'];
    $digit3 = $_POST['digit-3'];
    $digit4 = $_POST['digit-4'];
    $digit5 = $_POST['digit-5'];
    $digit6 = $_POST['digit-6'];
    $otp = "$digit1$digit2$digit3$digit4$digit5$digit6";
    if ($otp == null) {
        $sukses = "<div class='alert alert-danger'>Masukkan kode OTP</div>";
    } else {
        $sqlQuery =
            "SELECT * FROM tb_authentication WHERE otp='" .
            $otp .
            "' AND expired!=1 AND NOW() <= DATE_ADD(created, INTERVAL 1 HOUR)";
        $result = mysqli_query($koneksi, $sqlQuery);
        $count = mysqli_num_rows($result);
        if (!empty($count)) {
            $sqlUpdate =
                "UPDATE tb_authentication SET expired = 1 WHERE otp = '" .
                $_POST['otp'] .
                "'";
            $result = mysqli_query($koneksi, $sqlUpdate);
            header('Location:reset_pass.php');
        } else {
            $sukses =
                "<div class='alert alert-danger'>Kode OTP tidak valid</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Password | Verif OTP</title>
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
#digit-group {
    width: 100%;
    justify-content: center;
    display: flex;
    flex-wrap: wrap;
    margin: 15px 0;
}

.otp {
    width: 10%;
    height: 50px;
    line-height: 50px;
    text-align: center;
    font-size: 24px;
    margin: 0 5px;
    border-radius: 8px;
}

.otp:focus {
    box-shadow: 0 0 5px darkblue;
}
</style>

<body>

    <div class="container-login" style="background-image: url('images/bg08.jpg');">
        <div class="wrap-login p-l-55 p-r-55 p-t-50 p-b-50" style="min-height:95vh;">
            <div class="text-center"><?php echo $sukses; ?></div>
            <form class="login-form validate-form text-center" action="verify_OTP.php" method="POST" name="digits"
                data-autosubmit="false" autocomplete="off">

                <span class="login-form-title p-b-30">
                    Kode OTP
                </span>
                <span class="txt2">Masukkan Kode OTP</span>
                <div id="digit-group">
                    <input class="otp" type="text" id="digit-1" name="digit-1" data-next="digit-2"
                        onkeypress="return isNumber(event)" autocomplate="off" />
                    <input class="otp" type="text" id="digit-2" name="digit-2" data-next="digit-3"
                        data-previous="digit-1" onkeypress="return isNumber(event)" />
                    <input class="otp" type="text" id="digit-3" name="digit-3" data-next="digit-4"
                        data-previous="digit-2" onkeypress="return isNumber(event)" />

                    <input class="otp" type="text" id="digit-4" name="digit-4" data-next="digit-5"
                        data-previous="digit-3" onkeypress="return isNumber(event)" />
                    <input class="otp" type="text" id="digit-5" name="digit-5" data-next="digit-6"
                        data-previous="digit-4" onkeypress="return isNumber(event)" />
                    <input class="otp" type="text" id="digit-6" name="digit-6" data-previous="digit-5"
                        onkeypress="return isNumber(event)">

                </div>
                <div class="container-login-form-btn p-t-15 p-b-40">
                    <button class="login-form-btn" name="authenticate">
                        verifikasi
                    </button>
                </div>
            </form>
            <form method="POST" action="verify_OTP.php" id="digit-group">

            </form>
        </div>
        <div>
        </div>
    </div>


    <!-- script java script -->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    $('#digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));
                if (prev.length) {
                    $(prev).select();
                }
            } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) ||
                e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));
                if (next.length) {
                    $(next).select()
                } else {
                    if (parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    </script>
</body>

</html>