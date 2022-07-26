<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include 'data.php';
include 'libs/helper.php';

$dt = new database;
include 'libs/user.php';
// if(isset($_SESSION['current_url'])) {
// 	$_SESSION['pre_url']=$_SESSION['current_url'];
// };
// $_SESSION['current_url'] = str_replace('/tintuconline1', '.', $_SERVER['REQUEST_URI']);
// ?>





<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="utf-8">
	<title>Báo mới</title>
	<script language="javascript" src="./js/jquery-3.6.0.min.js"></script>
	<script src="https://kit.fontawesome.com/4106177160.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="style3.css" type="text/css">
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

	<style>
		body {
			background-image: url(https://upload.wikimedia.org/wikipedia/commons/7/78/Tr%C6%B0%E1%BB%9Bc_C1.png);
			background-size: cover;
			background-attachment: fixed;

		}
	</style>
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			font-family: Verdana, sans-serif;
		}

		.mySlides {
			display: block;
		}

		.mySlides img {
			vertical-align: middle;
			height: 500px;
			width: 1000px;
		}

		.mySlides.hide {
			transition: disapper 1.5s linear;
		}

		/* Slideshow container */
		.slideshow-container {
			max-width: 1000px;
			position: relative;
			margin: auto;
			margin-top: 30px;
		}



		/* Number text (1/3 etc) */


		/* The dots/bullets/indicators */

		/* Fading animation */
		.fade {
			-webkit-animation-name: fade;
			-webkit-animation-duration: 1.5s;
			animation-name: fade;
			animation-duration: 1.5s;
		}

		.disapear {
			-webkit-animation-name: disapear;
			-webkit-animation-duration: 1.5s;
			animation-name: disapear;
			animation-duration: 1.5s;
		}

		@-webkit-keyframes fade {
			from {
				margin-left: 20%;
				margin-right: -20%
			}

			to {
				margin-left: 0;
				margin-right: 0;
			}
		}

		@keyframes fade {
			from {
				margin-left: 20%;
				margin-right: -20%
			}

			to {
				margin-left: 0;
				margin-right: 0;
			}
		}

		
		/* On smaller screens, decrease text size */
		@media only screen and (max-width: 300px) {
			.text {
				font-size: 11px
			}
		}
	</style>
</head>

<body>
	<div id="main">
		<!--Bao gồm toàn bộ khung web -->


		<div id="menutop" class="main-nav">
			<div id="menu">
				<ul>
					<li><a href="index.php"> Trang chủ</a></li>
					<?php
					$dt->select('SELECT * FROM  theloai');
					while ($r = $dt->fetch()) {
						$id = $r['id_theloai'];
						$name = $r['name_theloai'];
						echo "<li><a href = 'news.php?id=$id'>$name</a></li>";
					}




					?>

				</ul>
				<ul>
					<?php
					if (isset($_SESSION['username'])) {/*dung isset kiem tra user name ton tai*/
						echo '<li>
						<div class="user_box">
						<img class="avatar_cmt" src="' . $_SESSION['anh_user'] . '">
						<a href = "" onclick="return false">' . $_SESSION['username'] . '</a>
						</div>
						<div class="dropdown_menu">
						<a class="dropdown_item" href="logout.php" class="log_button"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
						</div>
						</li>';
					?>
						<script>
							$('.user_box img').click(function() {
								$('.dropdown_menu').toggle();
							});
						</script>
					<?php
					} else {
						echo "<li><a href='login.php'  class='log_button'> Đăng Nhập</a></li>";
						echo "<li><a href = 'signup.php' class='log_button'> Đăng Kí</a></li>";
					}


					?>

				</ul>

			</div>

		</div>
		<div id="head">
			<!-- Banner -->

			<?php
			$add = $dt->db_get_list('SELECT * FROM `quangcao` ORDER By tien_quangcao DESC ');
			echo '<div class="slideshow-container">';
			foreach ($add as $index) {
			?>

				<div class="mySlides fade">
					<a href="<?php echo $index['link_quangcao'] ?>"><img src="<?php echo $index['anh_quangcao'] ?>" style="width:100%"></a>
					<div class="text"></div>
				</div>
			<?php } ?>
		</div>
		<script>
			var slideIndex = 1;
			showSlides();

			function showSlides() {
				var slides = document.getElementsByClassName("mySlides");
				var i;
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}
				slideIndex++;
				if (slideIndex > slides.length) {
					slideIndex = 1
				}
				slides[slideIndex - 1].style.display = "block";
				setTimeout(showSlides, 7000); // Change image every 2 seconds
			}
		</script>
	</div>

	<div id="maincontent">