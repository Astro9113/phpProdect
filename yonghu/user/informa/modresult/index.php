<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

foreach ($_POST as $v){
    if($v !== gl2($v)){
        alert('参数错误');
        goback();
    }
}

$username   = $_POST['username'];
$qq         = $_POST['qq'];
$tel        = $_POST['tel'];
$email      = $_POST['email'];
$alipay     = $_POST['alipay'];
$alipayname = $_POST['alipayname'];

if(!is_qq($qq)){
    alert('qq号码只能是数字');
    goback();
}

if(!is_tel($tel)){
    alert('手机号码只能是11位数字');
    goback();
}

$user = userinfo($uid);
if($user['alipay']){
    $sql = "update wx_user set username='$username',qq='$qq',tel='$tel',email='$email' where id = '$uid'";        
}else{
    $sql = "update wx_user set username='$username',qq='$qq',tel='$tel',email='$email',alipay='$alipay',alipayname='$alipayname' where id = '$uid'";
}

$ret = $mysql->execute($sql);
if($ret!==false){
    go('../');
}else{
    go('../','信息修改失败');
}
