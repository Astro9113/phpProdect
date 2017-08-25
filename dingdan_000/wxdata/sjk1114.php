<?php
ini_set('display_errors','Off');
header('content-type:text/html;charset=utf-8');

include 'config.php';
include 'func.php';

$link = mysql_connect($db_host,$db_user,$db_pass) or die("服务器连接失败");
mysql_select_db($db_name,$link) or die("数据库连接失败.");
mysql_query("set names utf8");
date_default_timezone_set('PRC');


$redis = new Redis();
if ($redis->connect($redis_host, $redis_port) == false) {
    $redis->getLastError();
}

if ($redis->auth($redis_user . ":" . $redis_pwd) == false) {
    $redis->getLastError();
}


