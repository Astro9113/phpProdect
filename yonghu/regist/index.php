<?php
require $_SERVER['DOCUMENT_ROOT']."/wxdata/sjk1114.php";

if(isset($_GET['p'])){
    $p = preg_replace('/[^0-9a-zA-Z=]/', '', $_GET['p']);
    setcookie('p',$p,time() + 24*60*60);
}elseif(isset($_COOKIE['p'])){
    $p = $_COOKIE['p']; 
}else{
    $p = 'MDAxNTA0MDQwNzEzMDU1NDMx';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优用户注册</title>

<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>


<script type="text/javaScript">
function fLoginihuyiFormSubmit(){
	var fm = window.document.frm_login;
	if(fm.addusername.value =="" || fm.addusername.value =="用户名 5-16位字母、数字组合") {
		window.alert("请填写用户名！");
		fm.addusername.value='';
		fm.addusername.focus();
		event.returnValue = false;
		return false;
	}
	if(fm.nicheng.value =="" || fm.nicheng.value =="昵称 2个字以上") {
		window.alert("请填写昵称！");
		fm.nicheng.value='';
		fm.nicheng.focus();
		event.returnValue = false;
		return false;
	}
	if(fm.addpassword.value =="" || fm.addpassword.value =="密码 6位以上") {
		window.alert("请填写密码！");
		fm.addpassword.value='';
		fm.addpassword.type='password';
		fm.addpassword.focus();
		event.returnValue = false;
		return false;
	}
	if(fm.addpassword.value != fm.password2.value) {
		window.alert("两次密码不一致，请重新填写！");
		fm.addpassword.value='';
		fm.addpassword.type='password';
		fm.password2.value='';
		fm.password2.type='password';
		fm.addpassword.focus();
		event.returnValue = false;
		return false;
	}
	if(fm.qq.value =="" || fm.qq.value =="QQ 号") {
		window.alert("请填写QQ！");
		fm.qq.value='';
		fm.qq.focus();
		event.returnValue = false;
		return false;
	}
	if(fm.tel.value =="" || fm.tel.value =="手机 号") {
		window.alert("请填写手机号！");
		fm.tel.value='';
		fm.tel.focus();
		event.returnValue = false;
		return false;
	}
	
	
	fm.submit();
	return true;
}
</script>

<style>
html { background:#f5f5f5;}
</style>

<body style="background:#f5f5f5">
<div class="login-main">

    <div class="login-logo">
    
<img src="/images/login-logo3.gif" />  
    </div>

    <div class="login-form">
		<form id="frm_login" method="post" name="frm_login" action="registpd/">
        <div class="login-txtbox" id="login-txtbox">
			<i class="ico-usename"></i>
            <input class="txt-input text-email" type="text" id="addusername" name="addusername" value="用户名 5-16位字母、数字组合" onmousedown="if(this.value=='用户名 5-16位字母、数字组合'){this.value='';}" onblur="if(this.value==''){this.value='用户名 5-16位字母、数字组合';}"  onmouseover="document.getElementById('login-txtbox').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox').style.border='solid 1px #bbb'"  />
        </div>
        <div class="login-txtbox" id="login-txtbox12">
			<i class="ico-usename"></i>
            <input class="txt-input text-email" type="text" id="nicheng" name="nicheng" value="昵称 2个字以上" onmousedown="if(this.value=='昵称 2个字以上'){this.value='';}" onblur="if(this.value==''){this.value='昵称 2个字以上';}"  onmouseover="document.getElementById('login-txtbox12').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox12').style.border='solid 1px #bbb'"  />
        </div>
      <div class="login-txtbox" id="login-txtbox2">
			<i class="ico-pwd"></i>
            <input class="txt-input text-email" type="text" id="addpassword" name="addpassword" value="密码 6位以上" onmousedown="if(this.value=='密码 6位以上'){this.value='';this.type='password';}" onblur="if(this.value==''){this.value='密码 6位以上';this.type='text';}"  onmouseover="document.getElementById('login-txtbox2').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox2').style.border='solid 1px #bbb'"  />
        </div>
      <div class="login-txtbox" id="login-txtbox3">
			<i class="ico-pwd"></i>
            <input class="txt-input text-email" type="text" id="password2" name="password2" value="确认密码" onmousedown="if(this.value=='确认密码'){this.value='';this.type='password';}" onblur="if(this.value==''){this.value='确认密码';this.type='text';}"  onmouseover="document.getElementById('login-txtbox3').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox3').style.border='solid 1px #bbb'"  />
        </div>
     <div class="login-txtbox" id="login-txtbox4">
			<i class="ico-usename"></i>
            <input class="txt-input text-email" type="text" id="qq" name="qq" value="QQ 号" onmousedown="if(this.value=='QQ 号'){this.value='';}" onblur="if(this.value==''){this.value='QQ 号';}"  onmouseover="document.getElementById('login-txtbox4').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox4').style.border='solid 1px #bbb'"  />
        </div>
     <div class="login-txtbox" id="login-txtbox5">
			<i class="ico-usename"></i>
            <input class="txt-input text-email" type="text" id="tel" name="tel" value="手机 号" onmousedown="if(this.value=='手机 号'){this.value='';}" onblur="if(this.value==''){this.value='手机 号';}"  onmouseover="document.getElementById('login-txtbox5').style.border='solid 1px #38B8E8'" onmouseout="document.getElementById('login-txtbox5').style.border='solid 1px #bbb'"  />
        </div>

  
        <input type="hidden" name="applyma" value="<?php  echo $p; ?>" />
        <div class="btn-login">
            <a href="javascript:fLoginihuyiFormSubmit();" id="submit" name="Logon_ihu_yi_index_denglu002" class="login-submit">注　册</a>
        </div>
        
		<div class="links-text">
            <a href="/user/login/" class="link-left"  name="Logon_ihu_yi_index_denglu003" id="reg">有帐号，马上登录</a>
        </div>
		           
        <div class="user-frd">
            <span>Copyright © 2003-2015 北京微优网络科技有限公司 版权所有</span>
        </div>
        </form>
    </div>
</div>
</body>
</html>