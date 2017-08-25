<?php
ini_set('display_errors','Off');
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();
header('content-type:text/html;charset=utf-8');
date_default_timezone_set('PRC');

define('ROOT', dirname(dirname(__FILE__)).'/');

define('CLASS_PATH', ROOT.'wxdata/inc/class/');
define('LIB_PATH'  , ROOT.'wxdata/inc/lib/');
define('KEFU_PATH' , ROOT.'vukefu/');
define('MID_PATH'  , ROOT.'sale/');
define('ADMIN_PATH', ROOT.'vuadmin/');
define('CAIWU_PATH', ROOT.'affair/');
define('CACHE_PATH', ROOT.'cache/');
define('UPLOAD_PATH',ROOT.'upload/');


define('HTTP_HOST', $_SERVER['HTTP_HOST']);

$db_host = 'rdsw66ek4d040dw85308.mysql.rds.aliyuncs.com';
$db_name = 'vu';
$db_user = 'dbuser_vu';
$db_pass = 'vuVU9527';



require CLASS_PATH.'mysql_class.php';
$mysql = new MySQL($db_host,$db_user,$db_pass,$db_name);
$db_name = $db_host = $db_user = $db_pass = null;

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



require LIB_PATH . 'admin.php';
require LIB_PATH . 'common.php';
require LIB_PATH . 'guest.php';
require LIB_PATH . 'houtai.php';
require LIB_PATH . 'kefu.php';
require LIB_PATH . 'miduser.php';
require LIB_PATH . 'shop.php';
require LIB_PATH . 'user.php';
require LIB_PATH . 'wuliu.php';
require LIB_PATH . 'log.php';
require LIB_PATH . 'affair.php';



//客服qq
$kfqq = '570549794';

$invite_domain = 'www.cmkxi.cn';


