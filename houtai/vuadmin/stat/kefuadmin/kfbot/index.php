<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$id  = intval($_GET['id']);
$sql = "update wx_kefu set kfupbot='0' where id='$id'";
$mysql->execute($sql);
go('../');
