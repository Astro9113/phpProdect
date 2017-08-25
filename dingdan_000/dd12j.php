<?php 
include 'wxdata/sjk1114.php';
$r = isset($_GET['r'])?$_GET['r']:'';

if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);


//参数 = 商品 -用户 - 渠道 -时间
$id     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);

if(!$id){
    $id = 96;
    $userid = 1;
}


//拿跳转链接,跳转
$mid = get_mid($userid);
$key = $mid.'-vu_domain_zjxd_2';
$key_backup = '1-vu_domain_zjxd_2';
$domain = get_config($key);
$domain = $domain?$domain:get_config($key_backup);

$randpath = '2'.rand_str(rand(3,7));
$link = 'http://'.rand_str(4).'.'.$domain.'/'.$randpath.'/?r='.$r;
echo '<script>location.href="'.$link.'";</script>';
mysql_close();