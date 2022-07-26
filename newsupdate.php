<?php
ob_start();
include 'top.php';
include 'right.php';
if(isset($_GET['id_tl']) && isset($_GET['id_bt'])){
	$id_theloai = $_GET['id_tl'];
	$id_bantin  = $_GET['id_bt'];
	$dt->select("SELECT * FROM bantin WHERE id_theloai= '$id_theloai' AND id_bantin = '$id_bantin'");
	$row = $dt->fetch();
?>

<style>
	h4{
		color: red;
		margin-bottom: 0px;
		
	}


</style>

<div id = "content1" class = "content">
<h1>Sửa bản tin chi tiết: </h1>
<div id = "ndcontent1" class = "ndcontent"> 
	<form method = "post">
		<h4>Tiêu đề: </h4>
		<input type = "text" name = "tieude" size = "90" value= "<?php echo$row['tieuDe'];?>"/>
		<h4>Trích dẫn: </h4>
		<textarea name = "trichdan" cols = "90" rows = "7"><?php echo$row['trichDan'];?></textarea>
		<h4>Ảnh trích dẫn: </h4>
		<input type = "text" name = "anhtrichdan" size = "90"/ value= "<?php echo$row['anh'];?>">
		<h4>Nội dung: </h4>
		<textarea name = "noidung" id ="cknoidung"><?php echo$row['noiDung']?></textarea>
		<script>
			CKEDITOR.replace(cknoidung);
		</script>
		<h4>Tác giả: </h4>
		<input type = "text" name = "tacgia" size = "90" value= "<?php echo$row['tacGia'];?>"/><br><br>
		<input type = "submit" name = "update" value = "Cập nhật"/>
	
	</form>	
<?php
	$id_user =  $_SESSION['id_user'];
	if(isset($_POST['update'])){
		$tieude = $_POST['tieude'];
		$trichdan = $_POST['trichdan'];
		$anhtrichdan = $_POST['anhtrichdan'];
		$noidung = $_POST['noidung'];
		$tacgia = $_POST['tacgia'];
		
		
	
		
	$dt->command("UPDATE `bantin` SET `tieuDe`='$tieude', trichDan= '$trichdan' , anh = '$anhtrichdan', noiDung = '$noidung', tacGia= '$tacgia'  WHERE id_theloai= '$id_theloai' AND id_bantin = '$id_bantin'");
		header("location:newsdetail.php?id_tl=$id_theloai&id_bt=$id_bantin");
		ob_end_flush();
	}
?>

</div>

</div>


</div><!-- nội dung -->


<?php

}
include 'bottom.php';

?>
