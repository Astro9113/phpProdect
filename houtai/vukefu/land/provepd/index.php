<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';

file_put_contents('E:\log\login\vu\logkefu.txt',date('Y-m-d H:i:s').'_'.$_SERVER['REMOTE_ADDR'].'_'.$_POST['kefuloginname'].'_'.$_POST['kefupassword'].PHP_EOL,FILE_APPEND);

$adminloginname = gl_sql($_POST['kefuloginname']);
$adminpassword = gl_sql($_POST['kefupassword']);
$prove = $_POST['provemanag'];
$kefuyzm = $_POST['kfyzm'];


if ($prove != $_SESSION["sessionRound"]) {
    $hyzm = rand(100, 999);
    $_SESSION["sessionRound"] = $hyzm;
    go('../index.php','验证码错误');
}

$hyzm = rand(100, 999);
$_SESSION["sessionRound"] = $hyzm;
$kefyzm = get_yzm();


if ($kefyzm != $kefuyzm) {
    go('../index.php','客服验证不通过');
}


$sql = "select * from wx_kefu where adminloginname='$adminloginname' and adminpassword='$adminpassword'";
$ret = $mysql->query($sql);
$num = $mysql->numRows;

$info = $ret[0];

if($num){
    $_SESSION['kefu1114name'] = $info['adminname'];
    $_SESSION['kefu1114id'] = $info['id'];
    go('../../');
} else {
    go('../index.php','账号或密码错误');
}