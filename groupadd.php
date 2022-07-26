<?php
ob_start();
include 'top.php';
include 'right.php';

?>

<style>
#table1 table{
    border:0.5px solid black;
}

#table1 table{
    border-collapse:collapse;
	text-align: center;
	font-family: Times New Roman;
	
}
#table1 th{
	font-size:20px;
	border:0.5px solid black;
}
#table1 td{
	font-size:18px;
	border:0.5px solid black;
}
a{
	text-decoration: none;
	color: blue;
}
a:hover{
	text-decoration: underline;
	color:red;
}
h4{
	color: red;
}
</style>

<div id = "content1" class = "content">
<h1>Xử lý thể loại</h1>
<div id = "ndcontent1" class = "ndcontent"> 
<div id = "table1">
<table width = "80%" align = "center">
	<tr>
		<th>STT</th><th>Tên thể loại</th><th>Xử lý</th>
	</tr>
<?php
	$dt->select("SELECT * FROM theloai");
	$i  = 0;
	while($r= $dt->fetch()){
		$i++;
		$id_tl = $r['id_theloai'];
		$name = $r['name_theloai'];
		echo"<tr>";
			echo"<td>$i</td><td>$name</td>";
			echo"<td>";
				echo"<a href = 'groupupdate.php?id=$id_tl'>Sửa</a>";
				echo" | <a href = 'groupdelete.php?id=$id_tl'>Xóa</a>";
			echo"</td>";
		echo"</tr>";
	}
	echo "</table>";

?>
</div>
	<h4>Thêm nhóm mới: </h4>
		<form method="post">
			<table width = "60%" align = "center">
		<tr>
			<td>Tên nhóm: </td>
			<td><input type="text" name = "nametl" size="40"></td>
		</tr>
		<tr>
			<td colspan = "2" align= "center">
			<input type = "submit" name = "add" value = "Thêm"/>
			
			</td>
			
			
		</tr>
	
	</table>
		</form>
<?php
			if(isset($_POST['add'])){
		$name = $_POST['nametl'];
			if($name){
				$dt->select("SELECT * FROM theloai WHERE name_theloai LIKE '$name'");
				$row = $dt->fetch();
				if($row) 
				{echo'<p style = "color : red">Tên thể loại đã tồn tại.</p>';}
				else{
				$dt->command("INSERT INTO theloai (name_theloai) VALUE ('$name')");
				header("location:groupadd.php");
				ob_end_flush();
				}
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
