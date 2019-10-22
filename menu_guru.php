<?php
include_once "cek_session.php";
$username = $_SESSION['nama'];
?>
<div class="menu_utama judul">
	<?php echo $username; ?></div>
<div class="menu_item">
	<div class="item">Ganti_password</div>
	<div class="item">Keluar</div>
</div>	
<div class="menu_utama judul">Tes_uraian</div>
<div class="menu_item">
	<div class="item">Buat_tes</div>
	<div class="item">Input_text_uji</div>
	<div class="item">Tambah_kata</div>
	<div class="item">Daftar_kata</div>
</div>	
<script type="text/javascript">
$(function(){
	var loading = "<div class='loading'>Mohon ditunggu ...........</div>";
	$(".menu_utama").toggle(function(){
		$(this).next().fadeIn('slow');
		},function(){
		$(this).next().fadeOut('slow');	
		})
	// event ketika menu diklik
	$(".menu_item div").click(function(){
		var url = $(this).text().toLowerCase();
		//$("#content").html("<div style='background:#55ffaa;padding:4px;margin:8px;text-align:center'><img src='images/loading.gif' /> mohon ditunggu .......</div>").load(url+".php");
		$("#content").html(loading).load(url+".php");
		});		
	})
</script>					
<style>
.menu_utama{
	width:88%;
	margin-left:auto;
	margin-right:auto;
	text-align:left;
	background-color:#D0F6D0;
	margin-top:3px;
	padding:4px;
	font-size:110%;
	color:#265E10;
	}	
.menu_item{
	display:none;
	width:96%;
	margin-left:auto;
	margin-right:auto;
	text-align:left;
//	background:#6BE73A;
	margin-top:4px;
	}	
.menu_item div{
//	padding:4px;
	margin-bottom:3px;
	border-bottom:1px solid green;
//	color:#224C12;
	}	
.menu_item div:hover,.menu_utama:hover{	
	cursor:pointer;
	font-size:110% ;
	font-weight:bold;
	}

</style>
