<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,5
);
qx($allow_qx, $adminclass);

foreach ($_POST as $k=>$v){
    $_POST[$k] = gl_sql(gl2($v));
}

$str = $mysql->arr2s($_POST);
$sql = "insert into wx_kefu {$str}";
$mysql->execute($sql);
go('../../');
