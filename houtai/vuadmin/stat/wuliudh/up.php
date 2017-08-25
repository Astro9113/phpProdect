<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,8);
qx($allow_qx, $adminclass);

$kai = isset($_GET['kai'])?intval($_GET['kai']):0;

$sql = "select * from daosj order by guestid limit $kai,1";
$infos = $mysql->query($sql);
$num = $mysql->numRows;

if($num){
    foreach ($infos as $info){
    	if(strlen($info['wuliudh'])==13){
    		if(substr($info['wuliudh'],0,1)=='D'){
    		  $wuliugs='圆通快递';	
    		}else{
    		  $wuliugs='EMS';
    		}
    	}elseif(strlen($info['wuliudh'])==12){
    	    if(substr($info['wuliudh'],0,1)=='D'){
    	        $wuliugs='圆通快递';
    	    }elseif(substr($info['wuliudh'],0,1)=='5'){
    	        $wuliugs='中通快递';
    	    }else{
    	        $wuliugs='顺丰速运';
    	    }
    	}elseif(strlen($info['wuliudh'])==10){
    		if(substr($info['wuliudh'],0,1)=='D'){
    		  $wuliugs='圆通快递';	
    		}else{
    		  $wuliugs='宅急送';
    		}
    	}
    	
    	
        $info['guestid']."---".$wuliugs."---".$info['wuliudh']."----";	
        $guestid=$info['guestid'];
        $yztel=$info['guesttel'];
        $wuliud=$info['wuliudh'];
        
        if($info['guestid']){
            $guest = guestinfo($guestid);
            $guesttel = $guest['guesttel'];
            $gueststate = $guest['gueststate'];
            

         
            if($gueststate <> 9){
    	       $kai++;
    	       go('up.php?kai='.$kai);
               exit();
            }
			
      
            if($guesttel==$yztel){ 
                $newrizhi = $guest['guestrizhi'].date('Y-m-d H:i:s')."， 已发货<br/>";
                $sql = "update wx_guest set wuliugs='{$wuliugs}',guestkuaidi='{$wuliud}',gueststate='3',guestrizhi='$newrizhi' where id='$guestid' and gueststate='9'";
                $ret = $mysql->execute($sql);
                
                if($ret){ 
                    echo $guestid."yes <br><br>";
                    sms_fahuo($guestid);
                }else{
                    echo $guestid."no <br><br>";
                }
            }else{
    	       $_SESSION['errdh'].=$guestid.", ";
            }
        }
    }

    $kai++; 
    echo "<meta http-equiv='refresh' content='1; url=up.php?kai=".$kai."' />";
}else{
    echo "结束了 异常的订单有 ".$_SESSION['errdh'];
}