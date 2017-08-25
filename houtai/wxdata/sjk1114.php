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

//mysql
$db_host = 'rdsw66ek4d040dw85308.mysql.rds.aliyuncs.com';
$db_name = 'vu_new';
$db_user = 'dbuser_vu_new';
$db_pass = 'dbuser_vu_new@123';

$encode_key = 'yangsi62';

require CLASS_PATH.'mysql_class.php';
$mysql = new MySQL($db_host,$db_user,$db_pass,$db_name);
$db_name = $db_host = $db_user = $db_pass = null;

//缓存服务器
$redis_host = "r-bp14397169de53b4.redis.rds.aliyuncs.com";
$redis_port = 6379;
$redis_user = "r-bp14397169de53b4";
$redis_pwd = "zysZYS9527";


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

$invite_domain = 'www.chinavuw.com';


