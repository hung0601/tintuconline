
<?php
session_start();
include'data.php';
$dt= new database();
$id_bantin=$_POST['id_bantin'];
$id_user=$_SESSION['id_user'];

$sql="SELECT coment.*,name_user,anh_user FROM coment,user WHERE coment.id_user= user.id_user
		AND id_bantin='$id_bantin' ORDER BY ngaytao_cmt DESC";
		$users=$dt->db_get_list($sql);
		foreach ($users as $item) {
			$row = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like WHERE id_cmt='$item[id_cmt]'");
			$avatar = $item['anh_user'];
			$id_cmt=$item['id_cmt'];
			echo '<div class="user_cmt">';
			echo '<div class="avatar">';
			echo "<img src='$avatar' alt='Ảnh đại diện' class='avatar_cmt'/>";
			echo '</div>';
			echo '<div class="content_cmt" id="'.$id_cmt.'">	';
			echo '<p class="username_cmt">' . $item['name_user'] . '</p>';
			echo '<p>' . $item['noidung_cmt'] . '</p>';

			echo '<a href="" onclick="return false" class="like '.$id_cmt.'"><i class="fas fa-thumbs-up">' . ' ' . $row['like_number'] . '</i></a>';
			echo '<a href="" onclick="return false">Trả lời</a>';
			echo '</div>';
			echo '</div>';
			$islike = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like 
			WHERE id_cmt='$id_cmt'
			AND id_user='$id_user'");
			if($islike['like_number']>0) { ?>
			<script language="javascript" >
				$('.<?php echo $id_cmt ?>').addClass('liked');
			</script>
<?php
			}
		}
