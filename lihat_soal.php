<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
$id_tes = $_REQUEST['id_tes'];
$id_soal = $_REQUEST['id_soal'];
// ambil soal ini saja
$sql = "select id_soal,isi_soal,bobot_soal from soal where id_tes='".$id_tes."' and id_soal='".$id_soal."'";
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
if($jumlahBaris > 0){
	// tampilkan soal
	while($baris = mysql_fetch_array($sqlExe)){
	echo "<div class='tempat_soal'>";	
	echo "<div class='div_soal'><div class='judul_soal' style='padding-left:19px'>Soal ke ".$baris['id_soal']."<span class='bobot_soal'> Bobot Soal : ".$baris['bobot_soal']."</span></div>";
	echo "<div  id='isi_soal".$baris['id_soal']."' class='isi_soal'>".$baris['isi_soal']."</div>";
	echo "<div class='jawaban' id='kunci".$baris['id_soal']."' >tulis jawaban disini</div>";
	echo "<div><button>Simpan</button></div>";
	echo "</div>";
	echo "<script>
	new nicEditor({iconsPath : 'js/nicEditorIcons.gif',buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','ol','ul','indent','outdent','removeformat']}).panelInstance('kunci".$baris['id_soal']."');
	</script>";
	echo "</div>";	
		}
	}
else {	
echo "Waduh durung gawe soal rek, kesusu ae ..........";
}
?>
<style>
.div_soal,.judul_soal{
	border-radius:3px;
	}
.kunci_jawaban{
	padding:3px;
	}
.bobot_soal{
position:absolute;	
right:30px;
font-style:oblique;
font-weight:bolder;
}	
</style>
