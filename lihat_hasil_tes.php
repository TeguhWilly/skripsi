<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
/*-------------------------------------------------------------------------------------
 Lihat nilai tes, bila level siswa maka akan melihat semua hasil ujiannya sendiri
 jika guru ( level = 0 ) maka akan melihat semua nilai siswa dalam tes yang dibuat
-------------------------------------------------------------------------------------*/
$id_user = $_SESSION['userId'];
$level = $_SESSION['level'];
if($level == 0){
$id_tes = $_REQUEST['id_tes'];	
// ambil semua nilai tes_uraian yang dibuat oleh guru ini
$sql = "select id_tes,id_user,nama_pelajaran as mata_pelajaran,nama_tes,nama as nama_siswa,nilai from v_nilai_tes_per_siswa where id_tes ='".$id_tes."'";
}
else {
// ambil semua nilai tes_uraian yang telah dikerjakan oleh siswa ini
$sql = "select id_tes,nama_pelajaran,nama_tes,nilai from v_nilai_tes_per_siswa where id_user ='".$id_user."'";
}
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
echo "<div style='margin:5px'>";
if($jumlahBaris > 0){
	echo "<table class='data'>";
	echo "<caption>Daftar Nilai Tes Yang Telah Dikerjakan</caption>";
	// buat header
	echo "<thead class='judul'><tr>";
	echo "<th>NO</th>";
	$jumlahKolom = mysql_num_fields($sqlExe);
	for($i = 0; $i < $jumlahKolom; $i++){
		echo "<th>".mysql_field_name($sqlExe,$i)."</th>";
		}
	echo "<th>Aksi</th>";	
	echo "</tr></thead>";	
	// tampilkan datanya
	echo "<tbody>";
	$no = 1;
	while($baris = mysql_fetch_array($sqlExe)){
		echo "<tr>";
		echo "<td>".$no."</td>";
		for($j = 0; $j < $jumlahKolom ; $j++){
			echo "<td>".$baris[$j]."</td>";
			}
		// buat link untuk melihat detail jawaban siswa berdasarkan level
		if($level == 0)	{
			echo "<td><a class='link' href=detail_jawaban.php?id_tes=".$baris[0]."&id_user=".$baris[1]." >Detail jawaban</a></td>";		
			}
		else {	
			echo "<td><a class='link' href=detail_jawaban.php?id_tes=".$baris[0]." >Detail jawaban</a></td>";	
		}
		echo "</tr>";
		$no++;
		}
	echo "</tbody>";
	echo "</table>";
	}
else {	
echo "Tes uraian tidak ada untuk saat ini";
}
echo "</div>";
?>
<script type="text/javascript" >
	$(function(){
	// ini untuk fancy, hanya untuk tag a
	$("a.link").click(function(e){
		e.preventDefault();
		var page = $(this).attr("href");
		/*
		var title = page.substr(0,page.indexOf("."));
		var tinggi = $(window).height();
		$("#lightbox-title > span").html(title);
		$("#lightbox-content").html("<div class='info'>Loading ...............</div>");
		$("#lightbox-content").load(page);
		$("#lightbox, #lightbox-panel").fadeIn(300);
		});
	$("a#close-panel").click(function(){
	$("#lightbox, #lightbox-panel").fadeOut(300);
	*/
	$("#lightbox, #lightbox-panel").fadeOut(1300);
	$("#content").html("Loading ................").load(page);
 })		
})
</script>	
