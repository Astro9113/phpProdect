<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=3;
$nav2=1;
$uid = $user11id=$_SESSION['user1114id'];

?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - 邀请链接</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../wxdata/dx_head.php");?>
<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
                <div class="vip-content-r-notice" style="height:48px;">
                    <div class="vip-content-r-notice-l" style="margin-top:5px; width:100%;">
                <?php
                    $applyma = get_user_applyma($uid);
                    if(!$applyma){
                        echo "<a class='state' href='applyma/'>申请邀请链接</a>";
                    }else{
                        $userreward=userreward();
                        echo "<span class='sousuo' style='margin-left: 5px;' >LINK：http://{$user_invite_domain}/regist/".base64_encode_withouteq($applyma)." &nbsp;&nbsp;&nbsp; 提成： ".$userreward."%</span>";
                    }
                ?>
                    </div>	
                </div>
    
                <h3 class="zaixiancz-icon" style="background-position: 0 -250px;">邀请统计</h3>
                
                <div class="vip-content-r-zijinsousuo" style="height: 280px; padding-top:30px;">
                    <div class="chongzhitaocan">
                        <p style="font-size:20px;">我的邀请成绩：</p>
                        <p style="padding-bottom:40px; font-size:16px; padding-left:50px;">点击查看邀请的详细用户和用户出单情况，综合了解自己的邀请收益</p>
                        <ul class="chongzhi-ul" style="margin-left:90px;">
                        <li><a href="invuser/" class="chongzhi-btn"><b>邀请用户</b><br /><br /><span><?php echo invite_num($uid);?></span></a></li>
                        <li><a href="invorder/" class="chongzhi-btn"><b>已分成金额</b><br /><br /><span><?php echo invite_fencheng($uid);?></span></a></li>
                        </ul>  
                    </div>
                </div>
            </div>               
		
<?php require("../../wxdata/dx_foot.php");?>
</body>
</html>