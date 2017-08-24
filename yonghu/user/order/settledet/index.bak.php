<?php require("../../../wxdata/userlimit.php");?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="短信平台" name="keywords" />
<meta content="短信平台" name="description" />
<title>微优结算详情</title>
<?php
$nav1=2;
$nav2=3;
require("../../../wxdata/sjk1114.php");
require("../../../wxdata/dx_fun.php");
$user11id=$_SESSION['user1114id'];
$userpercent=userpercent();
?>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">

<?php require("../../../wxdata/dx_head.php");?>


<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
                        
    <?php require("../../../wxdata/dx_mid.php");?>
    
   
    
   	<div class="vip-content-r-notice" style="min-height:42px;">
            
<div class="vip-content-r-notice-l" style="margin-top:5px; width:100%;">
                <span class="sousuo" style="margin-left: 5px;" >BUTTON : </span>
                 <a class="state" href="/user/order/settle/">返回结算列表</a>  
                </div>                
                
            </div>
    
    <?php
  $time=strgl($_GET['time']);
  $time3=$time.' 00:00:00';
  $time4=$time.' 23:59:59';
  
  	$page_arr = array(
		"time={$time}",
	);
	
	$pagestr = join('&',$page_arr);


  $userzid=userlistid();

  $sql1=mysql_query("select moneyguestid from wx_playmoney where moneyguestid in(select id as moneyguestid from wx_guest where userid='$user11id' and gueststate='5') and addtime>='$time3' and addtime<='$time4' and moneyclass='1' order by id");
	$num=mysql_num_rows($sql1);
  if($num<>0){
$b=1;
  while($info=mysql_fetch_array($sql1)){
	$userzid1[$b]=$info['moneyguestid'];
	$b++;
}
}else{
	$userzid1=array('0');
}
$userzhuid1=implode(',',$userzid1);

	?>
    
                <h3><a class="tianjmb">结算详情</a> &nbsp;&nbsp; 结算时间： <?php echo $time;?>  &nbsp;&nbsp; 查询结果 &nbsp;&nbsp; 总数 : <?php echo $num;?></h3>    
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                    <tr class="tittle">
                        <td width="13%" align="center">下单时间</td>
                        <td width="10%" align="center">ID</td>
                        <td width="36%" align="center">商品</td>
                        <td width="12%" align="center">金额/分成</td>
                        <td width="13%" align="center">渠道</td>
                        <td width="9%" align="center">STATE</td>
                        <td width="7%" align="center">详情</td>
                    </tr>
                      
  <?php 

  $page_size=18;
  $page_count=ceil($num/$page_size);  //得到页数

  $page=intval($_GET['page']);
  if(!$page)
  	$page=1;

  $offset=($page-1)*$page_size;

  $sql=mysql_query("select id,shopid,skuid,userid,userwx,gueststate,guestkuanshi,addtime from wx_guest where id in($userzhuid1) order by id desc limit $offset,$page_size");	
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

	$orderstate=orderstate($gueststate);
	?>
 
                       <tr height="10"><td colspan="9"></td></tr>                      
                         <tr class="xiangmu">
                            <td valign="top" align="center"><p><?php echo date("m-d H:i",strtotime($info['addtime']));?></p></td>
                            <td valign="top" align="center"><p><?php echo $userzid[$info['id']];?></p></td>
                            <td  valign="top"><p class="diqu"><?php echo $gusettitle." ".$guestkuanshi; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $shopsku[1]; ?> / <?php echo $shopsku[2]; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $userwxh; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $orderstate; ?> </p></td>
                            <td align="center" valign="top">
                                <!--  <a href="templates_24566.html" class="caozuo">模板测试</a>  -->
                                <a href="../detail/?bh=<?php echo $userzid[$info['id']];?>" class="caozuo">详情</a>        
                            </td>
                        </tr>
              
              
        <?php }?>                
                   
                        
                        
                </table>
                
              <?php require("../../../wxdata/dx_page.php");?>           
                
                <!--
              <div class="vip-content-r-notice" style="background: #FB9D44;">
                            <p style="color:#fff;">提示：</p>	
                        </div>
              -->
                   
            </div>                        
		
<?php require("../../../wxdata/dx_foot.php");?>

<!-- 时间控件 -->
<script src="http://res.sentsin.com/lay/lib/laydate/laydate.js"></script>
<script language="javascript">
		$("#state a").bind("click",function(){//尺码点击
			var o = $(this);
			if(!o.hasClass("statexz")){//点击的不是当前已经选中的
				$(".state").removeClass("statexz");
				o.addClass("statexz");
				/*更新对应的选中尺码的数据*/
				$("#stateid").val(o.attr("state-id"));
			}
		})

</script>

</body>
</html>