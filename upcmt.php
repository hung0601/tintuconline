<?php
include 'data.php';
include 'libs/helper.php';
$dt = new database();
$id_bantin = $_POST['id_bantin'];
$id_user = $_POST['id_user'];
$data = array(
	'id_user' => $_POST['id_user'],
	'id_bantin'  => $_POST['id_bantin'],
	'noidung_cmt'  => $_POST['noidung_cmt']
);
$dt->db_insert('coment', $data);
$sql = "SELECT coment.*,name_user,anh_user FROM coment,user WHERE coment.id_user= user.id_user
		AND id_bantin='$id_bantin' ORDER BY ngaytao_cmt DESC";
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
		echo '<p class="show_reply"><i>Xem</i> ' . $rep_num['rep_number'] . ' câu trả lời</p>';
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
		echo '<p class="username_cmt username_reply">' . $i['name_user'] . '&emsp; <i>vừa xong</i></p>';
		echo '</div>';
		echo '<div class="clearfix"></div>';
		echo '<p class="rep_content">' . $i['noidung_repcmt'] . '</p>';
		echo '</div>
				</div>';
	}
	echo '</div>';
	if (isset($id_user)) { ?>
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
if (isset($id_user)) { ?>
	<script language="javascript">
		$('#click_comment').click(function() {
			$.ajax({
				url: 'upcmt.php',
				type: 'post',
				dataType: 'text',
				data: {
					id_user: <?php echo $id_user ?>,
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
					id_user: <?php echo $id_user; ?>,
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
					id_user: <?php echo $id_user; ?>,
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