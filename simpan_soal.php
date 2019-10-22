<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$data = $_REQUEST['data'];
$aksi = $_REQUEST['aksi'];
$id_tes = $data[0];
$id_soal = $data[1];
$isi_soal = $data[2];
$kunci_jawaban = $data[3];
$kunci_arr = implode(",",$data[4]);
$nilai_bobot = implode(",",$data[5]);
$bobot_soal = $data[6];
$urut = $data[7];
$jml_item_jawaban = $data[8];
// buat query berdasarkan aksi yang diberikan
if($aksi == "Simpan"){
	$sql = "insert into soal values('".$id_soal."','".$id_tes."','".$isi_soal."','";
	$sql .= $kunci_jawaban."','".$kunci_arr."','".$nilai_bobot."','".$bobot_soal."','".$urut."','".$jml_item_jawaban."')";
	}
else {
	$sql = "update soal set isi_soal='".$isi_soal."',";
	$sql .= "kunci_jawaban='".$kunci_jawaban."',kunci_jawaban_arr='".$kunci_arr."',bobot_kunci_arr='".$nilai_bobot."',bobot_soal='".$bobot_soal."'";
	$sql .=" ,urut ='".$urut."',jml_item_jawaban='".$jml_item_jawaban."' where id_tes ='".$id_tes."' and id_soal ='".$id_soal."'";
	}	
mysql_query($sql);
//echo $sql;
?>
