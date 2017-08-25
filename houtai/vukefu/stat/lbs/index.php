<?php 
echo "本功能暂停使用";
exit;
require("../../../wxdata/kefulimit.php");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<?php
echo '本功能暂停使用';
exit;
?>
<title>订单统计</title>
<link rel="stylesheet" href="/css/main.css" />
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function statbzxs(targetid){    
 if (document.getElementById){target=document.getElementById(targetid);            
  if (target.style.display=="block")
  {target.style.display="none";} 
  else {target.style.display="block";} 
 }}
</script>
</head>
<body>
<div id="top">
	<div class="top"><img src="/images/logo.png">微信公众号盈利平台</div>
    </div>
<div id="wrap" class="clearfix">
<div class="menu">
 <dl class="">
 	<dt><a href="/vukefu/">客服管理中心<i class="only"></i></a></dt>
 </dl>
   <dl class="cur">
 	<dt><a href="/vukefu/stat/">订单统计<i class="only"></i></a></dt>
    <dd><a class="" href="/vukefu/stat/queren/">●　确认中订单</a></dd>
    <dd><a href="/vukefu/stat/zhuidan/">●　跟进订单</a></dd>
    <dd class="last"><a class="now" href="/vukefu/stat/lbs/">●　联不上订单</a></dd>
  
 </dl> 
 
  <dl class="cur">
 	<dt><a href="/vukefu/stat/important/queren/">重点客户订单统计<i class="only"></i></a></dt>
    <dd><a href="/vukefu/stat/important/queren/">●　确认中订单</a></dd>
    <dd><a href="/vukefu/stat/important/zhuidan/">●　跟进订单</a></dd>
    <dd class="last"><a href="/vukefu/stat/important//lbs/">●　联不上订单</a></dd>
 </dl> 
  <dl class="">
 	<dt><a>信息设置<i></i></a></dt>
	<dd><a href="/vukefu/center/mydata/">●　我的信息</a></dd>
	<dd class="last"><a href="/vukefu/center/mydata/modpassword/">●　修改密码</a></dd>
 </dl>
 <dl>
 	<dt><a href="/vukefu/logout/">退出登录<i class="only"></i></a></dt>
 </dl>
</div><div id="main" class="clearfix">
 <div class="filter widthb110">
<?php
 require("../../../wxdata/sjk1114.php");
$uptime=date('Y-m-d',time()-24*60*60).' 17:00:00';
$kefid=$_SESSION['kefu1114id'];

?>
<div class="cxform2" style="width:150px; line-height:38px;">
<form id="search" method="get" action="">
<select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
  <option value="?class=0">订单状态查询</option>
  <option value="?class=0">全部</option>
  <?php 
     $class=$_GET['class'];
      $sql=mysql_query("select * from wx_lbsstate order by id");	
while($info=mysql_fetch_array($sql)){
	if($class==$info['id']){
		echo "<option value='?class=".$info['id']."' selected='selected'>".$info['name']."</option>";
	}else{
		 echo "<option value='?class=".$info['id']."'>".$info['name']."</option>";
	 }
	}
?>
</select>
</form>
</div>
<div class="cxform2" style="width:450px; line-height:38px;">
<?php
	$sql = "select id,name from wx_lbsstate where 1;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$cur = $row['id'];
		$arr[$cur] = $row['name'];	
	}
	
	foreach($arr as $k=>$v){
		$sql = "select count(*) as num from wx_guest g left join wx_lbsguest lbs on g.id = lbs.guestid where g.guestkfid = '{$kefid}' and g.gueststate=11 and lbs.stateid = $k";
		$result = mysql_query($sql);
		$row= mysql_fetch_assoc($result);
		
		echo "{$v}:{$row['num']}";
		echo '&nbsp;&nbsp;&nbsp;';
	}
?>
</div>
<div class="cb"></div>
 </div>
 <div class="uc">
	<table class="items" width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3" cellspacing="1">
	<tr bgcolor="#f5f5f5"><th width="82px">下单时间</th><th width="30px">ID</th><th>订购商品</th><th width="80px">购买者</th><th width="72px">金额</th><th width="100px">状态</th><th width="35px">详情</th></tr>
    
          <?php  
    require("../../../js/fun.php");
  if($class==''){ $class='0';}
    if($class=='0'){	  
 $sql = "select g.*,lbs.guestid,lbs.stateid from wx_guest g left join wx_lbsguest lbs on g.id = lbs.guestid where g.addtime <= '{$lbs_start_data}' and g.guestkfid = '{$kefid}' and g.gueststate=11 and g.userid not in(select id as userid from wx_user where isimportant = 1)  group by g.id order by g.id desc;";
  }else{
 $sql = "select g.*,lbs.guestid,lbs.stateid from wx_guest g left join wx_lbsguest lbs on g.id = lbs.guestid where  g.addtime <= '{$lbs_start_data}' and g.guestkfid = '{$kefid}' and g.gueststate=11 and lbs.stateid='$class' and g.userid not in(select id as userid from wx_user where isimportant = 1) group by g.id order by g.id desc;";
  }
    $sql=mysql_query($sql);

 	$ww=1;
  $m="ffffff";
while($info=mysql_fetch_assoc($sql)){
	foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
		//$info[$k] = guestrizhi($v);
	}else{
		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}
}
	
	$shopid=$info['shopid'];
	$skuid=$info['skuid'];
	$userid=$info['userid'];
	$userwx=$info['userwx'];
	$userwx=$info['userwx'];   
	$guestname=$info['guestname'];   
	$gueststate=$info['gueststate'];  
	$guestkuanshi=$info['guestkuanshi'];
	$sql1=mysql_query("select * from wx_shop where id='$shopid'");
	$info1=mysql_fetch_array($sql1);
	$shopskuid="shopsku".$skuid;
	$shopsku=$info1[$shopskuid];
	$shopsku=explode("_",$shopsku);
	$gusettitle=$info1['shopname2']."&nbsp;&nbsp;&nbsp;".$shopsku[0]."&nbsp;&nbsp;".$guestkuanshi;
	
	$sql4 = "select name from wx_lbsstate  where id = '{$info['stateid']}'";
	$rs4 = mysql_query($sql4);
	$row4 = mysql_fetch_array($rs4);
	$orderstate=$row4['name'];
	
	?>
    <tr bgcolor="#<?php echo $m; ?>"  onmouseover="statbzxs('bz<?php echo $ww;?>')" onMouseOut="statbzxs('bz<?php echo $ww;?>')"><td><?php echo date("m-d H:i",strtotime($info['addtime']));?></td><td><?php echo $info['id'];?></td><td><?php echo $gusettitle; ?></td><td><?php echo $guestname; ?></td><td><?php echo $shopsku[1]; ?></td><td><?php echo $orderstate; ?>&nbsp;&nbsp;&nbsp;<a href="../orderstate/?id=<?php echo $info['id'];?>&class=<?php echo $class;?>&page=<?php echo $page;?>">更改</a></td><td><a href="../statcon/?id=<?php echo $info['id'];?>&class=<?php echo $class;?>&page=<?php echo $page;?>">详情</a><div class="statbzd"><div class="statbz" id="bz<?php echo $ww;?>"><?php echo mysubstr($info['guestrem'],0,25);?></div></div></td></tr>


	
        <?php 
	if($m=="f5ffe4"){
		$m="ffffff";
	}else{
		$m="f5ffe4";
	}
	$ww++;
}?>
	</table>
	<h5>特别重要的提醒</h5>
	<div class="notice">
1、不要长期都发同一类产品，到后面成交量自然就低，不同类别的产品切换轮流发送，这样才能保证较高的收益。<br>
2、这里的产品，我们一段时间就会切换，过一阵可能就不会再推这些产品，而是换别的了，只有一段时间集中推一些产品，这样才有势能效应，成交量自然也高，同时我们的工作效率也才能高，当然肯定保证大家每天都有不同的产品及文案可发。<!--br>
3、新增7日前订单数据统计，可供参考。其中，取消率是按总订单计算，签收和拒收是按发货订单计算。--></div>
 </div>
</div>
</div>
<div id="footer">
<p>北京微优网络科技有限公司</p>
</div>



<script src="/js/j.js"></script>
</body>
</html><script>$(document).ready(function(){
ph('search');
});</script>
