<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
file_put_contents('E:\log\login\vu\logcaiwu.txt',date('Y-m-d H:i:s').'_'.$_SERVER['REMOTE_ADDR'].'_'.$_POST['caiwuloginname'].'_'.$_POST['caiwupassword'].PHP_EOL,FILE_APPEND);

if(!check_request($_POST)){
    alert('参数不合法');
    go('../');
}


$adminloginname = gl_sql($_POST['caiwuloginname']);
$adminpassword = gl_sql($_POST['caiwupassword']);
$prove = $_POST['provemanag'];

if ($prove != $_SESSION["sessionRound"]) {
    $hyzm = rand(100, 999);
    $_SESSION["sessionRound"] = $hyzm;
    go('../index.php','验证码错误');
}

$hyzm = rand(100, 999);
$_SESSION["sessionRound"] = $hyzm;


$sql = "select * from wx_admin where adminloginname='$adminloginname' and adminpassword='$adminpassword' and adminclass = 6";
$ret = $mysql->find($sql);

if($ret){
    $_SESSION['caiwu1114name'] = $ret['adminname'];
    $_SESSION['caiwu1114class'] = $ret['id'];
    go('../../');
} else {
    go('../index.php','账号或密码错误');
}