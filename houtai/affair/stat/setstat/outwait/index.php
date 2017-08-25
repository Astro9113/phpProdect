<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

header("Content-type:application/vnd.ms-excel"); 
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");


$HeadArr = array ('编号','订单号','用户名','金额','账号','姓名','属性','日期' );

creatExcel($HeadArr,'utf-8','gb2312');


$time1=$_GET['time1'];
$phptime=strtotime($time1);
$time3=date('Y-m-d H:i:s',$phptime);
$time2=$_GET['time2'];
$phptime2=strtotime($time2);
$time4=date('Y-m-d H:i:s',$phptime2);

$sql = "select * from wx_playmoney where addtime>='$time3' and addtime<='$time4' order by id desc";
$infos = $mysql->query($sql);
foreach ($infos as $info){
    if($info['moneyclass']=='1'){
        $monclass='微信主';
    }else{
        $monclass='中间人';
    }
    
    $row = array(
            $info['id'],
            $info['moneyguestid'],
            $info['moneyname'],
            $info['moneyhow'],
            $info['moneynum'],
            $info['moneyfullname'],
            $monclass,
            $info['addtime'],
    );
    
    creatExcel($row,'utf-8','gb2312');
}
