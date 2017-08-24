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
    
    if($v !== gl_sql($v)){
        alert('参数错误');
        goback();
    }
}


$olduserpassword = $_POST['olduserpassword'];
$userpassword    = $_POST['userpassword'];
$userpassword2   = $_POST['userpassword2'];


if(!$userpassword){
    exit("<script>alert('密码不能为空！'); javascript:history.go(-1);</script>");
}

if($userpassword !== $userpassword2){
    exit("<script>alert('新密码输入不一致！'); javascript:history.go(-1);</script>");
}

$user = userinfo($uid);
$olduserpassword2=$user['password'];

if($olduserpassword!=$olduserpassword2){
 	exit("<script>alert('原密码不正确！'); javascript:history.go(-1);</script>");
}else{
    $sql=mysql_query("update wx_user set password='$userpassword' where id=$uid");
    if($sql){
     	exit("<script>alert('修改密码成功！'); javascript:history.go(-2);</script>");
    }else{
     	exit("<script>alert('修改密码失败'); javascript:history.go(-1);</script>");
    }
}