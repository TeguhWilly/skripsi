/*-------------------------------------------------------------------------
Fungsi ini akan melakukan preprocessing dan menghasilkan daftar kata dasar terpilih
* variabel stoplist pada baris ke 11 meerupakan variabel dari file stoplist2.js
* yang telah diincludekan dalam file index.php
--------------------------------------------------------------------------*/	
function proses(elm){
	var div_elm = $(elm).parent();
	var kunci_jawaban = $(div_elm).prevAll(".kunci_jawaban").text();
	var div_kunci_arr = $(div_elm).prevAll(".kunci_arr");
	// tampilkan info untuk menunggu
	$(div_kunci_arr).html("Masih proses, silakan tunggu ...........");
	var terpilih = preprocessing(kunci_jawaban,stoplist);
	if(terpilih.length > 0){
	$.post("cari_kata_dasar.php",{daftar_kata:terpilih},function(data){
		// tampilkan di dalam div kunci_arr
		var obj = JSON.parse(data);
		var jmlObj = obj.length;
		var kunci_arr="";
		for(var a in obj){
			kunci_arr = kunci_arr +"<span class='kata_terpilih'>"+obj[a]+" <select name='bobot'><option>1</option><option>2</option><option>3</option></select></span>";
			}
	    var lebarDivKunci = $(div_kunci_arr).outerWidth();
		$(div_kunci_arr).html(kunci_arr);
		// tata ulang posisinya, sisipkan /n bila > dari outerWidth() kunci_arr	
		var spanSemua = $(div_kunci_arr).find("span");
		var lebar = 0;
		for(var i = 0; i < spanSemua.length; i++){
			lebar = parseInt(lebar) + $(spanSemua).eq(i).outerWidth() + 2;
			if(lebar > lebarDivKunci){
				// ganti baris kawan
				$("<hr style='color:green;opacity:0.0'/><br />").insertBefore($(spanSemua).eq(i));
				lebar = $(spanSemua).eq(i).outerWidth();; 
				}
			}
		
		});
	}
	else {
		alert("semua kata yang anda masukkan termasuk dalam kata terlarang");
		}
}
		
	
