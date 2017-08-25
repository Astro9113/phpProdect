<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);


$id = intval($_POST['id']);
$info = admininfo($id);
if (! $info) {
    exit();
}

$adminname = $_POST['adminname'];
$adminloginname = $_POST['adminloginname'];
$adminclass = intval($_POST['adminclass']);

if($adminname !== gl2(gl_sql($adminname))){
    exit('参数错误');
}

if($adminloginname !== gl2(gl_sql($adminloginname))){
    exit('参数错误');
}



$sql = "update wx_admin set adminname='$adminname',adminloginname='$adminloginname',adminclass='$adminclass' where id = $id";
$ret = $mysql->execute($sql);
if($ret){
    go('../../','修改成功');
}else{
    alert('修改失败');
    goback();
}