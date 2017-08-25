<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH.'menu.php';?>
    
    <div id="main">
		<div class="box contact" style="height: 320px">
			<h3>微信公众号返利平台</h3>
			<p>
				<b>技术咨询：</b><br>小果： <?php echo $kfqq;?><br>
			</p>
		</div>
		
		<p class="title">
			<b><?php echo $_SESSION['admin1114name'];?></b>，欢迎进入管理中心！
		</p>
        <?php
        $kefuyzm = get_yzm();
        echo '<p>验证码:' . $kefuyzm . '</p>';
        ?>
          
        <br /><br />  
        <p><a href="stat/daodan">导单</a></p>
        <p><a href="stat/wuliudh">上传单号</a></p>
		<p><a href="stat/fahuosea/">签收</a></p>
		<p><a href="stat/fahuosea/yjs.php">拒收</a></p>
		
        
        
    <?php  require ADMIN_PATH.'tip.php';?>
	</div>
</div>
<?php  require ADMIN_PATH.'foot.php';?>
