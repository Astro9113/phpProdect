<?php 
//cli模式循环处理用户回复的脚本
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require dirname(__FILE__).'/user.php';


$delay    =  11 * 1        ; //两次处理之间间隔秒数
$check_flag = array(1,3,'1','3','回复3','确认'); //当回复内容是此值的时候才进行处理
$cancel_arr = array(0,5,'0','5','回复5','取消','不要','真的');


require dirname(__FILE__).'/func.php';

//函数==================================================================

//改订单状态 如果订单状态为确认中 则改为待发货
function change_guest_status($guestid,$sms_con){
    $table_name = 'wx_guest';
    $sms_con = intval($sms_con);
    $guestid = intval($guestid);
    if($sms_con==3){
        $rizhi = date('Y-m-d H:i:s').'， 待发货<br/>';
        $sql = "update `{$table_name}` set gueststate = 9,is_sms = '{$sms_con}',guestrizhi = concat(ifnull(guestrizhi,''),'{$rizhi}')  where id = '{$guestid}'  and gueststate = 2 limit 1";
    }else{
        $sql = "update `{$table_name}` set is_sms = '{$sms_con}' where id = '{$guestid}'  and gueststate = 2 limit 1";
    }
    $result = mysql_query($sql);
}

//改发送记录表状态
function change_wait_state($id){
    $table_name = 'wx_wait_confirm_guest';
    $sql = "update `{$table_name}` set checked = 1 where id = '{$id}'";
    $result = mysql_query($sql);
    return $result;
}

//根据手机号码 获取订单号
function get_guestid($tel){
    $table_name = 'wx_wait_confirm_guest';
    $sql = "select id,guestid,addtime from `{$table_name}` where tel = '{$tel}' and status = '1' and checked = '0' order by id desc limit 1";
    $result = mysql_query($sql);
    $ret = mysql_fetch_assoc($result);
    return $ret;
}


//开始================================================================


//循环开始
while(true){

	
    echo "==============================\r\n";
    $arr = get_response();
    if(!$arr){//没有新信息则延时之后重新循环
        echo "No response\r\n";
		sleep($delay);
        continue;
    }
	
	echo $r = json_encode($arr);
	file_put_contents('nnrrr.txt',$r.PHP_EOL,FILE_APPEND);
	continue;
    
    if(!isset($arr[0])){
        $newarr[0] = $arr;
        $arr = $newarr;
    }
    
	//mylog(var_export($arr,true));

    //有新信息则开始处理
    foreach($arr as $sub_arr){
		$cancel = false;
        $tel = trim($sub_arr['Phone']);
        $con = trim($sub_arr['Content']);
        $rtime= $sub_arr['ReceiveTime'];
        
        if(!preg_match('/^\d{11}$/', $tel)){//手机号非法
            continue;
        }

        echo "Tel : $tel\t";
        
        $wait_guest = get_guestid($tel);
        
        if(!$wait_guest){//找不到发送记录
            echo 'no send'.PHP_EOL; //有时候会重复获取,也在这里
			continue;
        }
        
        $addtime = $wait_guest['addtime'];
        $wait_id = $wait_guest['id'];
        $guestid = $wait_guest['guestid'];
        
        echo $guestid,',',$wait_id,"\t";

        //检查取消
        foreach ($cancel_arr as $v){
            if(strpos($con, $v)!==false){
                echo 'cancel______'.PHP_EOL;
                change_guest_status($guestid,5);
                change_wait_state($wait_id);
				$cancel = true;
                break;
            }
        }
		
		if($cancel){
			echo PHP_EOL;
			continue;
		}
		
        
        //检查发货
        $fahuo = false;
        foreach ($check_flag as $v){
            if(strpos($con, $v)!==false){
                change_guest_status($guestid,3);
                change_wait_state($wait_id);
                $fahuo = true;
                break;
            }
        }
        
        if($fahuo){
            echo PHP_EOL;
			continue;
        }
        
        if(!$fahuo){
            file_put_contents('sms_other.txt', $guestid.'-'.$tel.'-'.$con.'-'.strlen($con)."\r\n",FILE_APPEND);
            echo 'pass'.PHP_EOL;
            continue;
        }
    }
    
    echo date('Y-m-d H:i:s')."\r\n";
    sleep($delay);
}