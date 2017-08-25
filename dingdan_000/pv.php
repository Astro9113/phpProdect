<?php 
include 'wxdata/sjk1114.php';

$shopid = intval($_POST['sid']);
$userid = intval($_POST['uid']);
$userwx = intval($_POST['wid']);
$tourl  = (strlen($_POST['r'])<=200)?$_POST['r']:substr($_POST['r'], 0,200); 

$sql = mysql_query("insert into wx_tongji(userid,wxid,shopid,tourl) values('$userid','$userwx','$shopid','$tourl')");
mysql_close();
