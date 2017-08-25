<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");


$HeadArr = array ('日期','订单ID','商品名称','C端账户','支付宝账号','姓名','打款金额（元）','中间人','中间人提成','中间人支付宝账号','中间人姓名','备注' );
creatExcel($HeadArr,'utf-8','gb2312');



$shops = get_shops();
$users = get_users();
$midusers = get_midusers();



$sql = "select * from wx_guest where gueststate = '4' order by id desc";	
$infos = $mysql->query($sql);
if($mysql->numRows){
    foreach ($infos as $info){
        $invite_type = $invite_money = 0;
        
        $userid = $info['userid'];
        $shopid = $info['shopid'];
        $skuid  = $info['skuid'];
        
        $shop = $shops[$shopid];
        $shopskuid = "shopsku".$skuid;
        $shopsku = $shop[$shopskuid];
        $shopsku = explode("_",$shopsku);
        $shopname = $shop['shopname2'];
        
        if(substr($info['guestrem'],0,2)=='yy'){
            $guestrem = $info['guestrem'];
        }else{
            $guestrem='';
        }
        
        $user = $users[$userid];
        
        $username = $user['loginname'];
        $userpercent = $user['userpercent']/100;
        
        if($shop['ischange'] == '1'){
            $shopsku[2] = $shopsku[2] * $userpercent;
            $shopsku[2] = round($shopsku[2]);
        }
        
        $alipay = $user['alipay'];
        $alipayname = $user['alipayname'];
        $topid = $user['topuser'];
        
        if(!$topid){
            $topuser="无中间人";
            $midreward='';
            $midalipay='';
            $midalipayname='';
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
                $topid=substr($topid,1);
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
        
        
        $mid_money = 0;
        $mid_money = $invite_type?$invite_money:($shopsku[2]*$midreward);
    
        
        $row = array(
                date('Y/m/d'),
                $info['id'],
                $shopname,
                $username,
                $alipay,
                $alipayname,
                $shopsku[2],
                $topuser,
                $mid_money,
                $midalipay,
                $midalipayname,
                $guestrem
                
        );
        
        creatExcel($row,'utf-8','gb2312');
        $midreward=''; $midalipay=''; $midalipayname='';
    }
}

$mysql->close();