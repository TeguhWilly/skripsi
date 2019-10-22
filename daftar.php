<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
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
$username = $nilai[0];
$password = $nilai[1];
$nama = $nilai[2];
$alamat = $nilai[3];
$agama = $nilai[4];
// insert ke tabel user dan tabel siswa
$sql ="insert into siswa value ('".$username."','".$nama."','".$alamat."','".$agama."')";
$sql_exc = mysql_query($sql);
if($sql_exc){
// insert data ke tabel user
$sqlUser ="insert into user (username,password) value ('".$username."','".md5($password)."')";
$sqlUserExe = mysql_query($sqlUser);
if($sqlUserExe){
	$status = 1;
	}
}
echo $status;
//echo $sql;
?>
