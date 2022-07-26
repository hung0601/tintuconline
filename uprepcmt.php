<?php
include 'data.php';
$dt = new database();
$id_bantin = $_POST['id_bantin'];
$id_user = $_POST['id_user'];
$id_cmt = $_POST['id_cmt'];
$data = array(
    'id_user' => $id_user,
    'id_coment'  => $id_cmt,
    'noidung_repcmt'  => $_POST['noidung_cmt']
);
$dt->db_insert('repcoment', $data);
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
