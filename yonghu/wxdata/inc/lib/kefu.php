<?php

//获取所有客服信息
function get_kefus(){
    global $mysql;
    $sql = "select * from wx_kefu where 1";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//根据状态获取客服订单数
function kefu_get_num($kfid,$gueststate){
    global $mysql;
    $gueststate = intval($gueststate);
    $kfid = intval($kfid);  

    if(!$gueststate){
        $sql = "select count(*) as num from wx_guest where guestkfid = '{$kfid}'";
    }else{
        $sql = "select count(*) as num from wx_guest where  gueststate='{$gueststate}' and guestkfid = '{$kfid}'";
    }

    $result = $mysql->find($sql);
    $num = $result['num'];
    return $num;
}

//获取客服信息
function get_kefu_info($id){
	global $mysql;
    $sql = "select * from wx_kefu where id = '{$id}'";
	$ret = $mysql->find($sql);
	return $ret;
}

//客服今日订单数量统计
function get_num_today($kfid,$orderstate,$important=0){
    global $mysql;
    $uptime = date('Y-m-d', time() - 24 * 60 * 60) . ' 18:00:00';
    $sql = "select count(*) as num from wx_guest where guestkfid='$kfid' and gueststate='$orderstate' and addtime>'$uptime' and userid not in(select id as userid from wx_user where isimportant = 1)";
    if($important){
        $sql = "select count(*) as num from wx_guest where guestkfid='$kfid' and gueststate='$orderstate' and addtime>'$uptime' and userid  in(select id as userid from wx_user where isimportant = 1)";
    }
    $ret = $mysql->find($sql);
    $num = $ret['num'];
    return $num;
}

//获取组员
function zuyuan($zuzhang_id){
    global $mysql;
    $sql = "select * from wx_kefu where pid = $zuzhang_id and level = 0";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//检查组员组长关系是否真实
function check_relation($zy,$zz){
    global $mysql;
    $sql = "select * from wx_kefu where pid = $zz and level = 0 and id = $zy";
    $ret = $mysql->find($sql);
    return $ret;
}











