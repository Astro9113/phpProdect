<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";

set_time_limit(0);

ob_end_flush();
echo str_repeat(" ",1024);

?>

<style>
*{padding:0;margin:0;font-size:14pt;font-weight:100;font-family:"黑体"}
table,td,th{border-collapse:collapse}
td,th{border:1px solid #666;padding:5px 8px;}
th{background-color:#ccc;}
</style>

<?php
$users = get_users();

$s = '2016-03-20 00:00:00';
$e = '2016-04-19 23:59:59';

echo "<h1 style='color:red;'>$s  -  $e  出单奖励</h1>";

$sql = "select * from wx_guest where addtime between '$s' and '$e' and gueststate = 5";

$ret = array();
$result = mysql_query($sql);
while(($r = mysql_fetch_assoc($result))!==false){
    $id = $r['id'];
    $uid = $r['userid'];
    $rizhi = $r['guestrizhi'];
    $qianshou = '， 已签收';
    
    $pos = strpos($rizhi, $qianshou);
    if($pos===false){
        continue;
    }
    
    $time = substr($rizhi, $pos-19,19);
    if(strtotime($time)<strtotime('2016-04-25 23:59:59')){
        $ret[$uid][] = $time;
    }
}

$newarr = array();
foreach($ret as $k=>$v){
    $newarr[$k] = count($v);
}


arsort($newarr);

$fujia = array();
$sql= "select userid from wx_usershopadd where 1 group by userid";
$fujia = $mysql->query_assoc($sql, 'userid');

echo '<table>
        <tr>
        <th>uid</th>
        <th>loginname</th>
        <th>alipay</th>
        <th>alipayname</th>
        <th>数量</th>
        <th>金额</th>
        <th>备注</th>
        </tr>';

foreach($newarr as $uid=>$count){
    if($count<100){
        continue;
    }
    
    $user = $users[$uid];
    $loginname = $user['loginname'];
    $alipay = $user['alipay'];
    $alipayname = $user['alipayname'];
    $money = get_money_tmp($count);
    $beizhu = '';
    
    if(isset($fujia[$uid])){
        $money = '';
        $beizhu = '有附加款,奖励为0';
    }
    
    echo "<tr>
        <td>$uid</td>
        <td>$loginname</td>
        <td>$alipay</td>
        <td>$alipayname</td>
        <td>$count</td>
        <td>$money</td>
        <td>$beizhu</td>
        </tr>";
    
}

echo '</table>';


/*
 * 
 * (1). 100个签收订单， 感恩回馈 300元（签收订单大于 100小于300 单） 
(2). 300个签收订单， 感恩回馈 900元（签收订单大于 300小于500 单） 
(3). 500个签收订单， 感恩回馈 1500元（签收订单大于 500小于1000单） 
(4). 1000个签收订单，感恩回馈 3000元（签收订单大于1000小于2000单） 
(5). 2000个签收订单，感恩回馈 6000元（签收订单大于2000小于3000单） 
(6). 3000个签收订单，感恩回馈 9000元（签收订单大于3000小于5000单） 
(6). 5000个签收订单，感恩回馈 20000元（签收订单大于5000小于6000单） 
(6). 6000个签收订单，感恩回馈 30000元（签收订单大于6000单）
 * 
 * 
 */
function get_money_tmp($num){
    if($num>=100 && $num<300){//100
        return 300;
    }
    if($num>=300 && $num<500){//300
        return 900;
    }
    if($num>=500 && $num<1000){//500
        return 1500;
    }
    if($num>=1000 && $num<2000){//1000
        return 3000;
    }
    if($num>=2000 && $num<3000){//2000
        return 6000;
    }
    if($num>=3000 && $num<5000){//3000
        return 9000;
    }
    if($num>=5000 && $num<6000){//5000
        return 20000;
    }
    if($num>=6000){//gt 6000
        return 30000;
    }
    
    return 0;
}

?>

