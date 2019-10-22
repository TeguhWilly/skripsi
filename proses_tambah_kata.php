<?php
session_start();
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$data = $_REQUEST['data'];
for($i = 0; $i < count($data); $i++){
	$data_ar=$data[$i];
	foreach($data_ar as $id => $nil){
		if($id == 'value'){
		$nilai[]=$data_ar[$id];
		}
		else 
		$nama[]=$data_ar[$id];
	}
}
$nama_tabel = "kamus";
$data_nilai = buatStringNilai($nilai);
$data_nama = buatStringKolom($nama);	
$sql ="insert into ".$nama_tabel."(".$data_nama.") value (".$data_nilai.")";
$sql_exc = mysql_query($sql);
if($sql_exc){
$status = 1;
}
echo $status;
//echo $sql;
?>
