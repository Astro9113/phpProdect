<?php
//初始化文件

//错误控制
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//路径常量
define('ROOT', dirname(__FILE__));
define('HOST', $_SERVER['HTTP_HOST']);
define('INC', ROOT.DIRECTORY_SEPARATOR.'inc');
define('CLASS_PATH', INC.DIRECTORY_SEPARATOR.'class');
define('LIB_PATH', INC.DIRECTORY_SEPARATOR.'lib');
define('CONFIG_PATH', INC.DIRECTORY_SEPARATOR.'config');
define('UPLOAD_PATH', ROOT.DIRECTORY_SEPARATOR.'upload');

//包含类库
include CLASS_PATH.DIRECTORY_SEPARATOR.'upload.class.php';
include CLASS_PATH.DIRECTORY_SEPARATOR.'curl.class.php';
include CLASS_PATH.DIRECTORY_SEPARATOR.'mysql.class.php';

//lib
include LIB_PATH.DIRECTORY_SEPARATOR.'common.php';

//输出一个编码 防止乱码
header('content-type:text/html;charset=utf-8');

$commonLog = 'debug.txt';




