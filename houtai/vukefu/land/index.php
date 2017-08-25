<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>管理员中心登陆</title>
<link rel="stylesheet" href="/css/main.css" />
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<div id="top">
	<div class="top"><img src="/images/logo.png">微信公众号盈利平台</div>
</div><div id="wrap" class="clearfix" style="margin:30px auto; padding-left:92px;">
 <img class="fl" src="../../images/kefubogin.jpg" />
 <div class="login height280">
  <form id="login" method="POST" action="provepd/">
	<h3>用心从这里开始</h3>
	<p>账 号：&nbsp;&nbsp;&nbsp;<input type="text" name="kefuloginname" /></p>
	<p>密 码：&nbsp;&nbsp;&nbsp;<input type="password" name="kefupassword" /></p>
    <p>验证码：<input type="text" name="provemanag" style="width:70px; margin-left:7px; margin-right:8px;"/><img src="/module/yzm/prove.php" name="validitpic" align="absmiddle" onclick="this.src='/module/yzm/prove.php?t='+ Math.random()" /></p>
    <p>客服码：<input type="text" name="kfyzm" style="width:70px; margin-left:7px; margin-right:8px;"/></p>
	<div class="sub"><button class="big" type="submit">登&nbsp;&nbsp;录</button></div>
  </form>
 </div>
</div>
<div id="footer">
<p>北京微优网络科技有限公司</p>
</div>
</body>
</html>