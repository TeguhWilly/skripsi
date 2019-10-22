<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
// tampilkan semua kata dalam kamus
$limit = 20;
$paging_tampil = 20;
if(isset($_GET['hal'])){
	$hal = ($_GET['hal'] - 1) * $limit;
	$hal_terpilih = $_GET['hal'];
	$bag_sekarang = $_GET['bag'];
	}
	else {
	$hal = 0;	
	$hal_terpilih = 1;
	$bag_sekarang = 1;
	}
// untuk pencarian
if(isset($_GET['cari']) && $_GET['cari'] != ""){
	$cari = " where kata like '%".$_GET['cari']."%'";
	}
else {
	$cari = "";
	}		
$bag_prev = $bag_sekarang - 1;		
$bag_next = $bag_sekarang + 1;		
$sql_total = "select count(*) from kamus".$cari;	
$jum_total = mysql_result(mysql_query($sql_total),0);
$jum_hal = ceil($jum_total / $limit);
$total_bagian = ceil($jum_hal / $paging_tampil);
$sql = "select kata,ifnull(sinonim,'--- belum diisi ---') as sinonim from kamus $cari limit $hal,$limit";	
$sql_exe = mysql_query($sql);
// buat div untuk pencarian
echo "<div class='cari'><input type='text' onfocus='pilih_cari(this)' onblur='biar(this)' value='Kata yang dicari' /><input type='image' width=24px onclick='cari_kata(this)' src='images/cari.jpg' /></div>";
echo "<table class='data'>";
echo "<caption>Daftar kata dalam kamus</caption>";
echo "<thead>
		<tr>
	
			<th>Kata</th>
			<th>Sinonim</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody style='text-align:left'>";
	
while($data = mysql_fetch_array($sql_exe)){
	echo "<tr>
	
			<td>$data[0]</td>
			<td>$data[1]</td>
			<td style='cursor:pointer' onclick='edit(this)'>Edit</td>
		</tr>";
	
	}
echo "</tbody></table>";	

// buat paging
echo "<div id='paging'>";
echo "<ul>";
$nomer_awal = $paging_tampil * ($bag_sekarang - 1) + 1 ;
$nomer_akhir = $nomer_awal + $paging_tampil;
//$nomer_akhir = $nomer_akhir < $jum_hal ? $nomer_akhir : $jum_hal;
for($i = $nomer_awal; $i < $nomer_akhir ;$i++){
	if($i > $jum_hal){
		$display = "style='display:none'";
		}
	else {
		$display = "";
		}	
	if($i == $hal_terpilih){
	echo "<li onclick='kata_di_hal(this)' style='background-color:green;color:#fff' >".$i."</li>";
		}
	else {
	echo "<li onclick='kata_di_hal(this)' $display >".$i."</li>";
		}	
	}
echo "</ul>";
echo "</div>";
echo "<div class='clear'></div>";
echo "<div style='width:80%;padding:3px;margin:2px'><span id='prev'>".$bag_prev."</span><span onclick='awal()' class='prev_next'>Awal</span><span onclick='prev()' class='prev_next' >Sebelumnya</span>";
echo "<span onclick='next()' class='prev_next'>Selanjutnya</span><span onclick='akhir()' class='prev_next'>Akhir</span><span id='next'>".$bag_next."</span>";
echo "<span>Loncat ke bagian : <select id='loncat' onchange='loncat(this)'>";
echo "<option>Bagian ke</option>";
for($i = 1; $i <= $total_bagian;$i++){
	echo "<option>$i</option>";
	}
echo "</select></span>";
echo "<span style='font-size:0.7em'>Total <b>: $jum_hal </b>hal dalam <b>".$total_bagian."</b> bagian</span>";
echo "</div>";

?>
<script type="text/javascript">
	var jum_paging ="<?php echo $paging_tampil ?>";
	var jum_hal ="<?php echo $jum_hal ?>";	
	var cari = "<?php echo $_GET['cari'] ?>";
function biar(elm){
	if($(elm).val() == ""){
		$(elm).val("Kata yang dicari");
		}
	}	
function pilih_cari(elm){
	$(elm).val("").select();
	}	
function cari_kata(elm){
	var yang_dicari = $(elm).prev().val();
	if(yang_dicari != "" && yang_dicari != "Kata yang dicari"){
	$("#content").html("Loading ........").load("daftar_kata.php?cari="+yang_dicari);
	}
	}	
function kata_di_hal(elm){
	var bag_sekarang = $("#next").text() - 1;
	var hal = $(elm).text();
	var url = "daftar_kata.php?hal="+hal+"&bag="+bag_sekarang+"&cari="+cari;
	$("#content").html("Loading ...........").load(url);
	}
function prev(){
	var bag_sekarang = $("#prev").text();
	// jika bag_sekarang = 2, maka ini sudah awal sekali
	if(bag_sekarang > 0){
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
		}
	}
function next(){
	var bag_akhir = Math.round(jum_hal / jum_paging) + 1;
	var bag_sekarang = $("#next").text();
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	if(bag_sekarang == bag_akhir){
	akhir();
	}
	else {
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	}		
	}
function awal(){
	var bag_sekarang = 1;
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	}	
function akhir(){
	var bag_sekarang = Math.round(jum_hal / jum_paging) + 1;
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) + parseInt(jum_paging) ;
//	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i < akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	}
function loncat(elm){
	var bag_akhir = Math.round(jum_hal / jum_paging) + 1;
	var bag_sekarang = elm.value;
	var awal_nomer = (jum_paging * (bag_sekarang - 1)) + 1;
	var akhir_nomer = parseInt(awal_nomer) +  parseInt(jum_paging) ;
	akhir_nomer = akhir_nomer < jum_hal ? akhir_nomer:jum_hal;
	if(bag_akhir == bag_sekarang){
		akhir();
		}
	else {	
	// ubah nomer halaman link pada paging
	var li_paging = $("#paging li"); 
	var j = 0;
	for(var i = awal_nomer; i <= akhir_nomer; i++){
		if(i <= jum_hal){
		$(li_paging).eq(j).text(i);
		if($(li_paging).eq(j).not(":visible")){
			$(li_paging).eq(j).show();
			}
		}
		else {
		$(li_paging).eq(j).hide();	
			}
		j++;
		}
	$("#next").text(parseInt(bag_sekarang) + 1);
	$("#prev").text(parseInt(bag_sekarang) - 1);
	}		
}
function edit(elm){
	// tambahkan inputan pada kolom sebelumnya 
	var text_kolom = $(elm).prev().text();
	$(elm).prev().html("<input type='text' value='"+text_kolom+"' /><input type='button' onclick='simpan_sinonim(this)' value='simpan'/>");
	}
function simpan_sinonim(elm){
	// update sinonim pada kata tersebut
	var kolom = $(elm).parent();
	var sinonim = $(elm).prev().val();
	var kata = $(elm).parent().prev().text();
	// simpan ke database
	var url = "simpan_sinonim.php";
	$.post(url,{kata:kata,sinonim:sinonim},function(hasil){
		// ubah kolom dengan sinonim baru, dan info tersimpan
		$(kolom).text(sinonim);
		})
	}	
</script>
<style>
.prev_next{
	cursor:pointer;
	padding:3px;
	margin:4px;
	background-color:#fff;
	border:1px solid green;	
	}
#prev,#next{
	display:none;
	}
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
