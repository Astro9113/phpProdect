<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");

$HeadArr = array ('日期','订单ID','中间人','中间人提成','中间人支付宝账号','中间人姓名' );
creatExcel($HeadArr,'utf-8','gb2312');

$arr = array();
$shops = get_shops();
$users = get_users();
$midusers = get_midusers();

$sql = "select * from wx_guest where gueststate ='4'";
$infos = $mysql->query($sql);
if(!$infos){
    exit;
}

foreach ($infos as $info){
    $id = $info['id'];
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
    $topid = $user['topuser'];
    
    if($shop['ischange']=='1'){
        $shopsku[2]=$shopsku[2]*$userpercent;
        $shopsku[2]=round($shopsku[2]);
    }
    
    if(!$topid){
        $topuser = "无中间人";
        $midreward='';
        $midalipay='';
        $midalipayname='';
        continue;
    }else{
        $top = null;
        if(array_key_exists($topid, $users)){
            $top = $users[$topid];
        }
    
        if($top){
            $topuser = $top['loginname'];
            $midreward = $top['userreward']/100;
            $midalipay = $top['alipay'];
            $midalipayname = $top['alipayname'];
            $invite_type = $top['invite_type'];
            $invite_money = $top['invite_money'];
        }else{
            continue;
            $topid = substr($topid,1);
            $top = $midusers[$topid];
    
            if($top['midclass']=='0'){
                $topuser = $top['username'];
                $midreward = $top['midreward']/100;
                $midalipay = $top['midalipay'];
                $midalipayname = $top['midalipayname'];
            }else{
                $topuser = "无中间人";
                $midreward='';
                $midalipay='';
                $midalipayname='';
            }
        }
    }
    
    
    $dakuan = 0;
    $gid = array();
    
    $key = md5($topuser);
    

    if(array_key_exists($key, $arr)){
        $dakuan = $arr[$key]['dakuan'];
        $dakuan += $shopsku[2];
        $arr[$key]['dakuan'] = $dakuan;
    
        $gid = $arr[$key]['gid'];
        $gid[] = $id;
        $arr[$key]['gid'] = $gid;
    }else{
        $gid[] = $id;
        $tmp = array(
                'gid' => $gid,
                'username' => $topuser,
                'alipay' => $midalipay,
                'alipayname' => $midalipayname,
                'dakuan' => $shopsku[2],
                'reward'=> $midreward,
                'invite_type'=>$invite_type,
                'invite_money'=>$invite_money,
        );
        $arr[$key] = $tmp;
        
    }
    
    
    
    
}


foreach ($arr as $uid=>$user){
    $money = 0;
    $money = $user['invite_type']?(count($user['gid'])*$user['invite_money']):($user['dakuan'] * $user['reward']);
    $gids = join(',', $user['gid']);
    $row=array(
        date('Y/m/d'),
        "'".$gids,
        $user['username'],
        $money,
        $user['alipay'],
        $user['alipayname']
    );
    creatExcel($row,'utf-8','gb2312');
}

$mysql->close();