<?php
session_start();
include 'data.php';
$dt = new database;
if(isset($_GET['id'])){
	$id_theloai = $_GET['id'];
	$dt->command("DELETE FROM bantin WHERE id_theloai= '$id_theloai'");
	$dt->command("DELETE FROM theloai WHERE id_theloai= '$id_theloai'");
	header("location:groupadd.php");
}
?>
