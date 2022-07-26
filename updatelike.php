<?php
include 'data.php';
$dt = new database();
$id_bantin = $_POST['id_bantin'];
$id_user = $_POST['id_user'];
$id_cmt = $_POST['id_cmt'];
$status = $_POST['status'];
if ($status) {
    $data = array(
        'id_cmt' => $id_cmt,
        'id_user' => $id_user
    );
    $dt->db_insert('cmt_like', $data);
} else {
    $sql = "DELETE FROM `cmt_like` WHERE id_cmt='$id_cmt' AND id_user='$id_user'";
    $dt->command($sql);
}
$row = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like WHERE id_cmt='$id_cmt'");
echo '<i class="fas fa-thumbs-up">' . ' ' . $row['like_number'] . '</i>';
$islike = $dt->db_get_row("SELECT count(id_user) as like_number FROM cmt_like 
			WHERE id_cmt='$id_cmt'
			AND id_user='$id_user'");
if ($islike['like_number'] > 0) { ?>
    <script language="javascript">
        $('.<?php echo $id_cmt ?>').addClass('liked');
    </script>
<?php }else{ ?>
    <script>
    $('.<?php echo $id_cmt ?>').removeClass('liked');
    </script>
<?php }
