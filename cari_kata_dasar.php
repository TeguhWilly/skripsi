<?php
include_once "include/koneksi.php";
include_once "include/stemmingArifin.php";
$daftar_kata = $_REQUEST['daftar_kata'];
// cari kata dasar untuk tiap kata dengan metode stemming_arifin
$kataDasarTerpilih = array();
foreach($daftar_kata as $kata){
	$kataDasar = cariKataDasar($kata);
	// buat query untuk menghasilkan semua kata yang mengandung kata hasil pemotongan AW dan AKH
	// cari semua kemungkinan kata dasar dg struktur 0/1 karakter + katadasat+0/1 karakter
//	$sql = "select distinct kata from kamus where kata regexp '^.?".$kataDasar.".?$'";
	$sql = "select distinct kata from kamus where kata regexp '^.*".$kataDasar.".*$'";
	$sqlExe = mysql_query($sql);
	if($sqlExe){
		$kamus_kata= array();
		while($baris = mysql_fetch_array($sqlExe)){
			$kamus_kata[] =$baris[0];	
			}
		// hasilkan kata dasar	
		$kataDasarTerpilih[] = stemmingArifin($kata,$kamus_kata);	
		}
	}
//  pilih kata yang unik aja
$kataDasarTerpilih = array_unique($kataDasarTerpilih);	
echo json_encode($kataDasarTerpilih);	
?>
