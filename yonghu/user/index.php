<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=2;
$nav2=1;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优用户主页</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">

<?php require("../wxdata/dx_head.php");?>
<div class="vip">
    <div class="vip-content">
    	<?php require("../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
                        
    <?php require("../wxdata/dx_mid.php");?>
                  
    <?php  //算各状态订单情况
	 $sql=mysql_query("select userpercent from wx_user where id='$user11id'");
	$info=mysql_fetch_array($sql);
	//分成比例
	$userpercent=$info['userpercent']/100;
	
	//所有商品的信息
	$all_shop_info = get_all_shop_info();
	function get_all_shop_info(){
        $arrShopInfo = array();
	    $sql  = "select id,ischange,shopsku1,shopsku2,shopsku3,shopsku4,shopsku5,shopsku6,shopsku7,shopsku8,shopsku9,shopsku10,shopsku11,shopsku12 from wx_shop where 1";
        $result = mysql_query($sql);
        while(($shop = mysql_fetch_assoc($result))!==false){
            $shopid = $shop['id'];
            unset($shop['id']);
            $arrShopInfo[$shopid] = $shop;
        }
        return $arrShopInfo;
	}
	
	//用户订单所有状态的数量
	$state_num = get_guest_num_of_state($user11id);
	
	function get_guest_num_of_state($userid){
	    $sql = "select gueststate,count(*) as num from wx_guest where userid='{$userid}' group by gueststate";
	    $result = mysql_query($sql);
	    while(($r = mysql_fetch_assoc($result))!==false){
	        $info[$r['gueststate']] = $r['num'];
	    }
	    return $info;
	}
	
	
	//用户所有的订单信息
	$user_guests = get_user_guests($user11id);
	function get_user_guests($user11id){
	    $sql = "select shopid,skuid,userid,gueststate from wx_guest where userid='$user11id'";
        $result = mysql_query($sql);
        while(($ret = mysql_fetch_assoc($result))!==false){
            $gueststate = $ret['gueststate'];
            $info[$gueststate][] = $ret;
        }
        return $info;
	}
	
	//订单对应的分成
	function cal_com($userpercent,$shopid,$skuid){
        global $all_shop_info;//所有的商品信息
        $com = 0;
        $shop = $all_shop_info[$shopid];
	    $shopsku_field = 'shopsku'.$skuid;
        $shopsku = $shop[$shopsku_field];
        $shopsku=explode("_",$shopsku);
        
        $com = 0;
        if($shop['ischange']=='1'){
            $com = $shopsku[2] * $userpercent;
            $com = round($com);
        }else{
            $com = $shopsku[2];
        }
        
        return $com;
	}
	
	
	 function tnum_tmp($aa){
        global $state_num;
        $state_ids = explode(',',$aa);
        $sum = 0;
        foreach($state_ids as $state_id){
            $sum += $state_num[$state_id];            
        }	 
        return $sum;
    }
    
 
    function tongji($aa){
        global $userpercent;//分成比例
        global $user_guests;//用户的所有订单
        
        
        $state_ids = explode(',',$aa);
        $sum_com = 0;
        foreach($state_ids as $state_id){
            $guest_of_state = (array) $user_guests[$state_id];//状态对应的订单
            foreach($guest_of_state as $guest){//循环订单统计分成
                $shopid = $guest['shopid'];
                $skuid  = $guest['skuid'];
                
                $com = cal_com($userpercent,$shopid,$skuid);
                $sum_com += $com;
            }
        }
        
        return $sum_com;
    }
    
    if(date('H')>=18){
    $timeYestoday = date('Y-m-d').' 18:00:00';
    $timeToday    = date('Y-m-d',time()+24*3600).' 18:00:00';
	$getstime = date('Y-m-d').' 18:00:00';
	$getetime = date('Y-m-d',time()+24*3600).' 18:00:00';
   }else{
    $timeYestoday = date('Y-m-d',time()-24*3600).' 18:00:00';
    $timeToday    = date('Y-m-d').' 18:00:00';
	$getstime = date('Y-m-d',time()-24*3600).' 18:00:00';
	$getetime = date('Y-m-d').' 18:00:00';
   }
	//=========================今日数据
	//$timeYestoday = date('Y-m-d').' 00:00:00';
    //$timeToday    = date('Y-m-d').' 23:59:59';
    //用户订单所有状态的数量
    $state_num_today = get_guest_num_of_state_today($user11id,$timeYestoday,$timeToday);
    
    function get_guest_num_of_state_today($userid,$stime,$etime){
        $sql = "select gueststate,count(*) as num from wx_guest where userid='{$userid}' and addtime between '{$stime}' and '{$etime}'  group by gueststate";
        $result = mysql_query($sql);
        while(($r = mysql_fetch_assoc($result))!==false){
            $info[$r['gueststate']] = $r['num'];
        }
        return $info;
    }
    
    function tnum_today($aa){
        global $state_num_today;
        $state_ids = explode(',',$aa);
        $sum = 0;
        foreach($state_ids as $state_id){
            $sum += $state_num_today[$state_id];
        }
        return $sum;
    }
    
    $user_guests_today = get_user_guests_today($user11id,$timeYestoday,$timeToday);
    function get_user_guests_today($user11id,$stime,$etime){
        $sql = "select shopid,skuid,userid,gueststate from wx_guest where userid='$user11id' and addtime between '{$stime}' and '{$etime}'  ";
        $result = mysql_query($sql);
        while(($ret = mysql_fetch_assoc($result))!==false){
            $gueststate = $ret['gueststate'];
            $info[$gueststate][] = $ret;
        }
        return $info;
    }
    
    function tongji_today($aa){
        global $userpercent;//分成比例
        global $user_guests_today;//用户的所有订单
    
        
        $state_ids = explode(',',$aa);
        $sum_com = 0;
        foreach($state_ids as $state_id){
            $guest_of_state = (array) $user_guests_today[$state_id];//状态对应的订单
            foreach($guest_of_state as $guest){//循环订单统计分成
                $shopid = $guest['shopid'];
                $skuid  = $guest['skuid'];
    
                $com = cal_com($userpercent,$shopid,$skuid);
                $sum_com += $com;
            }
        }
        return $sum_com;
    }
    
    
    
	?>
                		
        	  <h3 class="zaixiancz-icon" style="background-position: 0 -300px;">订单各状态预览</h3>
                <div class="vip-content-r-zijinsousuo" style="height: 850px; min-width:1000px;">
                <form method="post" name="form1" action="recharge_alipay.html">
                
                    <div class="chongzhitaocan" style="width:1000px;">
                    <!-- 首页活动 
                        <p style="font-size:20px; color:#F00;">即日起(5月4号)部分商品已上涨分成</p>
                        <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">费洛蒙情趣香水每单分成上涨20元！买2送1上涨40元！</p>
                        <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">英国卫裤VK每单分成上涨10元,买2送1上涨20元！</p>
                        <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">陈老师泄油瘦身汤每单分成上涨10元!买2送1上涨20元！</p>
                        <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">勃金V8每单分成加10元,买2送1上涨20元！</p>
                  -->
                  
                       <p style="font-size:20px;">今日订单：</p>
                        <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">每天18点前显示是昨天18点到今天18点， 18点后是今天18点到明天18点的单子</p>
                        
                        <style>
                        .bgred{background:#C61C13 !important;}
                        .bgblue{background:#3aab5a !important}
                        .bggreen{background:#02a98d !important;}
                        .bggray{background:#3c3a42 !important;}
                        </style>
                        
                    <!-- 以下为当日订单  -->
                        <ul class="chongzhi-ul" style="">
                        <li><a href="/user/order/?pre=1&stime=<?php echo $getstime;?>&etime=<?php echo $getetime;?>" class="chongzhi-btn bgred"><b>今日全部订单</b><br /><br /><span>个：<?php echo tnum_today('2,3,4,5,6,7,8,9,10,11,12');?><br />￥：<?php echo tongji_today('2,3,4,5,6,7,8,9,10,11,12');?></span></a></li>
                        <li><a href="/user/order/?pre=1&stateid=11&stime=<?php echo $getstime;?>&etime=<?php echo $getetime;?>" class="chongzhi-btn bgblue"><b>今日联不上</b><br /><br /><span>个：<?php echo tnum_today('11');?><br />￥：<?php echo tongji_today('11');?></span></a></li>
                        <li><a href="/user/order/?pre=1&stateid=9&stime=<?php echo $getstime;?>&etime=<?php echo $getetime;?>" class="chongzhi-btn bgblue"><b>今日待发+已发货</b><br /><br /><span>个：<?php echo tnum_today('9,3');?><br />￥：<?php echo tongji_today('9,3');?></span></a></li>
                        <li><a href="/user/order/?pre=1&stateid=8&stime=<?php echo $getstime;?>&etime=<?php echo $getetime;?>" class="chongzhi-btn bgblue"><b>今日已取消+假单</b><br /><br /><span>个：<?php echo tnum_today('8,10');?><br />￥：<?php echo tongji_today('8,10');?></span></a></li>
                        </ul>
                  
                  <div style="clear:both;"></div><br/><br/><br/>
                    <p style="font-size:20px;">全部订单：</p>
                    <p style="padding-bottom:10px; font-size:16px; padding-left:50px;">显示出的所有个状态订单</p>
                        
                  <!-- 以下为全部订单  -->
                       <ul class="chongzhi-ul" style="clear:both; padding-top:25px;">
                        <li><a href="/user/order/?stateid=2" class="chongzhi-btn bggreen"><b>确认中订单</b><br /><br /><span>个：<?php echo tnum_tmp('2');?><br />￥：<?php echo tongji('2');?></span></a></li>
                        <li><a href="/user/order/?stateid=11" class="chongzhi-btn bggreen"><b>联不上订单</b><br /><br /><span>个：<?php echo tnum_tmp('11');?><br />￥：<?php echo tongji('11');?></span></a></li>
                        <li><a href="/user/order/?stateid=9" class="chongzhi-btn bggreen"><b>待发货订单</b><br /><br /><span>个：<?php echo tnum_tmp('9');?><br />￥：<?php echo tongji('9');?></span></a></li>
                        <li><a href="/user/order/?stateid=8" class="chongzhi-btn bggreen"><b>已取消订单</b><br /><br /><span>个：<?php echo tnum_tmp('8');?><br />￥：<?php echo tongji('8');?></span></a></li>
                        </ul>  
                  
                        <ul class="chongzhi-ul" style="clear:both; padding-top:25px;">
                        <li><a href="/user/order/?stateid=3" class="chongzhi-btn bggreen"><b>已发货订单</b><br /><br /><span>个：<?php echo tnum_tmp('3');?><br />￥：<?php echo tongji('3');?></span></a></li>
                        <li><a href="/user/order/?stateid=4" class="chongzhi-btn bggreen"><b>已签收订单</b><br /><br /><span>个：<?php echo tnum_tmp('4');?><br />￥：<?php echo tongji('4');?></span></a></li>
                        <li><a href="/user/order/?stateid=6" class="chongzhi-btn bggreen"><b>已拒收订单</b><br /><br /><span>个：<?php echo tnum_tmp('6');?><br />￥：<?php echo tongji('6');?></span></a></li>
                        <li><a href="/user/order/?stateid=5" class="chongzhi-btn bggreen"><b>已结算订单</b><br /><br /><span>个：<?php echo tnum_tmp('5');?><br />￥：<?php echo tongji('5');?></span></a></li>
                        </ul>  
                        
                        <ul class="chongzhi-ul" style="clear:both; padding-top:25px;">
                        <li><a href="/user/order/?stateid=10" class="chongzhi-btn bggray"><b>假单</b><br /><br /><span>个：<?php echo tnum_tmp('10');?><br />￥：<?php echo tongji('10');?></span></a></li>
                        <li><a href="/user/order/?stateid=12" class="chongzhi-btn bggray"><b>无效重复订单</b><br /><br /><span>个：<?php echo tnum_tmp('12');?><br />￥：<?php echo tongji('12');?></span></a></li>
                        <li><a href="/user/order/?stateid=7" class="chongzhi-btn bggray"><b>退货订单</b><br /><br /><span>个：<?php echo tnum_tmp('7');?><br />￥：<?php echo tongji('7');?></span></a></li>
                        <li><a href="/user/order/?stateid=13" class="chongzhi-btn bggray"><b>返款异常订单</b><br /><br /><span>个：<?php echo tnum_tmp('13');?><br />￥：<?php echo tongji('13');?></span></a></li>
                        </ul>  
                     </div>
                
                </form>    
    
                </div>
                   
            </div>               
		
<?php require("../wxdata/dx_foot.php");?>
</body>
</html>