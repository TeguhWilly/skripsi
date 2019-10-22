<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
if(isset($_GET['id_user'])){
	$id_user = $_GET['id_user'];
	}
else {	
$id_user = $_SESSION['userId'];
}
$id_tes = $_REQUEST['id_tes'];
echo "<div class='judul'>Detail Jawaban Siswa dengan id_user $id_user</div>";
// ambil semua tes_uraian yang tersedia dan belum dikerjakan oleh siswa ini
$sql = "select soal.id_soal,isi_soal,jawaban,nilai,bobot_soal from soal,jawaban where soal.id_tes = jawaban.id_tes and soal.id_soal = jawaban.id_soal and id_user ='".$id_user."' and soal.id_tes='".$id_tes."'";
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
if($jumlahBaris > 0){
	// tampilkan soal
	$no_soal = 1;
	while($baris = mysql_fetch_array($sqlExe)){
	echo "<div class='tempat_soal'>";	
	echo "<div class='div_soal'><div class='judul_soal'style='padding-left:19px'>Soal ke ".$no_soal."<span class='bobot_soal'> Bobot Soal : ".$baris['bobot_soal']." ==> Nilai : ".$baris['nilai']."</span></div>";
	echo "<div  id='isi_soal".$baris['id_soal']."' class='isi_soal'>".$baris['isi_soal']."</div>";
	echo "<div class='jawaban' id='kunci".$baris['id_soal']."' >".$baris['jawaban']."</div>";
	echo "</div>";
	echo "<script>
	new nicEditor({iconsPath : 'js/nicEditorIcons.gif',buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','ol','ul','indent','outdent','removeformat']}).panelInstance('kunci".$baris['id_soal']."');
	</script>";
	echo "</div>";
	$no_soal++;
		}
	}
else {	
echo "Waduh durung gawe soal rek, kesusu ae ..........";
}
?>
<style>

.bobot_soal{
position:absolute;	
right:30px;
font-style:oblique;
font-weight:bolder;
}
.kunci_jawaban{
	padding:3px;
	}	
</style>
