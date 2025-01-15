<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailerv6/librarysmtp/autoload.php';

//Create an instance; passing `true` enables exceptions

function smtp_mail($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug=false) {
  $mail = new PHPMailer(true);
  //$mail->SMTPDebug = $debug; // Ubah menjadi true jika ingin menampilkan sistem debug SMTP Mailer
  $mail->isSMTP();
  
  // Hapus Semua Tujuan, CC dan BCC
  $mail->ClearAddresses();  
  $mail->ClearCCs();
  $mail->ClearBCCs();

  /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */
  
 $mail->SMTPAuth = true;
    $mail->Host = 'mail.in-pro.web.id'; // Masukkan Server SMTP
    $mail->Port = '587'; // Masukkan Port SMTP 587
    $mail->SMTPSecure = 'tls'; // Masukkan Pilihan Enkripsi ( `tls` atau `ssl` )
    $mail->Username = 'nonreply@in-pro.web.id'; // Masukkan Email yang digunakan selama proses pengiriman email via SMTP
    $mail->Password = ''; // Masukkan Password dari Email tsb
    $default_email_from = 'nonreply@in-pro.web.id'; // Masukkan default from pada email
    $default_email_from_name = 'IF UKDC'; // Masukkan default nama dari from pada email
  
  /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */
  
  if(empty($from)) $mail->From = $default_email_from;
  else $mail->From = $from;

  if(empty($from_name)) $mail->FromName = $default_email_from_name;
  else $mail->FromName = $from_name;
  
  // Set penerima email
  if(is_array($to)) {
    foreach($to as $k => $v) {
      $mail->addAddress($v);
    }
  } else {
    $mail->addAddress($to);
  }
  
  
  // Set isi dari email
  $mail->isHTML(true);
  $mail->Subject 	= $subject;
  $mail->Body 	  = $message;
  $mail->AltBody	= $message;
  if(!$mail->send())
    return 1;
  else
    return 0;
}

?>