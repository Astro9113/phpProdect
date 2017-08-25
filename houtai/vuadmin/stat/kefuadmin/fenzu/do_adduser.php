<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,5
);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);
$pid = intval($_GET['pid']);
	
if(!$id){
		echo 'fail';
		exit;
}

if(!$pid){
		echo 'fail';
		exit;
}
	
$sql = "update wx_kefu set pid = '{$pid}' where id = '{$id}'";
$mysql->execute($sql);
echo 'ok';