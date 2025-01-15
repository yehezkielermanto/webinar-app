<?php 
    session_start();
    include "koneksi.php";
	include("asset/library-email/function.php");

	$error = null;
    if(isset($_POST["submit"])){
        if(!empty($_POST["email"])){
            try{
                $_SESSION["email"] = $_POST["email"];
                $email = $_POST["email"];
                $sql = "SELECT * FROM master_peserta WHERE email = '$email'";
                $result = $koneksi->query($sql);
                if($result->num_rows >0){
                    $otp = rand(100000, 999999);
                    
                    $headers = "FROM: nonreply@in-pro.web.id" . "\r\n";
                                    
                    $messageBody = "<div style='width : 550px;
                    border : 2px solid black;
                    margin : 20px auto;'>
                        <div style='border-bottom : 2px solid black;'>
                            <center><img src = 'https://drive.google.com/uc?id=1cTPc2fgt_RY78klrt6m3mSRnXtdRSAQD' alt = 'DC Informatics' width = '550' height = '175'></center>
                        </div>
                        <p style='text-align:center; padding-top:15px;'>Kode (One Time Password) OTP anda:</p> 
                        <h1  style='font-family : sans-serif;
                        text-align : center;'> $otp
                        </h1>
                        <br>
                        <p style='text-align:center;'>Harap masukkan kode OTP kurang dari 1 jam</p>
                        <br>
                        <br>
                        <p style='font-size : 12px;
                        font-family : sans-serif;
                        text-align : center;''> &copy; DC Informatics </p>
                    </div>";
                    $subject = "Kode OTP untuk Reset Kata Sandi";
                    //$mailStatus = smtp_mail($email, $subject, $messageBody, $headers,0,0,true);
                    //smtp_mail($email, $subject, $messageBody, '', '', 0, 0, true);
                    if(smtp_mail($email, $subject, $messageBody, '', '', 0, 0, true) == 0){
                        $insertQuery = "INSERT INTO tb_authentication (otp,expired,created) VALUES('".$otp."',0,'".date("Y-m-d H:i:s")."')";
                        $result = mysqli_query($koneksi, $insertQuery);
                        header("location:verify_OTP.php");   
                    }else{
                        //print_r(error_get_last());
                        $error = '<div class="alert alert-danger text-center" role="alert">
                            Ada kesalahan, silahkan hubungi Admin
                            </div>';
                    
                    }
                }else{
                    $error = '<div class="alert alert-danger text-center" role="alert">
                            Email tidak terdaftar.
                            </div>';
                }
            }catch(Exception $e){
                echo '<div class="alert alert-danger text-center" role="alert">
                            Terjadi Kesalahan sistem, segera laporkan ke IT Support.
                            </div>';
            }
        }
    }    
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Verifikasi Email</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="shortcut icon" href="images/logo_if.png">
</head>
<body>

	<div class="container-login" style="background-image: url('images/bg08.jpg');">
		<div class="wrap-login p-l-55 p-r-55 p-t-50 p-b-50" style="min-height:95vh;">
			<div><?php echo $error;?></div>
			<form class="login-form validate-form" action="lupa_pass.php" method="POST">
				
				<span class="login-form-title p-b-30">
					Verifikasi Email
				</span>

				<span class="txt2">Masukkan Email</span>
				<div class="wrap-input validate-input m-b-25" data-validate = "Masukkan Email">
					<input class="input" type="email" name="email" placeholder="">
					<span class="focus-input"></span>
				</div>

				<div class="container-login-form-btn p-t-15 p-b-40">
					<button class="login-form-btn " name="submit">
						verifikasi
					</button>
				</div>

				<div class="text-center">
					<a href="masuk.php" class="txt2 hov1">
						< kembali
					</a>
				</div>
			</form>

			
		</div>
	</div>

	<!-- script java script -->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>