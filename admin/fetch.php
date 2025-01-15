<?php
//fetch.php
$connect = mysqli_connect("localhost", "ifukdcco", "hhR2I2n2k2", "ifukdcco_webinar");
$column = array("peserta_event.id_peserta_event", "peserta_event.id_peserta", "master_event.id_event", "peserta_event.absen");
$query = "
 SELECT * FROM peserta_event 
 INNER JOIN master_event 
 ON master_event.id_event = peserta_event.id_event 
";
$query .= " WHERE ";
if(isset($_POST["is_category"]))
{
 $query .= "peserta_event.id_event = '".$_POST["is_category"]."' AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(peserta_event.id_peserta_event LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR peserta_event.id_peserta LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR master_event.id_event LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR peserta_event.absen LIKE "%'.$_POST["search"]["value"].'%") ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY peserta_event.id_peserta_event DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
 $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["id_peserta_event"];
 $sub_array[] = $row["id_peserta"];
 $sub_array[] = $row["id_event"];
 $sub_array[] = $row["absen"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM peserta_event";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>