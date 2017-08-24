<?php
require $_SERVER['DOCUMENT_ROOT']."/wxdata/sjk1114.php";

$username = $_POST['username'];
$userpassword = $_POST['userpassword'];
$prove = $_POST['code'];


if ($prove != $_SESSION["sessionRound"]) {
    $hyzm = rand(100, 999);
    $_SESSION["sessionRound"] = $hyzm;
    alert('验证码错误，请重新填写！');
    go('../');
} else {
    $hyzm = rand(100, 999);
    $_SESSION["sessionRound"] = $hyzm;
    
    foreach ($_POST as $v){
        if($v !== gl_sql($v)){
            alert('参数错误');
            goback();
        }    
    }
    
    if($info = checkuserandpwd($username, $userpassword)){
        $_SESSION['user1114name'] = $info['username'];
        $_SESSION['user1114id'] = $info['id'];
        $_SESSION['login1114name'] = $info['loginname'];
        $userid = $info['id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql1 = $mysql->query("insert into wx_userlogin(userid,username,ip) values('$userid','$username','$ip')");
        go('/user/active');
    }else{
        alert('密码错误，请重新填写！');
        go('../');
    }
} 

