<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
$time = time();
$uid = intval($_GET['uid']);
$pid = intval($_GET['pid']);
$findex = intval($_GET['findex']);
$cid = 0;
$key = '1-vu_domain_waxd_1';
$domain = get_config($key);
$rand = rand_str(3);
$randParh = '5'.rand_str(4);

$args = "$pid-$uid-$cid-$findex-$time";
$link = "http://{$domain}/{$randParh}/?r={$args}&t=cps";

$sql = "select ad_img_heng as img from wx_shop_addon where shopid = '{$pid}' and file_index = '{$findex}'";
$result = mysql_query($sql);
$ret = mysql_fetch_assoc($result);
$img = $ret['img']; 
echo "var url = '{$link}';";
echo PHP_EOL;
echo "var img = '{$img}';";
echo PHP_EOL;
mysql_close();
?>

document.write("<a href=\"" + url + "\" style=\"border:none;\"><img style=\"width: 98vw !important;height:20vw;\" src=\"" + img + "\"/></a>");