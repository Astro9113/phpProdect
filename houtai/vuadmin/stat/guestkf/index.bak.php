<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

//配置条件
$gkfzt='2,11';
$geshu = 1;

$jintime = date('Y-m-d',time()-0*24*60*60);
$zuotime = date('Y-m-d',time()-1*24*60*60);

$zuolbst=$zuotime.' 17:00:00';

//订单库  按照不同的时间段 顺序  获取可分配的订单 
//06:00--08:30
$time3=$jintime.' 06:00:00';
$time4=$jintime.' 08:30:00';

$sql[] = "select id from wx_guest where addtime>='$time3' and addtime<='$time4' and guestkfid='0' ";

//17:00--23:00
$time3=$zuotime.' 17:00:00';
$time4=$zuotime.' 23:00:00';

$sql[] = "select id from wx_guest where addtime>='$time3' and addtime<='$time4' and guestkfid='0' ";

//23:00--06:00
$time3=$zuotime.' 23:00:00';
$time4=$jintime.' 06:00:00';

$sql[] = "select id from wx_guest where addtime>='$time3' and addtime<='$time4' and guestkfid='0' ";

//23:00--06:00
$time3=$jintime.' 08:30:00';
$time4=$jintime.' 18:00:00';

$sql[] = "select id from wx_guest where addtime>='$time3' and addtime<='$time4' and guestkfid='0' and timediff(now(),addtime) >= '00:04:00' ";

$sqls = join(' union all ', $sql) .' order by id';



//$sqls = "select id from wx_guest where guestkfid='0' and  gueststate = 2";

$infos = $mysql->query($sqls);
$ids = array();

if($infos){
    foreach ($infos as $info){
        $ids[] = $info['id'];
    }
    $iod = join(',', $ids);
}



$l = isset($_GET['l'])?intval($_GET['l']):0; //靠此参数判断应该从谁开始分配

//无可分定单 则l不增加  延时然后刷新
if(!$iod){
    echo '当前无可分订单';
    echo "<script>setTimeout(\"window.location.href='index.php?l=".$l."'\",15000);</script>";
    exit;
}

echo '当前可分订单id : ';
echo $iod."<br>";


//获取上班客服

$sql = "select * from wx_kefu where kfupbot='1' order by id";
$kefus = $mysql->query($sql);
$shangban_kefu_num = $mysql->numRows; //上班人数


if($l >= $shangban_kefu_num){ 
    $l = 0;
}

//从l开始分配
for($i = $l ; $i < $shangban_kefu_num ; $i++){
    $kefu_ids[] = $kefus[$i]['id'];	
}

//从 0 开始 分配到  l
if($l>0){
    for($i=0;$i<$l;$i++){
    	$kefu_ids[] = $kefus[$i]['id'];	
    }
}
$kefuids = join(',', $kefu_ids);



//根据设置的数量计算出每个客服要分配的数量  和 要分配的顺序

$bgnumz = 0;//总共要分配的单数
$sql = "select * from wx_kefu where id in($kefuids) order by FIND_IN_SET(id,'$kefuids')";
$infos = $mysql->query($sql);
$u = 1;



foreach ($infos as $info){
    $bgnum = 0;                         //当前客服要分订单数量
    
    $kefid=$info['id'];                 //id
    $kefnum=$info['kfnum'];             //总数量
    $lbsnum=$info['lbsnum'] * $geshu;   //连不上数量

    $lbsnum_yf = $mysql->count_table('wx_guest',"addtime>='$zuolbst' and guestkfid='$kefid' and gueststate='11'");                      //已经存在的连不上数量
    
    
    
    if($lbsnum_yf < $lbsnum){           //如果连不上数量还未到设定值  则 在检查  确认中  和 连不上的总数是否达到数量
        $num_queren_and_lbs = $mysql->count_table('wx_guest',"addtime>='$zuolbst' and guestkfid='$kefid' and gueststate in($gkfzt)");
        $bgnum = $kefnum-$num_queren_and_lbs;
    }else{
        $bgnum = 0;
    }
    
    echo '客服  :' .$kefid. ':' .$info['adminname'].' 可分单数 : ';
    echo $bgnum;
    echo '<br />';
    
    if($bgnum > 0){
    	$feipei[$u]=$bgnum;
        $kefuid[$u]=$kefid;
        $bgnumz += $bgnum;
        $u++;
    }
}


echo "<br>总需分单数量 : ^^".$bgnumz."<br>";



if($bgnumz > 0){
	$kefushu = count($feipei);
	echo "===".$bgnumz."--".$kefushu."<br>";

	for($i=1;$i<=$bgnumz;$i++){ //保证数量  = 要分配的总数
        for($p=1;$p<=$kefushu;$p++){ //循环每个要分配订单的客服
            if($feipei[$p]>=$i){ //如果要分的数量  大于 已经分的数量 则  把他加载到待分配列表去  //反之证明已经分够了 则 跳过
                $idshun .= $kefuid[$p]."-";
            }
        }
    }

    $idshun = rtrim($idshun,'-');
    echo $idshun;
    echo '<br />';
    $idshun = explode("-",$idshun);
    
    $sql = "select * from wx_guest where id in($iod) and guestkfid='0' order by FIND_IN_SET(id,'$iod') limit 0,$bgnumz";
    
    $infos = $mysql->query($sql);
    $num = $mysql->numRows;
    
    $o=0;
    foreach ($infos as $info){
        
        $kfid       = $idshun[$o];
        $guestid    = $info['id'];
        
        
        if(($info['gueststate']==3) && in_array($kfid, array(27,28))){
            $o++;
            continue;
        }
        
        echo $sql = "update wx_guest set guestkfid='$kfid' where id='$guestid'";
        echo '<br />';
        $ret = $mysql->execute($sql);
        if($ret){ echo "yes";}else{ echo "no";}
        $zgdid.=$gdid." ";
        $o++;
    }
}


echo $zgdid;
$l++;
echo "<script>setTimeout(\"window.location.href='index.php?l=".$l."'\",15000);</script>";
