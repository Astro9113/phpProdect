<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";
?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main">
		<div class="box contact" style="height: 320px">
			<h3>微信公众号返利平台</h3>
			<p>
				<b>技术咨询：</b><br>小果： <?php echo $kfqq;?><br>
			</p>
		</div>
		<p class="title">
			<b><?php echo $_SESSION['miduser1114name'];?></b>，欢迎进入管理中心！
		</p>

		<p class="info">
			订单统计：<br> &nbsp;&nbsp;&nbsp;<a href="/sale/stat/">查看订单统计</a>
		</p>
		<hr>

		<p class="info">
			用户统计：<br> &nbsp;&nbsp;&nbsp;<a href="/sale/user/">查看微信主统计</a>
		</p>
		<hr>

	</div>
</div>
<?php require MID_PATH.'foot.php';?>