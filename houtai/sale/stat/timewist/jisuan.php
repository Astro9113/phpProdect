<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";


?>

<?php
ob_end_flush();

$time1=$_GET['time1'];
$phptime=strtotime($time1);
$time3=date('Y-m-d H:i:s',$phptime);
$time2=$_GET['time2'];
$phptime2=strtotime($time2);
$time4=date('Y-m-d H:i:s',$phptime2);


$topid = $loginid;
$topid = "m" . $topid;
$sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
$users = $mysql->query_assoc($sql,'id');
$num = $mysql->numRows;
if ($num) {
    $uids = array_keys($users);
    $uids = join(',', $uids);
} else {
    $uids = '0';
}

$aa = intval($_GET['aa']);
$orderstate_arr = orderstateinfo($aa);
$gustart = $orderstate_arr['orderstate'];

$shops = get_shops();

$sql = "select id,guestrizhi,shopid,skuid from wx_guest where userid IN($uids) and gueststate='$aa' order by id";
$infos = $mysql->query($sql);
$num = $mysql->numRows;
$midzfc=0;
$bs=0;

if($infos){
    
    foreach($infos as $info){
        $gurizhi = $info['guestrizhi'];
        $youfh="， ".$gustart;
        if(strpos($gurizhi,$youfh)){
            $bb=explode($youfh,$gurizhi);
            $cc=substr($bb[0],-19);
            if($cc>$time3 and $cc<$time4){
                $shopid=$info['shopid'];
                $skuid=$info['skuid'];
                echo $info['id']."&nbsp;&nbsp;";
                flush();
                $shop = $shops[$shopid];
                $shopskuid="shopsku".$skuid;
                $shopsku=$shop[$shopskuid];
                $shopsku=explode("_",$shopsku);
                $miduserfc = $shopsku[1];
                echo $miduserfc."<br/>";
                flush();
                $midzfc += $miduserfc;
                $bs++;
            }
        }
    }


}

echo "数量：<d class='nowstat'>".$bs."</d>&nbsp;&nbsp;&nbsp; 流水：<d class='nowstat'>".$midzfc."</d>";
flush();
