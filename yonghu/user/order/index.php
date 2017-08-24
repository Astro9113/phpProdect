<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=2;
$nav2=2;

$user11id = $uid = $_SESSION['user1114id'];

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优我的订单</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<link href="css/lrtk.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $(".subNav").click(function(){
			$(this).toggleClass("currentDd").siblings(".subNav").removeClass("currentDd")
			$(this).toggleClass("currentDt").siblings(".subNav").removeClass("currentDt")
			$(this).parent().next(".navContent").slideToggle(0);
	})	
})
</script>

<?php require("../../wxdata/dx_head.php");?>


<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
                        
    <?php require("../../wxdata/dx_mid.php");?>
    
    <?php
	$where  = "where 1 and userid = '{$user11id}'";
	
	
	
	
	
	$stime = check_time($_GET['stime']);
	$etime = check_time($_GET['etime']);
	
	if($stime && $etime){
        $where .= " and (addtime between '".$stime."' and '".$etime."')";
    }

    $stateid  = intval($_GET['stateid']);
    if($stateid){
        $where .= " and gueststate = '{$stateid}'";
    }
    
    //改成使用limit直接读取
    $guestid = intval($_GET['guestid']);
    if($guestid){
        $userconid = userconid();
        $gid = $userconid[$guestid];
        if($gid){
            $where .= " and id = '{$gid}'";
        }
    }
    
    
    
    $page_arr = array(
		"guestid={$guestid}",
		"stime={$stime}",
		"etime={$etime}",
		"stateid={$stateid}",
	);
	
	$pagestr = join('&',$page_arr);
	
	?>
    
    <div class="vip-content-r-notice" style="min-height:42px;">
        <form method="get" name="form_send" action="">
            
    <div class="vip-content-r-notice-r left" style="width:22%;">
           <span class="sousuo" style="margin-left: 5px;" >订单状态 : </span>
           <select style="width:105px;" name="stateid" class="vip-test">
           
           <?php 
           $state_arr[0] = '全部';
           $result = mysql_query("select id,orderstate from wx_orderstate order by statesx");
           while ($r = mysql_fetch_assoc($result)){
               $state_arr[$r['id']] = $r['orderstate'];
           }
           
           foreach ($state_arr as $_stateid=>$_orderstate){
               $sel = '';
               if($_stateid==$stateid){
                   $sel = ' selected';
               }
               echo "<option value='$_stateid'{$sel}>$_orderstate</option>"; 
           }
           ?>
           </select>
        </div>	
    
        <div class="vip-content-r-notice-l left" style="width:20%;">
            <span class="sousuo" style="margin-left: 5px;" >订单ID : </span>
            <input style="width:80px;" class="vip-test" type="text" value="<?php if($guestid){echo $guestid;}?>" name="guestid" id="guestid">
        </div>	
 
        <div class="vip-content-r-notice-r left" style="width:47%;">
           <span class="sousuo" style="margin-left: 5px;" >下单时间 : </span>
           <input  style="width:140px;" class="vip-test" type="text"  value="<?php if($stime){echo $stime;}else{ echo '选择开始时间';}?>" name="stime" id="stime">&nbsp;-&nbsp;
           <input  style="width:140px;" class="vip-test" type="text" value="<?php if($etime){echo $etime;}else{ echo '结束时间';}?>" name="etime" id="etime">
        </div>
        
        
        	
        
        <input type="submit" name="sub" class="tianjmb" />
        </form>
        
                
        <div style="clear:both;"></div>
    </div>
    
    
    
    <?php
        $sql=mysql_query("select count(*) as num from wx_guest {$where}");
        $result=mysql_fetch_assoc($sql);
        $num = $result['num'];
	?>
    
         <h3>查询结果 &nbsp;&nbsp; 总数 : <?php echo $num;?></h3>    

                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                    <tr class="tittle">
                        <td width="13%" align="center">下单时间</td>
                        <td width="8%" align="center">ID</td>
                        <td width="8%" align="center">买家</td>
                        <td width="31%" align="center">商品</td>
                        <td width="12%" align="center">金额/分成</td>
                        <td width="12%" align="center">渠道</td>
                        <td width="9%" align="center">STATE</td>
                        <td width="7%" align="center">详情</td>
                    </tr>
                      
  <?php 

  $userzid = userlistid();
  $userpercent = userpercent();
  
  $page_size=18;
  $page_count=ceil($num/$page_size);  //得到页数

  $page = intval($_GET['page']);
  if(!$page){
      $page=1;
  }
  	
  $offset=($page-1)*$page_size;

  $sql=mysql_query("select id,shopid,skuid,userid,userwx,gueststate,guestkuanshi,addtime,guestname,guestsheng,guestcity,guestqu,guestdizhi,guestkuaidi,guestrizhi,wuliugs from wx_guest {$where} order by id desc limit $offset,$page_size");	
while($info=mysql_fetch_array($sql)){
	$shopid=$info['shopid'];
	$skuid=$info['skuid'];
	$userid=$info['userid'];
	$userwx=$info['userwx'];   
	$gueststate=$info['gueststate'];  
	$guestkuanshi=$info['guestkuanshi'];
	$sql1=mysql_query("select shopname2,ischange,shopsku1,shopsku2,shopsku3,shopsku4,shopsku5,shopsku6,shopsku7,shopsku8,shopsku9,shopsku10,shopsku11,shopsku12 from wx_shop where id='$shopid'");
	$info1=mysql_fetch_array($sql1);
	$shopskuid="shopsku".$skuid;
	$shopsku=$info1[$shopskuid];
	$shopsku=explode("_",$shopsku);
	if($info1['ischange']=='1'){
	$shopsku[2]=$shopsku[2]*$userpercent;
	$shopsku[2]=round($shopsku[2]);
   }
	$gusettitle=$info1['shopname2']."&nbsp;&nbsp;&nbsp;".$shopsku[0];
	
	if($userwx==""){
		$userwxh="无";
	}else{
	$sql2=mysql_query("select userchannel from wx_userchannel where id='$userwx' and channeltop='$user11id'");
	$info2=mysql_fetch_array($sql2);
	$userwxh=$info2['userchannel'];
	  if($userwxh==""){
		$userwxh=" ";
	  }
	}

	$orderstate = orderstate($gueststate);
	?>
                    <tr height="8"><td colspan="9"></td></tr>    
                       <tr class="xiangmu">
                            <td valign="top" align="center" class="subNav"><p><?php echo date("m-d H:i",strtotime($info['addtime']));?></p></td>
                            <td valign="top" align="center"><p><?php echo $userzid[$info['id']];?></p></td>
                            <td valign="top" align="center"><p><?php echo htmlspecialchars($info['guestname']);?></p></td>
                            <td  valign="top"><p class="diqu"><?php echo $gusettitle." ".$guestkuanshi; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $shopsku[1]; ?> / <?php echo $shopsku[2]; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $userwxh; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $orderstate; ?> </p></td>
                            <td align="center" valign="top">
                                <!--  <a href="templates_24566.html" class="caozuo">模板测试</a>  -->
                                <a href="detail/?bh=<?php echo $userzid[$info['id']];?>" class="caozuo">详情</a>        
                            </td>
                        </tr>
                        
                        <tr class="navContent xiangmu">
                            <td colspan="8" style="padding:3px 0px 5px 50px;">
                            <?php 
                                $wuliugs = '';
                                if($info['wuliugs']=='顺丰速运'){
                                    $wuliugs = 'shunfeng';
                                }elseif($info['wuliugs']=='EMS'){
                                    $wuliugs = 'ems';
                                }
                            ?>
地址：<?php echo $info['guestsheng'].$info['guestcity'].$info['qu'].$info['guestdizhi'];?>   
<A href="http://m.kuaidi100.com/index_all.html?type=<?php echo $wuliugs;?>&postid=<?php echo $info['guestkuaidi'];?>" class="caozuo" target="_blank">快递查询</A><br>
<?php echo $info['guestrizhi'];?></td>
                        </tr>
                       <tr height="3"><td colspan="9"></td></tr>     
              
              
        <?php }?>                
                   
                        
                        
                </table>
                
              <?php require("../../wxdata/dx_page.php");?>           
                
              <div class="vip-content-r-notice" style="background: #FB9D44;">
                            <p style="color:#fff;">提示：订单以实际时间为准，如有出错订单，请提交工单，或者联系媒介处理！</p>	
                        </div>
                   
            </div>                        
		
<?php require("../../wxdata/dx_foot.php");?>

<!-- 时间控件 -->
<script src="http://res.sentsin.com/lay/lib/laydate/laydate.js"></script>
<script>
var start = {
	    elem: '#stime',
	    format: 'YYYY-MM-DD hh:mm:ss',
	    max: '2099-06-16 23:59:59', //最大日期
	    istime: true,
	    istoday: false,
	    choose: function(datas){
	         end.min = datas; //开始日选好后，重置结束日的最小日期
	         end.start = datas //将结束日的初始值设定为开始日
	    }
	};
	var end = {
	    elem: '#etime',
	    format: 'YYYY-MM-DD hh:mm:ss',
	    max: '2099-06-16 23:59:59',
	    istime: true,
	    istoday: false,
	    choose: function(datas){
	        start.max = datas; //结束日选好后，重置开始日的最大日期
	    }
	};
	laydate(start);
	laydate(end);
</script>
</body>
</html>