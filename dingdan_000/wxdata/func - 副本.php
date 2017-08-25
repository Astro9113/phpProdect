<?php 
//商品信息
function shopinfo($shopid){
    $sql = "select * from wx_shop where id = '$shopid'";
    $result = mysql_query($sql);
    $info = mysql_fetch_array($result);
    return $info;
}

//用户信息
function userinfo($uid){
    $sql = "select * from wx_user where id = '$uid'";
    $result = mysql_query($sql);
    $info = mysql_fetch_array($result);
    return $info;
}

//用户渠道
function userChannel($uid){
    $sql = "select id,userchannel from wx_userchannel where channeltop='$uid'";
    $rs = mysql_query($sql);
    $num = mysql_num_rows($rs);
    if(!$num){
        return array();
    }
    while(($row = mysql_fetch_array($rs)) !==false){
        $ret[$row['id']] = $row['userchannel'];
    }
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


//获取setting 表数据
function get_setting(){
    $sql = "select * from wx_seting where 1";
    $result = mysql_query($sql);
    $ret = mysql_fetch_assoc($result);
    return $ret;
}


//获取config表数据
function get_config_db($k){
    $k = trim($k);
    $sql = "select v from wx_config where k = '{$k}' limit 1";
    $result = mysql_query($sql);
    $config = mysql_fetch_assoc($result);
    $config = $config['v'];
    return $config;
}

function get_config($k){
    $ret = get_cache_value($k);
    if(!$ret){
        $ret = get_config_db($k);
        set_cache_value($k, $ret);
    }
    return $ret;
}


//用户处设置的大客户使用新域名
function get_domain($uid){
    $sql = "select newdomain from wx_user where id = '$uid'";
    $result = mysql_query($sql);
    $ret = mysql_fetch_assoc($result);
    return $ret['newdomain'];
}

function get_cache_value($key){
    global $redis;
    $value = $redis->get($key);
    return $value;
}

function set_cache_value($key,$value){
    global $redis;
    if ($redis->set($key, $value) == false) {
        return false;
    }
    return true;
}


function get_mid($uid){
    $key = 'vu:user:mid:'.$uid;
    $ret = get_cache_value($key);
    if(!$ret){
        $ret = get_mid_db($uid);
        set_cache_value($key, $ret);
    }
    return $ret;
}

//获取用户媒介 id
function get_mid_db($uid){
    $sql = "select topuser,dinguser from wx_user where id  = '$uid'";
    $result = mysql_query($sql);
    $ret = mysql_fetch_assoc($result);
    $topuser = $ret['topuser'];
    $dinguser = $ret['dinguser'];
    if(strpos($topuser, 'm')!==false){
        $target = $topuser;
    }else{
        $target = $dinguser;
    }
    
    $target = substr($target, 1);
    return $target;
}


//跳转
function go($url,$delay = 2000){
    if($delay){
        echo "<script>setTimeout(\"location.href='{$url}'\",$delay);</script>";
        exit;
    }else{
        echo "<script>location.href='{$url}';</script>";
        exit;
    }
}

