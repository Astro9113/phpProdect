<?php

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

    return htmlentities($topuser);
}

