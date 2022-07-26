<div id="rightcontent">
    <h1>Xem nhiều</h1>
    <div id="ndright">
        <ul>
        <?php
        $dt->select('SELECT * FROM  bantin ORDER BY luotXem DESC LIMIT 5');
        $i = 0;
        while ($r = $dt->fetch()) {
            $id_bt = $r['id_bantin'];
            $id_tl = $r['id_theloai'];
            $tieude = $r['tieuDe'];
            $anh = $r['anh'];
            $trichDan = $r['trichDan'];
            echo "<li class='right_content'>";
            // echo "<div class='right_content>";
            echo "<img src = '$anh' width = '90.15px' height = '54.58px'/>";
            echo "<h5><a href ='newsdetail.php?id_tl=$id_tl&id_bt=$id_bt'>$tieude</a></h5>";
            echo "<div class='clearfix'></div>";
            echo "</li>";
            $i++;
        }




        ?>
        </ul>

    </div>

</div>