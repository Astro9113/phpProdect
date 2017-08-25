<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$id = intval($_POST['id']);
$info = guestinfo($id);
if (! $info) {
    alert('订单信息不存在');
    goback();
}

foreach ($_POST as $k=>$v){
    $_POST[$k] = gl_sql(gl2($v));
}


//状态控制
$gueststate = intval($info['gueststate']);
$orderstate = isset($_POST['orderstate'])?trim($_POST['orderstate']):'';

//拿到状态名为键值的关联数组
$sql = "select * from wx_orderstate where  1";
$orderstates = $mysql->query_assoc($sql, 'orderstate');
if(!array_key_exists($orderstate, $orderstates)){
    alert('状态错误');
    goback();
}

$state = $orderstates[$orderstate];
$stateid = intval($state['id']);


//记录
$date = date('Y-m-d H:i:s');
//$log_str = "客服:{$loginid}-{$loginname},{$date},{$gueststate},{$stateid}";
$log = array(
        'guestid'=>$id,
        'ip'=>get_client_ip(),
        't'=>$date,
        'type'=>'admin',
        'uid'=>$loginid,
        'uname'=>$adminname,
        'f'=>$gueststate,
        'to'=>$stateid,
        'ok'=>0,
        'rem'=>'',
);


//日志处理
$guestrem = $_POST['guestrem'];
if($guestrem !== mysql_escape_string($guestrem)){
    alert('参数错误');
    goback();
}

$guestrizhi = $info['guestrizhi'];
$guestrizhi .= date('Y-m-d H:i:s')."， ".$orderstate." ".$guestrem."<br/>";
if($gueststate != $stateid){
    if($orderstate == '已发货'){ $isdx='1';}else{ $isdx='0';}
}

//检查单号是否重复
$shopsku = intval($_POST['shopsku']);
$kuaidihao = $_POST['kuaidihao'];
if($isdx == 1){
    $sql = "select id from wx_guest where guestkuaidi='{$kuaidihao}'";
    $ret = $mysql->find($sql);
    if($ret){
        alert('此单号系统已存在');
        goback();
    }
}



$lbsstate  = $info['lbsstate'];
$lbsnum    = $info['lbsnum'];
$no_connect_state = isset($_POST['no_connect_state'])?intval ($_POST ['no_connect_state']):0;
if ($no_connect_state && ($orderstate == '联不上')) {
    if($no_connect_state==$lbsstate){
        $lbsnum +=1;
    }else{
        $lbsstate = intval($no_connect_state);
        $lbsnum = 1;
    }   
}


//重新分配客服

$kfid = intval($_POST['kfid']);

/*
if($kfid != $info['guestkfid']){
    if($info['userid'] <> 1){
        echo '只允许修改用户微优的客服';
        exit;
    }
}
*/


$wuliugs = $_POST['wuliugs'];   





$sql = "update wx_guest set 
guestkuaidi='$kuaidihao',
guestrem='$guestrem',
gueststate='$stateid',
skuid='$shopsku',
guestrizhi='$guestrizhi',
wuliugs='$wuliugs',
lbsstate = '$lbsstate',
lbsnum = '$lbsnum',
guestkfid = '$kfid' 
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

    if($isdx){
        sms_fahuo($id);
    }
    
    go('../?id='.$id,'修改成功');
}else{
    go('../?id='.$id,'修改失败');
}
