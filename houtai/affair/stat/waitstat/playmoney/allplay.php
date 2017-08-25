<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

//开始处理则生成锁定文件,不允许并行处理
$lock_file = CACHE_PATH.'affair/lock';
if(file_exists($lock_file)){
    exit('请不要开多个窗口同时运行');
}


$ret = file_put_contents($lock_file, date('Y-m-d H:i:s'));
if(!file_exists($lock_file)){
    exit('锁定失败');
}

ob_end_flush();

$shops = get_shops();
$users = get_users();


$sql = "select * from wx_guest where gueststate = 4  order by id";
$infos = $mysql->query($sql);
if(!$infos){
    unlink($lock_file);
    exit('处理完毕.');
}

foreach ($infos as $info){
    $id = intval($info['id']);
    if(check_is_payed($id)){
        echo  "<font color='#FF0000'>".$id." 已结算  跳过<br/></font>";
        flush();
        continue;
    }
    
    $shopid=$info['shopid'];
    $skuid=$info['skuid'];
    $userid=$info['userid'];
    $shop = $shops[$shopid];
    $user = $users[$userid];
    
    $shopskuid="shopsku".$skuid;
    $shopsku=$shop[$shopskuid];
    $shopsku=explode("_",$shopsku);
        
    $username=$user['loginname'];
    $userpercent=$user['userpercent']/100;
    
    if($shop['ischange']=='1'){
        $shopsku[2]=$shopsku[2]*$userpercent;
        $shopsku[2]=round($shopsku[2]);
    }
    
    $alipay = $user['alipay'];
    $alipayname = $user['alipayname'];
    $topid = $user['topuser'];
    
    $midwhether = false;
    if(isset($users[$topid])){
        $top = $users[$topid];
        $topuser = $top['loginname'];
        $midreward = $top['userreward']/100;
        $midalipay = $top['alipay'];
        $midalipayname = $top['alipayname'];
        $midwhether = true;
    }else{
        $topuser="无中间人";
        $midwhether='0';
    }
    
    $moneyguestid = $id;
    $moneyname = $username;
    $moneyhow = $shopsku[2];
    $moneyfullname = $alipayname;
    $moneynum=$alipay;
    
    
    $mysql->startTrans();
    if($midwhether){
        $moneymidname = $topuser;
        $moneymidhow  = $shopsku[2]*$midreward;
        $moneymidfullname = $midalipayname;
        $moneymidnum = $midalipay;
    
        $sql = "insert into wx_playmoney(moneyguestid,moneyname,moneyhow,moneyfullname,moneynum,moneyclass) values('$moneyguestid','$moneymidname','$moneymidhow','$moneymidfullname','$moneymidnum',2)";
        $ret1 = $mysql->execute($sql);
    }
    
    
    $sql = "insert into wx_playmoney(moneyguestid,moneyname,moneyhow,moneyfullname,moneynum,moneyclass) values('$moneyguestid','$moneyname','$moneyhow','$moneyfullname','$moneynum',1)";
    $ret2 = $mysql->execute($sql);
    
    $guestrizhi = $info['guestrizhi'];
    $guestrizhi .= date('Y-m-d H:i:s')."， 已结算<br/>";
    $sql = "update wx_guest set gueststate='5',guestrizhi='$guestrizhi' where id='$moneyguestid'";
    $ret3 = $mysql->execute($sql);
    
    
    if($midwhether){
        if($ret1 && $ret2&&$ret3){
            $mysql->commit();
            echo $id." 打款成功<br/>";
            flush();
        }else{
            $mysql->rollback();
            echo $id." 打款失败<br/>";
            flush();
        }
    }else{
        if($ret2&&$ret3){
            $mysql->commit();
            echo $id." 打款成功<br/>";
            flush();
        }else{
            $mysql->rollback();
            echo $id." 打款失败<br/>";
            flush();
        }
    }
    
}

echo "<br/><br/>打款结束<br/>";
flush();

$mysql->close();
unlink($lock_file);