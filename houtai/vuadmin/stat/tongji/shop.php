<?php 
//require("../../../wxdata/Jurisdiction.php");
require("../../../wxdata/sjk1114.php");

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>订单统计</title>
<link rel="stylesheet" href="/css/main.css" />
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script src="/js/My97DatePicker/WdatePicker.js"></script>
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
 	<dt><a href="/vuadmin/">管理中心首页<i class="only"></i></a></dt>
 </dl>
  <?php if($_SESSION['admin1114class']=="1" or $_SESSION['admin1114class']=="5" or $_SESSION['admin1114class']=="2"){?>
 <dl class="expand cur">
 	<dt><a class="now" href="/vuadmin/stat/">订单统计<i class="only"></i></a></dt>
 </dl>
 <?php }?>
<?php if($_SESSION['admin1114class']=="1" or $_SESSION['admin1114class']=="4"){?>
 <dl class="">
 	<dt><a>用户管理<i></i></a></dt>
	<dd><a href="/vuadmin/user/adduser/">●　添加用户</a></dd>
	<dd class="last"><a href="/vuadmin/user/">●　用户列表</a></dd>
 </dl>
  <?php }?>
  <?php if($_SESSION['admin1114class']=="1" or $_SESSION['admin1114class']=="3" or $_SESSION['admin1114class']=="2"){?>
 <dl class="">
 	<dt><a>商品管理<i></i></a></dt>
    <dd><a href="/vuadmin/pro/addpro/">●　添加商品</a></dd>
    <dd><a href="/vuadmin/pro/">●　商品列表</a></dd>
	<dd class="last"><a href="/vuadmin/pro/class/">●　商品分类管理</a></dd>
 </dl>
 <?php }?>
 <?php if($_SESSION['admin1114class']=="1"){?>
 <dl class="">
 	<dt><a>管理员设置<i></i></a></dt>
	<dd><a href="/vuadmin/center/">●　管理员列表</a></dd>
	<dd class="last"><a href="/vuadmin/center/adminclass/">●　管理员等级</a></dd>
 </dl>
 <?php }?>
   <?php if($_SESSION['admin1114class']=="1"){?>
   <dl class="">
 	<dt><a>系统设置<i></i></a></dt>
	<dd><a href="/vuadmin/seting/">●　基本设置</a></dd>
	<dd class="last"><a href="/vuadmin/miduser/">●　中间人设置</a></dd>
 </dl>
 <?php }?>
  <dl class="">
 	<dt><a>信息设置<i></i></a></dt>
	<dd><a href="/vuadmin/center/mydata/">●　我的信息</a></dd>
	<dd class="last"><a href="/vuadmin/center/mydata/modpassword/">●　修改密码</a></dd>
 </dl> <?php if($_SESSION['admin1114class']=="1" or $_SESSION['admin1114class']=="2"){?>
  <dl class="">
 	<dt><a>推广统计<i></i></a></dt>
	<dd><a href="/vuadmin/tongji/shop/">●　商品统计</a></dd>
	    <?php if($_SESSION['admin1114class']=="1"){?>
	<dd class="last"><a href="/vuadmin/tongji/user/">●　用户统计</a></dd>
    <?php }?>
 </dl>  
 <?php }?><dl>
 	<dt><a href="/vuadmin/logout/">退出登录<i class="only"></i></a></dt>
 </dl>
</div>

<div id="main" class="clearfix">
<table class="table">
<?php
    function get_all_shops(){
        $sql = "select * from wx_shop where 1";
        $result = mysql_query($sql);
        while(($r=mysql_fetch_assoc($result))!==false){
            $ret[$r['id']] = $r;
        }
        return $ret;
    }
    
    function get_guestnum_by_shop_and_gueststate($shopid,$skuid,$gueststate,$stime,$etime){
        $sql = "select count(*) as num from wx_guest where addtime between '{$stime}' and '{$etime}' and shopid = '{$shopid}' and skuid = '{$skuid}' and gueststate in (".join(',', $gueststate).")";
        $result = mysql_query($sql);
        $r = mysql_fetch_assoc($result);
        return $r['num'];
    }
    
    function get_guestnum_by_shop_and_gueststate2($shopid,$skuid,$gueststate,$stime){
        $sql = "select count(*) as num from wx_guest where addtime <= '{$stime}' and shopid = '{$shopid}' and skuid = '{$skuid}' and gueststate in (".join(',', $gueststate).")";
        $result = mysql_query($sql);
        $r = mysql_fetch_assoc($result);
        return $r['num'];
    }
    
    function get_name($shopid,$skuid){
        global $shops;
        $shop = $shops[$shopid];
        $skufield = 'shopsku'.$skuid;
        $sku = $shop[$skufield];
        $sku = explode('_', $sku);
        $skuname = $sku[0];
        return $shop['shopname2'].'-<span style="color:blue;">'.$skuname.'</span>';
    }
    

    $shops = get_all_shops();
    
    
    if((date('H')>=17)&&(date('H')<=24)){
        $today    = date('Y-m-d',strtotime('+1 day')).' 17:00:00';
        $yestoday = date('Y-m-d').' 17:00:00';
        $twodaysbefore = date('Y-m-d',strtotime('-1 day')).' 17:00:00';
        $threedaysbefore = date('Y-m-d',strtotime('-2 day')).' 17:00:00';
        
    }else{
        $today    = date('Y-m-d').' 17:00:00';
        $yestoday = date('Y-m-d',strtotime('-1 day')).' 17:00:00';
        $twodaysbefore = date('Y-m-d',strtotime('-2 days')).' 17:00:00';
        $threedaysbefore = date('Y-m-d',strtotime('-3 day')).' 17:00:00';
    }
    
?>
<tr>
<td>商品名称</td>
<td>今日出单</td>
<td>今日待发货</td>
<td>两天前待发货</td>
<td><?php echo $twodaysbefore;?> - <?php echo $yestoday;?> 已发货</td>
<td><?php echo $threedaysbefore;?> - <?php echo $twodaysbefore;?> 已发货</td>
</tr>

<?php 
    
    $sql = "select concat(shopid,'-',skuid) as ssku,count(*) as num from wx_guest where addtime between '{$yestoday}' and '{$today}' group by ssku";  
    $result = mysql_query($sql);
    while(($r = mysql_fetch_assoc($result))!==false){
          $count[$r['ssku']] = $r['num'];  
    }
    
    arsort($count);
    
    $gueststate = array(3,9);
    $gueststate2 = array(9);
    
    
    foreach ($count as $ssku=>$num){
        list($shopid,$skuid) = explode('-', $ssku);
        $dfnum = get_guestnum_by_shop_and_gueststate($shopid, $skuid,$gueststate, $yestoday, $today);
        $dfnum2 = get_guestnum_by_shop_and_gueststate2($shopid, $skuid,$gueststate2, $twodaysbefore);
        $dfnum3 = get_guestnum_by_shop_and_gueststate($shopid, $skuid,$gueststate, $twodaysbefore,$yestoday);
        $dfnum4 = get_guestnum_by_shop_and_gueststate($shopid, $skuid,$gueststate, $threedaysbefore,$twodaysbefore);
        
        $name=  get_name($shopid, $skuid);
        echo "<tr>
        <td>{$name}</td>
        <td> {$num}</td>
        <td>待发货量 {$dfnum}</td>
        <td> {$dfnum2}</td>
        <td> {$dfnum3}</td>
        <td> {$dfnum4}</td>
        </tr>";
    }
    
    
?> 
</table>
<style>
table,td{border-collapse:collapse;border:1px solid #ccc;}
td{padding:5px 10px;}
</style>
</div>

</div>
<div id="footer">
<p>北京微优网络科技有限公司</p>
</div>
</body>
</html>