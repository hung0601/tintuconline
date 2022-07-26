<?php
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['phanquyen']);
	unset($_SESSION['id_user']);
	header("location:index.php");



?>