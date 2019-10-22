<?php
session_start();
if(isset($_SESSION['userId'])){
	return 1;	
	}
else {
	session_destroy();
	echo "<script>window.location.reload()</script>";
	}	
?>
