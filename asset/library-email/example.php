<form action="" method="post">
  <button type="submit" name="submit">Click Me</button>
</form>

<?php
	require_once('function.php');
	if(isset($_POST['submit']))
	{
      try{
       	$to       = 'in.pro1407@gmail.com';
    	$subject  = 'Subject Pengiriman Email Uji Coba';
    	$message  = '<p>Isi dari Email Testing</p>';
        $headers = 'From: nonreply@in-pro.web.id';
    	smtp_mail($to, $subject, $message, $headers, '', 0, 0, true);
      }
      catch(Exception $e){
        echo 'error';
      }
   
    
    /*
      jika menggunakan fungsi mail biasa : mail($to, $subject, $message);
      dapat juga menggunakan fungsi smtp secara dasar : smtp_mail($to, $subject, $message);
      jangan lupa melakukan konfigurasi pada file function.php
    */
	}
?>