<div class="listpage">
	<?php echo '共 ' .$num .' 条记录'?>
	<?php echo $page;?>/<?php echo $page_count;?>  共 <?php echo $page_count;?> 页 
	<?php
	   
        if ($page > 1) {
            echo "<a href='?page=1&class=" . $class . "'>首页</a> <a href='?page=" .($page - 1) . "&class=" . $class . "'>上一页</a>";
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
            echo "<a href='?page=" . $i . "&class=" . $class . "'>" . $i . "</a> ";
        }
        if ($page < $page_count) {
            echo " <a href='?page=" . ($page + 1) . "&class=" . $class ."'>下一页</a>  <a href='?page=" .$page_count . "&class=" . $class ."'>尾页</a>";
        } else {
            echo "下一页  尾页";
        }
        
        
    ?>
</div>
    
<form action="" method="get" >
<input name="class" type="hidden" value="<?php echo $class;?>">
<input name="page" type="text" size="5">
<input name="" type="submit" value="跳转">
</form>