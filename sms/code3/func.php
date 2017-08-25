<?php
function mylog($msg,$file=''){
    $file = $file?$file:dirname(__FILE__).'/debug.txt';
    file_put_contents($file, $msg.PHP_EOL,FILE_APPEND);
}
function send_sms($mobile,$msg){
	global $sms_user;
	global $sms_pwd;

	$data = array(
		'account' =>$sms_user,
		'password'=>$sms_pwd,
		'mobile'  =>$mobile,
		'content' =>$msg,
	);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://106.ihuyi.cn/webservice/sms.php?method=Submit');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$str = curl_exec($ch);
	$gets =  xml_to_array($str);
	if($gets['SubmitResult']['code']==2){
		return 2;
	}else{
		return $gets['SubmitResult']['code'];
	}
}

function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return $arr;
}

function send_sms_old($mobile, $msg){
    global $sms_user;
    global $sms_pwd;
    $str = 'http://211.147.239.62:8440/cgi-bin/sendsms?username=%s&password=%s&to=%s&text=%s&msgtype=1';
	//$str = 'http://211.147.239.62:9050/cgi-bin/sendsms?username=%s&password=%s&to=%s&text=%s&msgtype=1';
	
    $url = sprintf($str,$sms_user,$sms_pwd,$mobile,urlencode(iconv('utf-8', 'GBK', $msg)));
	
	//mylog($url);
    //exit;
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    //mylog(var_export($ret,true));
    return $ret;
}

function get_response(){
    global $sms_user;
    global $sms_pwd;
    
    require_once dirname(__FILE__).'/php_webservice/lib/nusoap.php';
    $wsdl = dirname(__FILE__).'/php_webservice/lib/a.wsdl';
    $client = new nusoap_client($wsdl, 'wsdl');
    $client->soap_defencoding = 'utf-8';
    $client->decode_utf8 = false;
    $client->xml_encoding = 'utf-8';
    
    $params = array(
            'account'  => $sms_user,
            'password' => $sms_pwd,
            'pagesize'   => 20,
    );
    
    $result = $client->call('GetMOMessage', $params);
    
    //mylog(serialize($result));
    //mylog(var_export($result,true));
    
    if(!$result['GetMOMessageResult']){//没有值
        return false;
    }
    return $result['GetMOMessageResult']['MOMsg'];
}