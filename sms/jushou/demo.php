<?php 

//vu 获取拒收手机号码  加人到redis中  每日计划任务运行
//======================================================
error_reporting(E_ALL &~E_NOTICE);

require  'sjk1114.php';


$sql = "SELECT guesttel,count(*) as num  from `wx_guest` where gueststate = 6 group by guesttel";
$sql  = mysql_query($sql);
while(($info = mysql_fetch_assoc($sql))!==false){
    $ret[$info['guesttel']] = $info['num'];
}

$redis->del('jushoushouji');
$redis->hMset('jushoushouji',$ret);
mysql_close();
echo 'done';