<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$uid = $user11id=$_SESSION['user1114id'];

$applyma = get_user_applyma($uid);
if($applyma){
    exit("<script>alert('已经拥有邀请链接！'); javascript:history.go(-1);</script>");
}else{
    $fname = date("ymdhis").rand(1000,9999);
    $sql = mysql_query("insert into wx_applyma(userid,applyma) values('$uid','$fname')");
    
    if($sql){
        exit("<script>alert('申请邀请链接成功！'); javascript:history.go(-1);</script>");
    }else{
        exit("<script>alert('申请邀请链接失败！'); javascript:history.go(-1);</script>");
    }
}
