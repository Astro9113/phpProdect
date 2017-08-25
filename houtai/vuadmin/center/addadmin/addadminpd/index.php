<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Juridiction.php";


$adminname = $_POST['adminname'];
$adminloginname = $_POST['adminloginname'];
$adminpassword = $_POST['adminpassword'];
$adminclass = intval($_POST['adminclass']);

if($adminname !== gl2(gl_sql($adminname))){
    alert('参数错误');
    goback();
}

if($adminloginname !== gl2(gl_sql($adminloginname))){
    alert('参数错误');
    goback();
}

if($adminpassword !== gl2(gl_sql($adminpassword))){
    alert('参数错误');
    goback();
}

if(!$adminname || !$adminloginname || !$adminclass || !$adminpassword){
    alert('参数错误');
    goback();
}

$sql = "select id from wx_admin where adminname = '{$adminname}' or adminloginname = '{$adminloginname}' limit 1";
$ret = $mysql->query($sql);
if($ret){
    alert('帐号已存在');
    goback();
}

$sql = "insert into wx_admin(adminname,adminloginname,adminpassword,adminclass) values('$adminname','$adminloginname','$adminpassword','$adminclass')";
$ret = $mysql->execute($sql);


if($ret){
	go('../../');
}else{
    $result="添加管理员失败，请联系技术人员.";
    alert($result);
    goback();
}