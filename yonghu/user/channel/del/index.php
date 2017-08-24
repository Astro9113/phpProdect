<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$id = intval($_GET['id']);

$sql = mysql_query("delete from wx_userchannel where id='$id' and channeltop='$user11id'");

if($sql){
	exit("<script>alert('删除渠道成功！'); javascript:history.go(-1);</script>");
}else{
	exit("<script>alert('删除渠道失败'); javascript:history.go(-1);</script>");
}
