<?php 
//cli 模式循环发送短信的脚本
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require dirname(__FILE__).'/user.php';

$delay = 2 * 1; //两次处理之间间隔秒数

require dirname(__FILE__).'/func.php';

//函数==========================================================

//根据待发送信息构造 短信内容
function get_sms(){
    $msg = "您之前领取的手表，因需求量巨大生产仓促，未经检验，可能质量未达标给您带来不便，我公司决定补送后 期生产的做工精美质优手表弥补您，厂家直接检验合格发货，降低仓储成本，只需到付20元人工打包费邮费 即可，如需补送，请回复3，不需要请回复5。";
	$msg = '双十一大放价.菲斯特手表厂家为回馈老客户,原价298元的手表双十一期间仅需支付14.9包装费用就可免费领取,双十一过后恢复原价,详情请加微信 yangsi62';
	return $msg;
}




    echo "==============================\r\n";
    $infos = file(dirname(__FILE__).'/tels2.txt');
    
    
    //有新信息则开始处理
    foreach($infos as $info){
        
        $mobile = trim($info);
        if(!preg_match('/^[0-9]{11}$/', $mobile)){//不是手机号就改状态跳过
           continue;
        }
		
		
		$sms_msg = get_sms();//根据订单信息 生成短信内容

		
        $ret = send_sms($mobile,$sms_msg);//发送短信
				
        $ret = intval($ret);
        
        if($ret !==0 ){
			$error =  "sms error ,errro no : $ret \r\n";
			file_put_contents(dirname(__FILE__).'/sendError.txt',$error.'_'.$sms_msg,FILE_APPEND);
			file_put_contents(dirname(__FILE__).'/sendError2.txt',$infoid.PHP_EOL,FILE_APPEND);
			echo $error;
            //continue;
        }
        
    }
    
    echo date('Y-m-d H:i:s')."\r\n";








