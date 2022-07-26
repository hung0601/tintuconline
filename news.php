<?php
include 'top.php';
include 'right.php';
if(isset($_GET['id'])){
	$id_theloai = $_GET['id'];
	$dt->select("SELECT name_theloai FROM theloai WHERE id_theloai = '$id_theloai'");
	$row = $dt->fetch();

?>

<link rel = "stylesheet" href = "style3.css" type = "text/css">

<div id = "content1" class = "content">
<h1>Tin <?php echo $row['name_theloai'];?> mới nhất</h1>
<div id = "ndcontent1" class = "ndcontent"> 
<ul class = "banghi">
<?php
	if(isset($_SESSION['username']) && isset($_SESSION['phanquyen'])){/*dung isset kiem tra user name ton tai*/
		if($_SESSION['phanquyen'] == 1){
		echo"<p  align= 'right' style = 'font-size : 18px;'>";
		echo"<a href = 'newsadd.php?id=$id_theloai'>Thêm bản tin</a>";
		echo"</p>";
		}
	}
	// so luong tin 1 trang
	$soluong = 3;
	
	// tong so luong ban ghi co cua nhom
	$dt->select("SELECT COUNT(id_bantin) AS tong FROM  bantin WHERE id_theloai = '$id_theloai'");
	$rw = $dt->fetch();
	$tong = $rw['tong'];
	
	if($tong>0){
	// so luong trang neu ban tin it hon so luong khong can chia
	if($tong>$soluong){
		$sotrang = ceil($tong/$soluong);//lay phan nguyen tiep theo
		
	}
	else{
		$sotrang = 1;
	}
	 // xac dinh trang hien tai
	 if(isset($_GET['page'])){
		 $page = $_GET['page'];
		 
	 }
	else{
		$page = 1;
	}
	//XAc dinh ban ghi dau tien cua moi trang
	$start = ($page-1)*$soluong;
	
	// hien thi noi dung cua trang
	
	
	//bat dau tu start thu may va lay ra so luong la
		$dt->select("SELECT * FROM  bantin WHERE id_theloai = '$id_theloai' ORDER BY ngayTao_bantin DESC LIMIT $start,$soluong");
		$i = 0;
	while( $r = $dt->fetch() ){
		$id_bt = $r['id_bantin'];
		$id_tl = $r['id_theloai'];
		$tieude = $r['tieuDe'];
		$anh = $r['anh'];
		$trichDan = $r['trichDan'];
		$i++;
		echo "<li>";
		echo "<img src = '$anh' width = '183.3px' height = '109.16px'/>";
		echo "<h2><a href ='newsdetail.php?id_tl=$id_tl&id_bt=$id_bt'>$tieude</a></h2>";
		echo "<p>$trichDan</p><br>";
		echo "</li>";
		$i++;		
	}
		
	}
		else{
			echo"Không có bản tin trong mục này.";
		}
	?>
</ul>
<?php
			if($tong>$soluong){
				//Hien thi link trang:
			echo"<ul class = 'phantrang'>";
			//nut prev
			if($page>1){
				$prev = $page-1;
				echo"<li class = 'dacbiet'><a href = 'news.php?id=$id_tl&page=$prev'>Prev</a></li>";
				
			}
			//nut so:
			for($i = 1; $i<= $sotrang; $i++){
				if( $page!= $i ){
					echo"<li><a href = 'news.php?id=$id_tl&page=$i'>$i</a></li>";
				}
				else{
					echo"<li class='hientai'>$i</li>";
				}
				
			}
			
			//nut next:
			if($page<$sotrang){
				$next = $page+1;
				echo"<li class = 'dacbiet'><a href = 'news.php?id=$id_tl&page=$next'>Next</a></li>";
				
			}
			
			echo"</ul>";
	
			}
?>
		
</div>

</div>

<div id = "content2" class = "content">
<h1>Tin <?php echo $row['name_theloai'];?> được xem nhiều nhất</h1>
<div id = "ndcontent2" class = "ndcontent"> 
<ul class = "banghi">
<?php
		$dt->select("SELECT * FROM  bantin WHERE id_theloai = '$id_theloai' ORDER BY luotXem DESC LIMIT 10");
		$i = 0;

	while( $r = $dt->fetch() ){
		$id_bt = $r['id_bantin'];
		$id_tl = $r['id_theloai'];
		$tieude = $r['tieuDe'];
		$anh = $r['anh'];
		$trichDan = $r['trichDan'];
		echo "<li>";
		echo "<img src = '$anh' width = '183.3px' height = '109.16px'/>";
		echo "<h2><a href ='newsdetail.php?id_tl=$id_tl&id_bt=$id_bt'>$tieude</a></h2>";
		echo "<p>$trichDan</p><br>";
		echo "</li>";
		$i++;
	}
	
	if($i == 0 ){
			echo"Không có bản tin trong mục này.";
		}
	
	
	?>
	</ul>
</div>

</div>


</div><!-- nội dung -->


<?php
}
include 'bottom.php';

?>
