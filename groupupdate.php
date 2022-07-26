<?php
include 'top.php';
include 'right.php';
if(isset($_GET['id'])){
	$id_theloai = $_GET['id'];
	$dt->select("SELECT name_theloai FROM theloai WHERE id_theloai = '$id_theloai'");
	$row = $dt->fetch();
}
?>



<div id = "content1" class = "content">
<h1>Sửa thể loại: <?php echo $row['name_theloai']; ?> </h1>
<div id = "ndcontent1" class = "ndcontent"> 
	<form method = "post" align = "center" >
	Tên nhóm: <input type = "text" name = "nametl" size = "40"
	value = " <?php echo $row['name_theloai']; ?>"/>
	<input type = "submit" name = "update" value = "Chấp nhận"/>
	</form>
	<?php
			if(isset($_POST['update'])){
		$name = $_POST['nametl'];
			if($name){
				$dt->command("UPDATE theloai SET name_theloai = '$name' WHERE id_theloai = '$id_theloai' ");
				header("location:groupadd.php");
			}
			else{
				{echo'<p style = "color : red">Không được bỏ trống.</p>';}
			}
		
	}
?>
</div>
	

</div>




</div><!-- nội dung -->


<?php

include 'bottom.php';

?>
