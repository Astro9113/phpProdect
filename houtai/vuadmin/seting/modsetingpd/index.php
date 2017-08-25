<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,
        9
); 

qx($allow_qx, $adminclass);

//=====================================================

$mid = isset($_POST['mid'])?intval($_POST['mid']):0;
if(!$mid){
    exit('参数错误');
}

unset($_POST['mid']);
foreach ($_POST as $k=>$v){
    $k = gl_sql(gl2($k));
    $v = gl_sql(gl2($v));
    save_config($k, $v);    
}

alert('保存成功');
go('../?mid='.$mid);
