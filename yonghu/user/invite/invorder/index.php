<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=3;
$nav2=3;
$uid = $user11id=$_SESSION['user1114id'];

$id = isset($_GET['id'])?intval($_GET['id']):0;

$where  = " 1";

if(!$id){
    $botuser = botuser();
    $where .= " and userid in ($botuser)";
}else{
    if(!isbotuser($id)){
        alert('用户不存在,或者不是被您邀请');
        goback();
    }
    
    $where .= " and userid = '$id'";
}

$stime = check_time($_GET['stime']);
$etime = check_time($_GET['etime']);

if($stime && $etime){
    $where .= " and (addtime between '".$stime."' and '".$etime."')";
}

$stateid  = intval($_GET['stateid']);
if($stateid){
    $where .= " and gueststate = '{$stateid}'";
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优用户订单</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
             <div class="vip-content-r-notice" style="min-height:42px;">
                <form method="get" name="form_send" action="">
                <input type="hidden" name="id" value="<?php echo $id;?>">
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
                
                    <div class="vip-content-r-notice-r left" style="width:47%;">
                       <span class="sousuo" style="margin-left: 5px;" >下单时间 : </span>
                       <input  style="width:140px;" class="vip-test" type="text"  value="<?php if($stime){echo $stime;}else{ echo '选择开始时间';}?>" name="stime" id="stime">&nbsp;-&nbsp;
                       <input  style="width:140px;" class="vip-test" type="text" value="<?php if($etime){echo $etime;}else{ echo '结束时间';}?>" name="etime" id="etime">
                    </div>
                    
                    
                    <input type="submit" name="sub" class="tianjmb" />
                    </form>
                    
                            
                    <div style="clear:both;"></div>
                </div>
     
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                    <tr class="tittle">
                        <td width="15%" align="center">下单时间</td>
                        <td width="32%" align="center">商品</td>
                        <td width="14%" align="center">金额/分成</td>
                        <td width="15%" align="center">用户</td>
                        <td width="12%" align="center">订单状态</td>
                        <td width="12%" align="center">邀请分成</td>
                    </tr>
                      
  <?php 
  
  $page_arr = array(
      "id={$id}",
      "stime={$stime}",
      "etime={$etime}",
      "stateid={$stateid}",
  );
  
  $pagestr = join('&',$page_arr);
  
  
  $userreward=userreward();

  $num = $mysql->count_table('wx_guest',$where);
  
  
  $page_size=18;
  $page_count=ceil($num/$page_size);  //得到页数

  $page = intval($_GET['page']);
  if(!$page)
  	$page=1;

  $offset=($page-1)*$page_size;

  
  $sql = "select id,shopid,skuid,userid,userwx,gueststate,guestkuanshi,addtime from wx_guest where {$where} order by id desc limit $offset,$page_size";
  
  $sql=mysql_query($sql);
  
  $shops = get_shops();
  $users_invite = get_invite_users();
  
while($info=mysql_fetch_array($sql)){
	$shopid = $info['shopid'];
	$skuid = $info['skuid'];
	$userid = $info['userid'];
	$botuser_loginname = gl2($users_invite[$userid]['loginname']);
 
	$gueststate = $info['gueststate'];  
	$guestkuanshi = $info['guestkuanshi'];
	$shop = $shops[$shopid]; 
	
	$shopskuid="shopsku".$skuid;
	$shopsku=$shop[$shopskuid];
	$shopsku=explode("_",$shopsku);

	$gusettitle=$shop['shopname2']."&nbsp;&nbsp;&nbsp;".$shopsku[0];

	$orderstate=orderstate($gueststate);
	?>
 
                       <tr height="10"><td colspan="9"></td></tr>                      
                         <tr class="xiangmu">
                            <td valign="top" align="center"><p><?php echo date("m-d H:i",strtotime($info['addtime']));?></p></td>
                            <td  valign="top"><p class="diqu"><?php echo $gusettitle." ".$guestkuanshi; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $shopsku[1]; ?> / <?php echo $shopsku[2]; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $botuser_loginname; ?></p></td>
                            <td align="center" valign="top"><p><?php echo $orderstate; ?> </p></td>
                            <td align="center" valign="top"><?php echo $shopsku[2]*$userreward/100; ?> </td>
                        </tr>
              
              
        <?php }?>                
                   
                        
                        
                </table>
                
              <?php require("../../../wxdata/dx_page.php");?>           
            </div>                        

            
<?php require("../../../wxdata/dx_foot.php");?>
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