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
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优订单详情页</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
    
  	         <div class="vip-content-r-notice" style="height:48px;">
                
                <div class="vip-content-r-notice-l" style="margin-top:5px; width:100%;">
                <span class="sousuo" style="margin-left: 5px;" >BUTTON : </span>
                 <a class="state" href="javascript:history.go(-1);">返回订单列表</a>  
                </div>	
                
            </div>
    
<?php
	$userpercent=userpercent();
	$bh=intval($_GET['bh']);
	$userconid=userconid();
	$gid = $userconid[$bh];
    
    $sql = mysql_query("select  * from wx_guest where userid='$user11id' and id='$gid'");
    $info=mysql_fetch_array($sql);
    foreach ($info as $k=>$v){
        if($k=='guestrizhi'){
            $info[$k] = guestrizhi($v);
        }else{
            $info[$k] = gl2($v);
        }
    }
	
    $shopid=$info['shopid'];
	$skuid=$info['skuid'];
	$guestkuanshi=$info['guestkuanshi'];
	$gueststate=$info['gueststate'];  

	$shop = shopinfo($shopid);
	
	$shopskuid="shopsku".$skuid;
	$shopsku=$shop[$shopskuid];
	$shopsku=explode("_",$shopsku);
	if($info1['ischange']=='1'){
	   $shopsku[2]=$shopsku[2]*$userpercent;
	   $shopsku[2]=round($shopsku[2]);
    }
	
    $gusettitle=$info1['shopname2']."&nbsp;&nbsp;&nbsp;".$shopsku[0];
	$orderstate=orderstate($gueststate);
	
	$wuliugsname = $info['wuliugs'];
	$sql5=mysql_query("select wuliugscode from wx_wuliugs where wuliugsname='$wuliugsname'");
	$info5 = mysql_fetch_array($sql5);
	$wuliugscode=$info5['wuliugscode'];
?>
    
            <h3><a class="tianjmb">订单详情</a>  &nbsp;&nbsp;  ID：<?php echo $bh;?></h3>    
                
            <h3 class="zaixiancz-icon" style="background-position: 0 -150px;">订单状态</h3>
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-mb-add">
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>
                     <tr>
                        <td align="right" valign="top"><p class="tittle">下单时间</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                          <?php echo $info['addtime'];?>
                            </p>
                        </td>
                    </tr>
                     <tr>
                        <td align="right" valign="top"><p class="tittle">购买商品</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                         <?php echo $gusettitle." ".$guestkuanshi; ?>

                            </p>
                        </td>
                    </tr>
                     <tr>
                        <td align="right" valign="top"><p class="tittle">价格分成</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                         <?php echo $shopsku[1].' / '.$shopsku[2]; ?>

                            </p>
                        </td>
                    </tr>
                   <tr>
                        <td align="right" valign="top"><p class="tittle">最新状态</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php echo $orderstate; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">发货状态</p></td>
                        <td align="left" valign="top">   
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php 
                            if($info['guestkuaidi']==""){   
                                echo " 未发货";
                            }else{
                                echo "已发货，".$info['wuliugs']." ".$info['guestkuaidi']."&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://m.kuaidi100.com/index_all.html?type=".$wuliugscode."&postid=".$info['guestkuaidi']."' target='_blank' class='spcona'>物流查询</a>";
                            }
                            ?>
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right" valign="top"><p class="tittle">状态日志</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php echo $info['addtime'];?>，下单成功 客服确认中<br>
                            <?php
                                echo $info['guestrizhi'];
                            ?>
                            </p>
                        </td>
                    </tr>  
                  <tr>
                        <td align="right" valign="top"><p class="tittle">客服备份</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php echo htmlspecialchars($info['guestrem']);?>
                            </p>
                        </td>
                    </tr>
                     <tr>
                        <td width="250" align="right" height="5"></td>
                        <td align="left"></td>
                    </tr>
                </table>
                </form>
                   
                   
            <form method="post" name="form1" action="user.html">	
                <h3 class="zaixiancz-icon" style="background-position: 0 -100px;">买家信息</h3>
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-mb-add">
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>
                    <?php 
					$kanxin=array(312,308,236,224);
					
					if($orderstate=='假单'||$orderstate=='已取消'||$orderstate=='退货'||$orderstate=='联不上'||$orderstate=='拒收'||$orderstate=='无效重复'||in_array($user11id,$kanxin)){ 
					$guestname=htmlspecialchars($info['guestname']);
					$guesttel=htmlspecialchars($info['guesttel']);
					$guestdizhi=htmlspecialchars($info['guestsheng'].$info['guestcity'].$info['guestqu']);
					//$log = data('Y-m-d H:i:s').'_'.$_SESSION['user1114name'].'_'.$gid.PHP_EOL;
					//file_put_contents('log.txt', $log,FILE_APPEND);
					}else{
					$guestname=htmlspecialchars('* '.substr($info['guestname'],-3));
					$guesttel=htmlspecialchars(substr($info['guesttel'],0,7)."****");
					$guestdizhi=htmlspecialchars($info['guestsheng'].$info['guestcity'].' **  **');		
					}
					?>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">买家姓名</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php echo htmlspecialchars($guestname);?>
                            </p>
                        </td>
                    </tr>
                  
                     <tr>
                        <td align="right" valign="top"><p class="tittle">买家手机</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                       <?php echo htmlspecialchars($guesttel);?>
                            </p>
                        </td>
                    </tr>
                  
                  <tr>
                        <td align="right" valign="top"><p class="tittle">收货地址</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;" class="tittle">
                            <?php echo htmlspecialchars($guestdizhi);?>
                            </p>
                        </td>
                    </tr>
                  
               
                  
                </table>
                </form>
                   
            </div>                     
		
<?php require("../../../wxdata/dx_foot.php");?>
</body>
</html>