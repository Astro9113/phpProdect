<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=1;
$nav2=3;

?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - 我的订单</title>

<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
    
<?php
	$channels = array();
    $sql  = "select * from wx_userchannel where channeltop = '$user11id' limit 10";
	$result = mysql_query($sql);
	while ($r = mysql_fetch_assoc($result)){
	    $channels[$r['id']] = $r; 
	}
	
    if(!$channels){
	    echo '您尚未添加渠道,暂无数据';
	}else{
	    $cid_a = array_keys($channels);
	    $cid_s = join(',', $cid_a);
	    
	    $c_nums = array();
	    $sql = "select count(*) as num,userwx from wx_guest where userid = '$user11id' and userwx in ($cid_s) group by userwx";
	    $result = mysql_query($sql);
	    while ($r = mysql_fetch_assoc($result)){
	        $c_nums[$r['userwx']] = $r['num'];
	    }
	    
	    $c_pvs = array();
	    $sql = "select count(*) as num,wxid from wx_tongji where userid = '$user11id' and wxid in ($cid_s) group by wxid";
	    $result = mysql_query($sql);
	    
	    while ($r = mysql_fetch_assoc($result)){
	        $c_pvs[$r['wxid']] = $r['num'];
	    }
	}
	
	
?>

	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
    <tr class="tittle">
    <td width="12%" align="center">渠道</td>
    <td width="10%" align="center">流量</td>
    <td width="10%" align="center">订单</td>
</tr>
                      
<?php 


if($channels){
    foreach ($channels as $cid=>$channel){
        $pv = isset($c_pvs[$cid])?intval($c_pvs[$cid]):0;
        $dd = isset($c_nums[$cid])?intval($c_nums[$cid]):0;
        $c_name = $channel['userchannel'];
        
        $tpl = '<tr class="xiangmu">
    <td valign="center" align="center">%s</td>
    <td valign="center" align="center">%s</td>
    <td valign="center" align="center">%s</td>
    </tr>';
        
        $html = sprintf($tpl,$c_name,$pv,$dd); 
        echo $html;
    }
}

?> 

</table>
       
</div>               		
<?php require("../../wxdata/dx_foot.php");?>
</body>
</html>