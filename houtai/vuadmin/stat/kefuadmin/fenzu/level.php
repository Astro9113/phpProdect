<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);
$id = intval($_GET['id']);
	
if(!$id){
    echo 'fail';
	exit;
}

$sql = "update wx_kefu set pid = 0 where pid = $id";
$mysql->execute($sql);	
$sql = "update wx_kefu set level = abs(level-1) where id = $id";
$mysql->execute($sql);	
echo 'ok';