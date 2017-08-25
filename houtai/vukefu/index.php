<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
    require ROOT."wxdata/kefulimit.php";
?>

<?php 
    require KEFU_PATH.'head.php';
?>


<div id="wrap" class="clearfix">
<?php 
    require KEFU_PATH.'menu.php';
?>


    <div id="main">
        <div class="box contact" style="height: 320px">
    	   <h3>微信公众号返利平台</h3>
    	   <p><b>改资料、登陆信息：</b><br>QQ：<?php echo $kfqq;?><br></p>
    	   <p><b>技术咨询：</b><br>小果： <?php echo $kfqq;?><br> </p>
        </div>
        
        <p class="title"><b><?php echo $_SESSION['kefu1114name'];?></b>，欢迎进入管理中心！</p>
        
        
    <?php

        $kefid = $_SESSION['kefu1114id'];
    	$num5 = kefu_get_num($kefid, 5);
    	$num3 = kefu_get_num($kefid, 3);
    
    ?>
      
    
        <p class="info">
                订单统计：<br>完成订单：<em><?php echo $num5;?></em> 单，正在发货：<em><?php echo $num3;?></em>单
        </p>
        <hr>
    
        <?php 
            require KEFU_PATH.'tip.php';
        ?>
    </div>
</div>


<?php 
    require KEFU_PATH.'foot.php';
?>