<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=3;
$nav2=2;
$uid = $user11id=$_SESSION['user1114id'];
?>


<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优邀请用户</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../../wxdata/dx_head.php");?>
<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
    
                <div class="vip-content-r-notice" style="height:48px;">
                    <div class="vip-content-r-notice-l" id="state" style="margin-top:5px; width:100%;">
                <span class="sousuo" style="margin-left: 5px;" >BUTTON : </span>
                     <a class="state" href="/user/invite/">返回我的邀请链接</a>  
                    </div>	
                </div>
    
                 <h3><a class="tianjmb">邀请用户</a>  &nbsp;&nbsp; 查询结果 &nbsp;&nbsp; 总数 : <?php echo invite_num($uid);?></h3>    
               
                 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                     <tr class="tittle">
                        <td width="16%" align="center"> 注册日期</td>
                        <td width="9%" align="center">ID</td>
                        <td width="18%" align="center">用户名</td>
                        <td width="18%" align="center">qq号</td>
                        <td width="18%" align="center">手机号</td>
                        <td width="8%" align="center">状态</td>
                        <td width="13%" align="center">操作</td>
                    </tr>
                    
<?php
  $page_size=12;
  
  $where = "topuser='$user11id'";
  
  $num = $mysql->count_table('wx_user',$where);
  
  $page_count=ceil($num/$page_size);  //得到页数

  $page=intval($_GET['page']);
  if(!$page)
  	$page=1;

  $offset=($page-1)*$page_size;

  $sql = mysql_query("select id,usertime,loginname,qq,tel,userstate from wx_user where $where order by userstate desc,id desc limit $offset,$page_size");	

while($info=mysql_fetch_array($sql)){
    
    foreach ($info as $k=>$v){
        $info[$k] = gl2($v); 
    }
?>
         
                       <tr height="10"><td colspan="9"></td></tr>                      
                           <tr class="xiangmu">
                            <td valign="center" align="center"><p class="splist"><?php echo date("Y-m-d H:i",strtotime($info['usertime']));?></p></td>
                            <td valign="center" align="center"><p class="splist"><?php echo $info['id']; ?></p></td>
                            <td valign="center" align="center"><p class="splist"><?php echo $info['loginname']; ?></p></td>
                            <td valign="center" align="center"><p class="splist"><?php echo substr($info['qq'],0,6)."****"; ?></p></td>
                            <td valign="center" align="center"><p class="splist"><?php echo substr($info['tel'],0,6)."****"; ?></p></td>
                            <td align="center" valign="center">
                            <?php if($info['userstate']=="1"){ echo "正常";}else{ echo "冻结";} ?>        
                            </td>
                            <td align="center" valign="top">
                                <a href="../invorder/?id=<?php echo $info['id']; ?>" class="caozuo">订单</a>
                            </td>
                        </tr>
                        
       <?php }?>     
               
                </table>
                 <?php require("../../../wxdata/dx_page.php");?>   
            </div>               
<?php require("../../../wxdata/dx_foot.php");?>
</body>
</html>