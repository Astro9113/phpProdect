<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=2;
$nav2=3;

$user11id = $uid = $_SESSION['user1114id'];

function check_day($day){
    $pat = '/^\d{4}-\d{2}-\d{2}$/';
    $r = preg_match($pat, $day);
    //var_dump($r);
    //exit;
    if(!preg_match($pat, $day)){
        return '';
    }
    return $day;
}

$where  = "";
echo $stime = isset($_GET['stime'])?check_day($_GET['stime']):'';

if($stime){
    echo $where .= " and (addtime between '{$stime} 00:00:00' and '{$stime} 23:59:59')";
}

$page_arr = array(
    "stime={$stime}",
);
	
$pagestr = join('&',$page_arr);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优结算列表</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
    

    
 <form method="get" name="form_send" action="">
   	<div class="vip-content-r-notice" style="min-height:42px;">
            
            		
 
            	<div class="vip-content-r-notice-r left">
           <span class="sousuo" style="margin-left: 5px;" >打款时间 : </span>
                    <input class="vip-test" type="text" onClick="laydate()" value="<?php echo $stime;?>" name="stime">
                </div>	
                <div style="clear:both;"></div>
                
                
            </div>
    
    <?php
	
  $sql=mysql_query("select DATE_FORMAT(addtime,'%Y%m%d') days,id,moneyguestid from wx_playmoney where moneyguestid in(select id as moneyguestid from wx_guest where userid='$user11id' and gueststate='5') {$where} group by days desc");

  $num=mysql_num_rows($sql);
	
	?>
    
                <h3><a href="javascript:window.document.form_send.submit();" class="tianjmb">条件查询</a><a href="/user/order/settle/" class="tianjmb2">清空</a>  &nbsp;&nbsp; 查询结果 &nbsp;&nbsp; 总数 : <?php echo $num;?></h3>    
            </form>    
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                    <tr class="tittle">
                        <td width="15%" align="center">时间</td>
                        <td width="15%" align="center">订单结算数</td>
                        <td width="18%" align="center">应打金额</td>
                        <td width="22%" align="center">改动订单数 / 改动金额</td>
                        <td width="20%" align="center">实打金额</td>
                        <td width="10%" align="center">详情</td>
                    </tr>
                      
  <?php 

  $page_size=18;
  $page_count=ceil($num/$page_size);  //得到页数

  $page=intval($_GET['page']);
  if(!$page)
  	$page=1;

  $offset=($page-1)*$page_size;

 $sql=mysql_query("select DATE_FORMAT(addtime,'%Y%m%d') days,id,moneyguestid from wx_playmoney where moneyguestid in(select id as moneyguestid from wx_guest where userid='$user11id' and gueststate='5') {$where} group by days desc limit $offset,$page_size");
 
while($info=mysql_fetch_array($sql)){
	$aadd=0;
	$aa4=$info['days'];
	$aa3=substr($aa4,0,4)."-".substr($aa4,4,2)."-".substr($aa4,6,2)." 00:00:00";
	$aa2=substr($aa4,0,4)."-".substr($aa4,4,2)."-".substr($aa4,6,2)." 23:59:59";
	$aa1=substr($aa4,0,4)."-".substr($aa4,4,2)."-".substr($aa4,6,2);
	
	$sql1=mysql_query("select moneyhow from wx_playmoney where moneyguestid in(select id as moneyguestid from wx_guest where userid='$user11id' and gueststate='5') and addtime>='$aa3' and addtime<='$aa2' and moneyclass='1' group by moneyguestid order by id");
	$num1=mysql_num_rows($sql1);
	while($info1=mysql_fetch_array($sql1)){    
	$aad=$info1['moneyhow'];
	$aadd=$aadd+$aad;
	}
	?>
 
                       <tr height="10"><td colspan="9"></td></tr>                      
                         <tr class="xiangmu">
                            <td valign="top" align="center"><p><?php echo $aa1;?></p></td>
                            <td valign="top" align="center"><p><?php echo $num1;?></p></td>
                            <td  valign="top" align="center"><p><?php echo $aadd; ?></p></td>
                            <td align="center" valign="top"><p>无</p></td>
                            <td align="center" valign="top"><p><?php echo $aadd; ?></p></td>
                            <td align="center" valign="top">
                                <a href="../settledet/?time=<?php echo $aa1;?>" class="caozuo">详情</a>        
                            </td>
                        </tr>
              
              
        <?php }?>                
                   
                        
                        
                </table>
                
              <?php require("../../../wxdata/dx_page.php");?>           
                
              <div class="vip-content-r-notice" style="background: #FB9D44;">
                <p style="color:#fff;">提示：结算返款一般在下午2点到5点，请及时查看自己支付宝情况。</p>	
              </div>
                   
            </div>                        
		
<?php require("../../../wxdata/dx_foot.php");?>
<script src="http://res.sentsin.com/lay/lib/laydate/laydate.js"></script>
</body>
</html>