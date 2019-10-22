<?php
include_once "include/koneksi.php";
$kata = $_REQUEST['kata'];
$sinonim = $_REQUEST['sinonim'];
// update sinonim pada database;
$sql = "update kamus set sinonim ='".$sinonim."' where kata ='".$kata."'";
$sql2 = "update kamus set sinonim ='".$kata."' where kata ='".$sinonim."'";
mysql_query($sql);
mysql_query($sql2);
?>
