<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

if (! $_GET['time1']) {
    header("Location:/sale/tongji/");
    exit();
}

$time1 = $_GET['time1'];
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = $_GET['time2'];
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">

		<h2>商品浏览统计  <?php echo $time3;?> -- <?php echo $time4;?></h2>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="160px">商品图片</th>
					<th>商品名称</th>
					<th width="110px">浏览次数</th>
					<th width="80px">推广详情</th>
				</tr>
    
<?php

    $topid = $loginid;
    $topid = "m" . $topid;
    $sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
    $users = $mysql->query_assoc($sql,'id');
    $num = $mysql->numRows;
    if ($num) {
        $uids = array_keys($users);
        $uids = join(',', $uids);
    } else {
        $uids = '0';
    }
    
    
    $sql = "select count(*) as num,shopid from wx_tongji where userid in($uids) and addtime>='$time3' and addtime<='$time4' group by shopid order by num desc";
    $infos = $mysql->query($sql);
    
    $shops = get_shops();
    
    foreach ($infos as $info){
        $shopid = $info['shopid'];
        $num = $info['num'];
        $shop = $shops[$shopid];
        
        
    ?>
           
	<tr>
        <td align="center"><img src="<?php echo shopimg($shop['shoppic'], '../../../')?>" width="150px"></td>
		<td>
		  <h3><?php echo $shop['shopname']; ?></h3>
		  <p><em>推广说明：</em><?php echo mysubstr($shop['shopcon'],0,54);?>...</p>
		</td>
		<td align="center"><em><?php echo $num;?></em></td>
		<td align="center">
		  <a class="btn mtop5" href="tjshopcon/?id=<?php echo $shopid; ?>&time1=<?php echo $time3; ?>&time2=<?php echo $time4; ?>">详情</a>
		</td>
	</tr>
<?php 
    }
?>

</table>
			
        <?php require MID_PATH.'tip.php';?>
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>