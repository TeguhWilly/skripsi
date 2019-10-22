<?php
session_start();
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
// cek username dan password
$sql = "select username,level from user where username ='".$username."' and password ='".md5($password)."'";
$sqlExe = mysql_query($sql);
$jumBaris = mysql_num_rows($sqlExe);
if($jumBaris > 0){
	// ambil nama dari tabel siswa / guru
	$data = mysql_fetch_array($sqlExe);
	if($data['level'] == 1) {$tabel = "siswa";}
	else $tabel = "guru";
	$nama_user = mysql_result(mysql_query("select nama from $tabel where id_user ='$username'"),0);
// set session untuk id_user, nama
	$_SESSION['nama'] = $nama_user;
	$_SESSION['userId'] = $username;
	$_SESSION['level'] = $data['level'];
	}
else {
	$data['level'] = "gagal login";
	}	
echo $data['level'];
//echo $sql;
?>
