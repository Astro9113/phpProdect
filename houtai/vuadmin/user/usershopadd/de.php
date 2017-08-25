<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);

$sql_str = "delete from wx_usershopadd where id = '$id'";
$mysql->execute($sql_str);
go('./');
