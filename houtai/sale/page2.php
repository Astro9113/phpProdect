<div class="listpage">
	<?php echo '共 ' .$num .' 条记录'?>
	<?php echo $page;?>/<?php echo $page_count;?>  共 <?php echo $page_count;?> 页 
	<?php
        $addon = http_build_query($page_config);
        if ($page > 1) {
            echo "<a href='?page=1&" . $addon . "'>首页</a> <a href='?page=" .($page - 1) . "&" . $addon . "'>上一页</a>";
        } else {
            echo "首页 上一页";
        }
        
        if ($page > 3) {
            $zuopage = $page - 2;
        } else {
            $zuopage = 1;
        }
        
        if (($page_count - $page) < 2) {
            $youpage = $page_count;
        } else {
            $youpage = $page + 2;
        }
        
        for ($i = $zuopage; $i <= $youpage; $i ++) {
            echo "<a href='?page=" . $i . "&" . $addon . "'>" . $i . "</a> ";
        }
        if ($page < $page_count) {
            echo " <a href='?page=" . ($page + 1) . "&" . $addon ."'>下一页</a>  <a href='?page=" .$page_count . "&" . $addon ."'>尾页</a>";
        } else {
            echo "下一页  尾页";
        }
        
        
    ?>
</div>
    
<form action="" method="get" >
<?php 
    foreach ($page_config as $k=>$v){
        echo "<input name='{$k}' type='hidden' value='{$v}'>".PHP_EOL;
    }
?>
<input name="page" type="text" size="5">
<input name="" type="submit" value="跳转">
</form>