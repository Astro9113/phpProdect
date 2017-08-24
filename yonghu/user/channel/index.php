<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=1;
$nav2=2;

$user11id = $uid = $_SESSION['user1114id'];
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优- 渠道设置</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../wxdata/dx_head.php");?>


<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
                <?php require("../../wxdata/dx_mid.php");?>
    
                <div class="vip-content-r-notice" style="height:48px;">
                
                    <div class="vip-content-r-notice-l" id="state" style="margin-top:5px; width:100%;">
                 <span class="sousuo" style="margin-left: 5px;" >BUTTON : </span>
                     <a class="state" href="/user/commod/">返回浏览商品</a>  
                    </div>	
                </div>
    
                 <h3><a href="/user/channel/add/" class="tianjmb">添加渠道</a></h3>    
                
                 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                     <tr class="tittle">
                        <td width="15%" align="center">ID</td>
                        <td width="50%" align="center">名称及描述</td>
                        <td width="24%" align="center">添加时间</td>
                        <td width="11%" align="center">编辑</td>
                    </tr>
                    
<?php
$sql=mysql_query("select * from wx_userchannel where channeltop='$user11id' order by id desc limit 10");	
while($info=mysql_fetch_array($sql)){
?>
         
                       <tr height="10"><td colspan="9"></td></tr>                      
                           <tr class="xiangmu">
                            <td valign="center" align="center"><p class="splist"><?php echo $info['id']; ?></p></td>
                            <td  valign="top" class="splist"><p class="splist"> 	
                            <b><?php echo strip_tags($info['userchannel']); ?></b>
                               <span><?php echo strip_tags($info['channelcon']); ?> </span>
                               </p></td>
                            <td class="ckulist" valign="center"><p>
                          <?php echo date("Y-m-d H:i",strtotime($info['addtime']));?>
                            </p></td>
                            <td align="center" valign="center">
                                <a href="javascript:if(confirm('您确定要删除么')){window.location='del/?id=<?php echo $info['id']; ?>'};" class="caozuo">删除</a>        
                            </td>
                        </tr>
                        
       <?php }?>     
               
                </table>         
            </div>               		
<?php require("../../wxdata/dx_foot.php");?>
</body>
</html>