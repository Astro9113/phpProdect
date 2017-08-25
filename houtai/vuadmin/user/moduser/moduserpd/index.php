<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$id = intval($_POST['id']);
$info = userinfo($id);
if(!$info){
    exit('用户不存在');
}


foreach ($_POST as $k=>$v){
    $_POST[$k]  = gl_sql($v);
}

$data['qq']    = $_POST['qq'];
$data['tel']   = $_POST['tel'];
$data['email'] = $_POST['email'];
$data['alipayname'] = $_POST['alipayname'];
$data['alipay'] = $_POST['alipay'];
$data['isimportant'] = intval($_POST['isimportant']);
$data['userstate'] = intval($_POST['userstate']);
$data['invite_type'] = intval($_POST['invite_type']);


$update_str = $mysql->arr2s($data,'update');
$sql = "update wx_user set {$update_str} where id='$id'";
$ret = $mysql->execute($sql);

if($ret){
    alert('修改成功');
	go('../?id='.$id);
}else{
    $result="修改用户信息失败，请联系技术人员.";
    alert($result);
    go('../?id='.$id);
}