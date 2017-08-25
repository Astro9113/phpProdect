<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,10);
qx($allow_qx, $adminclass);

$dz_state = get_dz_state();
if(!$dz_state){
    exit('状态数据异常');
}

$allow_type = array(
        '5_default'=>'已回款'  , //已回款
        '5_yc'     =>'回款异常' , //回款异常
        '6_default'=>'退回签收' , //退回签收
        '6_yc'     =>'退回异常' , //退回异常        
);


$type = $_POST['type'];
if(!array_key_exists($type, $allow_type)){
    exit('参数错误');
}

$id = $_POST['id'];
if(count($id)<=0){
    exit('没有数据要处理');
}



$state = $allow_type[$type];
$state_id = $dz_state[$state];

if(!$state_id){
    exit('状态数据异常');
}


foreach ($id as $i){
    if(!preg_match('/^[0-9]+$/', $i)){
        exit('提交数据异常');
    }
}
        

foreach($id as $i){
	$num = $mysql->count_table('wx_dzguest',"guestid = {$i}");
	if(!$num){
        $sql = "insert into wx_dzguest (guestid,stateid) values ";
        $sql .= " ('{$i}','{$state_id}');";
        $mysql->execute($sql);
	}else{
        $sql = "update wx_dzguest set stateid = '$state_id' where guestid = '$i'";
        $mysql->execute($sql);
	}
}



echo '处理成功';
//echo '&nbsp;&nbsp;<a href="dz.php">返回</a>';
