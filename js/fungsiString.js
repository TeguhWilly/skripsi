function removeByIndex(arrayName,arrayIndex){	
	arrayName.splice(arrayIndex,1);					
	}
function cekKamus(kata,kamus_arr){
	var hasilCari = 0;
	if(kamus_arr.indexOf(kata) > -1){
	hasilCari = 1;	
	}
	return hasilCari;
	}
/*---------------------------------------------------
  ini untuk fungsi stemming_arifin (awal)
  * parameter pertama kata yang akan dicari kata dasarnya
  * parameter kedua adalah daftar kata dalam bentuk array
  * return berupa kata dasar 
 ----------------------------------------------------*/ 
 function stemmingArifin(kata,kamus){
/* ------------------------------------------------------------------
asumsikan bentuk kata adalah aw 1 + aw 2 + kd + akh 3 + akh 2 + akh 1
--------------------------------------------------------------------*/
var ketemu =kata;
/* ------------------------------------------------------------------
cek apakah kata ada dalam kamus
kombinasi  = KD 
--------------------------------------------------------------------*/
if(kamus.indexOf(kata) > -1){
	return kata;
	exit;
	}
else {		
/* ------------------------------------------------------------------
hasilkan awalan dan periksa apakah kata telah ditemukan
--------------------------------------------------------------------*/	
var awalan = potongAwalan(kata);
/* ------------------------------------------------------------------
potong kata dengan AW I
--------------------------------------------------------------------*/	
var tempKata = kata.substr(awalan[0].length);
// rubah dulu kata sesuai aturan perubahan kata bila mendapat awalah me / pe
var _2hurufAwal = awalan[0].substr(0,2);
if(_2hurufAwal == 'me' || _2hurufAwal == 'pe'){
	// jika diikuti ny, maka tambahkan hasil pemotongan dengan s
	var _2hurufAkhir = awalan[0].substr(2,2);
	if(_2hurufAkhir == 'ng'){
		// cek dulu dikamus
		tempKata = 's'+tempKata;
		}

	if(_2hurufAkhir == 'ny'){
		tempKata = 's'+tempKata;
		}
	}
if(cekKamus(tempKata,kamus) == 1) {
	ketemu = tempKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
potong kata dengan AW I + AW II
--------------------------------------------------------------------*/	
var tempKata = tempKata.substr(awalan[1].length);
if(cekKamus(tempKata,kamus) == 1) {
	ketemu = tempKata;
	return ketemu;
	}	
/* ------------------------------------------------------------------
hasilkan akhiran
--------------------------------------------------------------------*/	
var akhiran = potongAkhiran(tempKata);
/* ------------------------------------------------------------------
potong kata dengan AKH I
--------------------------------------------------------------------*/	
tempKata = tempKata.substr(0,tempKata.length - akhiran[0].length);
if(cekKamus(tempKata,kamus) == 1) {
	ketemu = tempKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
potong kata dengan AKH II
--------------------------------------------------------------------*/	
tempKata = tempKata.substr(0,tempKata.length - akhiran[1].length);
if(cekKamus(tempKata,kamus) == 1) {
	ketemu = tempKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
potong kata dengan AKH III
--------------------------------------------------------------------*/	
tempKata = tempKata.substr(0,tempKata.length - akhiran[2].length);
if(cekKamus(tempKata,kamus) == 1) {
	ketemu = tempKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
bila belum ditemukan juga maka, cek kombinasinya
--------------------------------------------------------------------*/	  
/* ------------------------------------------------------------------
AW I + AW II + KD ==> langkah e
--------------------------------------------------------------------*/	  
var pjgAkhiran = akhiran[2].length + akhiran[1].length + akhiran[0].length;
var kombKata = kata.substr(0,kata.length - pjgAkhiran);
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}  
/* ------------------------------------------------------------------
AW I + AW II + KD + AKH III ==> langkah f, kombKata (dari langkah e) + akhiran[2]
--------------------------------------------------------------------*/	  
kombKata = kombKata + akhiran[2];
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}    
/* ------------------------------------------------------------------
AW I + AW II + KD + AKH III + AKH II ==> langkah g, kombKata (dari langkah f) + akhiran[1]
--------------------------------------------------------------------*/	  
kombKata = kombKata + akhiran[1];
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
AW I + AW II + KD + AKH III + AKH II + AKH I ==> langkah h, kombKata (dari langkah g) + akhiran[0]
--------------------------------------------------------------------*/	  
kombKata = kombKata + akhiran[0];
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}	
/* ------------------------------------------------------------------
 AW II + KD ==> langkah i
--------------------------------------------------------------------*/	  
kombKata = kata.substr(awalan[1].length,kata.length - pjgAkhiran);
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}	
/* ------------------------------------------------------------------
 AW II + KD + AKH III ==> langkah j, kombKata ( langkah i) + akhiran[2]
--------------------------------------------------------------------*/	  
kombKata = kombKata + akhiran[2];
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}
/* ------------------------------------------------------------------
 AW II + KD + AKH III + AKH II ==> langkah k, kombKata ( langkah j) + akhiran[1]
--------------------------------------------------------------------*/	  
kombKata = kombKata + akhiran[1];
if(cekKamus(kombKata,kamus) == 1) {
	ketemu = kombKata;
	return ketemu;
	}		  
  }
return ketemu;
}
/* ------------------------------------------------------------------
potong kata yang berawalan me atau pe
--------------------------------------------------------------------*/
function potongAwalanMe(kata){
	var _2hurufAwal = kata.substr(0,2);
	var awalan = "";
	var	_4hurufAwal = kata.substr(0,4);
	var	_3hurufAwal = kata.substr(0,3);
	var hurufPengganti="";
	if(_4hurufAwal == "meng" || _4hurufAwal == "peng"){
			awalan = _4hurufAwal;
			// hasil yang dipotong tambahkan dengan salah satu huruf berikut ini
			// hurufPengganti=['v','k','g','h','q'];	
			}
		else if(_4hurufAwal == "meny" || _4hurufAwal == "peny"){
			//awalan = _4hurufAwal.substr(0,2);
			awalan = _4hurufAwal;
			// ganti ny dengan huruf pengganti
			hurufPengganti=['s'];
			}
		else if(_3hurufAwal == "mem" || _3hurufAwal == "pem"){
			awalan = _3hurufAwal;
			// tambahkan huruf pengganti jika hasil kata yang dipotong berupa huruf vokal
			hurufPengganti=['b','f','p','v'];	
			}
		else if(_3hurufAwal == "men" || _3hurufAwal == "pen"){
			awalan = _3hurufAwal;
			// tambahkan huruf pengganti jika hasil kata yang dipotong berupa huruf vokal
			hurufPengganti=['c','d','j','s','t','z'];	
			}
		else if(_3hurufAwal == "per"){
			awalan = _3hurufAwal;
		//	hurufPengganti=['c','d','j','s','t','z'];	
			}	
		else if(_2hurufAwal == "me" || _2hurufAwal == "pe"){
			awalan = _2hurufAwal;
		//	hurufPengganti=['l','m','n','r','y','w'];	
			}
	return awalan;		
//	return awalan+" "+kata.substr(awalan.length)+" "+hurufPengganti;
}
/* ------------------------------------------------------------------
potong kata yang berawalan be
--------------------------------------------------------------------*/
function potongAwalanBe(kata){
	var awalan = "";
	var hurufPengganti="";
	var _2hurufAwal = kata.substr(0,2);
	var _3hurufAwal = kata.substr(0,3);
	if(_3hurufAwal == "ber"){
		awalan = _3hurufAwal;
		}
	else if(_2hurufAwal == "be" && kata == "bekerja"){
		awalan = _2hurufAwal;
		}
	else if(_3hurufAwal == "bel" && kata == "belajar"){
		awalan = _3hurufAwal;
		}
	return awalan;		
//	return awalan+" "+kata.substr(awalan.length)+" "+hurufPengganti;			
}
/* ------------------------------------------------------------------
potong kata yang awalannya selain me,pe,be
--------------------------------------------------------------------*/
function potongAwalanLainnya(kata){
	var awalan = "";
	var hurufPengganti="";
	var _2hurufAwal = kata.substr(0,2);
	var _3hurufAwal = kata.substr(0,3);
	if(_3hurufAwal == "ter"){
		awalan = _3hurufAwal;
		hurufPengganti=['r'];
		}
	else if(_2hurufAwal == "di" || _2hurufAwal == "ke" || _2hurufAwal == "se"){
		awalan = _2hurufAwal;
		}		
	return awalan;		
//	return awalan+" "+kata.substr(awalan.length)+" "+hurufPengganti;
}
/* ------------------------------------------------------------------
potong awalan
--------------------------------------------------------------------*/
function potongAwalan(kata){
	//jadikan huruf kecil semua
	var kata = kata.toLowerCase();
	var awalan1 =new Array('me','di','ke','pe','se','be');	
	var awalan2 =new Array('ber','ter','per');
	var _2hurufAwal = kata.substr(0,2);
	var awalan = new Array();
	awalan[0] ="";
	awalan[1] ="";
	for(var i =0; i < 2; i++){
	var awalanTmp="";
	if(_2hurufAwal == "me" || _2hurufAwal == "pe"){
	 awalanTmp = potongAwalanMe(kata);
	}
	else if(_2hurufAwal == "be"){
	awalanTmp = potongAwalanBe(kata);	
	}
	else {
	awalanTmp = potongAwalanLainnya(kata);	
	}
	if(awalanTmp != ""){
		//deklarasi ulang kata dan _2hurufAwal
		var pjgAwalan = awalanTmp.length;
		kata = kata.substr(pjgAwalan,kata.length - pjgAwalan);
		_2hurufAwal = kata.substr(0,2);
	if(awalan2.indexOf(awalanTmp) > -1){
		// jika awalan[1] sudah ada isinya masukkan ke awalan[1];
		//if(awalan[1] != ""){
		//awalan[0] = awalanTmp;		
		//	}
		//else
		 awalan[1] = awalanTmp;
		
		}
	else {
		// pengecekan dilakukan untuk menangani kata yang berawalan ke seperti kerja, kemul, kemudan dll
		if(awalan[0] == ""){
		awalan[0] = awalanTmp;		
			}
		else {
		awalan[1] = awalanTmp;	
			}	
		
		}
	
		}	
	}
	return awalan;
  }
function potongAkhiran(kata){
	//jadikan huruf kecil semua
	var kata = kata.toLowerCase();
	var akhiran1 =['lah','kah','pun','tah'] ;
	var akhiran2 =['ku','mu','nya'] ;
	var akhiran3 =['i','an','kan'] ;
	var akhir =['','',''];
	var _3hurufAkhir = kata.substr(kata.length - 3);
	var _2hurufAkhir = kata.substr(kata.length - 2);
	var _1hurufAkhir = kata.substr(kata.length - 1);
	for(var i = 0; i < 3; i++){
		if(i == 0){
			if( akhiran1.indexOf(_3hurufAkhir) > -1){
				akhir[i] = _3hurufAkhir;
				//potong kata
				kata = kata.substr(0,kata.length - 3);
				//deklarasi ulang akhiran
				_3hurufAkhir = kata.substr(kata.length - 3);
				_2hurufAkhir = kata.substr(kata.length - 2);
				_1hurufAkhir = kata.substr(kata.length - 1);
				}
			}
		else if(i == 1){
			if( akhiran2.indexOf(_3hurufAkhir) > -1){
				akhir[i] = _3hurufAkhir;
				//potong kata
				kata = kata.substr(0,kata.length - 3);
				//deklarasi ulang akhiran
				_3hurufAkhir = kata.substr(kata.length - 3);
				_2hurufAkhir = kata.substr(kata.length - 2);
				_1hurufAkhir = kata.substr(kata.length - 1);
				}
			else if( akhiran2.indexOf(_2hurufAkhir) > -1){
				akhir[i] = _2hurufAkhir;
				//potong kata
				kata = kata.substr(0,kata.length - 3);
				//deklarasi ulang akhiran
				_3hurufAkhir = kata.substr(kata.length - 3);
				_2hurufAkhir = kata.substr(kata.length - 2);
				_1hurufAkhir = kata.substr(kata.length - 1);
				}	
			}
		else {
			if( akhiran3.indexOf(_3hurufAkhir) > -1){
				akhir[i] = _3hurufAkhir;
				}
			else if( akhiran3.indexOf(_2hurufAkhir) > -1){
				akhir[i] = _2hurufAkhir;
				}	
			else if( akhiran3.indexOf(_1hurufAkhir) > -1){
				akhir[i] = _1hurufAkhir;
				}	
			}		
		}
	return akhir;
	}
/*---------------------------------------------------
  ini untuk fungsi stemming_arifin (akhir) 
 ----------------------------------------------------*/ 
/*----------------------------------------------------
 untuk proses case folding,tokenizing dan filtering 
 -----------------------------------------------------*/  		
function strToPar(str){
	var par = str.split("\n");
	return par;
	}
function strToKal(str){
	var kal = str.split(".");
	return kal;
	}
function strToKata(str){
	var kata = str.split(" ");
	return kata;
	}
function caseFolding(str){
	var kata = str.toLowerCase();
	return kata;
	}	
function tokenizing(str){
	// pecah menjadi perparagraf, lalu perkalimat lalu perkata
	str = caseFolding(str);
	var par = strToPar(str);
	var kal = new Array();
	for(var i = 0; i < par.length; i++){
		kal[i] = strToKal(par[i]);
		}
	var kata = new Array();
	var h =0;
	for(var i = 0; i < kal.length; i++){
		for(var j =0; j < kal[i].length; j++){
			var temp= strToKata(kal[i][j]);
			for( var a in temp){
				kata[h] = temp[a];
				h++;
				}
			}
		}
	return kata;	
	}	
function tokenizing_baru(str){
	var	str = caseFolding(str);
	// hapus tanda baca dan spasi, lalu ganti dengan spasi sejumlah 1
	//var pola = ;
	str = str.replace(/[^\w]+/gi," ");
	return str.split(" ");
	}	
function filtering(kata_arr,stop_arr){
	// cek apakah kata ada dalam stop_arr
	var kata_terpilih = new Array();
	var i = 0;
	for(var a in kata_arr){
	// bila tidak ditemukan maka simpan kata tersebut
	if(!cekKamus(kata_arr[a],stop_arr)){
		kata_terpilih[i] = kata_arr[a];
		i++;
		}
	}
	return kata_terpilih;
}
/*------------------------------------------------------------------
 preprocessing ==>case folding->tokenizing->filtering->stemming
 -------------------------------------------------------------------*/ 	
function preprocessing(str,stop_arr){
	var kata_arr = tokenizing_baru(str);
	var kata_terpilih_arr = filtering(kata_arr,stop_arr);
	return kata_terpilih_arr;	
	}
function hash(str){
	var nilai = 0;
	for(var i in str){
		nilai += str.charCodeAt(i);
		}
	return nilai;	
	}
/**
 * Converts the given data structure to a JSON string.
 * Argument: arr - The data structure that must be converted to JSON
 * Example: var json_string = array2json(['e', {pluribus: 'unum'}]);
 * 			var json = array2json({"success":"Sweet","failure":false,"empty_array":[],"numbers":[1,2,3],"info":{"name":"Binny","site":"http:\/\/www.openjs.com\/"}});
 * http://www.openjs.com/scripts/data/json_encode.php
 */
function array2json(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}
