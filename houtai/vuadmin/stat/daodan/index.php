<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,8);
qx($allow_qx, $adminclass);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>


<a href="outwait.php?sj=zuowan">昨天下午5点之后</a><br /><br />
<a href="outwait.php?sj=shangwu">今天 8:00 ---- 13:30</a><br /><br />

<a href="outwait.php?sj=jin1">今天下午13:30 ---- 16:00</a><br /><br />
<a href="outwait.php?sj=jin2">今天下午16:00 ---- 17:00</a><br /><br />
<!-- <a href="outwait.php?sj=jin3">今天下午17:00 ---- 18:30</a><br /><br /> -->
<!-- <a href="outwait.php?sj=jin4">昨天下午18:30 ---- 昨天12:00</a><br /><br /> -->

<!-- <a href="outwait.php?sj=jin3">今天下午17:00 ---- 19:00</a><br /><br />  -->


</body>
</html>