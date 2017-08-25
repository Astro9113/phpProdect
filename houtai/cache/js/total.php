<?php
if ($_GET['key'] !== 'yangsi6211') {
    exit();
}
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';

if(date('H')>=17){
    $zuotian=date("Y-m-d")." 17:00:00";
    $jintian=date('Y-m-d',time()+24*60*60)." 17:00:00";
}else{
    $zuotian=date("Y-m-d",time()-24*60*60)." 17:00:00";
    $jintian=date('Y-m-d')." 17:00:00";
}
 
$sql = "select count(*) as num,gueststate from wx_guest where addtime between '$zuotian' and  '$jintian' group by gueststate";
$nums = $mysql->query_assoc($sql,'gueststate');

$total = 0;
foreach ($nums as $k=>$v){
    $total += intval($v['num']);
}

for($i=1;$i<=20;$i++){
    if(isset($nums[$i])){
        continue;
    }
    $nums[$i] = 0;
}

$tpl = <<<eee
今日订单总：$total,确认中： {$nums[2]['num']},联不上： {$nums[11]['num']},假单：   {$nums[10]['num']},待发货：{$nums[9]['num']},已发货： {$nums[3]['num']},已取消： {$nums[8]['num']},无效重复： {$nums[12]['num']}
eee;
echo $tpl;exit;

