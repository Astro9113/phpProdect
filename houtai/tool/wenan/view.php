<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";
ini_set('display_errors', 'off');


$id = intval($_GET['id']);

$sql = "select * from wx_shop_addon where id = $id";
$addon = $mysql->find($sql);

$shopid = $addon['shopid'];
$findex = $addon['file_index'];

$domain = get_config('1-jumpdomain_2');

$args = "$shopid-1-0-$findex-000";
$url  = 'http://aaa.'.$domain.'/5aa/?r='.$args; 
header('location:'.$url);