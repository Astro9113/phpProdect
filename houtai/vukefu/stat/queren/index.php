<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

require KEFU_PATH . 'head.php';
$cur = 'queren';
$page = $class = 0;
?>


<div id="wrap" class="clearfix">
<?php require KEFU_PATH . 'menu.php';?>

<div id="main" class="clearfix">
		<div class="filter widthb110">
        <?php
            $num1 = get_num_today($loginid, 2);
            $num2 = get_num_today($loginid, 11);
            $num3 = get_num_today($loginid, 9);
        ?>
        <div class="cxform2" style="width: 800px; line-height: 38px;">
                              普通客户 今日确认中：<?php echo $num1;?> ， 联不上：<?php echo $num2;?> ， 待发货：<?php echo $num3;?>   <a href="index17.php">过年期间</a><br>
        </div>
		
		<div class="cb"></div>
		
		</div>
		
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="80px">购买者</th>
					<th width="72px">金额</th>
					<th width="100px">状态</th>
					<th width="35px">详情</th>
				</tr>

<?php

$shops = get_shops(); // 所有的商品信息
$orderstates = get_orderstates();

//要获取的状态  2 确认中 11连不上
$statearr = array(2,11);

// 今5-9 ,昨18-23 昨23-今5 今9之后
$timearr = array();
$timearr[] = date('Y-m-d') . ' 05:00:00,' . date('Y-m-d') . ' 09:00:00';
$timearr[] = date('Y-m-d', strtotime('-1 day')) . ' 18:00:00,' . date('Y-m-d', strtotime('-1 day')) .' 23:00:00';
$timearr[] = date('Y-m-d', strtotime('-1 day')) . ' 23:00:00,' . date('Y-m-d') .' 05:00:00';
$timearr[] = date('Y-m-d') . ' 09:00:00,' . date('Y-m-d') . ' 23:59:59';

//拼接sql
$sql = array();
foreach ($statearr as $state) {
    foreach ($timearr as $v) {
        list ($stime, $etime) = explode(',', $v);
        $sql[] = "select * from wx_guest where guestkfid='$loginid' and gueststate = '{$state}' and userid not in(select id as userid from wx_user where isimportant = 1) and addtime between '{$stime}' and '{$etime}'";
    }
}
$sql = join(' union all ', $sql);
$infos = $mysql->query($sql);

$ww = 1;
if($infos){
foreach ($infos as $info){
			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}

	
            $shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $userid         =  $info['userid'];
            $userwx         =  $info['userwx'];
            $guestname      =  $info['guestname'];
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  $info['guestkuanshi'];
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            $orderstate     =  $orderstates[$gueststate];
            $orderstate     =  $orderstate['orderstate'];
            $bz             =  mysubstr($info['guestrem'],0,25);
            $addtime        =  substr($info['addtime'], 5,11);

print <<<EOT
            <tr onmouseover="statbzxs('bz{$ww}')" onmouseout="statbzxs('bz{$ww}')">
					<td>{$addtime}</td>
					<td>{$info['id']}</td>
					<td>{$gusettitle}</td>
					<td>{$guestname}</td>
					<td>{$shopsku[1]}</td>
					<td>{$orderstate}
					    <a href="../orderstate/?id={$info['id']}&class={$class}">更改</a>
					</td>
					<td>
					 <a href="../statcon/?id={$info['id']}&class={$class}&page={$page}">详情</a>
    					<div class="statbzd">
    					   <div class="statbz" id="bz{$ww}">{$bz}</div>
    					</div>
					</td>
			 </tr>
EOT;
					    
            $ww ++;
}
}


echo "<tr height='100'><td  align='center' colspan='7'>以下为 之前联不上</td> </tr>";

$uptime = date('Y-m-d', time() - 24 * 60 * 60) . ' 18:00:00';
$sql = "select * from wx_guest where addtime<='{$uptime}' and guestkfid='$kefid' and gueststate =11 and userid not in(select id as userid from wx_user where isimportant = 1) order by id desc";
$infos = $mysql->query($sql);

$ww = 1;

if($infos){
   foreach ($infos as $info){
			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
            
			$shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $userid         =  $info['userid'];
            $userwx         =  $info['userwx'];
            $guestname      =  $info['guestname'];
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  $info['guestkuanshi'];
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            $orderstate     =  $orderstates[$gueststate];
            $orderstate     =  $orderstate['orderstate'];
            $bz             =  mysubstr($info['guestrem'],0,25);
            $addtime        =  substr($info['addtime'], 5,11);
       
       
           $lbs_num = $info['lbsnum'];
           if ($lbs_num >= 7) {
               $orderstate_add = ' 可改取消'; // 可改联不上
           } else {
               $orderstate_add = '';
           }
       
print <<<EOT
            <tr onmouseover="statbzxs('bz{$ww}')" onmouseout="statbzxs('bz{$ww}')">
					<td>{$addtime}</td>
					<td>{$info['id']}</td>
					<td>{$gusettitle}</td>
					<td>{$guestname}</td>
					<td>{$shopsku[1]}</td>
					<td>{$orderstate}
					    <a href="../orderstate/?id={$info['id']}&class={$class}">更改</a>
					</td>
					<td>
					 <a href="../statcon/?id={$info['id']}&class={$class}&page={$page}">详情</a>
    					<div class="statbzd">
    					   <div class="statbz" id="bz{$ww}">{$bz}</div>
    					</div>
					</td>
			 </tr>
EOT;
       
       
   } 
}



?>
	</table>
	
		    <?php require KEFU_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require KEFU_PATH . 'foot.php';?>