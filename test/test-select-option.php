<?php 
    include "../koneksi.php";
    
        $result = $koneksi->query("SELECT judul,id_event FROM master_event WHERE status=1");
    echo "<html>";
    echo "<body>";
    echo "<select name='workers'>";
    while ($row = $result->fetch_assoc()) {
     
        $id_event = $row['id_event'];
        $judul = $row['judul'];
        echo '<option value=" '.$id_event.'"  >'.$id_event.'</option>';
    }
    echo "</select>";
    echo "</body>";
    echo "</html>";
?>