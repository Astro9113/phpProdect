<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,5
);
qx($allow_qx, $adminclass);

if($adminclass==5){
    $file = '../index_5.php';
}else{
    $file = '../index.php';
}
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix" style="width:820px;">
		<h2>
			订单 日/周 详细统计<a class="btn"
				style='margin-bottom: 5px; margin-left: 20px;' href='../'>返回订单列表</a><a
				class="btn" style='margin-bottom: 5px; margin-left: 20px;'
				href='index.php'>周统计</a>
		</h2>

<?php

function tnum_tmp($aa,$i){
    global $mysql;
    $zuotian=date("Y-m-d",time()-$i*24*60*60)." 17:00:00";
    $jintian=date('Y-m-d',time()-($i-1)*24*60*60)." 17:00:00";
    $num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian' and gueststate IN($aa)");
    return $num;
}

for ($i = 1; $i <= 15; $i ++) {
    $zuotian = date("Y-m-d", time() - $i * 24 * 60 * 60) . " 17:00:00";
    $jintian = date('Y-m-d', time() - ($i - 1) * 24 * 60 * 60) . " 17:00:00";
    $num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian'");
    
    ?>

<div class="mtop12 waitstat">
			<d class="nowstatz hongse"><?php echo date('m-d',time()-($i-1)*24*60*60);?></d>
			订单总数：
			<d class="nowstat"><?php echo $num;?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=2&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">确认中</a>：
			<d class="nowstat"><?php echo tnum_tmp('2',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=11&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">联不上</a>：
			<d class="nowstat"><?php echo tnum_tmp('11',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=10&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">假单</a>：
			<d class="nowstat"><?php echo tnum_tmp('10',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=9&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">待发货</a>：
			<d class="nowstat"><?php echo $df = tnum_tmp('9',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=3&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已发货</a>：
			<d class="nowstat"><?php echo $fh = tnum_tmp('3',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=4&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已签收</a>：
			<d class="nowstat"><?php echo $qs = tnum_tmp('4',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=5&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已结算</a>：
			<d class="nowstat"><?php echo $js = tnum_tmp('5',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=6&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">拒收</a>：
			<d class="nowstat"><?php echo $jus = tnum_tmp('6',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=8&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已取消</a>：
			<d class="nowstat"><?php echo tnum_tmp('8',$i);?></d>
			<a href="#">签收率</a>：
			<d class="nowstat">
<?php
    $aa = $qs + $js;
    $bb = $qs + $js + $fh + $jus;
    $ret = $bb==0?0:(number_format($aa / $bb, 4) * 100 .'%');
    echo $ret;
    ?>
</d>
			<a href="#">核单率</a>：
			<d class="nowstat">
<?php
    $bb = $qs + $js + $fh + $jus + $df;
    $ret = $bb==0?0:(number_format(($bb / $num) * 100, 2). '%');
    echo $ret;
    ?>
</d>
		</div>

		<hr style="margin-top: 12px;">

<?php
}
?>


<?php

function tnum15($aa)
{
    global $mysql;
    $zuotian = date("Y-m-d", time() - 15 * 24 * 60 * 60) . " 17:00:00";
    $jintian = date("Y-m-d") . " 17:00:00";
    $num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian' and gueststate IN($aa)");
    return $num;
}


$zuotian = date("Y-m-d", time() - 15 * 24 * 60 * 60) . " 17:00:00";
$jintian = date("Y-m-d") . " 17:00:00";
$num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian'");
    
?>


 <div class="mtop12 waitstat">
			<d class="nowstatz hongse">15天</d>
			订单总数：
			<d class="nowstat"><?php echo $num;?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=2&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">确认中</a>：
			<d class="nowstat"><?php echo tnum15('2');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=11&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">联不上</a>：
			<d class="nowstat"><?php echo tnum15('11');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=10&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">假单</a>：
			<d class="nowstat"><?php echo tnum15('10');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=9&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">待发货</a>：
			<d class="nowstat"><?php echo tnum15('9');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=3&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已发货</a>：
			<d class="nowstat"><?php echo tnum15('3');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=4&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已签收</a>：
			<d class="nowstat"><?php echo tnum15('4');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=5&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已结算</a>：
			<d class="nowstat"><?php echo tnum15('5');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=6&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">拒收</a>：
			<d class="nowstat"><?php echo tnum15('6');?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=8&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已取消</a>：
			<d class="nowstat"><?php echo tnum15('8');?></d>
		</div>



	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>