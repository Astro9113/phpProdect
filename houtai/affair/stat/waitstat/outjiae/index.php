<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");

$HeadArr = array ('日期','C端账户','支付宝账号','姓名','附加金额（元）' );
creatExcel($HeadArr,'utf-8','gb2312');


$sql = "select * from wx_usershopadd where 1";
$ret = $mysql->query($sql);
$useradd = array();
foreach ($ret as $r){
    $userid = $r['userid'];
    $shopid = $r['shopid'];
    $key = $userid.'-'.$shopid;
    $useradd[$key] = $r;
}

$shops = get_shops();
$users = get_users();


$sql = "select * from wx_guest where gueststate ='4'";
$infos = $mysql->query($sql);
if(!$infos){
    exit;
}


$arr = array();
foreach ($infos as $info){
    $shopid = $info['shopid'];
    $skuid = $info['skuid'];
    $userid = $info['userid'];
    
    if(!in_array($skuid, array(1,2,3,4,5,6,7,8,9,10,11,12))){
        $skuid = 1;
    }
    if($skuid == 1){
        $skuid = '';
    }
    $jine_sku = 'jine'.$skuid;
    
    $key = $userid.'-'.$shopid;
    
    
    $add = isset($useradd[$key])?$useradd[$key][$jine_sku]:0;
    
    $user = $users[$userid];
    $username = $user['loginname'];
    $alipay = $user['alipay'];
    $alipayname = $user['alipayname'];

    $dakuan = 0;
    $gid = array();

    if(array_key_exists($userid, $arr)){
        $dakuan = $arr[$userid]['dakuan'];
        $dakuan += $add;
        $arr[$userid]['dakuan'] = $dakuan;
    }else{
        $tmp = array(
                'username' => $username,
                'alipay' => $alipay,
                'alipayname' => $alipayname,
                'dakuan' => $add,
        );
        $arr[$userid] = $tmp;
    }

}


foreach ($arr as $uid=>$user){
    $row=array(date('Y/m/d'),$user['username'],$user['alipay'],$user['alipayname'],intval($user['dakuan']));
    creatExcel($row,'utf-8','gb2312');
}

$mysql->close();
