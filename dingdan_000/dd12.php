<?php 
include '/wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);


//参数 = 商品 -用户 - 渠道 -时间
$id     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$time   = $args[3];

if(!$id){
    $id = 96;
    $userid = 2;
}

if(!$userid){
    $userid = 2;
}

//封之后跳转

switch($id){
	default:
	case 96:
	include 'wxa/vk.php';
	break;
	case 50:
	include 'wxa/xs.php';
	break;
}