<?php 

function r(){
    $seed = 'abcdefghijklmnopqestuvwxyz0123456789谈及家居诉求，杨威直言要保留妻子杨云喜欢的黑白灰风格，爱妻之心时时可见。不仅夫妻情深，和孩子亲密如友，杨威更自曝即将迎来的二胎宝宝是双胞胎。对于即将到来的新生命，杨威笑不拢嘴，被问及孩子的名字时，杨威羞涩透露已有想法，“杨阳洋想叫杨美洋、杨阳美，我想叫杨美平、杨美安，寓意平平安安，不过身边的朋友都强烈表示不认可，但我自己觉得挺好。”不幸的是，杨威有关名字的想法在节目现场也无人支持，主持人周群还毒舌补刀“明显不如前面一个”，引发全场爆笑连连';
    $len = mb_strlen($seed,'utf-8');
    $rand_len = rand(10,100);
    $ret = '';
    for($i=0;$i<$rand_len;$i++){
        $rand = rand(0, $len-1);
        $cur = mb_substr($seed, $rand,1,'utf-8');
        $ret .= $cur;
    }
    $tpls = array(
        '<div style="display:none">%s</div>',
        '<p style="width:0;height:0">%s</p>',
        "<script>var dsds99_7 = '%s';</script>",
        '<script>//%s</script>',
    );
    $tpl = $tpls[rand(0,3)];
    $ret = sprintf($tpl,$ret);
    return $ret;
}

//下单短信
function sms_xiadan($guestid,$guesttel){
    $time = date('Y-m-d H:i:s');
    $sql = "insert into wx_sms_xiadan (guestid,guesttel,addtime,status) values('{$guestid}','{$guesttel}','{$time}',0)";
    mysql_query($sql);
}

/*
//检查当天有没有相同的 商品 手机号的订单
function check_cf($guesttel,$shopid,$max=1){
    $sql = "select count(*) as num from wx_guest where guesttel = '{$guesttel}' and shopid = '{$shopid}' and date_format(addtime,'%Y-%m-%d') = '".date('Y-m-d')."'";

    $result = mysql_query($sql);
    $num = mysql_fetch_assoc($result);
    $num = $num['num'];
    if($num >= $max){
        return true;
    }
    return false;
}
*/

//检查当天有没有相同的 商品 手机号的订单
function check_cf($guesttel,$shopid,$max=1,$skuid=1){
    $sql = "select count(*) as num from wx_guest where guesttel = '{$guesttel}' and shopid = '{$shopid}' and skuid = '{$skuid}' and date_format(addtime,'%Y-%m-%d') = '".date('Y-m-d')."'";

    $result = mysql_query($sql);
    $num = mysql_fetch_assoc($result);
    $num = $num['num'];
    if($num >= $max){
        return true;
    }
    return false;
}


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

function goback(){
    echo '<script>history.go(-1);</script>';
    exit;
}

function alert($msg){
    echo "<script>alert('$msg');</script>";
}

