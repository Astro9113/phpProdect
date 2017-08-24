<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=4;
$nav2=2;
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - 修改密码</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
    <?php require("../../../wxdata/dx_head.php");?>


<div class="vip">
    <div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
    
            <div class="vip-content-r-notice" style="height:40px;">
                <div class="vip-content-r-notice-l" id="state" style="margin-top:5px; width:100%;">
                         <span class="sousuo" style="margin-left: 5px;" >BUTTON : </span>
                             <a class="state" href="/user/informa/">返回我的信息</a>  
                </div>
            </div>

    
                <form method="post" name="detail" action="modpasswordresult/">	
                <h3 class="zaixiancz-icon" style="background-position: 0 -250px;">修改密码</h3>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-mb-add">
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">原密码</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><input type="password" name="olduserpassword" id="olduserpassword" class="vip-test" value="" style="width: 300px;"></p>
                        </td>
                    </tr>
                                        <tr>
                        <td align="right" valign="top"><p class="tittle">新密码</p></td>
                        <td align="left" valign="top">
                           <p><input type="password" name="userpassword" id="userpassword" class="vip-test" value="" style="width: 300px;"></p>
                            <p style="padding-bottom:12px;color: #F00;">定期修改密码，能让您的账号更安全！</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">确认新密码</p></td>
                        <td align="left" valign="top">
                        
                        <p><input type="password" name="userpassword2" id="userpassword2" class="vip-test" value="" style="width: 300px;"></p>
                        
                            <p style="padding-bottom:12px;color: #F00;"></p>
                        </td>
                    </tr>
                  
                    <tr>
                        <td align="right" height="20"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td align="right" height="15"></td>
                        <td align="left"><a href="javascript:document.detail.submit();" class="gengxin" onClick="return pk()">修&nbsp;&nbsp;改</a><a href="javascript:document.detail.reset();" class="fanhui">重&nbsp;&nbsp;置</a></td>
                    </tr>
                    <tr>
                        <td align="right" height="60"></td>
                        <td align="left"></td>
                    </tr>
                </table>
                </form>
<script language="javascript">
function pk(){
	if(detail.olduserpassword.value==""){
		alert("原密码不可为空，请填写！");
		detail.olduserpassword.focus();
		return false;
	}
	
	if(detail.userpassword.value==""){
		alert("新密码不可为空，请填写！");
		detail.userpassword.focus();
		return false;
	}
	
	if(detail.userpassword.value!=detail.userpassword2.value){
		alert("两次密码输入不一致，请重新填写!");
		detail.userpassword.value="";
		detail.userpassword2.value="";
		detail.userpassword.focus();
		return false;
	}
}
</script>
                
            </div>         
            
		
<?php require("../../../wxdata/dx_foot.php");?>
</body>
</html>