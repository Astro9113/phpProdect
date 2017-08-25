<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array( 1,5 );
qx($allow_qx, $adminclass);


$ret2 = $redis->HKEYS('jushoushouji');
echo '<pre>';
//var_dump($ret2);

var_dump($redis->hGet('jushoushouji','1522368111400'));