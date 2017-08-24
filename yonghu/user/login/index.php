<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
$uid = $_SESSION['user1114id'];

if($uid){
    go('/user');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优用户登录</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>

<style>
html { background:#f5f5f5;}
</style>

<body style="background:#f5f5f5">


<style>
#modal{display:none;position:absolute;top:10px;left:400px;padding:20px;padding-bottom:40px;border:1px solid #ccc;width:600px;margin:auto;background-color:#FFF;z-index:99;font-size:14px;}
#close{position:relative;right:10px;botton:}
</style>

<div id="modal">
    <center><h2 id="modal1Title">域名切换公告</h2></center>
    <p>
	<div style="text-align:left;line-height:1.9em;">
            尊敬的用户您好：<br />
            旧平台登陆链接将于2016-03-18日更改为 <a href="http://bak.chinavuw.com/"> http://bak.chinavuw.com</a><br />
            请使用此域名登陆,查询旧平台数据,<br />
			原旧平台域名会跳转到新平台<br />

	<p style="float:right;clear:both;">微优网络 2016年3月17日</p>
	<p style="clear:both;"></p>
	<center><p id="close" style="border:1px solid #ccc;width:70px;">X 关闭</p></center>
	</div>	  
    </p>
</div>

<script>
	$(function(){
		//$("#modal").show();
		$("#close").click(function(){
			$("#modal").hide();
		})
	});
</script>

<div class="login-main">

    <div class="login-logo">
    
<img src="/images/login-logo3.gif" />  
    </div>

    <div class="login-form">
		<form id="frm_login" method="post" name="frm_login" action="loginpd/">
        <div class="login-txtbox" id="login-txtbox">
			<i class="ico-usename"></i>
            <input class="txt-input text-email" type="text" id="username" name="username" placeholder="账号"/>
        </div>

        <div class="login-txtbox" id="login-txtbox2" >
            <i class="ico-pwd"></i>
            <input class="txt-input" type="password" id="userpassword" name="userpassword" placeholder="密码" />

        </div>
        
        <div class="login-txtbox" id="login-txtbox2" >
            <input style="width:330px !important;" class="txt-input" type="text" id="code" name="code" placeholder='验证码' />
            <img src="/module/yzm/prove.php" onclick="this.src='/module/yzm/prove.php?t='+ Math.random()"/>
        </div>
        
        
        <div class="btn-login">
            <a href="javascript:document.frm_login.submit();" id="submit" name="Logon_ihu_yi_index_denglu002" class="login-submit">登　录</a>
        </div>
        
		    
        <div class="links-text">
            <a href="/regist/" class="link-left"  name="Logon_ihu_yi_index_denglu003" id="reg">注册账号</a>
            
        </div>
		           
        <div class="user-frd">
            <span>Copyright © 2003-2015 北京微优网络科技有限公司 版权所有</span>
        </div>
        </form>
    </div>


</div>

</body>
</html>