<?php 
//cli 模式循环发送短信的脚本
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require dirname(__FILE__).'/user.php';

$delay = 2 * 1; //两次处理之间间隔秒数

require dirname(__FILE__).'/func.php';

//函数==========================================================

//获取一定数量的未发送的信息
function get_rows(){
	//$addtime = '1446156000';
    $infos = array();
    $limit = 20;//一次最多处理的订单数量
    $table_name = 'wx_wait_confirm_guest';
    $sql = "select `id`,`guestid` from `{$table_name}` where id > 92382 and status = '0' order by id desc limit {$limit} ";
    $result = mysql_query($sql);
    if(!$result){
        return false;
    }
    
    while (($info = mysql_fetch_assoc($result))!==false){
        $infos[] = $info;                            
    }
    return $infos;
}


//根据待发送信息构造 短信内容
function get_sms($guest_info){
	return '您好，您的订单已成功提交，因春节物流放假1.23-2.2无法发货，2月3（初七）我公司会给您电话核实安排发货请注意接听。祝您春节快乐，阖家幸福。';
    global $shops;
	$name = $guest_info['guestname'];
    $tel = $guest_info['guesttel'];
    $shopid = $guest_info['shopid'];
	$skuid  = $guest_info['skuid'];
	$shop = $shops[$shopid];
	$shopname = $shop['shopname'];
	$shoptitle = $guest_info['guestkuanshi'];
    
	//mylog(var_export($guest_info,true));
	
	$shopsku_field = 'shopsku'.$skuid;
	$shopsku = $shop[$shopsku_field];
	$shopsku=explode("_",$shopsku);
	$price = $shopsku[1];
	$skuname = $shopsku[0];
	
	//$msg = "{$name}您好,您订购的{$shopname}{$shoptitle}{$skuname}已经订购成功！全程保密配送，货到您只需要支付{$price}元即可（可开箱验货）如确认信息无误请直接回复3,如有疑问请回复5,之后将会有工作人员(早9点-晚6点之间)与您联系！祝您身体健康，生活愉快！";
	$msg = "{$name}您好,您订购的{$shopname}{$shoptitle}{$skuname}已经订购成功！全程保密配送大概3-7天之内送到，货到您只需要支付{$price}元即可!请回复3确认发货,如有疑问请回复5,之后将会有工作人员(早9点-晚6点之间)与您联系！祝您身体健康，生活愉快！";
	
	return $msg;
}


//获取所有商品信息  
function get_all_shops(){
    $ret = array();
    $sql = "select * from wx_shop where 1";
    $result = mysql_query($sql);
    while(($row=mysql_fetch_assoc($result))!==false){
       $shopid = $row['id'];
       $ret[$shopid] = $row;
    }
    return $ret;
}

//获取订单信息
function get_guest_info($guestid){
    $table_name = 'wx_guest';
    $sql = "select * from `{$table_name}` where `id` = '{$guestid}' and gueststate = 2";
    $result = mysql_query($sql);
    if(!$result){
        return false;
    }
    $guest = mysql_fetch_assoc($result);
    return $guest;
}

//改发送状态
function change_status($id){
    $table_name = 'wx_wait_confirm_guest';
    $sql = "update `{$table_name}` set `status` = '1' where `id` = '{$id}'";
    mysql_query($sql);
}
//短信发送记录
function sms_log($guestid,$sms,$ret,$mobile,$linkid){
	$sql  = "insert into wx_smslog(addtime,guestid,sms,ret,mobile,linkid) values(now(),'$guestid','$sms','$ret','$mobile','$linkid')";
	mysql_query($sql);
}


//开始==========================================================================
$shops = get_all_shops();

//循环开始
while(true){
    echo "==============================\r\n";
    $infos = get_rows();
    
    //var_dump($infos);
    //exit;
    
    if(!$infos){//没有新信息则延时重新循环
        echo 'No guest'.rand(1,99).PHP_EOL;
        sleep($delay);
        continue;
    }
    
    //有新信息则开始处理
    foreach($infos as $info){
        $guestid = $info['guestid'];
        $infoid = $info['id'];
        
        echo "guestid : $guestid\r\n";
        
        $guest_info = get_guest_info($guestid);
        if(!$guest_info){
            change_status($infoid);
            continue;
        }
        
        $mobile = $guest_info['guesttel'];
        if(!preg_match('/^[0-9]{11}$/', $mobile)){//不是手机号就改状态跳过
            change_status($infoid);
            continue;
        }
		
		
		$sms_msg = get_sms($guest_info);//根据订单信息 生成短信内容

		
        if(!$sms_msg){
            change_status($infoid);
            continue;
        }
        
        $ret = send_sms($mobile,$sms_msg);//发送短信
				
        $ret = intval($ret);
        
        sms_log($guestid,$sms_msg,$ret,$mobile,$infoid);
        
        if($ret !==2 ){
			$error =  "sms error ,errro no : $ret \r\n";
			file_put_contents(dirname(__FILE__).'/sendError.txt',$error.'_'.$sms_msg,FILE_APPEND);
			file_put_contents(dirname(__FILE__).'/sendError2.txt',$infoid.PHP_EOL,FILE_APPEND);
			echo $error;
            //continue;
        }
        
        change_status($infoid);
        //exit;
    }
    
    echo date('Y-m-d H:i:s')."\r\n";
    sleep($delay);
}








