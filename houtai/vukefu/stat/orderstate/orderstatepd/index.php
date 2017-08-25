<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";


$id = intval($_POST['id']);
$sql = "select * from wx_guest where id = '{$id}' and guestkfid = '{$loginid}'";
$info = $mysql->find($sql);

// 这样客服端口 组长也看不了组员的订单详情
if (! $info) {
    alert('订单信息不存在');
    goback();
}

//状态控制
$gueststate = intval($info['gueststate']);
$orderstate = trim($_POST['orderstate']);

//拿到状态名为键值的关联数组
$sql = "select * from wx_orderstate where  1";
$orderstates = $mysql->query_assoc($sql, 'orderstate');
if(!array_key_exists($orderstate, $orderstates)){
    alert('状态错误');
    goback();
}

$state = $orderstates[$orderstate];
$stateid = intval($state['id']);

$date = date('Y-m-d H:i:s');

//$log_str = "客服:{$loginid}-{$loginname},{$date},{$gueststate},{$stateid}";

$log = array(
        'guestid'=>$id,
        'ip'=>get_client_ip(),
        't'=>$date,
        'type'=>'kf',
        'uid'=>$loginid,
        'uname'=>$loginname,
        'f'=>$gueststate,
        'to'=>$stateid,
        'ok'=>0,
        'rem'=>'',
);



if($stateid !== $gueststate){//状态有变化  
    $allow_from  = array(
            2  => array(8,9,10,11,12),
            8  => array(10,11,12),
            10 => array(11,12),
            11 => array(8,9,10,12),
            12 => array(10,11),
			9  => array(11),   
    );
    
    if(!array_key_exists($gueststate, $allow_from)){
        $log['rem'] = '没有修改权限1';
        log_orderstate_db($og);
        alert('没有修改权限.');
        goback();
    }
    
    $allow_to = $allow_from[$gueststate];
    if(!in_array($stateid, $allow_to)){
        $log['rem'] = '没有修改权限2';
        log_orderstate_db($log);
        alert('没有修改权限..');
        goback();
    }
    
    
}

//日志处理
$guestrem = gl2($_POST['guestrem']);
if($guestrem !== mysql_escape_string($guestrem)){
    alert('参数错误');
    goback();
}

$guestrizhi = $info['guestrizhi'];
$guestrizhi .= date('Y-m-d H:i:s')."， ".$orderstate." ".$guestrem."<br/>";


$lbsstate  = $info['lbsstate'];
$lbsnum    = $info['lbsnum'];
$no_connect_state = intval ($_POST ['no_connect_state']);
if ($no_connect_state && ($orderstate == '联不上')) {
    if($no_connect_state==$lbsstate){
        $lbsnum +=1;
    }else{
        $lbsstate = intval($no_connect_state);
        $lbsnum = 1;
    }   
}


$shopsku = intval($_POST['shopsku']);
if(!$shopsku){
    exit();
}
$sql = "update wx_guest set 
guestrem='$guestrem',
gueststate='$stateid',
guestrizhi='$guestrizhi',
lbsstate = '$lbsstate',
skuid='$shopsku',
lbsnum = '$lbsnum' 
where id = $id";


$ret = $mysql->execute($sql);

if($ret){
    $log['ok'] = 1;
    log_orderstate_db($log);
    
    //改连不上状态
    if($no_connect_state && ($orderstate=='联不上')){
		$lbs_id = intval($_POST['lbs_id']);
		if($lbs_id){
			$sql = "update wx_lbsguest set guestid = {$id},stateid = {$no_connect_state} where id = $lbs_id;";
		}else{
			$sql = "insert into wx_lbsguest (guestid,stateid) values({$id},{$no_connect_state});";
		}
		$mysql->execute($sql);
	}
    
	go('../?id='.$id,'修改成功'); 
}else{
    go('../?id='.$id,'修改失败');
}