<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");

$HeadArr = array ('日期','订单ID','商品名称','C端账户','支付宝账号','姓名','打款金额（元）','备注' );
creatExcel($HeadArr,'utf-8','gb2312');


$arr = array();
$shops = get_shops();
$users = get_users();


$sql = "select * from wx_guest where gueststate ='4'";
$infos = $mysql->query($sql);
if(!$infos){
    exit;
}

foreach ($infos as $info){
    $shopid = $info['shopid'];
    $skuid = $info['skuid'];
    $userid = $info['userid'];
    
    $shop = $shops[$shopid];
    $shopskuid="shopsku".$skuid;
    $shopsku = $shop[$shopskuid];
    $shopsku = explode("_",$shopsku);
    $shopname = '';
    
    $user = $users[$userid];
    $username = $user['loginname'];
    $userpercent = $user['userpercent']/100;
    
    if($shop['ischange']=='1'){
        $shopsku[2]=$shopsku[2]*$userpercent;
        $shopsku[2]=round($shopsku[2]);
    }
    
    $userdakuan = $shopsku[2];
    $alipay = $user['alipay'];
    $alipayname = $user['alipayname'];
    
    $dakuan = 0;
    $gid = array();
    
    if(array_key_exists($userid, $arr)){
        $dakuan = $arr[$userid]['dakuan'];
        $dakuan += $userdakuan;
        $arr[$userid]['dakuan'] = $dakuan;
        
        $gid = $arr[$userid]['gid'];
        $gid[] = $info['id'];
        $arr[$userid]['gid'] = $gid;
    }else{
        $gid[] = $info['id'];
        $tmp = array(
            'gid' => $gid,
            'username' => $username,
            'alipay' => $alipay,
            'alipayname' => $alipayname,
            'dakuan' => $userdakuan,
        );
        $arr[$userid] = $tmp;
    }
    
}
    

foreach ($arr as $uid=>$user){
    $gids = join(',', $user['gid']);
    $row=array(date('Y/m/d'),"'".$gids,'',$user['username'],$user['alipay'],$user['alipayname'],$user['dakuan'],'');
    creatExcel($row,'utf-8','gb2312');
}

$mysql->close();





