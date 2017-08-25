<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

echo $id = intval($_POST['id']);
$info = get_kefu_info($id);
if(!$info){
    exit('信息不存在');
}


foreach ($_POST as $k =>$v){
    $_POST[$k] = gl_sql(gl2($v));
}

$adminname = $_POST['adminname'];
$adminloginname = $_POST['adminloginname'];
$kfnum = $_POST['kefunum'];
$lbsnum = $_POST['lianxinum'];

$sql = "update wx_kefu set adminname='$adminname',adminloginname='$adminloginname',kfnum='$kfnum',lbsnum='$lbsnum' where id=$id";
$mysql->execute($sql);

go('../?id='.$id);
