<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';


  file_put_contents('E:\log\login\vu\logsale.txt',date('Y-m-d H:i:s').'_'.$_SERVER['REMOTE_ADDR'].'_'.$_POST['miduserloginname'].'_'.$_POST['miduserpassword'].PHP_EOL,FILE_APPEND);

$adminloginname = gl_sql($_POST['miduserloginname']);
$adminpassword = gl_sql($_POST['miduserpassword']);
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


$sql = "select * from wx_miduser where midloginname='$adminloginname' and midpassword='$adminpassword'";
$ret = $mysql->query($sql);
$num = $mysql->numRows;

$info = $ret[0];

if($num){
    $_SESSION['miduser1114name'] = $info['username'];
	$_SESSION['miduser1114id'] = $info['id'];	
	$_SESSION['mid1114class'] = $info['midclass'];
    go('../../');
} else {
    go('../index.php','账号或密码错误');
}