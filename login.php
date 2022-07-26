<?php
include 'top.php';
include 'right.php';
?>



<div id="content1" class="content">
	<h1>Đăng nhập hệ thống</h1>
	<div id="ndcontent1" class="ndcontent">
		<form method="post">
			<table width="60%" align="center">
				<tr>
					<td>Tên đăng nhập: </td>
					<td><input type="text" name="user" size="40"></td>
				</tr>
				<tr>
					<td>Mật khẩu: </td>
					<td><input type="password" name="pass" size="40" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="login" value="Đăng nhập" />
						<input type="submit" name="create" style="width : 81.22px" value="Đăng ký" />
					</td>


				</tr>

			</table>
		</form>
		<?php
		if (isset($_POST['login'])) {/*kiem tra nguoi dung nhan nut dang nhap*/
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			$dt->select("SELECT * FROM user WHERE name_user LIKE '$user' AND password_user LIKE '$pass'");
			if ($r = $dt->fetch()) {

				$_SESSION['username'] = $user;
				$_SESSION['phanquyen'] = $r['phanquyen_user'];
				$_SESSION['id_user'] = $r['id_user'];
				$_SESSION['anh_user'] = $r['anh_user'];
				// if (isset($_SESSION['pre_url'])) {
				// 	echo $_SESSION['pre_url'];
				// 	redirect($_SESSION['pre_url']);
				// } else
					header("location:index.php");
			} else {
				echo '<p style = "color : red">Đăng nhập thất bại! Xin mời đăng nhập lại.</p>';
			}
		}
		if (isset($_POST['create'])) {
			header("location:signup.php");
		}

		?>
	</div>

</div>


</div><!-- nội dung -->


<?php
include 'bottom.php';

?>