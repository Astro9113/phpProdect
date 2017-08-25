<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);


$username = $_POST['adminname'];
$userloginname = $_POST['adminloginname'];
$userpassword = $_POST['adminpassword'];
$fname="00".date("ymdhis").rand(1000,9999);
$midclass = intval($_POST['midclass']);

if($username !== gl2(gl_sql($username))){
    alert('参数错误');
    goback();
}

if($userloginname !== gl2(gl_sql($userloginname))){
    alert('参数错误');
    goback();
}

if($userpassword !== gl2(gl_sql($userpassword))){
    alert('参数错误');
    goback();
}

if(!$username || !$userloginname || !$userpassword){
    alert('参数错误');
    goback();
}


$sql = "select id from wx_miduser where username = '{$username}' or midloginname = '{$userloginname}' limit 1";
$ret = $mysql->query($sql);
if($ret){
    alert('帐号已存在');
    goback();
}


$sql = "insert into wx_miduser(username,applyma,midloginname,midpassword,midclass) values('$username','$fname','$userloginname','$userpassword','$midclass')";
$ret = $mysql->execute($sql);

$new_mid = $mysql->last_insert_id();
$sql = "insert into wx_applyma(userid,applyma) values('$new_mid','$fname')";
$ret = $mysql->execute($sql);


if($ret){
    go('../../');
}else{
    $result="添加失败，请联系技术人员.";
    alert($result);
    goback();
}