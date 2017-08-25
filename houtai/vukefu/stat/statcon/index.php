<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

require KEFU_PATH . 'head.php';

$id = intval($_GET['id']);
$sql = "select * from wx_guest where id = '{$id}' and guestkfid = $loginid";
$info = $mysql->find($sql);


if(!$info){
    alert('订单信息不存在');
    goback(); 
}


//黑名单信息
$blacklist = $mysql->query_assoc('select * from wx_blacklist where 1', 'tel');



//查询太多 有时间改写成一次查出来 看看是否能节省查询时间

foreach($info as $k=>$v){
    if($k=='guestrizhi'){
        continue;
    }
	$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
}
			

$shopid     = $info['shopid'];
$skuid      = $info['skuid'];
$userid     = $info['userid'];
$gueststate = $info['gueststate'];
$guestname  = $info['guestname'];
$guestkuanshi   = $info['guestkuanshi'];
$guesttel = guesttel_kefu($info['guesttel'],$gueststate);
$dizhi  =  $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$info['guestdizhi'];
$guestrizhi = guestrizhi($info['guestrizhi']);
$guestrem = $info['guestrem'];

$shop           = shopinfo($shopid);
$shopsku        = shopsku($shop, $skuid);
$gusettitle = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] .
"&nbsp;&nbsp;" . $guestkuanshi;

$orderstate_arr = orderstateinfo($gueststate);
$orderstate = $orderstate_arr['orderstate'];

$wuliugsname = $info['wuliugs'];
$wuliugs = wuliugsinfo($wuliugsname);
$wuliugscode = $wuliugs['wuliugscode'];

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

<div id="wrap" class="clearfix">
    <?php require KEFU_PATH . 'menu.php';?>
	<div id="main" class="clearfix">

        <h2>
			订单详情&nbsp;&nbsp;&nbsp;<a class="btn" style="margin-bottom: 3px;"
				href="javascript:history.go(-1);">返回订单列表</a>
		</h2>
		
		<div class="uc">
			<div class="comform">
				<table cellpadding="12" cellspacing="0" border="0" class="table-form">
                    <?php
					if(array_key_exists(trim($info['guesttel']),$blacklist)){
						echo '<tr style="background-color:#b7785d !important;">
						<th width="80">提醒</th>
						<td>电话:'.$info['guesttel'].'在黑名单内,原因:'.$blacklist[trim($info['guesttel'])]['remark'].'</td>
						</tr>';
					}
					?>
					<tr>
						<th width="80">订单信息</th>
						<td>订单ID：<?php echo $id;?>， 下单时间：<?php echo $info['addtime'];?></td>
				    </tr>
					<tr>
						<th width="80">收货信息</th>
    						<td>
    						  收货人：<?php echo $guestname;?>，
    						  联系方式：<?php echo $guesttel;?>
    		                 <br>
                                                                            收货地址：<?php echo $dizhi;?>
                        </td>
					</tr>
					<tr>
						<th>购买商品</th>
						<td><?php echo $gusettitle; ?>， <?php echo $shopsku[1]; ?>.00 元</td>
					</tr>
					<tr>
						<th>订单状态</th>
						<td><?php echo $orderstate; ?></td>
					</tr>
					<tr>
						<th>发货状态</th>
						<td>
                            <?php echo $fahuo;?>
                        </td>
					</tr>
					
					<tr>
                        <th valign="top">订单日志</th>
                        <td>
                            <?php echo $info['addtime'];?>， 下单成功 客服确认中<br>
                            <?php echo $guestrizhi;?>
                        </td>
					<tr>
					
					<tr class="last">
						<th>备注信息</th>
						<td><?php echo $guestrem;?></td>
					</tr>
					
				</table>
				
			</div>
			
            <?php require KEFU_PATH . 'tip2.php';?>
		</div>
	</div>
</div>

<?php require KEFU_PATH . 'foot.php';?>
