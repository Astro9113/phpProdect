<?php

function get_user_byqq($qq){
    global $mysql;
    $qq = preg_replace('/[^\d]/', '', $qq);
    $sql = "select * from wx_user where qq = '$qq' limit 1";
    $ret = $mysql->find($sql);
    return $ret;
}

//用户渠道
function userChannel($uid){
    global $mysql;
    $sql = "select id,userchannel from wx_userchannel where channeltop='$uid' limit 10";
    $ret = $mysql->query($sql);
    
    foreach ($ret as $channel){
        $_ret[$channel['id']] = $channel['userchannel'];
    }
    return $_ret;
}

//用户数量 
function user_get_num($dong = 0){
    global $mysql;
    $sql = "select count(*) as num from wx_user";
    if($dong){
        $sql = "select count(*) as num from wx_user where userstate='0'";
    }
    $result = $mysql->find($sql);
    $num = $result['num'];
    return $num;
}

//用户信息
function userinfo($id){
    global $mysql;
    $sql = "select * from wx_user where id = $id";
    $ret = $mysql->find($sql);
    return $ret;
}


//用户信息
function find_user_byname($loginname){
    global $mysql;
    $sql = "select * from wx_user where loginname = '{$loginname}'";
    $ret = $mysql->find($sql);
    return $ret;
}



//获取所有用户信息
function get_users(){
    global $mysql;
    $sql = "select * from wx_user where 1";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}




//获取用户商品加价信息
function usershopadd($userid,$shopid,$skuid){
    if(!in_array($skuid, array(1,2,3))){
        $skuid = 1;
    }
    if($skuid == 1){
        $skuid = '';
    }
    $jine_sku = 'jine'.$skuid;

    $sql_str = "select * from wx_usershopadd where userid = '$userid' and shopid = '$shopid'";
    $sql = mysql_query($sql_str);
    $res = mysql_fetch_assoc($sql);
    return $res[$jine_sku];
}

//用户数量
function user_num(){
    global $mysql;
    $table = 'wx_user';
    $count = $mysql->count_table($table);
    return $count;
}

//媒介id保存的字段
function get_mid_field($uid){
    global $mysql;
    $sql = "select topuser,dinguser from wx_user where id = '$uid'";
    $ret = $mysql->find($sql);
    $target = '';
    $topuser = $ret['topuser'];
    if(strpos($topuser, 'm')!==false){
        $target = 'topuser';
    }else{
        $target = 'dinguser';
    }
    return $target;
}

function get_mid($uid){
    global $mysql;
    $sql = "select topuser,dinguser from wx_user where id = '$uid'";
    $ret = $mysql->find($sql);
    $target = '';
    $topuser = $ret['topuser'];
    if(strpos($topuser, 'm')!==false){
        $target = $ret['topuser'];
    }else{
        $target = $ret['dinguser'];
    }
    return trim(substr($target, 1));
}

//用户转媒介
function change_mid($uid,$mid){
    global $mysql;
    $target = get_mid_field($uid);
    $value = 'm'.intval($mid);
    $sql = "update wx_user set {$target} = '{$value}' where id='{$uid}'";
    $ret = $mysql->execute($sql);
}

//获取邀请人
function yaoqingren($user){
    $topid = $user['topuser'];
    if($topid==""){
        $topuser="无中间人";
    }else{
        if($top = userinfo($topid)){
            $topuser = $top['loginname'];
        }else{
            $topid = substr($topid,1);
            $top = miduserinfo($topid);
            $topuser=$top['username'];
        }
    }

    return $topuser;
}

function checkuserandpwd($username,$pwd){
    global $mysql;
    $username = gl_sql($username);
    $pwd = gl_sql($pwd);
    
    $sql = "select * from wx_user where loginname = '$username' and password = '$pwd' limit 1";
    $user = $mysql->find($sql);
    if($user){
        return $user;
    }else{
        return false;
    }
}

