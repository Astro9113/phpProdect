<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);


$id = intval($_GET['id']);
$shop = shopinfo($id);
if(!$shop){
    exit('商品不存在');
}

//屏蔽删除功能   启用直接删除下面这一行
exit;

$sql = "delete from wx_shop where id = $id";
$ret = $mysql->execute($sql);
go('../');