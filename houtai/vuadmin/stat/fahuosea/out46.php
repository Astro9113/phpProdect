<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,7);
qx($allow_qx, $adminclass);

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");

$HeadArr = array ('订单ID','金额','单号','跑出状态','重要否');
creatExcel($HeadArr,'utf-8','gb2312');

function  notice(){
    global $mysql;
    $notice_id = array();
    $sql = "select guestid from wx_gueststate where notice = 1";
    $infos = $mysql->query_assoc($sql,'guestid');
    return $infos;
}

$notice_id = notice();
$shops = get_shops();

$sql = "select id,shopid,skuid,guestkuaidi from wx_guest where gueststate=3 and id in(select guestid from wx_gueststate where wuliustate = 4)";
$infos = $mysql->query($sql);
if($infos){
    $idname='签收';
    foreach ($infos as $info){
        $isno = '';
        if(array_key_exists($info['id'],$notice_id)){
            $isno = '重要';
        }
        $shopid=$info['shopid'];
        $skuid=$info['skuid'];
        $shop = $shops[$shopid];
        $shopskuid="shopsku".$skuid;
        $shopsku=$shop[$shopskuid];
        $shopsku=explode("_",$shopsku);
        $row=array($info['id'],$shopsku[1],$info['guestkuaidi'],$idname,$isno);
        creatExcel($row,'utf-8','gb2312');
    }
}

$sql = "select id,shopid,skuid,guestkuaidi from wx_guest where gueststate=3 and id in(select guestid from wx_gueststate where wuliustate = 5)";
$infos = $mysql->query($sql);
if($infos){
    $idname='拒收';
    foreach ($infos as $info){
        $shopid=$info['shopid'];
        $skuid=$info['skuid'];
        $shop = $shops[$shopid];
        $shopskuid="shopsku".$skuid;
        $shopsku=$shop[$shopskuid];
        $shopsku=explode("_",$shopsku);
        $row=array($info['id'],$shopsku[1],$info['guestkuaidi'],$idname);
        creatExcel($row,'utf-8','gb2312');
    }
}
