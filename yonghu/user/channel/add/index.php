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

<title>微优添加渠道</title>
<script language="javascript">
function pk(){
	if(detail.userchannel.value==""){
		alert("请填写渠道名称！");
		detail.userchannel.focus();
		return false;
	}
}
</script>

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
                 <a class="state" href="/user/channel/">返回渠道列表</a>  
                </div>	
            </div>
    

                <h3 class="zaixiancz-icon" style="background-position: 0 -250px;">添加渠道</h3>
       
                <form method="post" name="detail" action="addresult/">	         
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-mb-add">
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>
                    
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>               
                     <tr>
                        <td align="right" valign="top"><p class="tittle">渠道名称</p></td>
                        <td align="left" valign="top">
                            <p><input type="text" name="userchannel" id="userchannel" class="vip-test" value="" style="width: 300px;"></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>               
                    <tr>
                        <td align="right" valign="top"><p class="tittle">渠道描述</p></td>
                        <td align="left" valign="top">
                            <p><input type="text" name="channelcon" id="channelcon" class="vip-test" value="" style="width: 500px;"></p>
                          
                        </td>
                    </tr>
                    
                                        
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>  
                           <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>                   
                   <tr>
                        <td align="right" height="15"></td>
                        <td align="left"><a href="javascript:document.detail.submit();" class="gengxin" onClick="return pk()">添&nbsp;&nbsp;加</a><a href="javascript:document.detail.reset();" class="fanhui">重&nbsp;&nbsp;置</a></td>
                    </tr>
                    <tr>
                        <td align="right" height="60"></td>
                        <td align="left"></td>
                    </tr>
                </table>
                </form>
                   
            </div>               
            
		
<?php require("../../../wxdata/dx_foot.php");?>

</body>
</html>