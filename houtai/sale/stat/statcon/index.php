<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$id = intval($_GET['id']);

$w = " 1 and id = '{$id}'";


// 初始条件 userid in (该媒介下面的用户id)
$topid = $loginid;
$topid = "m" . $topid;
$sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
$users = $mysql->query_assoc($sql, 'id');
$num = $mysql->numRows;
if ($num) {
    $uids = array_keys($users);
    $uids = join(',', $uids);
} else {
    $uids = '0';
}
$w .= " and userid in ({$uids})";

$sql = "select * from wx_guest where {$w}";
$info = $mysql->find($sql);

if (! $info) {
    alert('订单信息不存在');
    goback();
}


foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
		//$info[$k] = guestrizhi($v);
	}else{
		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}
}

$userid = $info['userid'];
$user = userinfo($userid);
$username = gl2($user['loginname']);

$guestrizhi = guestrizhi($info['guestrizhi']);
$guestrem = $info['guestrem'];

$guestkuanshi = $info['guestkuanshi'];
$shopid = $info['shopid'];
$skuid = $info['skuid'];
$shop = shopinfo($shopid);
$shopsku = shopsku($shop, $skuid);
$gusettitle = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] .
         "&nbsp;&nbsp;" . $guestkuanshi;

if ($shop['ischange'] == '1') {
    $shopsku[2] = $shopsku[2] * $userpercent;
    $shopsku[2] = round($shopsku[2]);
}

$gueststate = $info['gueststate'];
$orderstate_arr = orderstateinfo($gueststate);
$orderstate = $orderstate_arr['orderstate'];

$wuliugsname = $info['wuliugs'];
$wuliugs = wuliugsinfo($wuliugsname);
$wuliugscode = $wuliugs['wuliugscode'];

// 发货信息
if ($info['guestkuaidi'] == "") {
    $fahuo = " 未发货";
} else {
    $fahuo = "已发货，" . $info['wuliugs'] . " " . $info['guestkuaidi'] .
             "&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://m.kuaidi100.com/index_all.html?type=" .
             $wuliugscode . "&postid=" . $info['guestkuaidi'] .
             "' target='_blank'>物流查询</a>";
}

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
		<h2>订单详情</h2>
		<div class="uc">
			<div class="comform">
				<table cellpadding="12" cellspacing="0" border="0" class="table-form">
	               <tr>
						<th width="80">订单信息</th>
						<td>订单ID：<?php echo $id;?>， 下单时间：<?php echo $info['addtime'];?></td>
					</tr>
					<tr>
						<th>购买商品</th>
						<td><?php echo $gusettitle; ?>， <?php echo $shopsku[1]; ?>.00 元<br>
						提成：<?php echo $shopsku[2]; ?>.00 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						微信主：<em><?php echo $username; ?>	</em>
						</td>
					</tr>
					<tr>
						<th>订单状态</th>
						<td><?php echo $orderstate; ?></td>
					</tr>
					<tr>
						<th>发货状态</th>
						<td><?php echo $fahuo;?></td>
					</tr>
					<th valign="top">订单日志</th>
					<td>
					<?php echo $info['addtime'],'， 下单成功 客服确认中<br />';?>
					<?php echo $guestrizhi;?>
					</td>
					<tr>
					</tr>
					<tr class="last">
						<th>备注信息</th>
						<td><?php echo $guestrem;?></td>
					</tr>
				</table>
			</div>
			
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>