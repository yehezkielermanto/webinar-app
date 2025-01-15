<?php
 if (isset($_GET['l'])  )  {
    $filename    =  $_GET['l'];
    $back_dir    ="asset/materi/";
    $file = $back_dir.$filename;
//     echo "$file";
//     die;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: private');
        header('Pragma: private');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        header("location:beranda.php");
        exit;
    }
    else {
        // $_SESSION['pesan'] = "Oops! File - $filename - not found ...";
        header("location:beranda.php");
    }
}
?>