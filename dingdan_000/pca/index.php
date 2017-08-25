<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META content="IE=10.000" http-equiv="X-UA-Compatible">
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">  
<META name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"> 
<META name="apple-mobile-web-app-capable" content="yes"> 
<META name="apple-touch-fullscreen" content="yes"> 
<META name="apple-mobile-web-app-status-bar-style" content="black"> 
<META name="MobileOptimized" content="320"> 
<META name="format-detection" content="telephone=no">

<?php
  include("../wxdata/sjk1114.php");

		$id = trim($_GET ['s']);
		$userid = trim($_GET ['u']);
		$userwx = trim($_GET ['w']);
		
		
		
		//开始做安全域名判断 不一致则跳转
		//加在下单首页  /wxa/index.php

		//end
		
		
		
		$id2 = intval(base64_decode($id));
		

  
  $sql=mysql_query("select shopname,shopcopy from wx_shop where id=$id2");	
  $info=mysql_fetch_assoc($sql);
  //echo $info['shopcopy'];
?>


<SCRIPT src="/pca/js/jquery.js" type="text/javascript"></SCRIPT>
<SCRIPT src="/pca/js/time.lesser.js" type="text/javascript"></SCRIPT>
<link href="/pca/css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<DIV id="page">

<?php 
    echo $info['shopcopy'];
?>


<script>
 //页面自适应
        function iFrameHeight() {
            var ifm = document.getElementById("ifbox");
            var subWeb = document.frames ? document.frames["ifbox"].document : ifm.contentDocument;
            if (ifm != null && subWeb != null) {
                ifm.height = subWeb.body.scrollHeight;
            }
        } 
</script>

<ARTICLE id="buy">
<H2>订单信息</H2>
 <iframe onload="javascript:iFrameHeight()" name="ifbox" id="ifbox" src="/wxa/<?php echo $id;?>/<?php echo $userid;?>/<?php if($userwx){echo $userwx; }?>" width="100%" frameBorder=0 scrolling=no></iframe>
</ARTICLE>

</DIV>
<NAV>
<UL class="Transverse">
  <LI><A href="#showcontent"><STRONG>产品参数</STRONG></A></LI>
  <LI><A href="#buy"><STRONG>立即订购（货到付款）</STRONG></A></LI></UL></NAV>

 <div style="display:none;"></div>
  
</body>
</html>
