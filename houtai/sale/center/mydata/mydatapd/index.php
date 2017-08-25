<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$info = miduserinfo($loginid);

foreach ($_POST as $k=>$v){
    $_POST[$k] = gl_sql(gl2($v));
}


$midkefuname    = $_POST['midkefuname'];
$midkefuqq      = $_POST['midkefuqq'];
$midkefutel     = $_POST['midkefutel'];

$sql = "update wx_miduser set midkefuname='$midkefuname',midkefuqq='$midkefuqq',midkefutel='$midkefutel' where id=$loginid";
$ret = $mysql->execute($sql);

if($ret){
	$result="修改我的信息成功";
}else{
    $result="修改我的信息失败，请联系技术人员.";
}

alert($result);
go('../');

