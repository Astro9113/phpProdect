<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=4;
$nav2=1;

$user = $info = userinfo($user11id);
foreach ($info as $k=>$v){
    $info[$k] = htmlspecialchars($v);
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优帐号信息</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
                <form method="post" name="detail" action="modresult/">	
                <h3 class="zaixiancz-icon" style="background-position: 0 0px;">账户信息</h3>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="vip-mb-add">
                    <tr>
                        <td width="250" align="right" height="30"></td>
                        <td align="left"></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">用户名</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><?php echo $info['loginname'];?></p>
                        </td>
                    </tr>
                                
                    <tr>
                        <td align="right" valign="top"><p class="tittle">支付宝帐号</p></td>
                        <td align="left" valign="top">
                        
                         <p><input type="text" name="alipay" id="alipay" class="vip-test" value="<?php echo $info['alipay'];?>" style="width: 300px;"></p>
                         <p style="padding-bottom:12px;color: #F00;">为了您的资金安全，支付方式一旦设置不可修改，请认真填写！</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">支付宝姓名</p></td>
                        <td align="left" valign="top">
                        
                        <p><input type="text" name="alipayname" id="alipayname" class="vip-test" value="<?php echo $info['alipayname'];?>" style="width: 300px;"></p>
                        <p style="padding-bottom:12px;color: #F00;"></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="60" colspan="2"><p style="width:90%; margin:0 auto; border-top:1px solid #ccc; height:2px; padding-bottom:10px;"></p></td>
                    </tr>
     
                    <tr>
                        <td align="right" valign="top"></td>
                        <td valign="top"><p class="tittle" style="padding-bottom:20px;">以下信息请填写完整，方便我们媒介能及时联系到您</p></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">个性昵称</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><input type="text" name="username" id="username" class="vip-test" value="<?php echo $info['username'];?>" style="width: 300px;" ></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">QQ</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><input type="text" name="qq" id="qq" class="vip-test" value="<?php echo $info['qq'];?>" style="width: 300px;"></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"><p class="tittle">手机</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><input type="text" name="tel" id="tel" class="vip-test" value="<?php echo $info['tel'];?>" style="width: 300px;"> </p>
                        </td>
                    </tr>
                       <tr>
                        <td align="right" valign="top"><p class="tittle">邮箱</p></td>
                        <td align="left" valign="top">
                            <p style="padding-bottom:15px;"><input type="text" name="email" id="email" class="vip-test" value="<?php echo $info['email'];?>" style="width: 300px;"></p>
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
function trim(str){ 
    return str.replace(/(^\s*)|(\s*$)/g, ""); 
}

function pk(){
	if(trim(detail.username.value)==""){
		alert("昵称不可为空，请填写!!!");
		detail.username.focus();
		return false;
	}	
	if(trim(detail.qq.value)==""){
		alert("请填写QQ！");
		detail.qq.focus();
		return false;
	}
	if(trim(detail.tel.value)==""){
		alert("请填写手机号！");
		detail.tel.focus();
		return false;
	}
	if(trim(detail.email.value)==""){
		alert("请填写邮箱！");
		detail.email.focus();
		return false;
	}
	
	
if(trim(detail.alipayname.value)!=""){
	if(trim(detail.alipay.value)==""){
		alert("请填写完整的支付宝信息！");
		detail.alipay.focus();
		return false;
	}
}

if(detail.alipay.value!=""){
	if(trim(detail.alipayname.value)==""){
		alert("请填写完整的支付宝信息！");
		detail.alipayname.focus();
		return false;
	}
}

}
</script>
                
            </div>         
            
		
<?php require("../../wxdata/dx_foot.php");?>

</body>
</html>