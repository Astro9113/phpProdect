<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];
$userchannel = gl2(gl_sql($_POST['userchannel']));
$channelcon = gl2(gl_sql($_POST['channelcon']));

if($userchannel !== $_POST['userchannel']){
    alert('渠道名称格式错误');
    goback();
}

if($channelcon !== $_POST['channelcon']){
    alert('渠道描述格式错误');
    goback();
}

$w = "channeltop = $user11id";
$count = $mysql->count_table('wx_userchannel',$w);
if($count>=10){
    alert('最多添加10个渠道,如需添加更多请联系媒介处理');
    goback();
}

$sql = mysql_query("insert into wx_userchannel(userchannel,channelcon,channeltop) values('$userchannel','$channelcon','$user11id')");

if($sql){
	exit("<script>alert('添加渠道成功！'); javascript:history.go(-2);</script>");
}else{
	exit("<script>alert('添加渠道失败'); javascript:history.go(-2);</script>");
}