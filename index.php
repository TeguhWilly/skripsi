<?php
session_start();
//session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Deteksi plagiarisme tugas siswa</title>
<link href="images/kj.png" rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/fungsiString.js"></script>
<script type="text/javascript" src="js/stoplist2.js"></script>
<script type="text/javascript" src="js/nicEdit.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
<script>
$(function(){
	// jika menu login / daftar diklik
	$(".menu").toggle(function(){
		$(this).next().fadeIn('slow');
		$(this).next().find("input:first").focus();
		},function(){
		$(this).next().fadeOut('slow');	
		});
	// event untuk mengatasi inputan, bila tidak diisi kembalikan ke nilai awal
	var nilaiAwal;
	$("form :input").not(":submit").focus(function(){
		nilaiAwal = $(this).val();
		$(this).val("");
		// tampilkan tooltip
		$(this).next().fadeIn();
		})
	$("form :input").blur(function(){
		if($(this).val() == ""){
			$(this).val(nilaiAwal);
			}
		// sembunyikan tooltip
		$(this).next().fadeOut();	
		})	
	// jika tombol daftar / login diklik
	$("form").submit(function(){
		var url = $(this).attr("action");
		var data = $(this).serializeArray();
		// kirim data ke server
		if(url == "daftar.php"){
			$.post(url,{data:data},function(status){
				if(status == '1'){
				var text = "data telah disimpan";
				}
			else {
				var text = "data gagal disimpan";
				}
			alert(text);	
			});
		}
		else {
			$.post(url,{data:data},function(status){
			if(status == 1 || status == 0){	
			// ubah content div menu_utama
			if(status == 1) var url = "menu_siswa.php";
			else var url = "menu_guru.php";
			$("#menu_utama").load(url);
			}
			else {
				var text = "username atau password salah";
				alert(text);
				};
			});
		}	
		return false;
		});
	
	// tampilan awal ketika web dibuka
	$("#content").load("depan.html");
		
	})
</script>
<style type="text/css">
<!--
body {
	background-image: url(images/text-typography_00312788.jpg);
}
-->
</style></head>
<body oncopy="alert('hayo jangge lapo !!!!!!');return false;">
   <!-- Begin Wrapper -->
   <div id="wrapper">
   
         <!-- Begin Header -->
         <div id="header">
			<div style='left:13.2%;'>
			<img src='images/mhs.png' width=95 height=73 style='border-radius:4px'/>			</div> 
<div style='left:280px; right:25%; text-align:center; font-weight:bolder; font-size:1.5em; color:#FFFFFF;'>
			      DETEKSI PLAGIARISME DOKUMEN TEKS MENGGUNAKAN ALGORITMA JARO-WINKLER DISTANCE</div>
		   <div style='right:13.2%'></div> 
	 </div>
		 <!-- End Header -->
		 
		 <!-- Begin Navigation -->
         <div id="navigation">
		 
		     <marquee><span class="judul">Take Risk, Commitment, Focus</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="judul">kunjungi blog saya di <a href='http://asligresik.wordpress.com'>x-presikanaksimu.blogspot.com</a></span></marquee>
			   
		 </div>
		 <!-- End Navigation -->
		 
         <!-- Begin Faux Columns -->
		 <div id="faux">
		       <!-- Begin Left Column -->
		       <div id="leftcolumn">
				<div id="menu_utama">
 <?php
 if($_SESSION){
	 if($_SESSION['level'] == 1){
		$menu_level = "menu_siswa.php"; 
		 }
	 else {
		$menu_level = "menu_guru.php"; 
		 }
	echo "<script>
	$(function(){
	$('#menu_utama').load('$menu_level');
	})
	</script>";
	 }
 else {	
 ?>					
					<div id="login" class="menu" >
					Login
					</div>
					<div id="form_login" class="div_form">
					<div class="judul">Silakan Login .....</div>
						<form action="login.php">
						<div><input type="text" name="username" value="username" /><span class="tooltip">Isi dengan NIS / NIP</span></div>
						<div><input type="password" name="password" value="password" /><span class="tooltip">Password anda</span></div>
						<div><input type="submit" value="login" class="button" /></div>
						</form>
					</div>
					<div id="daftar" class="menu">
					Daftar	
					</div>
					<div id="form_daftar" class="div_form">	
					<div class="judul">Daftar Dulu ...........</div>
					<form action="daftar.php">
						<div><input type="text" name="username" value="username" /><span class="tooltip">Isi dengan NIS / NIP</span></div>
						<div><input type="password" name="password" value="password" /><span class="tooltip">Password anda</span></div>
						<div><input type="text" name="nama" value="nama" /><span class="tooltip">Isi dengan nama lengkap</span></div>
						<div><input type="text" name="agama" value="agama" /><span class="tooltip">Agama yang anda anut</span></div>
						<div><input type="text" name="alamat" value="alamat" /><span class="tooltip">Alamat lengkap</span></div>
						<div><input type="submit" value="daftar" class="button" /></div>
					</form>	
					</div>
<?php 
};
?>					
					</div>	   

				<div id="banner" style="position:relative;margin-top:2em;margin-bottom:2em">
					<div class="iklannya">
					<div  class='judul' style='background-color:#fff;color:#13500B;margin-bottom:2px;width:84%;font-size:67%'>Space for rent</div>
				<a href='http://www.radiorodja.com' target='_blank'><img src='images/rodja.jpg' width='120' height='105' /></a> 
					</div>	   
					<div class="iklannya">
					<div  class='judul' style='background-color:#fff;color:#13500B;margin-bottom:2px;width:84%;font-size:67%'>Space for rent</div>
				<a href='http://www.facebook.com/groups/gresikblankonan/' target='_blank'><img src='images/blankon.jpg' width='120' height='105' /></a> 
					</div>	   
				</div>	   
		       </div>
		       <!-- End Left Column -->
		 
		       <!-- Begin Right Column -->
		       <div id="rightcolumn">
		       	<div id='content' ></div>
			   <div class="clear"></div>
			   
		       </div>
		       <!-- End Right Column -->
			   
			   <div class="clear"></div>
			   
         </div>	   
         <!-- End Faux Columns --> 

         <!-- Begin Footer -->
         <div id="footer" class="judul" style="text-align:center">
		      	Dikembangkan oleh : <br />
					Teguh willyanto hp: 08813268965 Email : teguhwillyanto87@gmail.com
		 </div>
		 <!-- End Footer -->
		 
   </div>
   <!-- End Wrapper -->
<!-- Untuk lightbox-panel -->
<div id="lightbox-panel">
<a id="close-panel" href="#">X</a>	
<div id="lightbox-title"><span></span></div>
<div id="lightbox-content"></div>
</div>
<!-- Untuk lightbox -->
<div id="lightbox"></div>
</body>
</html>
<style>
#content{
// gak boleh dipilih
/*
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-o-user-select: none;
	user-select: none;
*/	
	color:#0D3912;
	background:#FDFCFA;
	padding:3px;
	}
div.menu{
	width:80%;
	margin-left:auto;
	margin-right:auto;
	margin-top:5px;
	padding:4px;
	border:1px solid #766DED;
	border-radius: 3px;
	text-align:center;
	font-size:115%;
	font-style:oblique;
//	color:#194B06;
	font-weight:bolder;
	background:url('images/kj.png') left no-repeat;
	}
div.menu:hover,input:hover{
	cursor:pointer;
	background-color:#FFFFFF;
	}		
.iklannya {
	width:120px;
	height:120px;
	border:1px solid #766DED;
	border-radius: 3px;
	margin-left:auto;
	margin-right:auto;
	margin-top:10px;
	margin-bottom:10px;
	padding:2px;
	background:#fff;
	}
.div_form{
	display:none;
	width:84%;
	margin-left:auto;
	margin-right:auto;
	margin-top:1px;
	border:1px solid #766DED;
	border-radius: 3px;
	background:#D9E6FA;
	color:#245D0A;
	}
.div_form div{
	margin-left:auto;
	margin-right:auto;
	padding:3px;
	text-align:center;
	}	
.div_form input{
	width:80%;
	height:20px;
	margin-top:1px;
	border:1px solid gray;
	color:#265213;
	}
.judul{
	font-weight:bold;
	font-style:italic;
	text-align:left;
	padding-left:20px;
	background:#ffffff url('images/kj.png') left center no-repeat;
	border-bottom:2px solid #766DED;
//	width:90%;
	}
.judul:hover{
	background:#FFFAF1 url('images/kj.png') left no-repeat;
	}	
.tooltip{
	color:blue;
	font-style:oblique;
	display:none;
	position:absolute;
	z-index:999;
	padding:5px;
	margin-top: -4px;
	margin-left:5px;
	border:1px solid gray;
	border-radius: 3px;
	background: #ffc ;
	}
.button{
//	background:#90EE90;
	font-weight:bold;
	font-style:oblique;
	border:1px solid red;
	}	
/* Lightbox */	
#lightbox {
 display:none;
 background:#000000;
 opacity:0.7;
 filter:alpha(opacity=90);
 position:absolute;
 top:0px;
 left:0px;
 min-width:100%;
 min-height:100%;
 overflow:auto;
 z-index:1000;
}
/* Lightbox panel with some content */
#lightbox-panel {
 display:none;
 position:fixed;
 top:10%;
 left:25%;
// margin-left:-200px;
 width:50%;
 min-height:100px;
 overflow:auto;
 background:#EAF7E6;
// padding:5px 10px 5px 10px;
 border:2px solid #CCCCCC;
 z-index:1001;
}
#lightbox-title{
 background-color:#0E6E1A;
 border-bottom:#158418 solid 2px;	
// margin-left:10px;
 font-style:oblique;
 font-weight:bold;
 height:22px;
 }
#lightbox-title>span{
	margin-left:10px;
	font-size:1.4em;
	color:#fff;
	} 
#close-panel{
	position:absolute;
	right:3px;
	top:2px;
	background-color:#fff;
	} 
#close-panel:hover{
	background-color:green;
	color:#fff;
	}
	
</style>
