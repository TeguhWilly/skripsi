<?php
include_once "cek_session.php";
include_once "include/koneksi.php";
// jika id_tes diset berarti akan melakukan edit tes
if(isset($_GET['id_tes'])){
	$data_hidden = "<input type='hidden' name='id_tes' value='".$_GET['id_tes']."' />";
	// ambil data dari mysql
	$sql = "select * from tes_uraian where id_tes='".$_GET['id_tes']."' and id_user='".$_SESSION['userId']."'";
	$sql_exe = mysql_query($sql);
	if($sql_exe){
		$data = mysql_fetch_array($sql_exe);
		$id_tes = $data['id_tes'];
		$tanggal_tes = $data['tanggal_tes'];
		$waktu_tes = $data['waktu_tes'];
		$nama_tes = $data['nama_tes'];
		$nama_pelajaran = $data['nama_pelajaran'];
		}	
	}
	else {
		$data_hidden = "";
		$id_tes ="";
		$tanggal_tes = "";
		$waktu_tes = "";
		$nama_tes = "";
		$nama_pelajaran="";
		}
?>

<div class="judul" style="text-transform : uppercase;">Buat Tes Plagiat</div>
<div style="margin:10px">
<form action="proses_buat_tes.php">
<dl>
	<dt>
		<?php
		// hanya untuk update saja
		echo $data_hidden;
		?>
		<label>Nama Pelajaran</label>
	</dt>
	<dd>
		<select name="nama_pelajaran">
			<option value="0">Pilih dulu</option>
			<option>Agama</option>
			<option>Biologi</option>
			<option>TIK</option>
			<option>Fisika</option>
			<option>IPS</option>
			<option>Kimia</option>
		</select>
	</dd>
	<dt>
		<label>Nama Tes</label>
	</dt>
	<dd>
		<input name="nama_tes" type="text" size="50" value="<?php echo $nama_tes ?>" />
	</dd>
	<dt>
		<label>Tanggal Tes</label>
	</dt>
	<dd>
		<input name="tanggal_tes" id="tanggal_tes" type="text" readonly value="<?php echo $tanggal_tes ?>" />
	</dd>
	<dt>
		<label>Waktu</label>
	</dt>
	<dd>
		<input name="waktu_tes" type="text" size=12 value="<?php echo $waktu_tes ?>" /><input name="id_user" type="hidden" value="<?php echo $_SESSION['userId'] ?>" />
		<span style="font-size:80%;position:relative;top:-18px;left:70px;">Menit</span>
	</dd>
	<dt></dt>
	<dd>
		<input value="simpan" type="submit" />
	</dd>	
</dl>	
</form>	
</div>
<div class="clear"></div>
<script>
$(function(){
	// set kalender
	calendar.set("tanggal_tes");
	// event ketika tombol submit diklik
	$("form").submit(function(){
		var url = $(this).attr("action");
		 var data = $(this).serializeArray();
		$.post(url,{data:data},function(hasil){
			if(hasil == 1){
				// cek apakah update ato insert
				if($("#lightbox").is(":visible")){
					$("form").parent().html("<h2>Data telah disimpan..........</h2>");
					// hapus lightbox
					$("#lightbox, #lightbox-panel").fadeOut(3000);
					}
				// ubah isi dari div content ke menu lihat tes
				$("#content").load("lihat_tes.php");
				}
			})
		return false;
		});
	// set	option untuk edit tes
	var nama_pelajaran="<?php echo $nama_pelajaran ?>";
	$("select").val(nama_pelajaran);
// buat uppercase ketika input di blur
$("input").blur(function(){
	var nilai = $(this).val();
	$(this).val(nilai.toUpperCase());
	})
})
</script>

