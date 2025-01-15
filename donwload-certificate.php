<?php
 if (isset($_GET['l']) & isset($_GET['e']) )  {
    $filename    =  $_GET['l'];
    $back_file = $_GET['e'];
    $back_dir    ="asset/tsps/";
    $file = $back_dir.$back_file."/".$filename;
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
        header("location:sertifikat.php");
        exit;
    }
    else {
        // $_SESSION['pesan'] = "Oops! File - $filename - not found ...";
        header("location:sertifikat.php");
    }
}
?>
