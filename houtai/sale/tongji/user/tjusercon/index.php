<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$time1 = $_GET['time1'];
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = $_GET['time2'];
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);


$id = intval($_GET['id']);
$user = userinfo($id);


?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
        <h2>统计用户：<?php echo gl2($user['loginname']);?> &nbsp;&nbsp;&nbsp;  
            <?php echo $time3;?> -- <?php echo $time4;?>
        </h2>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="160px">商品图片</th>
					<th>商品名称</th>
					<th width="110px">浏览次数</th>
				</tr>
    
<?php
$shops = get_shops();        
$sql = "select count(*) as num ,shopid from wx_tongji where addtime>='$time3' and addtime<='$time4' and userid='$id' group by shopid order by num desc";
        $infos = $mysql->query($sql);
        if($infos){
            foreach ($infos as $info){
                $shopid = $info['shopid'];
                $shop = $shops[$shopid];
                $num = $info['num'];
?>
    <tr>
        <td align="center">
            <img src="<?php echo shopimg($shop['shoppic'], '../../../')?>" width="150px">
        </td>
		<td><h3><?php echo $shop['shopname']; ?></h3>
		  <p><em>推广说明：</em><?php echo mysubstr($shop['shopcon'],0,54);?>...</p>
		</td>
		<td align="center"><em><?php echo $num;?></em></td>
	</tr>
<?php
            }
        }
        
?>
	</table>

			
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>