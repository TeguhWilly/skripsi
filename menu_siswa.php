<?php
session_start();
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
	<div class="item">input_text_latih</div>
	<div class="item">Lihat_hasil</div>
</div>	
<script type="text/javascript">
$(function(){
	t = 0; //ini variabel untuk timer saat mengerjakan soal
	var loading = "<div class='loading'>Mohon ditunggu ...........</div>";
	$(".menu_utama").toggle(function(){
		$(this).next().fadeIn('slow');
		},function(){
		$(this).next().fadeOut('slow');	
		})
	// event ketika menu diklik
	$(".menu_item div").click(function(){
		var url = $(this).text().toLowerCase();
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
	color:#224C12;
	}	
.menu_item div:hover,.menu_utama:hover{	
	cursor:pointer;
	font-size:110% ;
	font-weight:bold;
	}

</style>
