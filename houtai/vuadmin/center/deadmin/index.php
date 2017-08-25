<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Juridiction.php";


$id = intval($_GET['id']);
$info = admininfo($id);
if (! $info) {
    exit();
}

$sql = "delete from wx_admin where id = $id and id <> '{$loginid}'";
$ret = $mysql->execute($sql);

if($ret){
	go('../');
}else{
    alert('删除失败');
    goback();
}
