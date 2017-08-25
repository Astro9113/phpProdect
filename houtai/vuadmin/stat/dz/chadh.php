<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,10
);
qx($allow_qx, $adminclass);

$dz_arr = get_dz_state2();

?>
<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
		<?php require ADMIN_PATH . 'menu.php';?>

		<div id="main" class="clearfix">

		<div class="filter">
			<div class="cxform2" style="width: 400px;">
				<a href="index.php" style="color: #000;">全部已签收</a> <a
					href="index_all.php">签收正常</a> <a href="index_yc.php">签收异常</a> <a
					href="tui.php">退回签收</a> <a href="tui_yc.php">退回异常</a>
			</div>
			<div class="cxform2" style="width: 320px;">
				<form action="cha.php" method="get" style="float: right;">
					<input type="text" name="id">
					<button type="submit">查询</button>
				</form>
			</div>
			<div class="cb"></div>
		</div>

		<div class="uc mtop5">

			<table class="items" width="145%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="30px">ID</th>
					<th width="180px">订购商品</th>
					<th width="70px">金额</th>
					<th width="50px">购买者</th>
					<th width="90px">手机号</th>
					<th width="60px">地址</th>
					<th width="60px">回款状态</th>
				</tr>
    
<?php

$dh = $_GET['dh'];
if($dh !== mysql_escape_string($dh)){
    exit('参数错误');
}

$sql = "select g.*,dg.stateid from wx_guest g left join wx_dzguest dg on g.id = dg.guestid where g.guestkuaidi = {$dh}";
$infos = $mysql->query($sql);

foreach ($infos as $info){
	foreach($info as $k=>$v){
		if($k=='guestrizhi'){
			continue;
		}
		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}


    $guestname = $info['guestname'];
    $guesttel = $info['guesttel'];

    $guestkuanshi = $info['guestkuanshi'];
    $shopid = $info['shopid'];
    $skuid = $info['skuid'];
    $shop = shopinfo($shopid);
    $shopskuid = "shopsku" . $skuid;
    $shopsku = $shop[$shopskuid];
    $shopsku = explode("_", $shopsku);
    $gusettitle = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] .
    "&nbsp;&nbsp;" . $guestkuanshi;
    $guestsheng = $info['guestsheng'] . $info['guestcity'] . $info['guestqu'] .
    $info['guestdizhi'];

    $addtime = shorttime($info['addtime']);
    ?>
    <tr>
				<td><?php echo $addtime;?></td>
				<td><a href='/vuadmin/stat/statcon/?id=<?php echo $info['id'];?>'
					target='_blank'><?php echo $info['id'];?></a></td>
				<td><?php echo $gusettitle; ?></td>
				<td><?php echo $shopsku[1]; ?> / <?php echo $shopsku[2]; ?></td>
				<td><?php echo $guestname; ?></td>
			    <td><?php echo $guesttel;?></td>
				<td><?php echo $guestsheng;?></td>
				<td><?php echo $dz_arr[$info['stateid']];?></td>
			</tr>

<?php
    
}
?>

</table>







		</div>
	</div>
</div>
</body>
</html>
