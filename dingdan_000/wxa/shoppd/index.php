<?php 
//
include '../../wxdata/sjk1114.php';

foreach ($_POST as $k=>$v){
    $_POST[$k] = strip_tags(trim($v));
}

$shopid = intval($_POST['shopid']);
$skuid  = intval($_POST['skuid']);
$userid = intval($_POST['userid']);
$userwx = intval($_POST['userwx']);

$userid = $userid?$userid:2;
$skuid = $skuid?$skuid:1;
$shopid = $shopid?$shopid:96;


$guestname   = $_POST['guestname'];
$guesttel    = $_POST['guesttel'];
if(!preg_match('/^\d{11}$/',$guesttel)){
	alert('电话号码不是11位,请检查您的输入');
    goback();
}
$guestsheng  = $_POST['guestsheng'];
$guestcity   = $_POST['guestcity'];
$guestqu     = $_POST['guestqu'];
$guestdizhi  = $_POST['guestdizhi'];
$guestrem    = $_POST['guestbeizhu'];
$guestrem = $guestrem?$guestrem:'待客服确认中';

$guestsheng = ($guestsheng == '')?'空 ':$guestsheng;
$guestcity = ($guestcity == '')?'空 ':$guestcity;
$guestqu = ($guestqu == '')?'空 ':$guestqu;


if(!$guestname){
    alert('请填写收货人姓名');
    goback();
}

if(!$guesttel){
    alert('请填写电话号码');
    goback();
}

if(!$guestdizhi){
    alert('请填写收货地址');
    goback();
}


$filter_tel = array(
'15947824896',

);


if(in_array($guesttel,$filter_tel)){
	$msg = "$guestname,您好，系统检测到您之前已经提交过相同的订单，请不要重复提交，稍后会有客服与您联系！";
    alert($msg);
    goback();
}


$filter_uid = array(
	'2201',
);

if(in_array($userid,$filter_uid)){
	$msg = "$guestname,您好，系统检测到您之前已经提交过相同的订单，请不要重复提交，稍后会有客服与您联系！";
    alert($msg);
    goback();
}


if(check_cf($guesttel,$shopid,1,$skuid)){
    $msg = "$guestname,您好，系统检测到您之前已经提交过相同的订单，请不要重复提交，稍后会有客服与您联系！";
    alert($msg);
    goback();
}


$shopcolor = $_POST['shopcolor'];
$shopsize  = $_POST['shopsize'];

if($shopid==96 && (!$shopsize)){
    $guestkuanshi = '黑色 XXL';
}else{
    $guestkuanshi = $shopcolor." ".$shopsize;
}

include("../../wxdata/func_hack.php");
include("../../wxdata/IP.class.php");
$userid = filter($userid, $guestsheng, $guestcity, $guesttel);


$sql = "insert into wx_guest(guestname,guesttel,guestsheng,guestcity,guestqu,guestdizhi,shopid,skuid,guestkuanshi,userid,userwx,guestrem) values('$guestname','$guesttel','$guestsheng','$guestcity','$guestqu','$guestdizhi','$shopid','$skuid','$guestkuanshi','$userid','$userwx','$guestrem')";
$rs = mysql_query($sql);

//记录下单ip
if($rs){
    $ip = $_SERVER['REMOTE_ADDR'];
    $newid=mysql_insert_id();
	mysql_query("insert into wx_guestip(ip,guestid) values('$ip','$newid')");
	
	function new_wait_confirm_guest($new_guestid,$tel){
	    $table_name = 'wx_wait_confirm_guest';
	    $new_guestid = intval($new_guestid);
	    if(!$new_guestid){
	        return false;
	    }
	    	
	    if(!preg_match('/^\d{11}$/', $tel)){
	        return false;
	    }
	    	
	    $sql = "insert into {$table_name} (`guestid`,`tel`,`addtime`) values('{$new_guestid}','{$tel}','".time()."');";
	    $result = mysql_query($sql);
	    return $result;
	}
	
	new_wait_confirm_guest($newid,$guesttel);
	
	
}else{
     $result="下单失败";
}


//下单提醒短信
//sms_xiadan($newid, $guesttel);
mysql_close();

?>
<meta http-equiv='refresh' content='0; url=a.html' /> 