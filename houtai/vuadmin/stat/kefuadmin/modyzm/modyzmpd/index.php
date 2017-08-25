<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$kefuyzm=rand(100000,999999);
$sql = "update wx_seting set kefuyzm='$kefuyzm' where id='1'";
$mysql->execute($sql);
alert('修改成功');
go('../../');
