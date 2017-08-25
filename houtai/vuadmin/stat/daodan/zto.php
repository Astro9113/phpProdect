<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,8);
qx($allow_qx, $adminclass);

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");




//$HeadArr = array ('客服','ID','商户号','日期','姓名','电话','地址','产品','金额','备注','寄件人','寄件电话','客服备注');
//creatExcel($HeadArr,'utf-8','gb2312');

$HeadArr = array('ID','发运单号','下单日期','收件人','收件地址','备注');
creatExcel($HeadArr,'utf-8','gb2312');

$sql = "select * from wx_guest where gueststate = 3 and wuliugs = '中通快递'";
$infos = $mysql->query($sql);
if($infos){
    foreach ($infos as $info){
                
                $guestname = $info['guestname'];
                $info['guestdizhi'] = str_replace(array("\n","\t"),'',$info['guestdizhi']);
                $guestdizhi = trim($info['guestdizhi']);

                $row = array(
                    $info['id'],
                    $info['guestkuaidi'],
                    $info['addtime'],
                    $guestname,
                    $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$guestdizhi,
                    $info['guestrem'],
				);
                
                creatExcel($row,'utf-8','gb2312');
    }
}
