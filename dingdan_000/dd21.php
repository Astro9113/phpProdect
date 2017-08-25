<?php 
ini_set('display_errors','On');
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}


$args = explode('-', $r);


//参数 = 商品 -用户 - 渠道 -时间

$id     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$time   = $args[3];


if(!$id){
    $id = 96;
    $userid = 2;
}

if(!$userid){
    $userid = 2;
}


//shop info
$sql=mysql_query("select shopname,shopcopy from wx_shop where id = $id");	
$info=mysql_fetch_assoc($sql);


//iframe 里面的下单
$domain = $vu_domain_zjxd_1 = '';
$arr = array(
    'vu_domain_zjxd_1'=>'直接下单一域名一',
);


$target = get_mid($userid);

foreach ($arr as $k=>$v){
    $$k = get_config($target.'-'.$k);
    $$k = $$k?$$k:get_config('1-'.$k);
}

$domain = $vu_domain_zjxd_1;
$randPath = '0'.rand_str(rand(3, 8));

$dd_page = 'http://'.rand_str(4).'.'.$domain.'/'.$randPath.'/?r='.$r;
?>


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
 <iframe onload="javascript:iFrameHeight()" name="ifbox" id="ifbox" src="<?php echo $dd_page;?>" width="100%" height="1200px" frameBorder=0 scrolling=no></iframe>
</ARTICLE>

</DIV>
<NAV>
<UL class="Transverse">
  <LI><A href="#showcontent"><STRONG>产品参数</STRONG></A></LI>
  <LI><A href="#buy" id="dbuy"><STRONG>立即订购（货到付款）</STRONG></A></LI>
</UL>
</NAV>

 <div style="display:none;"></div>
  
  
<script>
$(function(){
	$("#dbuy").click(function(){
		$(this).parent().parent().parent().hide();
	});
})
</script>  
</body>
</html>
<?php mysql_close();?>