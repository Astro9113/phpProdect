<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);


for($i=1;$i<=12;$i++){
	$shopid = "id".$i;
	$id = intval($_POST[$shopid]);
	$shoporderid="order".$i;
	$shoporder = intval($_POST[$shoporderid]);
	
	$sql = "update wx_shop set shoporder=$shoporder where id=$id";
	$mysql->execute($sql);
}

go('../');