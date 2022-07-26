<?php
include 'top.php';
include 'right.php';
if(isset($_GET['id'])){
	$id_theloai = $_GET['id'];
	$dt->select("SELECT name_theloai FROM theloai WHERE id_theloai = '$id_theloai'");
	$row = $dt->fetch();

?>

<style>
	h4{
		color: red;
		margin-bottom: 0px;
		
	}


</style>

<div id = "content1" class = "content">
<h1>Thêm bản tin: <?php echo $row['name_theloai']; ?></h1>
<div id = "ndcontent1" class = "ndcontent"> 
	<form method = "post">
		<h4>Tiêu đề: </h4>
		<input type = "text" name = "tieude" size = "90"/>
		<h4>Trích dẫn: </h4>
		<textarea name = "trichdan" cols = "90" rows = "7"></textarea>
		<h4>Ảnh trích dẫn: </h4>
		<input type = "text" name = "anhtrichdan" size = "90"/>
		<h4>Nội dung: </h4>
		<textarea name = "noidung" id ="cknoidung"></textarea>
		<script>
			CKEDITOR.replace(cknoidung);
		</script>
		<h4>Tác giả: </h4>
		<input type = "text" name = "tacgia" size = "90"/><br><br>
		<input type = "submit" name = "Them" value = "Chấp nhận"/>
	
	</form>
	
<?php
	$id_user =  $_SESSION['id_user'];
	if(isset($_POST['Them'])){
		$tieude = $_POST['tieude'];
		$trichdan = $_POST['trichdan'];
		$anhtrichdan = $_POST['anhtrichdan'];
		$noidung = $_POST['noidung'];
		$tacgia = $_POST['tacgia'];
	/*	if($tieude == NULL || $trichdan == NULL || $noidung == NULL || $tacgia== NULL)
		{
			echo "<p style = 'color : red'>Không được bỏ trống.</p>";
		}*/
		
	$dt->command("INSERT INTO `bantin`(`tieuDe`, `trichDan`, `anh`, `noiDung`, `tacGia`, `id_theloai`, `id_nguoitao`) 
					VALUES ('$tieude','$trichdan','$anhtrichdan','$noidung','$tacgia','$id_theloai','$id_user')");
		header("location:news.php?id=$id_theloai");
		
	}
	





?>

</div>

</div>


</div><!-- nội dung -->


<?php

}
include 'bottom.php';

?>
