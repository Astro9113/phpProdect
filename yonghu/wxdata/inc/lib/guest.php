<?php

//订单数量 
function guest_get_num($gueststate = 0){
    global $mysql;
    $gueststate = intval($gueststate);
    
    if(!$gueststate){
        $sql = 'select count(*) as num from wx_guest';
    }else{
        $sql = "select count(*) as num from wx_guest where  gueststate='{$gueststate}'";
    }
    
    $result = $mysql->find($sql);
    $num = $result['num'];
    return $num;
}

//订单信息
function guestinfo($id){
    global $mysql;
    $sql = "select * from wx_guest where id = '{$id}';";
    $ret = $mysql->find($sql);
    return $ret;
}


//订单状态
function get_orderstates(){
    global $mysql;
    $sql = "select * from wx_orderstate order by statesx";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//状态信息
function orderstateinfo($id){
    global $mysql;
    $sql = "select * from wx_orderstate where id = $id";
    $ret = $mysql->find($sql);
    return $ret;
}

//客服查询订单处理手机号码
function guesttel_kefu($guetstel,$gueststate){
    $arr = array(4,5); //签收 结算不显示
    if (in_array($gueststate, $arr)) {
        return  gl2(substr($guetstel, 0, 7) . "****");
    } else {
        return  gl2($guetstel);
    }
}

//处理订单日志
function guestrizhi($guestrizhi){
    $rizhi = explode('<br/>', $guestrizhi);
    foreach ($rizhi as $k => $v) {
        $rizhi[$k] = gl2($v);
    }
    return join('<br/>', $rizhi);
}

//连不上的状态
function get_lbsstates(){
    global $mysql;
    $sql = "select * from wx_lbsstate";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//连不上的状态
function get_ages(){
    global $mysql;
    $sql = "select * from wx_guestage order by id";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//统计今日各状态的订单数量
function tnum ($aa){
    global $mysql;
    if (date('H') >= 17) {
        $zuotian = date("Y-m-d") . " 17:00:00";
        $jintian = date('Y-m-d', time() + 24 * 60 * 60) . " 17:00:00";
    } else {
        $zuotian = date("Y-m-d", time() - 24 * 60 * 60) . " 17:00:00";
        $jintian = date('Y-m-d') . " 17:00:00";
    }

    $w = "addtime between '$zuotian' and  '$jintian' and gueststate  = $aa";
    $num = $mysql->count_table('wx_guest',$w);
    return $num;
}

//改签收
function qianshou($id){
    global $mysql;
    $id = intval($id);
    $rizhi_addon = date('Y-m-d H:i:s')."， 已签收<br/>";
    $sql="update wx_guest set gueststate = 4 ,guestrizhi = concat(guestrizhi,'{$rizhi_addon}') where id='$id' and gueststate = 3";
	$ret = $mysql->execute($sql);
	return (bool) $ret;		
}

//改签收
function jushou($id){
    global $mysql;
    $id = intval($id);
    $rizhi_addon = date('Y-m-d H:i:s')."， 拒收<br/>";
    $sql="update wx_guest set gueststate = 6 ,guestrizhi = concat(guestrizhi,'{$rizhi_addon}') where id='$id' and gueststate = 3";
    $ret = $mysql->execute($sql);
    return (bool) $ret;
}

