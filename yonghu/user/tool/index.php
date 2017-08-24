<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=6;
$nav2=1;

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - 推广工具</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
        	  <h3 class="zaixiancz-icon" style="background-position: 0 -300px;">推广工具</h3>
                <div class="vip-content-r-zijinsousuo" style="height: 1150px; min-width:1000px;">
                
                    <div class="chongzhitaocan" style="width:1000px;">
                        
                    <p><a class="t_link" href="cps/"> ① cps 广告</a></p>
                        
                    </div>
                </div>
                   
            </div>               
		
<?php require("../../wxdata/dx_foot.php");?>
<style>
.t_link{color:#000 !important;}
</style>
</body>
</html>