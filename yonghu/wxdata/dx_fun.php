<?php
function userpercent(){
	global $user11id;
	$sql=mysql_query("select userpercent from wx_user where id='$user11id'");
	$info=mysql_fetch_array($sql);
	$percent=$info['userpercent']/100;
     return $percent;
}

function userreward(){
	global $user11id;
	$sql=mysql_query("select userreward from wx_user where id='$user11id'");
	$info=mysql_fetch_array($sql);
	$percent2=$info['userreward'];
     return $percent2;
}

function userlistid(){
   global $user11id;
   $sql6=mysql_query("select id from wx_guest where userid='$user11id' order by id");
  $num6=mysql_num_rows($sql6);
  if($num6<>0){
$b=1;
  while($info=mysql_fetch_array($sql6)){
	$userzid[$info['id']]=$b;
	$b++;
}
}else{
	$userzid=array('0');
}	
 return $userzid;
}

function userconid(){
   global $user11id;
  $sql6=mysql_query("select id from wx_guest where userid='$user11id' order by id");
  $num6=mysql_num_rows($sql6);
  if($num6<>0){
$b=1;
  while($info=mysql_fetch_array($sql6)){
	$userconid[$b]=$info['id'];
	$b++;
}
}else{
	$userconid=array('0');
}
    return $userconid;
}

//转义
function strgl($str){
    if(!get_magic_quotes_gpc()){
        return addslashes($str);
    }else{
        return $str;
    }
}

//状态id对名字
function orderstate($gueststateid){
	$sql4=mysql_query("select orderstate from wx_orderstate where id='$gueststateid'");
	$info4=mysql_fetch_array($sql4);
	$orderstate=$info4['orderstate'];  
	 return $orderstate;
}

//根据商品名获取商品id shopname 字段做索引
function shopname_shopid($shopname){
    $sql = "select id from wx_shop where shopname2 = '{$shopname}' limit 1";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);
    if($num){
        $shop = mysql_fetch_assoc($result);
        $shopid = $shop['id'];
        return $shopid;
    }else{
        return false;
    }
}

// 用户下邀请的用户id
function botuser(){
	global $user11id;
  $sql6=mysql_query("select id from wx_user where topuser='$user11id'");
  $num6=mysql_num_rows($sql6);
  if($num6<>0){
$b=1;
  while($info=mysql_fetch_array($sql6)){
	$userzid[$b]=$info['id'];
	$b++;
}
}else{
	$userzid=array('0');
}
$botuser=implode(',',$userzid);
return $botuser;
}

// 判断邀请用户id是否是登录用户邀请的  用户id获取用户用户名
function isbotuser($botuserid){
	global $user11id;
	$sql=mysql_query("select loginname from wx_user where topuser='$user11id' and id='$botuserid'");
	$info=mysql_fetch_assoc($sql);
	$botuserloginname=$info['loginname'];
	if($botuserloginname){
	  return $botuserloginname;
	}else{
		return false;
	}
}

?>