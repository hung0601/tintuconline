<?php
include 'top.php';
include 'right.php'

?>

<link rel = "stylesheet" href = "style3.css" type = "text/css">

<div id = "content1" class = "content">
<h1> Tin mới nhất</h1>
<div id = "ndcontent1" class = "ndcontent"> 
<ul class = "banghi">
<?php
	if(isset($_SESSION['username']) && isset($_SESSION['phanquyen'])){/*dung isset kiem tra user name ton tai*/
		if($_SESSION['phanquyen'] == 1){
		echo"<p  align= 'right' style = 'font-size : 18px;'>";
		echo"<a href = 'groupadd.php'>Xử lý thể loại</a>";
		echo"</p>";
		}
	}
		$dt->select('SELECT * FROM  bantin ORDER BY ngayTao_bantin DESC LIMIT 10');
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
		
		
		
	}
	
	
	
	
	?>
</ul>

</div>

</div>

<div id = "content2" class = "content">
<h1>Tin được bình luận nhiều nhất</h1>
<div id = "ndcontent2" class = "ndcontent"> 
<ul class = "banghi">
<?php
		$dt->select('SELECT bantin.* from  
						bantin INNER JOIN coment
						ON bantin.id_bantin = coment.id_bantin
						LEFT JOIN repcoment 
						ON coment.id_cmt = repcoment.id_coment
						group by bantin.id_bantin
						ORDER BY COUNT(DISTINCT  coment.id_cmt) + COUNT(repcoment.id_repcmt) DESC LIMIT 10');
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
	
	
	
	
	?>
	</ul>
</div>

</div>


</div><!-- nội dung -->


<?php
include 'bottom.php';

?>

