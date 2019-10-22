<?php
session_start();
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
$status = 0;
$pass = $_REQUEST['pass'];
$nama_tabel = "user";
$sql ="update ".$nama_tabel." set password =md5('".$pass."') where username='".$_SESSION[userId]."'"; 
$sql_exc = mysql_query($sql);
if($sql_exc){
$status = 1;
}
echo $status;
//echo $sql;
?>
