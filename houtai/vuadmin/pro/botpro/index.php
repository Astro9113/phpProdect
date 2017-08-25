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

$shopname2 = $shop['shopname2'];
$upbot = abs($shop['upbot'] - 1);

$sql = "update wx_shop set upbot = '{$upbot}' ,shoporder = 0 where id = $id";
$ret = $mysql->execute($sql);
if($ret){
	$adduser = $adminname;
	$sql2 = "insert into wx_shopupbotlog(shopid,upbot,adduser) values('$id','{$upbot}','$adduser')";
	$mysql->execute($sql);
	alert('修改成功');
	go('../');
}else{
    alert('修改失败');
	go('../');
}
