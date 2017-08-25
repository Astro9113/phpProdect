<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';

  file_put_contents('E:\log\login\vu\log.txt',date('Y-m-d H:i:s').'_'.$_SERVER['REMOTE_ADDR'].'_'.$_POST['uname'].'_'.$_POST['pwd'].PHP_EOL,FILE_APPEND);
  


$adminloginname = gl_sql($_POST['uname']);
$adminpassword = gl_sql($_POST['pwd']);
$prove = $_POST['provemanag'];

/*
if ($prove != $_SESSION["sessionRound"]) {
    $hyzm = rand(100, 999);
    $_SESSION["sessionRound"] = $hyzm;
    go('../index.php','验证码错误');
}
*/

$hyzm = rand(100, 999);
$_SESSION["sessionRound"] = $hyzm;

$sql = "select * from wx_admin where adminloginname='$adminloginname' and adminpassword='$adminpassword'";
$ret = $mysql->query($sql);
$num = $mysql->numRows;

if(!$num){
    go('../index.php','账号或密码错误');
}

$info = $ret[0];
$_SESSION['admin1114name'] = $info['adminname'];
$_SESSION['admin1114class'] = $info['adminclass'];
$_SESSION['admin1114id'] = $info['id'];
go('../../');