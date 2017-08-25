<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$id = intval($_POST['id']);
$sql = "select * from wx_user where id = '{$id}' and (topuser = 'm{$loginid}' or dinguser = 'm{$loginid}')";
$info = $mysql->find($sql);
if(!$info){
    exit;
}


$rizhi = $info['userrizhi'];
$adduserrz = gl_sql(gl2($_POST['userrizhi']));
$rizhi .= date('y-m-d H:i')."， ".$adduserrz."<br/>";


echo $sql = "update wx_user set userrizhi='$rizhi' where id=$id";
$ret = $mysql->execute($sql);
go('../?id='.$id);