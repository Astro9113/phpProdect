<?php 
//vu文案加下单跳转(最新)
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    //exit;
    exit('参数错误');
}

$args = explode('-', $r);


//参数 = 商品 -用户 - 渠道 -时间
$id     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$file_index = intval($args[3]);

$key_backup = '1-domain_2_2_1';
$domain = get_config($key_backup);

$time = time();
$r = "$id-$userid-$userwx-$file_index-$time";
$randpath = '6'.rand_str(rand(3,4));
$link = 'http://'.$domain.'/'.$randpath.'/?r='.$r;


echo 'var vu_url = \''.$link.'\';';
mysql_close();