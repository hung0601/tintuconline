<?php
session_start();
include 'data.php';
$dt = new database;
if(isset($_GET['id_tl']) && isset($_GET['id_bt'])){
	$id_theloai = $_GET['id_tl'];
	$id_bantin  = $_GET['id_bt'];
	$dt->command("DELETE FROM bantin WHERE id_theloai= '$id_theloai' AND id_bantin = '$id_bantin'");
	header("location:news.php?id=$id_theloai");
}
?>
