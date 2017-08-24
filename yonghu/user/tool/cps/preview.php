<?php
$type = isset($_GET['type'])?$_GET['type']:'';


$arr = array(
    1=>'<script type="text/javascript" src="http://rgzj.sufgps.cn/abs/abs.php?type=1&num=5&uid=2099&width=0&height=0&cid=0&color=0&pid=119,96,50,115,116,117"></script>',
    2=>'<script type="text/javascript" src="http://m37G.sufgps.cn/abs/abs.php?type=0&num=5&uid=2099&width=100&height=100&cid=0&color=0&pid=119,96,50,115,116,117"></script>',
    3=>'<script type="text/javascript" src="http://Jfh9.sufgps.cn/abs/abs.php?type=2&num=5&uid=2099&width=0&height=0&cid=0&color=0&pid=119,96,50,115,116,117"></script>',
    4=>'<script type="text/javascript" src="http://yzW7.sufgps.cn/abs/imgs.php?type=1&uid=2099&cid=0&pid=96&findex=9"></script>',
);


$js = '';
switch ($type) {
    case '1':
        $js = $arr[1];
        break;
    case '2':
        $js = $arr[2];
        break;
    case '3':
        $js = $arr[3];
        break;
    case 'img':
        $js = $arr[4];
        break;
    default:
        break;
}


echo $js;