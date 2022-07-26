<?php
include 'top.php';
include 'right.php';
if (isset($_GET['id_tl']) && isset($_GET['id_bt'])) {
	$id_theloai = $_GET['id_tl'];
	$id_bantin  = $_GET['id_bt'];
	if (isset($_SESSION['id_user'])) $id_user = $_SESSION['id_user'];
	$dt->select("SELECT * FROM theloai WHERE id_theloai = '$id_theloai'");
	$row = $dt->fetch();
}
?>

<style>
	#ndcontent1 img {
		display: block;
		margin-left: auto;
		margin-right: auto;
	}

	#ndcontent1 b {
		float: right;
		font-size: 16px;
	}

	#ndcontent1 p {
		font-size: 15px;
	}

	#ndcontent1 a {
		color: blue;
		text-decoration: none;
	}

	#ndcontent1 a:hover {

		color: red;
		text-decoration: underline;
		/*khong co dau gach chan*/
		font-weight: bold;
	}
</style>


<div id="content1" class="content">
	<h1><?php echo $row['name_theloai']; ?></h1>
	<div id="ndcontent1" class="ndcontent">
		<?php
		if (isset($_SESSION['username']) && isset($_SESSION['phanquyen'])) {/*dung isset kiem tra user name ton tai*/
			if ($_SESSION['phanquyen'] == 1) {
				echo "<p  align= 'right' style = 'font-size : 18px;'>";
				echo "<a href = 'newsupdate.php?id_tl=$id_theloai&id_bt=$id_bantin'>Sửa bản tin</a>";
				echo " | <a href = 'newsdelete.php?id_tl=$id_theloai&id_bt=$id_bantin'>Xóa bản tin</a>";
				echo "</p>";
			}
		}

		$dt->select("SELECT * FROM bantin WHERE id_theloai= '$id_theloai' AND id_bantin = '$id_bantin'");
		$r = $dt->fetch();
		if ($r) {
			$luotxem = $r['luotXem'] + 1;
			$ngay = $r['ngayTao_bantin'];
			echo "<h2>";
			echo $r['tieuDe'];
			echo "</h2>";
			echo "<p style = 'text-align: right; color: #757575; font-size: 14px'>
	Ngày tạo: ";
			$time = strtotime($ngay);
			echo date("d-m-Y h:i:s", $time);
			echo "<br>Số lượt xem: $luotxem</p>";

			echo "<h3>";
			echo $r['trichDan'];
			echo "</h3>";
			$anh = $r['anhnd_bantin'];
			if ($anh) {
				echo "<img src ='$anh' width = '826' height = 'auto'> ";
			}
			echo "<p align = justify>";
			echo $r['noiDung'];
			echo "</p>";
			echo "<b>";
			echo $r['tacGia'];
			echo "</b><br><br>";
			echo "<h4 style = 'color: red; font-size: 15.5px'>Có thể bạn quan tâm: </h4>";
			$dt->select("SELECT * FROM bantin WHERE id_theloai= '$id_theloai' AND id_bantin != '$id_bantin' ORDER BY `ngayTao_bantin` DESC LIMIT 5");
			$i = 0;
			echo "<ul>";
			while ($rowt = $dt->fetch()) {
				$tieude = $rowt['tieuDe'];
				$id_btk = $rowt['id_bantin'];
				echo "<li><h4><a href ='newsdetail.php?id_tl=$id_theloai&id_bt=$id_btk'>$tieude</a></h4></li>";
				$i++;
			}

			if ($i == 0) {
				echo "<li>Không có bản tin mới.</li>";
			}
			echo "</ul>";
			$dt->command("UPDATE bantin SET luotXem = '$luotxem' WHERE id_theloai = '$id_theloai' AND id_bantin = '$id_bantin'");
		} else {
			echo "Khong co ban tin nay.";
		}

		?>

	</div>

</div>

<div id="content2" class="content">
	<h1>Bình luận</h1>
	<div class="comment_box">

		</h3>
		<?php if (isset($_SESSION['username'])) { ?>
			<textarea id="comment_box" name="comment" placeholder="Bình luận..."></textarea>
			<input type="button" name="sent_comment" id="click_comment" value="Gửi" />
		<?php } else { ?>
			<h3> Đăng nhập để bình luận
				<a href="./login.php" class="log_button">Đăng nhập</a>
				<a href="./signup.php" class="log_button">Đăng kí</a>
			<?php } ?>

	</div>
	<div class="comment_list">
		<?php
		$id_bt = $_GET['id_bt'];
		$sql = "SELECT coment.*,name_user,anh_user FROM coment,user WHERE coment.id_user= user.id_user
		AND id_bantin='$id_bt' ORDER BY ngaytao_cmt DESC";
		$users = $dt->db_get_list($sql);
		foreach ($users as $item) {
			$row = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like WHERE id_cmt='$item[id_cmt]'");
			$avatar = $item['anh_user'];
			$id_cmt = $item['id_cmt'];
			echo '<div class="user_cmt">';
			echo '<div class="avatar">';
			echo "<img src='$avatar' alt='Ảnh đại diện' class='avatar_cmt'/>";
			echo '</div>';
			echo '<div class="content_cmt" id="' . $id_cmt . '">	';
			echo '<p class="username_cmt">' . $item['name_user'] . '&emsp; <i>' . date_process($item['ngaytao_cmt']) . '</i></p>';
			echo '<p>' . $item['noidung_cmt'] . '</p>';

			echo '<a href="" onclick="return false" class="like ' . $id_cmt . '"><i class="fas fa-thumbs-up">' . ' ' . $row['like_number'] . '</i></a>';
			echo '<a href="" onclick="return false" class="rep_button">Trả lời</a>';
			$rep_num = $dt->db_get_row("SELECT count(id_repcmt) as rep_number FROM repcoment WHERE id_coment='$item[id_cmt]'");
			if ($rep_num['rep_number'] > 0) {
				echo '<p class="show_reply show"><i>Xem</i> ' . $rep_num['rep_number'] . ' câu trả lời</p>';
			}
			echo '<div class="reply_list">';
			echo '<div class="rep_list">';
			$sql = "SELECT repcoment.*,name_user,anh_user FROM repcoment,user WHERE repcoment.id_user= user.id_user
			AND id_coment='$id_cmt' ORDER BY ngaytao_repcmt ASC";
			$reply = $dt->db_get_list($sql);
			foreach ($reply as $i) {
				$rep_avatar = $i['anh_user'];
				$id_rep = $i['id_repcmt'];
				echo '<div class="reply_box">
					<div class="content_cmt">
						<div class="reply_head">
							<div class="avatar rep_avatar">';
				echo "<img src='$rep_avatar'  alt='Ảnh đại diện' class='avatar_cmt' />";
				echo '</div>';
				echo '<p class="username_cmt username_reply">' . $i['name_user'] . '&emsp; <i>' . date_process($i['ngaytao_repcmt']) . '</i></p>';
				echo '</div>';
				echo '<div class="clearfix"></div>';
				echo '<p class="rep_content">' . $i['noidung_repcmt'] . '</p>';
				echo '</div>
				</div>';
			}
			echo '</div>';
			if (isset($_SESSION['id_user'])) { ?>
				<div class="input_reply">
					<input type="text" name="reply" class="reply">
					<button name="sent_rep" type="button" class="click_rep"><i class="fas fa-paper-plane"></i></button>
				</div>
				<?php }
			echo '</div>';
			echo '</div>';
			echo '</div>';
			if (isset($id_user)) {
				$islike = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like 
			WHERE id_cmt='$id_cmt'
			AND id_user='$id_user'");
				if ($islike['like_number'] > 0) { ?>
					<script language="javascript">
						$('.<?php echo $id_cmt ?>').addClass('liked');
					</script>
		<?php
				}
			}
		}
		?>

	</div>
	<div id="ndcontent2" class="ndcontent">


	</div>

</div>
<?php if (isset($_SESSION['id_user'])) { ?>
	<script language="javascript">
		$('#click_comment').click(function() {
			$.ajax({
				url: 'upcmt.php',
				type: 'post',
				dataType: 'text',
				data: {
					id_user: <?php echo $_SESSION['id_user'] ?>,
					noidung_cmt: $('#comment_box').val(),
					id_bantin: <?php echo $id_bantin; ?>
				},
				success: function(result) {
					$('.comment_list').html(result);
					// location.reload();
				}
			});
		});
		$('.click_rep').click(function() {
			const parent = $(this).parent('.input_reply');
			noidung = parent.children('.reply').val();
			const id_cmt = $(this).parent().parent().parent().attr('id');
			$.ajax({
				url: 'uprepcmt.php',
				type: 'post',
				dataType: 'text',
				data: {
					id_bantin: <?php echo $id_bantin; ?>,
					id_user: <?php echo $_SESSION['id_user']; ?>,
					noidung_cmt: noidung,
					id_cmt: id_cmt
				},
				success: function(result) {
					$('.rep_list').html(result);
				}
			});
		});
	</script>
	<script language="javascript">
		$('.rep_button').click(function() {
			$(this).parent().children('.reply_list').show();
			$(this).parent().children('.reply_list').children('.input_reply').children('.reply').focus();
		});

		$('.like').click(function() {
			var id_cmt = $(this).parent('.content_cmt').attr('id');
			const current = $(this);
			var status;
			if ($(this).hasClass('liked')) {
				status = 0;
			} else {
				status = 1;
			}
			$.ajax({
				url: 'updatelike.php',
				type: 'post',
				dataType: 'text',
				data: {
					id_user: <?php echo $_SESSION['id_user']; ?>,
					id_cmt: id_cmt,
					id_bantin: <?php echo $id_bantin; ?>,
					status: status
				},
				success: function(result) {
					current.html(result);
				}
			});
		});
	</script>
<?php } ?>
<script language="javascript">
	$('.show_reply').click(function() {
		if ($(this).hasClass('show')) {
			$(this).parent().children('.reply_list').show();
			$(this).parent().children('.reply_list').children('.input_reply').children('.reply').focus();
			$(this).children('i').html('Ẩn');
			$(this).removeClass('show');
		} else {
			$(this).parent().children('.reply_list').hide();
			$(this).children('i').html('Xem');
			$(this).addClass('show');
		}
	});
	// function load_cmt() {
	// 	$.ajax({
	// 		url: 'reload_cmt.php',
	// 		type: 'post',
	// 		dataType: 'text',
	// 		data: {
	// 			id_bantin: <?php echo $id_bantin; ?>
	// 		},
	// 		success: function(result) {
	// 			$('.comment_list').html(result);
	// 		}
	// 	});
	// }
	// setInterval(load_cmt, 2000);
</script>
</div><!-- nội dung -->



<?php

include 'bottom.php';

?>