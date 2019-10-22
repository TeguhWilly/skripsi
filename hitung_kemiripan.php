<?php
session_start();
include_once "include/koneksi.php";
include_once "include/stemmingArifin.php";
$daftar_kata = $_REQUEST['daftar_kata'];
$jawaban_siswa = $_REQUEST['jawaban'];
$id_soal = $_REQUEST['id_soal'];
$id_tes = $_REQUEST['id_tes'];
$id_user = $_SESSION['userId'];
// cari kata dasar untuk tiap kata dengan metode stemming_arifin
$kata_dasar_jawaban = array();
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
		$kata_dasar_jawaban[] = stemmingArifin($kata,$kamus_kata);	
		}
	}
// ambil yang unik aja	
$kata_dasar_jawaban = array_unique($kata_dasar_jawaban);	

// ambil kunci_jawaban dan bobot dari tabel soal
$sqlKunci = "select kunci_jawaban_arr,bobot_kunci_arr,bobot_soal,kunci_jawaban,urut,jml_item_jawaban from soal where id_soal='".$id_soal."' and id_tes='".$id_tes."'";	
$sqlKunciExe = mysql_query($sqlKunci);
$kunci = mysql_fetch_array($sqlKunciExe);
$kunci_jawaban = explode(",",$kunci['kunci_jawaban_arr']);
$bobot_jawaban = explode(",",$kunci['bobot_kunci_arr']);
$bobot_soal = $kunci['bobot_soal'];
$jml_item_jawaban = $kunci['jml_item_jawaban'];
/*--------------------------------------------------
hitung kemiripan array dengan jaro winckler distance
----------------------------------------------------*/
// cek kata yang sama dalam array
$kata_sama = array_intersect($kunci_jawaban,$kata_dasar_jawaban);
/*---------------------------------------------------------------
 * cek sinonim untuk kata yang tidak sama, bila ditemukan masukkan ke dalam kata_sama
 * dan ganti kata tersebut dengan sinonimnya
 ---------------------------------------------------------------*/ 

$kunci_tidak_sama = array_diff($kunci_jawaban,$kata_sama);
$jawaban_tidak_sama = array_diff($kata_dasar_jawaban,$kata_sama);
// anggaplah setiap kata hanya memiliki satu sinonim aja

foreach ($jawaban_tidak_sama as $i => $tidak_sama){
	$query = "select sinonim from kamus where kata='".$tidak_sama."'";
	$sinonim = mysql_result(mysql_query($query),0);
	if($sinonim != null){
		if(in_array($sinonim,$kunci_tidak_sama)){
			// masukkan kedalam array kata_sama
			array_push($kata_sama,$sinonim);
			// ganti kata dalam jawaban tidak sama dengan sinonim
			$jawaban_tidak_sama[$i] = $sinonim;
			}
		}
	}

// buat array baru yang menyimpan kata yang sama aja untuk kunci jawaban dan jawaban untuk menghitung transposisi
$kunci_jawaban_sama = array();
$kata_dasar_jawaban_sama = array();
foreach($kata_sama as $kata){
	$index_kunci = array_search($kata,$kunci_jawaban);
	$index_jawaban = array_search($kata,$kata_dasar_jawaban);
	$kunci_jawaban_sama[$index_kunci] = $kata;
	$kata_dasar_jawaban_sama[$index_jawaban] = $kata;
	}

// hitung transposisi, tapi urutkan dulu array berdasarkan indexnya dengan ksort
ksort($kunci_jawaban_sama);
ksort($kata_dasar_jawaban_sama);
// bangun ulang index dari kata_dasar_jawaban_sama agar indexnya jadi 0,1,2 dst
$kata_dasar_jawaban_sama_new = array();
$index = 0;
foreach($kata_dasar_jawaban_sama as $kata){
	$kata_dasar_jawaban_sama_new[$index] = $kata;
	$index++; 
	}

// variabel $t untuk menghitung transposisi
$t = 0;
$i = 0;
$l = 0;
$m_bobot = 0;
foreach($kunci_jawaban_sama as $index => $kata){
	if($kata != $kata_dasar_jawaban_sama_new[$i]){
		$t++;
		}
	// increment l hanya jika l = i, untuk menghitung jumlah kata awal yang sama
	else {
		if($l == $i) $l++;
		}	
		$i++;
		// bila menggunakan pembobotan kata pake ini sebagai nilai $m
		$m_bobot += $bobot_jawaban[$index];
	}
/*--------------------------------------------------
hitung kemiripan dengan jaro winckler distance
* rencana 1, abaikan bobot kata dan transposisi
* rencana 2, gunakan bobot kata dan abaikan transposisi
* rencana 3, gunakan bobot kata dan transposisi
* dj = 1/3((m/s1)+(m/s2)+(m-t)/m)
----------------------------------------------------*/
$m = count($kata_sama);
$s1 = count($kunci_jawaban);
$s2 = count($kata_dasar_jawaban);
$t = (int) $t/2;

// hitung $s1_bobot, untuk rencana 2 dan 3
	$s1_bobot = 0;
	foreach($bobot_jawaban as $nilai){
		$s1_bobot += $nilai;
		}
	// panjang jawaban - panjang kata_dasar_jawaban_sama + m_bobot
	$s2_bobot = count($kata_dasar_jawaban) - count($kata_dasar_jawaban_sama) + $m_bobot;
// jika jml_item_jawaban di set maka jadikan panjang maksimals1 dan s2 serta kata yang sama = jml_item_jawaban
if($jml_item_jawaban != "" || $jml_item_jawaban > 0){
$m = $jml_item_jawaban	< $m ? $jml_item_jawaban : $m;
$m_bobot = $jml_item_jawaban < $m_bobot ? $jml_item_jawaban : $m_bobot;
/*
$s1 = $jml_item_jawaban	< $s1 ? $jml_item_jawaban : $s1;
$s2 = $jml_item_jawaban	< $s2 ? $jml_item_jawaban : $s2;
$s1_bobot = $jml_item_jawaban < $s1_bobot ? $jml_item_jawaban : $s1_bobot;
$s2_bobot = $jml_item_jawaban < $s2_bobot ? $jml_item_jawaban : $s2_bobot;
*/
$s1 = $s2 = $s1_bobot = $s2_bobot = $jml_item_jawaban; 
}
// rencana 1, jadikan set nilai $t = 0, karena diabaikan
if($m == 0){
	$dj_1 = 0;
	}
else {
	$dj_1 = (1/3) * ($m/$s1 + $m/$s2 + ($m - 0)/$m);	
	}
// rencana 2, jadikan set nilai $t = 0, karena diabaikan
if($m_bobot == 0){
	$dj_2 = 0;
	}
else {
	$dj_2 = (1/3) * (($m_bobot/$s1_bobot) + ($m_bobot/$s2_bobot) + (($m_bobot - 0)/$m_bobot));	
	}
// rencana 3, perhatikan tranposisi dan bobot kata
if($m_bobot == 0){
	$dj_3 = 0;
	}
else {
	$dj_3 = (1/3) * (($m_bobot/$s1_bobot) + ($m_bobot/$s2_bobot) + (($m_bobot - $t)/$m_bobot));	
	}	
/*------------------------------------------
 * hitung dw, nilai winckler
 * dw = dj+(lp(1 - dj)), p = 0.1
 *------------------------------------------*/ 	
 $l = ($l >= 4) ? "4" : $l;
 $dw_1 = $dj_1 + ($l * 0.1 * (1 - $dj_1));
 $dw_2 = $dj_2 + ($l * 0.1 * (1 - $dj_2));
 $dw_3 = $dj_3 + ($l * 0.1 * (1 - $dj_3));
/*
echo "Nilai jaro winkler tanpa menggunakan bobot kata dan transposisi <br />";
$nilai_siswa_1 = $dw_1 * $kunci['bobot_soal'];
echo "Nilai jaro winkler distance = ".$dw_1." dan bobot_soal =".$kunci['bobot_soal']."<br />";
echo "Nilai siswa_1 = <b>".$nilai_siswa_1."</b> <br /><br />";
echo "Nilai jaro winkler tanpa memperhatikan transposisi <br />";
$nilai_siswa_2 = $dw_2 * $kunci['bobot_soal'];
echo "Nilai jaro winkler distance = ".$dw_2." dan bobot_soal =".$kunci['bobot_soal']."<br />";
echo "Nilai siswa_2 =<b>".$nilai_siswa_2."</b> <br /><br />";
echo "Nilai jaro winkler dengan menggunakan bobot kata dan transposisi <br />";
*/
// jika urut  = 1 gunakan $dw_3, jika tidak gunaka $dw_2
if($kunci['urut'] == "1"){
	$dw_akhir = $dw_3;
	}
else{
	$dw_akhir = $dw_2;	
	}
$nilai_siswa = $dw_akhir * $kunci['bobot_soal'];
echo "bobot sama =".$m_bobot." panjang s1=".$s1." panjang s2=".$s2;
echo "Nilai jaro winkler distance = ".$dw_akhir." dan bobot_soal =".$kunci['bobot_soal']."<br />";
echo "Nilai siswa = <b> ".$nilai_siswa."</b>";
echo "<br />"; 
echo "Jawaban anda :<br />".$jawaban_siswa;

echo "<br />"; 
echo "Kunci jawaban :<br />".$kunci['kunci_jawaban'];
//echo "<br />Nilai anda : ".$nilai_siswa_3;
// simpan nilainya di database dalam tabel jawaban
$sql_simpan = "insert into jawaban values('".$id_soal."','".$id_user."','".$jawaban_siswa."','".implode(',',$kata_dasar_jawaban)."','".$nilai_siswa."','".$id_tes."')";
$sql_simpan_exe = mysql_query($sql_simpan);
//echo $sql_simpan;
?>
