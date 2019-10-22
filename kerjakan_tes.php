<?php
include_once "cek_session.php";
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$id_user = $_SESSION['userId'];
$id_tes = $_REQUEST['id_tes'];

// ambil semua tes_uraian yang tersedia dan belum dikerjakan oleh siswa ini
$sql = "select id_soal,isi_soal,bobot_soal from soal where id_tes='".$id_tes."' order by id_soal";
$sqlExe = mysql_query($sql);
$jumlahBaris = mysql_num_rows($sqlExe);
if($jumlahBaris > 0){
	// tampilkan soal
	$no_soal = 1;
	while($baris = mysql_fetch_array($sqlExe)){
	echo "<div class='tempat_soal'>";	
	echo "<div class='div_soal'><div class='judul_soal' style='padding-left:19px'>Soal ke ".$no_soal."<span class='bobot_soal'> Bobot Soal : ".$baris['bobot_soal']."</span></div>";
	echo "<div  id='isi_soal".$baris['id_soal']."' class='isi_soal'>".$baris['isi_soal']."</div>";
	echo "<div class='jawaban' id='kunci".$baris['id_soal']."' >tulis jawaban disini</div>";
	echo "<div><button onclick='simpan(this,".$baris['id_soal'].",".$id_tes.")'>Simpan</button></div>";
	echo "</div>";
	echo "<script>
	new nicEditor({iconsPath : 'js/nicEditorIcons.gif',buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','ol','ul','indent','outdent','removeformat']}).panelInstance('kunci".$baris['id_soal']."');
	</script>";
	echo "</div>";
	$no_soal++;
		}
	echo "<div id='divwaktu'></div>";	
	echo "<div><a class='button' href='#' onclick='selesai()' >selesai & lihat hasil</a></div>";
	}
else {	
echo "Halahh durung input text latih mblo kesusu ae :P";
}

?>
<script type="text/javascript" >
// set id_tes sebagai nama cookie
var c_tes = "c_"+"<?php echo $_REQUEST['id_tes']."_".$id_user ?>";	
$(function(){
var lama_tes = "<?php echo $_GET['wkt']*60 ?>";
	// hapus timer bila sudah pernah membukan, biar gak numpuk
	// t telah dideklarasikan di file menu_siswa.php
	if(t != 0){
	clearTimeout(t);	
		}
	// catat waktu dimulai tes ini
	var saat_ini = Math.round((new Date()).getTime()/1000);
	// cek cookie, jika cookie belum ada, maka buat dulu bila telah ada ambil nilai cookie tersebut
	var mulai_tes = getCookie(c_tes);
	if(mulai_tes != null && mulai_tes != ""){
		var sisa_temp = (parseInt(mulai_tes) + parseInt(lama_tes)) - saat_ini;
		sisa_waktu = (sisa_temp < 0 ) ? 1:sisa_temp;		
	}
	else {
		sisa_waktu = lama_tes;
		setCookie(c_tes,saat_ini,1);
	}
	mulai();
	})	

function mulai(){
    jam = Math.floor(sisa_waktu/3600);
    sisa = sisa_waktu%3600;
    menit = Math.floor(sisa/60);
    sisa2 = sisa%60
    detik = sisa2%60;
    if(detik<10){
        detikx = "0"+detik;
    }else{
        detikx = detik;
    }
    if(menit<10){
        menitx = "0"+menit;
    }else{
        menitx = menit;
    }
    if(jam<10){
        jamx = "0"+jam;
    }else{
        jamx = jam;
    }
    $("#divwaktu").html(jamx+":"+menitx+":"+detikx);
    sisa_waktu--;
    if(sisa_waktu>0){
        t = setTimeout("mulai()",1000);
        jalan = 1;
    }else{
        clearTimeout(t);
		alert("waktu habis");
        selesai();
    }
}
function selesai(){
	var id_tes = "<?php echo $id_tes ?>";
    deleteCookie(c_tes);	
    if($(":button").length > 0){
		$(":button").click();	
		}
	// load content dengan halaman lihat_hasil_tes.php	 
    $("#content").delay(1000).load("lihat_hasil_tes.php?id_tes"+id_tes);
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function checkCookie(c_name,nilai_awal){
     var waktuy=getCookie(c_name);
    if (waktuy!=null && waktuy!=""){
        return waktuy;
    }else{
        setCookie(c_name,nilai_awal,1);
    }
}
function deleteCookie(c_name){
	setCookie(c_name,"",-1);		
}

// event ketika tombol simpan diklik
function simpan(elm,id_soal,id_tes){
	$(elm).attr("disabled",true);
	var div_elm = $(elm).parent();
	var jawaban = $(div_elm).prevAll(".jawaban").text();
	// lakukan preprocessing
	var terpilih = preprocessing(jawaban,stoplist);
//	if(terpilih.length > 0){
	// proses data diserver, kirimkan kata terpilih dan id_soal	
	$.post("hitung_kemiripan.php",{daftar_kata:terpilih,jawaban:jawaban,id_soal:id_soal,id_tes:id_tes},function(data){
		// hapus div_soal ini
		$(div_elm).parent().html("<div>Sudah dikoreksi ....................</div>"+data);
		});
//	}
//	else {
//		alert("semua kata yang anda masukkan termasuk dalam kata terlarang");
//		}
}
</script>
<style>
div#divwaktu{	
position:fixed;
left:45%;
top:10px;
border:1px solid green;
padding:9px;
background-color:#36DB13;
font-size:1.6em;
border-radius:4px;
}
div#divwaktu:hover{
opacity:0.2;
}
.bobot_soal{
position:absolute;	
right:30px;
font-style:oblique;
font-weight:bolder;
}
.kunci_jawaban{
	padding:3px;
	}
a.button{
	position:absolute;
	margin:9px;
	padding:3px;
	border:1px solid #6E4FF9;
	color:blue;
	}		
</style>
