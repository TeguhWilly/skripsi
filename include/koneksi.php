<?php 
//error_reporting(E_ALL^E_NOTICE);
$user='root';
$server='localhost';
$pass='';
$database='koreksiOtomatis';
mysql_connect($server,$user, $pass) or die('koneksi gagal');
mysql_select_db($database) or die('database tidak ditemukan');
?>
