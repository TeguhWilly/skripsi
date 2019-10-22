<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
// ambil semua tes_uraian yang tersedia dan belum dikerjakan oleh siswa ini
$sql = "select id_tes,nama_pelajaran,nama_tes,tanggal_tes,waktu_tes as waktu from tes_uraian where id_tes not in(select id_tes from jawaban where id_user='".$id_user."')" ;
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
if($jumlahBaris > 0){
	echo "<table class='data'>";
	echo "<caption>Daftar cek kemiripan teks</caption>";
	// buat header
	echo "<thead class='judul'><tr>";
	$jumlahKolom = mysql_num_fields($sqlExe);
	for($i = 0; $i < $jumlahKolom; $i++){
		echo "<th>".mysql_field_name($sqlExe,$i)."</th>";
		}
	echo "<th>Aksi</th>";	
	echo "</tr></thead>";	
	// tampilkan datanya
	echo "<tbody>";
	while($baris = mysql_fetch_array($sqlExe)){
		echo "<tr>";
		for($j = 0; $j < $jumlahKolom ; $j++){
			echo "<td>".$baris[$j]."</td>";
			}
		// buat link untuk mengerjakan ujian
		echo "<td><a class='link' href=kerjakan_tes.php?id_tes=".$baris[0]."&wkt=".$baris['4']." >Input</a></td>";	
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
	}
else {	
echo "Tidak ada daftar cek kemiripan teks";
}
?>
<script type="text/javascript" >
$(function(){
	$("a.link").click(function(){
		var url = $(this).attr("href");
		$("#content").html("Loading ..........").load(url);
		return false;
		})
	})
</script>
