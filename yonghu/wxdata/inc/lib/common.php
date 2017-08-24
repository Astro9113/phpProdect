<?php

function is_tel($tel){
    $pat = '/^\d{11}$/';
    return preg_match($pat, $tel);
}

function is_qq($tel){
    $pat = '/^\d{5,12}$/';
    return preg_match($pat, $tel);
}



function get_invite_users(){
    global $mysql;
    $botuser=botuser();
    $sql = "select * from wx_user where id in ({$botuser})";
    $users = $mysql->query_assoc($sql, 'id');
    return $users;
}

function check_time($time){
    $time = trim($time);
    $timepat = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
    if(preg_match($timepat,$time)){
        return $time;
    }
    return false;
}

function invite_num($uid){
    global $mysql;
    $ret = $mysql->find("select count(*) as num from wx_user where topuser='$uid'");
    $num = $ret['num'];
    return $num;
}

function invite_fencheng($uid){
    $userreward = userreward();
    global $mysql;
    $botuser=botuser();
    $sql = "select shopid,skuid from wx_guest where userid in ($botuser) and gueststate = 5 order by id";
    $infos = $mysql->query($sql);
    
    if(!$infos){
        $ticheng = 0;
    }else{
        $ticheng = 0;
        $shops = get_shops();
        foreach ($infos as $info){
            $shopid = $info['shopid'];
            $skuid  = $info['skuid'];
            $shop   = $shops[$shopid];
            $fencheng = cal_fencheng($shop, $skuid);
            $ticheng += $fencheng;
        }
    }

    $ticheng = $ticheng * $userreward/100;
    $ticheng = round($ticheng,2);
    return $ticheng;
}

function base64_encode_withouteq($num){
    $num = base64_encode($num);
    $last = substr($num, -1);
    while ($last=='='){
        $num = substr($num, 0,-1);
        $last = substr($num, -1);
    }
    return $num;
}

//获取用户邀请码
function get_user_applyma($uid){
    global $mysql;
    $sql = "select applyma from wx_applyma where userid='$uid'";
    $ret = $mysql->find($sql);
    return $ret?$ret['applyma']:false;
}


//根据邀请码获取用户 或者 媒介id
function get_applyma_uid($applyma){
    global $mysql;
    $applyma = preg_replace('/[^\d]/', '', $applyma);
    $sql = "select * from wx_applyma where applyma='$applyma'";
    $ret = $mysql->find($sql);
    return $ret;
}

//随机
function rand_str($len=8){
    $seed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $str = '';
    for($i=0;$i<$len;$i++){
        $key = rand(0, 61);
        $str .= $seed[$key];
    }
    return $str;
}

//直接下单2 伪静态中有限的字母组合
function rand_str_z($len=6){
    $seed = 'abcdefghijklmnopqrstuvwxyz';
    $str = '';
    for($i=0;$i<$len;$i++){
        $key = rand(0, 23);
        $str .= $seed[$key];
    }
    return $str;
}

function base64_encode_withouteq2($num){
    $num = base64_encode($num);
    $last = substr($num, -1);
    while ($last=='='){
        $num = substr($num, 0,-1);
        $last = substr($num, -1);
    }
    return $num;
}

//sql 变量过滤
function gl_sql($var){
    if(is_array($var)){
        foreach ($var as $k=>$v){
            $var[$k] = gl_sql($v);
        }
    }else{
        if(get_magic_quotes_gpc()){
            $var = stripslashes($var);
        }
        $var = mysql_escape_string($var);
    }
    return $var;
}

//输出过滤
function gl2($var){
    if(is_array($var)){
        foreach ($var as $k=>$v){
            $var[$k] = gl2($v);
        }
    }else{
        $var = htmlspecialchars(strip_tags($var));
    }
    return $var;
}


function go($url,$msg=''){
    header('content-type:text/html;charset=utf-8;');
    echo '<script>';
    if($msg){
        echo 'alert("'.$msg.'");';
    }
    
    echo 'location.href="'.$url.'";';
    echo '</script>';
    exit;
}

function goback($msg=''){
    echo '<script>';
    if($msg){
        echo 'alert("'.$msg.'");';
    }
    echo 'history.go(-1);';
    echo '</script>';
    exit;
}

function alert($msg){
    header('content-type:text/html;charset=utf-8;');
    echo '<script>';
    echo 'alert("'.$msg.'");';
    echo '</script>';
}


//日期字符串比较大小
function dateBDate($date1, $date2) {
    $month1 = date("m", strtotime($date1));
    $month2 = date("m", strtotime($date2));
    $day1   = date("d", strtotime($date1));
    $day2   = date("d", strtotime($date2));
    $year1  = date("Y", strtotime($date1));
    $year2  = date("Y", strtotime($date2));
    $from   = mktime(0, 0, 0, $month1, $day1, $year1);
    $to     = mktime(0, 0, 0, $month2, $day2, $year2);
    if ($from > $to) {
        return true;
    } else {
        return false;
    }
}

function mysubstr($str, $start, $len) {
    $tmpstr = "";
    $strlen = $start + $len;
    for($i = 0; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else
            $tmpstr .= substr($str, $i, 1);
    }
    $cd=strlen($str);
    if($cd>$len)
        $tmpstr=$tmpstr."..";
    return $tmpstr;
}



function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


function is_zr($str){
    return $str !== mysql_escape_string($str);
}

//导出
function creatExcel($dataArr,$from='',$to='') {
    $LengthArr = count($dataArr);
    for ($i = 0; $i < $LengthArr; $i++) {
        $d = $dataArr[$i];
        if($from&&$to){
            $d = iconv($from, $to.'//IGNORE', $d);
        }
        echo $d . "\t";
    }
    echo "\n";
}

//循环输出option
function echo_option($arr,$sel_val,$val_field,$text_field){
    $str = '';
    foreach ($arr as $row){
        $value = $row[$val_field];
        $text  = $row[$text_field];
        
        $sel = '';
        
        if($value == $sel_val){
            $sel = " selected='selected' ";
        }
        $str .= "<option value='{$value}'{$sel}>{$text}</option>".PHP_EOL;
    }
    echo  $str;
}

//循环输出option
function echo_option2($arr,$sel_val){
    $str = '';
    foreach ($arr as $k=>$v){
        $sel = '';

        if($k == $sel_val){
            $sel = " selected='selected' ";
        }
        $str .= "<option value='{$k}'{$sel}>{$v}</option>".PHP_EOL;
    }
    echo  $str;
}

//配置
function get_setting(){
    global $mysql;
    $sql = "select * from wx_seting";
    $ret = $mysql->find($sql);
    return $ret;
}

function set_setting(){
    
}


function get_config ($k){
    global $mysql;
    $k = trim($k);
    $sql = "select v from wx_config where k = '{$k}' limit 1";
    $result = $mysql->find($sql);
    $config = $result['v'];
    return $config;
}

function save_config($k,$v){
    global $mysql;
    $k = trim($k);
    $v = trim($v);
    $sql = "select v from wx_config where k = '{$k}'";
    $ret = $mysql->find($sql);
    if($ret){
        $sql = "update wx_config set v = '{$v}' where k = '{$k}' limit 1";
    }else{
        $sql = "insert into wx_config(k,v) values('{$k}','{$v}')";
    }
    
    $mysql->execute($sql);
    set_cache_value($k,$v);
    
}

function set_cache_value($key,$value){
    global $redis;
    if ($redis->set($key, $value) == false) {
        return false;
    }
    return true;
}



function shorttime($time){
    return date("m-d H:i",strtotime($time));
}


//对账状态
function get_dz_state(){
    global $mysql;
    $sql = "select id,name from wx_dzstate where 1";
    $o = array();
    $ret = $mysql->query($sql);
    foreach ($ret as $row){
        $o[$row['name']] = $row['id'];
    }
    return $o;
}
//对账状态2
function get_dz_state2(){
    global $mysql;
    $sql = "select id,name from wx_dzstate where 1";
    $o = array();
    $ret = $mysql->query($sql);
    foreach ($ret as $row){
        $o[$row['id']] = $row['name'];
    }
    return $o;
}


//短信相关函数
function sms_fahuo($guestid){
    //return;
    $guestid = intval($guestid);
    $info = guestinfo($guestid);
    
    $guestname = $info['guestname'];
    $guesttel = $info['guesttel'];
    $guestkuaidi = $info['guestkuaidi'];
    $wuliugs = $info['wuliugs'];
    
    $msg = '您好'.$guestname.'，宝贝已发'.$wuliugs.'，快递单号：'.$guestkuaidi.'。客服电话15313659570，感谢订购祝您生活愉快！
';
    $ret = sms($guesttel, $msg);
    if($ret==2){
        return true;
    }else{
        return false;
    }
}

//发短信
function sms($mobile,$msg){
    $data = array(
            'account'=>'cf_vu006',
            'password'=>'12301230123',
            'mobile'=>$mobile,
            'content'=>$msg,
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

//短信辅助函数 xml 2 array
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

//加密解密类函数
function authcode ($string, $operation = 'DECODE', $key = 'sdfdsfsdfsdf', $expiry = 3600)
{
    $ckey_length = 16;
    // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥

    $key = md5($key ? $key : 'sdfdsfsdfsdf'); // 这里可以填写默认key值
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0,
            $ckey_length) : substr(md5(microtime()), - $ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(
            substr($string, $ckey_length)) : sprintf('%010d',
                    $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) .
                    $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i ++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i ++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i ++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) ==
                substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                    return substr($result, 26);
                } else {
                    return '';
                }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}



