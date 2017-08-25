<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);


$id = intval($_GET['id']);
$info = miduserinfo($id);
if (! $info) {
    exit();
}

$sql = "delete from wx_miduser where id = $id";
$ret = $mysql->execute($sql);

if($ret){
	go('../');
}else{
    alert('删除失败');
    goback();
}