<?php
session_start();
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
$status = 0;
if(isset($_POST['id_tes']) && isset($_POST['id_soal']) && isset($_POST['hapus'])){
	$sql = "delete from soal where id_tes='".$_POST['id_tes']."' and id_soal='".$_POST['id_soal']."'";
	$sqlExe = mysql_query($sql);
	if($sqlExe){
		$status = 1;
		}
	echo $status;		
	}
else {
	echo "<div style='text-align:center;font-size:1.5em;font-style:oblique'><p>Apakah anda yakin akan menghapus soal dengan id_tes = ".$_GET['id_soal']."<br />";
	echo "<input type='button' value='Sangat Yakin' onclick='hapus()'/>&nbsp;&nbsp;<input type='button' value='Tidak Yakin' onclick='batal()'/></p></div>";	
?>
<script type="text/javascript" >
var id_tes = "<?php echo $_GET['id_tes'] ?>";
var id_soal = "<?php echo $_GET['id_soal'] ?>";
function hapus(){
	$.post("hapus_soal.php",{id_tes:id_tes,id_soal:id_soal,hapus:"1"},function(hasil){
		if(hasil == 1){
			$("#lightbox-content").html("<h2>Data telah dihapus..........</h2>");
			$("#lightbox, #lightbox-panel").fadeOut(2000);
			// ubah isi dari div content ke menu lihat tes
				$("#content").load("daftar_soal.php?id_tes="+id_tes);
			}
		})
	}
function batal(){
	$("#lightbox, #lightbox-panel").fadeOut(1000);
	}	
</script>
<?php
}
?>
