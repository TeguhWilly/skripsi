<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_soal = $_REQUEST['id_soal'];
$id_tes = $_REQUEST['id_tes'];
// ambil soal tes_uraian yang dipilih
$sql = "select isi_soal,kunci_jawaban,kunci_jawaban_arr,bobot_kunci_arr,bobot_soal,urut,jml_item_jawaban from soal where id_soal='".$id_soal."' and id_tes='".$id_tes."'";
$sqlExe = mysql_query($sql);
$data = mysql_fetch_array($sqlExe);
if($data['urut'] == "1"){
	$checked = "checked";
	}
else {
	$checked = "";
	}	
echo "<div class='tempat_soal'>";	
	echo "<div class='div_soal'><div class='judul_soal' style='padding-left:19px'>Soal ke ".$id_soal."</div>";
	echo "<div class='bobot_soal'>Masukkan nilai bobot soal <input class='i_bobot_soal' type='text' value='".$data['bobot_soal']."' size='1' /><span class='peringatan'></span>";
	echo "<label class='l_jml_item'>Jumlah item jawaban yang diharapkan</label><input type='text' value='".$data['jml_item_jawaban']."' class='jml_item'/><span class='urut'><input class='i_urut' type='checkbox' $checked /><label>Harus urut</label></span></div>";
	echo "<div  id='isi_soal".$data['id_soal']."' class='isi_soal'>".$data['isi_soal']."</div>";
	echo "<div class='kunci_jawaban' id='kunci".$data['id_soal']."' >".$data['kunci_jawaban']."</div>";
	echo "<div class='kunci_arr'></div>";
//	echo "<div class='jawaban' id='kunci".$baris['id_soal']."' >tulis jawaban disini</div>";
	echo "<div><button class='proses' onclick='proses(this)'>Proses</button><input type='button' id='update' value='Update' /></div>";
	echo "</div>";
	echo "<script>
	new nicEditor({fullPanel : true,iconsPath : 'js/nicEditorIcons.gif',uploadURI:'include/nicUpload.php'}).panelInstance('isi_soal'".$baris['id_soal'].");
	new nicEditor({iconsPath : 'js/nicEditorIcons.gif',buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','ol','ul','indent','outdent','removeformat']}).panelInstance('kunci".$baris['id_soal']."');
	</script>";
	echo "</div>";	 
?>
</script>
</div>
<script type="text/javascript">
$(function(){
	var id_tes = "<?php echo $id_tes; ?>";
	$("button.proses").click();

/*-------------------------------------------------------------------------
Fungsi ini akan menyimpan soal tsb ke database, hanya soal ini saja
--------------------------------------------------------------------------*/	

$("#update").click(function(){
	var aksi=$(this).val();
	var div_elm = $(this).parent();
	var div_kunci_arr = $(div_elm).prevAll(".kunci_arr");
	var div_bobot_soal_input = $(div_elm).prevAll(".bobot_soal").find("input");
	var bobot_soal = $(div_bobot_soal_input).eq(0).val();
	var jml_item_jawaban = $(div_bobot_soal_input).eq(1).val();
	var urut = $(div_bobot_soal_input).eq(2).is(":checked")?"1":"0";
	if( bobot_soal > 0){
	var bobot = $(div_kunci_arr).find("select");
	var kunci_arr_span = $(div_kunci_arr).find("span");
	var kunci_arr = new Array();
	var nilai_bobot = new Array();
	for(var i = 0; i < bobot.length; i++){
		nilai_bobot[i] = $(bobot).eq(i).val();
		var temp = $(kunci_arr_span).eq(i).text().split(" ");
		kunci_arr[i] = temp[0];
		}
	var url = "simpan_soal.php";	
	var div_id_soal = $(div_elm).prevAll(".judul_soal");
	var id_soal_arr = $(div_id_soal).text().split(" ");
	var id_soal = id_soal_arr[2];
	var isi_soal = $(div_elm).prevAll(".isi_soal").html();
	var kunci_jawaban = $(div_elm).prevAll(".kunci_jawaban").html();

	// kirim ke database
	var data = [id_tes,id_soal,isi_soal,kunci_jawaban,kunci_arr,nilai_bobot,bobot_soal,urut,jml_item_jawaban];
	$.post(url,{data:data,aksi:aksi},function(hasil){
		// hapus div_soal
		$(div_elm).parent().html("<h2>Data telah disimpan..........</h2>");
		// hapus lightbox
		$("#lightbox, #lightbox-panel").fadeOut(2000);
		// pake cara yang paling mudah, load ulang aja
		$("#content").load("daftar_soal.php?id_tes="+id_tes);
		});
	}
	else {
	$(div_bobot_soal_input).next().html("harus diisi dan lebih besar dari nol").fadeIn();
	$(div_bobot_soal_input).select();
	}
})
})
</script>
