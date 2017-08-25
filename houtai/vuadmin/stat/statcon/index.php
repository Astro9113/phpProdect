<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array( 1,10);
qx($allow_qx, $adminclass);


$id = intval($_GET['id']);
$info = guestinfo($id);
if(!$info){
    alert('订单信息不存在');
    goback();
}

foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
	}
	$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
}


$userid         = $info['userid'];
$user           = userinfo($userid);

foreach($user as $k=>$v){
	$user[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
}
			
$username       = $user['loginname'];
$alipay         = $user['alipay'];
$alipayname     = $user['alipayname'];
$topid          = $user['topuser'];
$userpercent    = $user['userpercent'];


if (!$topid) {
    $topuser = "无中间人";
} else {
    $miduser = miduserinfo($topid);
    if ($miduser) {
        $topuser        = $miduser['username'];
        $midreward      = $miduser['midreward'] / 100;
        $midalipay      = $miduser['midalipay'];
        $midalipayname  = $miduser['midalipayname'];
    } else {
        $miduser        = userinfo($topid);
        $topuser        = $miduser['loginname'];
        $midreward      = $miduser['userreward'] / 100;
        $midalipay      = $miduser['alipay'];
        $midalipayname  = $miduser['alipayname'];
    }
}

$guestname          = $info['guestname'];
$guesttel           = $info['guesttel'];
$dizhi              = $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$info['guestdizhi'];
$guestrizhi         = guestrizhi($info['guestrizhi']);
$guestrem           = $info['guestrem'];

$guestkuanshi       = $info['guestkuanshi'];
$shopid             = $info['shopid'];
$skuid              = $info['skuid'];
$shop               = shopinfo($shopid);
$shopsku            = shopsku($shop, $skuid);
$gusettitle         = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] ."&nbsp;&nbsp;" . $guestkuanshi;

if ($shop['ischange'] == '1') {
    $shopsku[2] = $shopsku[2] * $userpercent;
    $shopsku[2] = round($shopsku[2]);
}


$gueststate         = $info['gueststate'];
$orderstate_arr     = orderstateinfo($gueststate);
$orderstate         = $orderstate_arr['orderstate'];

$wuliugsname        = $info['wuliugs'];
$wuliugs            = wuliugsinfo($wuliugsname);
$wuliugscode        = $wuliugs['wuliugscode'];

//发货信息
if ($info['guestkuaidi'] == "") {
    $fahuo = " 未发货";
}else{
    $fahuo = "已发货，" . $info['wuliugs'] . " " . $info['guestkuaidi'].
    "&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://m.kuaidi100.com/index_all.html?type=" .
    $wuliugscode . "&postid=" . $info['guestkuaidi'] .
    "' target='_blank'>物流查询</a>";
}

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
        <h2>订单详情</h2>
		<div class="uc">
			<div class="comform">
				<table cellpadding="12" cellspacing="0" border="0" class="table-form">
                    <tr>
						<th width="80">订单信息</th>
						<td>订单ID：<?php echo $id;?>， 下单时间：<?php echo $info['addtime'];?>，购买者：<?php echo $guestname;?>，地址：<?php echo $dizhi;?></td>
					</tr>
    
                    <tr>
						<th width="80">收货信息</th>
						<td>联系方式：<?php echo $guesttel;?><br></td>
					</tr>
     
                    <tr>   
						<th>购买商品</th>
						<td><?php echo $gusettitle;?>， <?php echo $shopsku[1]; ?>.00 元&nbsp;&nbsp;&nbsp; 提成：<?php echo $shopsku[2]; ?>.00 元 </td>
					</tr>
					
                    <tr>
						<th>分成信息</th>
						<td>微信主 <?php echo $username; ?>	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
						          分成：<?php echo $shopsku[2]; ?>.00 元<br>
                                                                        支付宝账号  <?php echo $alipay; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                        姓名  <?php echo $alipayname; ?>
                        </td>
					</tr>
					<tr>
						<th>邀请提成</th>
						<td>中间人 <?php echo $topuser;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
						          分成：<?php echo $shopsku[2]*$midreward;?> 元<br>
                                                                        支付宝账号  <?php echo $midalipay; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                        姓名  <?php echo $midalipayname; ?>
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
                        <?php echo $info['addtime'];?>， 下单成功 客服确认中<br>
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
<?php require ADMIN_PATH . 'foot.php';?>