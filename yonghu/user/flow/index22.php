<?php 

require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";
require 'function.php';

$nav1=1;
$nav2=4;

$user11id = $uid = $_SESSION['user1114id'];

?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - pv</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">

<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
    
<?php
define('ONE_DAY_IN_SEC', 24*3600);

$where  = "where 1";

$stime = isset($_GET['stime'])?trim($_GET['stime']):'';
$etime = isset($_GET['etime'])?trim($_GET['etime']):'';

if(!check_date($stime) || !check_date($etime)){
    $stime = date('Y-m-d H:i:s',time()-ONE_DAY_IN_SEC);
    $etime = date('Y-m-d H:i:s');
    $format = '%m-%d %H:00';
}else{
    $_stime = strtotime($stime);
    $_etime = strtotime($etime);
    $timediff = $etime-$stime;
    if($timediff<=0){
        $stime = date('Y-m-d H:i:s',time()-ONE_DAY_IN_SEC);
        $etime = date('Y-m-d H:i:s');
        $format = '%m-%d %H:00';
    }elseif($timediff >= ONE_DAY_IN_SEC){
        if($timediff>=5*ONE_DAY_IN_SEC){
            $etime = strtotime('+5 days',strtotime($stime));
        }
        $format = '%Y-%m-%d';
    }else{
        $format = '%m-%d %H:00';
    }
}

$where .= " and addtime >= '{$stime}' and addtime <= '{$etime}'";
$where .= " and userid = '{$user11id}'";

$shopname = '';
if(isset($_GET['shopname'])){
    if($_GET['shopname'] === gl_sql($_GET['shopname'])){
        $gid = shopname_shopid($shopname);
        if($gid){
            $where .= " and shopid = '{$gid}'";
        }            
    }
}

$where_pv = $where;
	
$channelid  = isset($_GET['channelid'])?intval($_GET['channelid']):0;
if($channelid){
    $where_pv .= " and wxid = '{$channelid}'";
    $where    .= " and userwx = '{$channelid}'";
}

//全部订单
echo $sql = "SELECT count(*) as num,date_format(addtime,'{$format}') as ymd FROM `wx_guest` {$where} group by ymd";

echo '<br />';
echo $sql = "SELECT count(*) as num,date_format(addtime,'{$format}') as ymd FROM `wx_tongji` {$where_pv} group by ymd";

exit;

$dd_all = array();

$result = mysql_query($sql);
while(($row = mysql_fetch_assoc($result))!==false){
	$dd_all[$row[ymd]] = $row['num']; 
}

$dd_all = $dd_all?$dd_all:array();

//pv
$pv = array();
echo '<br />';
echo $sql = "SELECT count(*) as num,date_format(addtime,'{$format}') as ymd FROM `wx_tongji` {$where_pv} group by ymd";
$result = mysql_query($sql);
while(($row = mysql_fetch_assoc($result))!==false){
	$pv[$row[ymd]] = $row['num'];
}
$pv = $pv?$pv:array();

foreach ($pv as $_ymd=>$_pvnum){
    if(!isset($dd_all[$_ymd])){
        $dd_all[$_ymd] = 0;
    }
}

?>
    
    
    <div class="vip-content-r-notice" style="min-height:42px;">
        <form method="get" name="form_send" action="">
            
    <div class="vip-content-r-notice-r left" style="width:22%;">
           <span class="sousuo" style="margin-left: 5px;" >渠道 : </span>
           <select style="width:105px;" name="channelid" class="vip-test">
           
           <?php 
           $channel_arr[0] = '全部';
           $result = mysql_query("select * from wx_userchannel where channeltop = '$user11id' limit 10");
           while ($r = mysql_fetch_assoc($result)){
               $channel_arr[$r['id']] = $r['userchannel'];
           }
           
           foreach ($channel_arr as $_channelid=>$_userchannel){
               $sel = '';
               if($_channelid==$channelid){
                   $sel = ' selected';
               }
               echo "<option value='$_channelid'{$sel}>$_userchannel</option>"; 
           }
           ?>
           </select>
        </div>	
    
        <div class="vip-content-r-notice-l left" style="width:20%;">
            <input style="width:80px;" class="vip-test" type="text" value="<?php echo $shopname;?>" name="shopname" id="shopname" placeholder="商品名称">
        </div>	
 
        <div class="vip-content-r-notice-r left" style="width:47%;">
           <span class="sousuo" style="margin-left: 5px;" >下单时间 : </span>
           <input  style="width:140px;" class="vip-test" type="text"  value="<?php if($stime){echo $stime;}else{ echo '选择开始时间';}?>" name="stime" id="stime">&nbsp;-&nbsp;
           <input  style="width:140px;" class="vip-test" type="text" value="<?php if($etime){echo $etime;}else{ echo '结束时间';}?>" name="etime" id="etime">
        </div>
        
        
        	
        
        <input type="submit" name="sub" class="tianjmb" value="查询"/>
        </form>
        
                
        <div style="clear:both;"></div>
    </div>
    
    
    
   	                
    <div class="chartstu">
    
 <script type="text/javascript">
	$(function () {
        $('#container').highcharts({
            title: {
                text: '订单数据',
                x: -20 //center
            },

            xAxis: {
                categories: [<?php 
                foreach($dd_all as $k=>$v){
                	echo "'{$k}',";	
                }
                ?>],

                labels: {
                	step:2, 
                	staggerLines:1,
                	formatter:function(){
						var l = this.value;

						var patt1 = new RegExp("[0-9]{4}-[0-9]{2}-[0-9]{2}");
						var patt2 = new RegExp("[0-9]{2}");
						var patt3 = new RegExp("[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}");
						
						if(patt1.test(l)){
							var tmparr = l.split('-');
							if(tmparr[2]=='01'){
								return tmparr[1]+'月';
							}else{
								return tmparr[2];
							}
						}

						if(patt3.test(l)){
							var tmparr = l.split(' ');
							if(tmparr[1]=='00:00'){
								return tmparr[0]+'日';
							}else{
								return tmparr[1].split(':')[0];
							}
						}


						if(patt2.test(l)){
							return this.value;	
						}
						
                   }
                 },
                 tickInterval: 1,
                 
                                
            },
            yAxis: {
                title: {
                    text: '数量'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
          legend: {
                layout: 'vertical',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0
            }, 
            series: [{
                name: '全部订单',
                data: [<?php 
                foreach($dd_all as $kk=>$vv){
                	echo $vv.',';	
                }
                ?>]
            },]
            
        });







        //pv

        $('#pv').highcharts({
            title: {
                text: 'pv数据(点击阅读原文数)',
                x: -20 //center
            },

            xAxis: {
                categories: [<?php 
                foreach($pv as $k=>$v){
                	echo "'{$k}',";	
                }
                ?>],


                labels: {
                	step:2, 
                	staggerLines:1,
                	formatter:function(){
						var l = this.value;

						var patt1 = new RegExp("[0-9]{4}-[0-9]{2}-[0-9]{2}");
						var patt2 = new RegExp("[0-9]{2}");
						var patt3 = new RegExp("[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}");
						
						if(patt1.test(l)){
							var tmparr = l.split('-');
							if(tmparr[2]=='01'){
								return tmparr[1]+'月';
							}else{
								return tmparr[2];
							}
						}

						if(patt3.test(l)){
							var tmparr = l.split(' ');
							if(tmparr[1]=='00:00'){
								return tmparr[0]+'日';
							}else{
								return tmparr[1].split(':')[0];
							}
						}


						if(patt2.test(l)){
							return this.value;	
						}
						
                   }
                 },
            },
            yAxis: {
                title: {
                    text: 'pv'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
            series: [{
                name: 'PV',
                data: [<?php 
                foreach($pv as $k=>$v){
                	echo $v.',';	
                }
                ?>]
            },]
        });
    });
    
</script>   
<script src="js/highcharts/highcharts.js"></script>
<script src="js/highcharts/themes/dark-unica.js"></script>
<script src="js/My97DatePicker/WdatePicker.js"></script>
<br />
<div id="pv" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<br /><br /><br /><br />
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    
    </div>
                   
            </div>                        
		
<?php require("../../wxdata/dx_foot.php");?>

<!-- 时间控件 -->
<script src="http://res.sentsin.com/lay/lib/laydate/laydate.js"></script>


</body>
</html>