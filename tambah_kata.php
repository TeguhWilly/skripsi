<?php
include_once "cek_session.php";
?>
<div class="judul" style="text-transform : uppercase;">Menambahkan Kata Dalam Kamus</div>
<div style="margin:10px">
<form action="proses_tambah_kata.php">
<dl>
	<dt>
		<label>Kata baru</label>
	</dt>
	<dd>
		<input name="kata" type="text" size="40" value="" />
	</dd>
	<dt>
		<label>Sinonim</label>
	</dt>
	<dd>
		<input name="sinonim" type="text" size="40" value="" />
	</dd>
	<dt>
	<dd>
		<input value="simpan" type="submit" />
	</dd>	
	</dt>
</dl>	
</form>
</div>
<div class="clear"></div>
<div id="kata_baru">Daftar kata yang baru ditambahkan</div>
<script>
$(function(){
	// event ketika tombol submit diklik
	$("form").submit(function(){
		var kata = $("input[name=kata]").val();
		var sinonim = $("input[name=sinonim]").val();
		var url = $(this).attr("action");
		 var data = $(this).serializeArray();
		$.post(url,{data:data},function(hasil){
			if(hasil == 1){
		/*
				// cek apakah update ato insert
				if($("#lightbox").is(":visible")){
					$("form").parent().html("<h2>Data telah disimpan..........</h2>");
					// hapus lightbox
					$("#lightbox, #lightbox-panel").fadeOut(3000);
					}
				*/	
				// ubah isi dari div content ke menu lihat tes
				$("<div>"+kata+" sinonimnya "+sinonim+"</div>").appendTo("#kata_baru");
				}
			else {
				$("<div>gagal ditambahkan, mungkin sudah ada</div>").appendTo("#kata_baru");
				}	
			})
		return false;
		});
})
</script>
