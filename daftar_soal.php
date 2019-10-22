<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
$id_tes = $_REQUEST['id_tes'];
// ambil semua tes_uraian yang dibuat oleh user ini
$sql = "select id_soal,if(length(isi_soal) > 140,concat(left(isi_soal,140),'....'),isi_soal) as soal ,if(length(kunci_jawaban) > 90,concat(left(kunci_jawaban,90),'.....'),kunci_jawaban) as kunci,bobot_soal as bobot from soal where id_tes='".$id_tes."' order by id_soal";
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
?>
<script type="text/javascript" src="js/fungsi_soal.js"></script>
<div style="margin:3px;padding:2px">Tambah <input size='1' type="text" id="jml" value="1" /><button onclick="tambah_soal()">Tambah soal</button></div>
<div style="margin-top:5px">
<?php 
if($jumlahBaris > 0){
	echo "<table class='data'>";
	echo "<caption>Daftar Soal Tes Uraian </caption>";
	// buat header
	echo "<thead class='judul'><tr>";
	$jumlahKolom = mysql_num_fields($sqlExe);
	for($i = 0; $i < $jumlahKolom; $i++){
		echo "<th>".mysql_field_name($sqlExe,$i)."</th>";
		}
	echo "<th colspan='2'>Aksi</th>";	
	echo "<th>Lihat soal</th>";
	echo "</tr></thead>";	
	// tampilkan datanya
	echo "<tbody>";
	while($baris = mysql_fetch_array($sqlExe)){
		echo "<tr>";
		for($j = 0; $j < $jumlahKolom ; $j++){
			echo "<td>".$baris[$j]."</td>";
			}
		// buat link untuk edit, hapus, tambah soal, preview
		echo "<td><a class='fancy' href='edit_soal.php?id_soal=".$baris[0]."&id_tes=".$id_tes."' >Edit</a></td>";	
		echo "<td><a class='fancy' href='hapus_soal.php?id_soal=".$baris[0]."&id_tes=".$id_tes."'>Hapus</a></td>";	
		echo "<td><a class='fancy' href='lihat_soal.php?id_soal=".$baris[0]."&id_tes=".$id_tes."'>Lihat</a></td>";	
		echo "</tr>";
		$no++;
		}
	echo "</tbody>";
	echo "</table>";
	}
else {	
echo "Soal belum ada";
}
echo "</div>";
echo "<div id='fancy'></div>";
?>
<div id="tempat_soal"></div>
<script type="text/javascript" >
	$(function(){
	// ini untuk fancy, hanya untuk tag a
	$("a.fancy").click(function(e){
		e.preventDefault();
		var page = $(this).attr("href");
		var title = page.substr(0,page.indexOf("."));
		$("#lightbox-title > span").html(title);
		$("#lightbox-content").html("<div class='info'>Loading ...............</div>");
		$("#lightbox-content").load(page);
		$("#lightbox, #lightbox-panel").fadeIn(300);
		});
	$("a#close-panel").click(function(){
	$("#lightbox, #lightbox-panel").fadeOut(300);
 })		
})		
function tambah_soal(){
	var id_tes="<?php echo $id_tes; ?>";
	var jumlah = $("#jml").val();
	// cek apakah soal sudah ada dengan memeriksa nilai id_soal yang terakhir, kolom pertama adalah nomer
	var soal_terakhir = $("table.data tr:last td").eq(0).text();
	var soal="";
	if(soal_terakhir == "" || soal_terakhir == null){
	var	indexnya = 1;
		}
	else {
	var	indexnya = parseInt(soal_terakhir)+1;	
		}	
	for(var i = 0; i < jumlah; i++){
	var index = parseInt(indexnya) + i; 	
	soal += "<div class='div_soal'><div class='judul_soal' style='padding-left:19px'>Soal ke "+index+"</div>";
	soal += "<div class='bobot_soal'>Masukkan nilai bobot soal <input class='i_bobot_soal' type='text' value='10' size='1' /><span class='peringatan'></span>";
	soal += "<label class='l_jml_item'>Jumlah item jawaban yang diharapkan</label><input type='text' class='jml_item'/><span class='urut'><input class='i_urut' type='checkbox' /><label>Harus urut</label></span></div>";
	soal += "<div id='isi_soal"+index+"' class='isi_soal'>Tulis soal disini</div>";
	soal += "<div class='kunci_jawaban' id='kunci"+index+"' >Tulis kunci jawaban disini</div>";
	soal += "<div class='kunci_arr'></div>";
	soal += "<div><button onclick='proses(this)'>Proses</button><input type='button' onclick='simpan(this,"+id_tes+")' value='Simpan' /></div>";
	soal += "</div>";
	}
	$(soal).appendTo("#tempat_soal");
	for(var i = 0; i < jumlah; i++){
	var index = parseInt(indexnya) + i; 		
	new nicEditor({fullPanel : true,iconsPath : 'js/nicEditorIcons.gif',uploadURI:'include/nicUpload.php'}).panelInstance('isi_soal'+index);
	new nicEditor({iconsPath : 'js/nicEditorIcons.gif',buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html']}).panelInstance('kunci'+index);
	}
	// disabled button tambah soal
	$("#jml").next().attr("disabled",true);
	}
/*-------------------------------------------------------------------------
Fungsi ini akan menyimpan soal tsb ke database, hanya soal ini saja
--------------------------------------------------------------------------*/	
function simpan(elm,id_tes){
	var aksi=$(elm).val();
	var div_elm = $(elm).parent();
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
		$(div_elm).parent().remove();
		// tambahkan data baru ke tabel
		var jumlah_baris = $("tbody tr").length + 1;
		var baris_baru="<tr><td>"+id_soal+"</td><td>"+isi_soal+"</td><td>"+kunci_jawaban+"</td>"
		baris_baru+="<td>"+bobot_soal+"</td><td>Edit</td>";	
		baris_baru+="<td>Hapus</td>";	
		baris_baru+="<td>Lihat</td>";		
		baris_baru+="</tr>";
		$(baris_baru).insertAfter($("tr:last"));
		});
		
	}
	else {
	$(div_bobot_soal_input).next().eq(0).html("harus diisi dan lebih besar dari nol").fadeIn().delay(1000).fadeOut();
	$(div_bobot_soal_input).select();	
	}
}
</script>
<style>
table.data{
	text-align:left;
	}
span.urut{
	position:absolute;
	right:20px;
	padding:1px;
	border-bottom:1px solid blue;
	font-style:60%;
	}
.l_jml_item{
	margin-left:20px;
	}	
.jml_item{
	width:25px;
	margin-left:10px;
	}			
</style>
