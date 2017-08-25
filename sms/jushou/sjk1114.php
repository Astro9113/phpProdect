<?php

$db_host = 'rdsw66ek4d040dw85308.mysql.rds.aliyuncs.com';
$db_name = 'vu';
$db_user = 'dbuser_vu';
$db_pass = 'vuVU9527';
$encode_key = 'yangsi62';


$link=@mysql_connect($db_host,$db_user,$db_pass) or die("服务器连接失败");
mysql_select_db($db_name,$link) or die("数据库连接失败");
mysql_query("set names utf8");
date_default_timezone_set('PRC');


//缓存服务器
$redis_host = "3c0529170d544824.m.cnhza.kvstore.aliyuncs.com";
$redis_port = 6379;
$redis_user = "3c0529170d544824";
$redis_pwd = "8696796qQ";

$redis = new Redis();
if ($redis->connect($redis_host, $redis_port) == false) {
    $redis->getLastError();
}

if ($redis->auth($redis_user . ":" . $redis_pwd) == false) {
    $redis->getLastError();
}
