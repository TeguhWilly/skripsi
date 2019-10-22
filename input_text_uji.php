<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
// untuk pencarian
if(isset($_GET['cari'])){
	$cari = " and nama_tes like '%".$_GET['cari']."%'";
	}
else {
	$cari = "";
	}		
// ambil semua tes_uraian yang dibuat oleh user ini
$sql = "select * from tes_uraian where id_user='".$id_user."'".$cari;
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
echo "<div class='cari'><input type='text' onfocus='pilih_cari(this)' onblur='biar(this)' value='Nama tes' /><input type='image' width=24px onclick='cari_tes(this)' src='images/cari.jpg' /></div>";
if($jumlahBaris > 0){
	echo "<table class='data'>";
	echo "<caption>Daftar Tes Yang Dibuat</caption>";
	// buat header
	echo "<thead class='judul'><tr>";
	$jumlahKolom = mysql_num_fields($sqlExe);
	for($i = 0; $i < $jumlahKolom - 1; $i++){
		echo "<th>".mysql_field_name($sqlExe,$i)."</th>";
		}
	echo "<th colspan='2'>Aksi</th>";	
	echo "<th>Lihat tes</th>";
	echo "<th colspan='2'>Lihat Hasil</th>";
	echo "</tr></thead>";	
	// tampilkan datanya
	echo "<tbody>";
	while($baris = mysql_fetch_array($sqlExe)){
		echo "<tr>";
		for($j = 0; $j < $jumlahKolom - 1; $j++){
			echo "<td>".$baris[$j]."</td>";
			}
		// buat link untuk edit, hapus, tambah soal, preview
		echo "<td><a class='fancy' href=buat_tes.php?id_tes=".$baris[0].">Edit</a></td>";	
		echo "<td><a class='fancy' href=hapus_tes.php?id_tes=".$baris[0].">Hapus</a></td>";	
		echo "<td><a class='link' href=daftar_soal.php?id_tes=".$baris[0].">Lihat</a></td>";	
		echo "<td><a class='fancy' href=lihat_hasil_tes.php?id_tes=".$baris[0].">Lihat</a></td>";	
		echo "<td><a class='cetak' href=cetak_hasil_tes.php?id_tes=".$baris[0].">Cetak</a></td>";	
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
	}
else {	
echo "Tes uraian tidak ada";
}
?>
<script type="text/javascript" >
var loading = "<div class='loading'>Mohon ditunggu ...........</div>";
$(function(){
	$("a.link").click(function(){
		var url = $(this).attr("href");
		$("#content").load(url);
		return false;
		});
	$("a.fancy").click(function(e){
		e.preventDefault();
		var page = $(this).attr("href");
		var title = page.substr(0,page.indexOf("."));
		$("#lightbox-title > span").html(title);
		$("#lightbox-content").html("<div class='info'>Loading ...............</div>");
		$("#lightbox-content").load(page);
		$("#lightbox, #lightbox-panel").fadeIn(300);
		});
	$("a.cetak").click(function(e){
		e.preventDefault();
		var page = $(this).attr("href");
		window.open(page,"","height=500");
		})
	$("a#close-panel").click(function(){
	$("#lightbox, #lightbox-panel").fadeOut(300);
 })		
	})
	function cari_tes(elm){
	var yang_dicari = $(elm).prev().val();
	if(yang_dicari != "" && yang_dicari != "Nama tes"){
	$("#content").html(loading).load("lihat_tes.php?cari="+yang_dicari);
		}
	else {
		alert("diisi dong kolom carinya");
		}	
	}
	function biar(elm){
	if($(elm).val() == ""){
		$(elm).val("Nama tes");
		}
	}
	function pilih_cari(elm){
	$(elm).val("").select();
	}			
</script>
<style>
table.data{
	margin-top:15px;
	}
.cari{
	position:absolute;
	right:15px;
	top:9px;	
	padding:4px;
	v-align:center;
	display:inline;
	}	
.cari input{
	float:left;
	display:inline;
	height:22px;
	margin:0px 0px 0px 1px;
	}	
</style>
