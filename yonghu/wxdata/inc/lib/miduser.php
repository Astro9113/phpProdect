<?php

//媒介信息
function miduserinfo($id){
    global $mysql;
    $sql = "select * from wx_miduser where id = $id";
    $ret = $mysql->find($sql);
    return $ret;
}

//获取所有商品信息
function get_midusers(){
    global $mysql;
    $sql = "select * from wx_miduser where 1";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//根据媒介id 获取用户id列表
function get_userids_by_mid($mid){
    global $mysql;
    $mid = intval($mid);
    $mid_search_str = 'm'.$mid;
    $sql = "select id from wx_user where topuser='{$mid_search_str}' or dinguser='{$mid_search_str}'";
    $ret = $mysql->query($sql);
    if(!$ret){
        return false;
    }
    
    $ids = array();
    foreach ($ret as $u){
        $ids[] = $u['id'];
    }
    return join(',',$ids);
}