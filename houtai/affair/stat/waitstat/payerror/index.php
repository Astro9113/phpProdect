<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

$page = intval($_GET['page']);
$id = intval($_GET['id']);
$sql = "select * from wx_guest where id = '{$id}' and gueststate = 4";
$info = $mysql->find($sql);

if(!$info){
    alert('订单信息不存在');
    goback();
}

$sql = "update wx_guest set gueststate='13' where id='$id'";
$ret = $mysql->execute($sql);

$u = '../?page='.$page;
if($ret){
	alert('支付宝改异常成功');
	go($u);
}else{
    alert('支付宝改异常失败');
    go($u);
}
