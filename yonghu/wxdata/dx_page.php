 <div class="Paging">
                    <a>总计：<?php echo $page_count;?> 页记录</a><a href="?page=1&<?php echo $pagestr;?>">首页</a><a href="?page=<?php echo ($page-1)."&".$pagestr;?>">上一页</a><span class="current"><?php echo $page;?></span><a href="?page=<?php echo ($page+1)."&".$pagestr;?>">下一页</a><a href="?page=<?php echo $page_count."&".$pagestr;?>">尾页</a>
                </div>             