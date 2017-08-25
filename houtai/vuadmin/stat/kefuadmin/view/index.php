<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$id  = intval($_GET['id']);
$kefu = get_kefu_info($id);

if(!$id){
    exit;
}

$file = '../../index_5.php';
?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2><?php echo $kefu['adminname'];?>订单 日/周 详细统计
		<a class="btn" style='margin-bottom: 5px; margin-left: 20px;' href='../'>返回</a>
		<a href="?id=<?php echo $id?>&tiqian=1">往前1天</a>
		<a href="?id=<?php echo $id?>&tiqian=3">往前3天</a>
		<a href="?id=<?php echo $id?>&tiqian=5">往前5天</a>
		<a href="?id=<?php echo $id?>&tiqian=7">往前7天</a>
		<a href="?id=<?php echo $id?>&tiqian=15">往前15天</a>
		<a href="?id=<?php echo $id?>&tiqian=30">往前30天</a>
		</h2>


<?php 

$tiqian = isset($_GET['tiqian'])?intval($_GET['tiqian']):0;


//最近十天的单子的各种状态
function tnum_tmp($aa,$i,$kfid){
    global $mysql;
    $zuotian=date("Y-m-d",time()-$i*24*60*60)." 17:00:00";
    $jintian=date('Y-m-d',time()-($i-1)*24*60*60)." 17:00:00";
    $num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian' and gueststate IN($aa) and guestkfid = '$kfid'");
    return $num;
}

for($i=$tiqian + 1;$i<= $tiqian + 15;$i++){
    $zuotian = date("Y-m-d",time()-$i*24*60*60)." 17:00:00";
    $jintian = date('Y-m-d',time()-($i-1)*24*60*60)." 17:00:00";
    $num = $mysql->count_table('wx_guest',"addtime>='$zuotian' and addtime<='$jintian' and guestkfid = '$id'");
    $n2 = $n11 = $n10 = $n9 = $n3 = $n4 = $n5 = $n6 = $n8 = 0;
    $n2 = tnum_tmp('2',$i,$id);
    $n11 = tnum_tmp('11',$i,$id);
    $n10 = tnum_tmp('10',$i,$id);
    $n9 = tnum_tmp('9',$i,$id);
    $n3 = tnum_tmp('3',$i,$id);
    $n4 = tnum_tmp('4',$i,$id);
    $n5 = tnum_tmp('5',$i,$id);
    $n6 = tnum_tmp('6',$i,$id);
    $n8 = tnum_tmp('8',$i,$id);
    $lv = round((($num?(($n3+$n9+$n5)/$num):0)*100),2);
    $num2 = $n4 + $n5 + $n3 + $n9 + $n6;
    $lv_qianshou = round((($num2?(($n4+$n5)/$num2):0)*100),2);
    echo "

<div class='mtop12 waitstat'>
	<d class='nowstatz hongse'>".date('m-d',time()-($i-1)*24*60*60)."</d>
	订单总数：<d class='nowstat'>{$num}</d>
	<a href='{$file}?gueststate_s=2&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>确认中</a>：<d class='nowstat'> ".$n2."</d>
	<a href='{$file}?gueststate_s=11&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>联不上</a><d class='nowstat'> ".$n11."</d>
	<a href='{$file}?gueststate_s=10&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>假单</a><d class='nowstat'> ".$n10."</d>
	<a href='{$file}?gueststate_s=9&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>待发货</a><d class='nowstat'> ".$n9."</d>
	<a href='{$file}?gueststate_s=3&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>已发货</a><d class='nowstat'> ".$n3."</d>
	<a href='{$file}?gueststate_s=4&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>已签收</a><d class='nowstat'> ".$n4."</d>
	<a href='{$file}?gueststate_s=5&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>已结算</a><d class='nowstat'> ".$n5."</d>
	<a href='{$file}?gueststate_s=6&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>拒收</a><d class='nowstat'> ".$n6."</d>
	<a href='{$file}?gueststate_s=8&time1={$zuotian}&time2={$jintian}&guestkfid_s={$id}'>已取消</a><d class='nowstat'> ".$n8."</d>
	<a href='#'>核单率</a><d class='nowstat'> ".$lv."%</d>
	<a href='#'>签收率</a><d class='nowstat'> ".$lv_qianshou."%</d>
	    
</div>
 <hr style='margin-top: 12px;'>

";
    
   //exit; 
}

?>

	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

