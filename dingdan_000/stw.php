<?php 
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);


//参数 = 用户-时间
//$id     = intval($args[0]);
$userid = intval($args[0]);
//$userwx = intval($args[2]);

if(!$userid){
    $userid = 1;
}

$rnd = rand(99,1000);

$str = '<script type="text/javascript" src="http://'.$rnd.'.sufgps.cn/abs/abs.php?type=2&num=5&uid='.$userid.'&width=0&height=0&cid=0&color=0&pid=119,96,50,115,116,117"></script>';

echo $str;
exit;
?>

