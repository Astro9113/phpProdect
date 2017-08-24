<?php
function mysubstr($str, $start, $len) {
    $tmpstr = "";
    $strlen = $start + $len;
    for($i = 0; $i < $strlen; $i++) {
        if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
        } else
            $tmpstr .= substr($str, $i, 1);
    }
	$cd=strlen($str);
	if($cd>$len)
		$tmpstr=$tmpstr."..";
    return $tmpstr;
}

function adminclass($a){
	if($a==1){
		$adminclassname="超级管理员";
	}elseif($a==2){
		$adminclassname="普通管理员";
	}elseif($a==3){
		$adminclassname="商品管理员";
	}elseif($a==4){
		$adminclassname="用户管理员";
	}elseif($a==5){
		$adminclassname="订单管理员";
	}elseif($a==6){
		$adminclassname="财务管理员";
	}
	
	 return $adminclassname;
	
}



?>