<div class="judul" style="text-transform : uppercase;">Halaman Ganti Pasword</div>
<div style="margin:10px">
<form action="proses_ganti_password.php">
<dl>
	<dt>
		<label>Masukkan Password Baru</label>
	</dt>
	<dd>
		<input name="password" type="password" />
	</dd>
	<dt>
		<label>Ulangi password</label>
	</dt>
	<dd>
		<input type="password" />
	</dd>
	<dt></dt>
	<dd>
		<input type="submit" value="simpan" />
	</dd>
	</dl>	
</form>	
<script >
$(function(){
// event ketika tombol submit diklik
	$("form").submit(function(){
		// validasi dulu
		if(($(":password").eq(0).val() != $(":password").eq(1).val()) || ($(":password").eq(0).val() == "")){
			alert("diisi dulu dong......... dan harus sama");
			}
		else {
		var url = $(this).attr("action");
		var pass = $("input:first").val();
		$.post(url,{pass:pass},function(hasil){
			if(hasil == 1){
			$("#content").html("<div style='font-size:1.5em;'>Password sudah diganti</div>");
				}
			})
		  }	
		return false;
	});
})			
</script>
