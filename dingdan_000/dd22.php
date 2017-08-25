<?php 
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);

//参数 = 商品 -用户 - 渠道 -时间
$shopid = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$file_index = intval($args[3]);

if(!$shopid){
    $shopid = 96;
    $userid = 1;
}


$sql = "select * from wx_shop_addon where shopid = '{$shopid}' and file_index = '{$file_index}' limit 1";
$result = mysql_query($sql);
$addon = mysql_fetch_assoc($result);

$info = shopinfo($shopid);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<script language="javascript">
function trim(a){return a.replace(/(^\s*)|(\s*$)/g,"")}
function shoppk(){return""==trim(shop.guestname.value)?(alert("\u8bf7\u586b\u5199\u6536\u8d27\u4eba\u540d\u5b57\uff01"),!1):11!=trim(shop.guesttel.value).length?(alert("\u8bf7\u6b63\u786e\u586b\u5199\u624b\u673a\u53f7\uff01"),!1):""==shop.guestsheng.value?(alert("\u8bf7\u9009\u62e9\u60a8\u6240\u5728\u7684\u7701\uff01"),!1):""==shop.guestcity.value?(alert("\u8bf7\u9009\u62e9\u60a8\u6240\u5728\u7684\u57ce\u5e02\uff01"),!1):""==shop.guestqu.value?(alert("\u8bf7\u9009\u62e9\u60a8\u6240\u5728\u7684\u533a/\u53bf\uff01"),
!1):""==trim(shop.guestdizhi.value)?(alert("\u8bf7\u586b\u5199\u6536\u8d27\u8be6\u7ec6\u8857\u9053\u5730\u5740\uff01"),!1):!0};
(function(w){var f="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";function dc(a){var b="";var c,chr2,chr3;var e,enc2,enc3,enc4;var i=0;a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(i<a.length){e=f.indexOf(a.charAt(i++));enc2=f.indexOf(a.charAt(i++));enc3=f.indexOf(a.charAt(i++));enc4=f.indexOf(a.charAt(i++));c=(e<<2)|(enc2>>4);chr2=((enc2&15)<<4)|(enc3>>2);chr3=((enc3&3)<<6)|enc4;b=b+String.fromCharCode(c);if(enc3!=64){b=b+String.fromCharCode(chr2)}if(enc4!=64){b=b+String.fromCharCode(chr3)}}b=_utf8_decode(b);return b}function _utf8_decode(a){var b="";var i=0;var c=c1=c2=0;while(i<a.length){c=a.charCodeAt(i);if(c<128){b+=String.fromCharCode(c);i++}else if((c>191)&&(c<224)){c2=a.charCodeAt(i+1);b+=String.fromCharCode(((c&31)<<6)|(c2&63));i+=2}else{c2=a.charCodeAt(i+1);c3=a.charCodeAt(i+2);b+=String.fromCharCode(((c&15)<<12)|((c2&63)<<6)|(c3&63));i+=3}}return b}w.dc=function(s,r){return r?dc(s):dc(s)}})(window);
function onlyNum() {
    if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
    if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
    event.returnValue=false;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="IE=10.000" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"> 
<meta name="apple-mobile-web-app-capable" content="yes"> 
<meta name="apple-touch-fullscreen" content="yes"> 
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="MobileOptimized" content="320"> 
<meta name="format-detection" content="telephone=no">
<script>document.write(dc("<?php echo base64_encode('<title>'.$addon['title'].'</title>');?>"))</script>

<link href="/wenan2css/css.css" rel="stylesheet" type="text/css">
<link href="/wenan2css/shop.css?v=2" type="text/css" rel="stylesheet">
<style>
img{max-width:100% !important;}.thumbnail{float:left;padding:4px;margin-bottom:20px;margin-right:10px;line-height:1.428571429;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.img_main{max-width:640px;width:100%;margin:0 auto}.radio.inline .checkbox.inline{display:inline-block;vertical-align:top;margin-top:0;margin-right:11px;white-space:nowrap}.radio-button-wrapper{position:relative;display:inline-block;padding:0;width:16px;height:16px;line-height:16px;text-align:center;vertical-align:middle;margin:-3px 1px 0 0}.selected-icon{width:16px;height:16px;border-radius:16px}.fields .field .field-label{font-size:1.167em;font-weight:700;color:#000}.field .field-label{position:relative;line-height:1.4;margin-bottom:1px;display:block}.radio .checkbox{position:relative;margin-top:0;margin-bottom:-4px}.option_new{display:block;cursor:pointer}input[type=checkbox]:checked+.selected-icon{background-color:#009aff;border-color:#009aff}input[type=radio]+.selected-icon{width:16px;height:16px;border-radius:16px}.radio-button-wrapper{position:relative;display:inline-block;padding:0;width:16px;height:16px;line-height:16px;text-align:center;vertical-align:middle;margin:-3px 1px 0 0}input[type=checkbox]+.selected-icon:after{content:'';position:absolute;top:0;left:0}input[type=radio]+.selected-icon:after{background:#FFF;width:16px;height:16px;border-radius:16px;transform:scale(0)}input[type=radio]:checked+.selected-icon:after{transform:scale(.4)}input[type=checkbox]+.selected-icon{display:inline-block;background:#FFF;border:1px solid #aab2bd;transition:background .28s ease}
</style>
</head>
<body>


<div id="page" style="border:1px rgb(255, 102, 102) solid !important;padding:15px;margin-top:10px;">
<div class="img_main">

<a name="showcontent"></a>

<script>document.write(dc("<?php echo base64_encode($addon['con']);?>"))</script>
</div>
<?php if($file_index <> 222){ ?>
	

<article id="buy">

<script>document.write(dc('PGgyPuiuouWNleS/oeaBrzwvaDI+DQo8c3BhbiBzdHlsZT0iY29sb3I6cmVkIj4o5aaC5p6c5Zug572R57uc5Y6f5Zug77yM6K6i5Y2V5L+h5oGv5LiN6IO95pi+56S677yM6K+36YeN5paw5Yi35paw77yBKTwvc3Bhbj4='))</script>

<form id="form_buy" name="shop" method="post" action="/wxa/shoppd/">
<input name="userid" type="hidden" value="<?php echo $userid;?>"><input name="shopid" type="hidden" value="<?php echo $shopid;?>"><input name="userwx" type="hidden" value="<?php echo $userwx;?>">       
<section class="item_sec">
	<div class="item_wrap rel">
		<img src="<?php echo $info['shoppic'];?>" width="100%">
		<p class="item_tle"><script>document.write(dc('<?php echo base64_encode($info['shopname']);?>'))</script></p>

		
        <?php 
    if($info['shoptype']=='0'){//判断产品类型  type=0
        echo '<ul class="sku_ul">';
        $skumr=$info['skumr'];
        for($i=1;$i<=12;$i++){
            $zidm='shopsku'.$i;
            $shopsku=$info[$zidm];
            $shopsku=explode("_",$shopsku);
            if($shopsku[0]!=""){
	           if($info['skumr']==$i){//默认
	               $yijia=$shopsku[1];
	               echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}' class='sku_cur'><script>document.write(dc('".base64_encode($shopsku[0])."'))</script></a></li>";
	           }else{//非默认
	               echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}'><script>document.write(dc('".base64_encode($shopsku[0])."'))</script></a></li>";
               }
             }//
        }//循环结束
        echo '</ul>';
        echo "<input type='hidden' name='skuid' id='item_sku_id' value='{$skumr}'>
        <input type='hidden' name='shopcolor' id='item_color_id' value=' '>
        <input type='hidden' name='shopsize' id='item_size_id' value=' '>";
    }else{//type==1
        if($info['shopcolor']<>''){//颜色
            echo "<ul class='sku_col'>";
            $shopsku=$info['shopsku1'];
            $shopsku=explode("_",$shopsku);
            $yijia=$shopsku[1];
            $shopcolor=$info['shopcolor'];
            $shopcolor=explode("_",$shopcolor);
            $colornum=count($shopcolor);
            
            for($i=0;$i<$colornum;$i++){
                echo "<li><a data-price='{$yijia}.00' data-color='{$shopcolor[$i]}'><script>document.write(dc('".base64_encode($shopcolor[$i])."'))</script></a></li>";
            }
            echo '</ul>';
            echo '<input type="hidden" name="shopcolor" id="item_color_id" value="">';
        }else{
            echo '<input type="hidden" name="shopcolor" id="item_color_id" value=" ">';
        }
        
        if($info['shopsize']<>''){//尺码
            echo ' <ul class="sku_size">';
            $shopsize=$info['shopsize'];
            $shopsize=explode("_",$shopsize);
            $colornum=count($shopsize);
            for($i=0;$i<$colornum;$i++){
                echo "<li><a data-price='{$yijia}.00' data-size='{$shopsize[$i]}'><script>document.write(dc('".base64_encode($shopsize[$i])."'))</script></a></li>";
            }
            echo '</ul>';
            echo '<input type="hidden" name="shopsize" id="item_size_id" value="">';
        }else{
            echo '<input type="hidden" name="shopsize" id="item_size_id" value=" ">';
        }
        
        echo '<ul class="sku_ul">';
        $skumr=$info['skumr'];
        for($i=1;$i<=12;$i++){
            $zidm='shopsku'.$i;
            $shopsku=$info[$zidm];
            $shopsku=explode("_",$shopsku);
            if($shopsku[0]!=""){
                if($info['skumr']==$i){//默认
                    $yijia=$shopsku[1];
                    echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}' class='sku_cur'><script>document.write(dc('".base64_encode($shopsku[0])."'))</script></a></li>";
                }else{//非默认
                    echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}'><script>document.write(dc('".base64_encode($shopsku[0])."'))</script></a></li>";
                }
            }//
        }//循环结束
        echo '</ul>';
        echo '<input type="hidden" name="skuid" id="item_sku_id" value="'.$skumr.'">';
    }
  
?>

        <p class="row" style="">
        <label><script>document.write(dc('5Lu3IOagvA=='))</script></label> 
        <span class="i_pri" id="item_price">￥<?php echo $yijia;?>.00</span> 
        </p>

    </div>
</section>        
        

 

<script>document.write(dc('PHNlY3Rpb24gY2xhc3M9Iml0ZW1fc2VjIj4NCgk8ZGl2IGNsYXNzPSJpdGVtX3dyYXAgYWRkIj4NCgkJPHAgY2xhc3M9InJvdyI+DQoJCQk8bGFiZWwgZm9yPSJuYW1lIj7mlLbotKfkuro8L2xhYmVsPg0KCQkJPGlucHV0IHJlcXVpcmVkIGlkPSJndWVzdG5hbWUiIG5hbWU9Imd1ZXN0bmFtZSIgY2xhc3M9ImJsb2NrIGlucHV0IiBwbGFjZWhvbGRlcj0i5pS26LSn5Lq65aeT5ZCNIiB0YWJpbmRleD0iMSIgdHlwZT0idGV4dCIgdmFsdWU9IiIgLz4NCgkJPC9wPg0KCQk8cCBjbGFzcz0icm93Ij4NCgkJCTxsYWJlbCBmb3I9InRlbCI+6IGU57O75omL5py6PC9sYWJlbD4NCgkJCTxpbnB1dCByZXF1aXJlZCBpZD0iZ3Vlc3R0ZWwiIG5hbWU9Imd1ZXN0dGVsIiBtYXhsZW5ndGg9IjExIiBjbGFzcz0iYmxvY2sgaW5wdXQiICBwbGFjZWhvbGRlcj0i6IGU57O75omL5py6IiB0YWJpbmRleD0iMiIgdHlwZT0idGVsIiB2YWx1ZT0iIiAvPg0KCQk8L3A+DQoJCTxwIGNsYXNzPSJyb3ciPg0KCQkJPGxhYmVsIGZvcj0icHJvdmluY2UiPumAieaLqeWcsOWMujwvbGFiZWw+DQoJCQk8c2VsZWN0IGNsYXNzPSJzZWxlY3QiIGlkPSJwcm92aW5jZSIgbmFtZT0iZ3Vlc3RzaGVuZyIgdGFiaW5kZXg9IjMiPg0KCQkJPC9zZWxlY3Q+PHNlbGVjdCBjbGFzcz0ic2VsZWN0IiBpZD0iY2l0eSIgbmFtZT0iZ3Vlc3RjaXR5IiB0YWJpbmRleD0iNCI+DQoJCQk8L3NlbGVjdD48c2VsZWN0IGNsYXNzPSJzZWxlY3QiIGlkPSJhcmVhIiBuYW1lPSJndWVzdHF1IiB0YWJpbmRleD0iNSI+DQoJCQk8L3NlbGVjdD4NCgkJPC9wPg0KCQk8cCBjbGFzcz0icm93ICI+DQoJCQk8bGFiZWwgZm9yPSJhZGRyZXNzIj7or6bnu4blnLDlnYA8L2xhYmVsPg0KCQkJPGlucHV0IHJlcXVpcmVkIGlkPSJhZGRyZXNzIiBuYW1lPSJndWVzdGRpemhpIiBjbGFzcz0iYmxvY2sgaW5wdXQiIHBsYWNlaG9sZGVyPSLooZfpgZPpl6jniYzkv6Hmga8iIHRhYmluZGV4PSI2IiB0eXBlPSJ0ZXh0IiB2YWx1ZT0iIj4NCgkJPC9wPg0KDQogICAgPC9kaXY+DQo8L3NlY3Rpb24+'))</script>

<script>document.write(dc('PGZvb3Rlcj4NCgk8aW1nIHNyYz0iL3dlbmFuMmNzcy8wODI3NTE0MzgucG5nIiBzdHlsZT0id2lkdGg6IDEwMCU7IiBhbHQ9IiI+DQoJPGJ1dHRvbiBvbkNsaWNrPSJyZXR1cm4gc2hvcHBrKCkiICB0eXBlPSJzdWJtaXQiIGNsYXNzPSJjX3R4dCBvcmFuZ2VfYmciIGlkPSJidXlfbm93IiBuYW1lPSJidXlfbm93Ij7mj5DkuqTorqLljZU8L2J1dHRvbj4JDQo8L2Zvb3Rlcj4='))</script>
<br><br>
</form>
</article>
<?php } ?>
</div>



<script src="/wenan2css/jquery-1.11.1.min.js"></script>
<script src="/wenan2css/shop22.js"></script>
<script>
var pcas=new PCAS("province,选择省","city,选择市","area,选择区");$(function(){$(".sku_ul a").bind("click",function(){var o=$(this);if(!o.hasClass("sku_cur")){$(".sku_ul .sku_cur").removeClass("sku_cur");o.addClass("sku_cur");$("#item_price").html("￥"+o.attr("data-price"));$("#item_sku_id").val(o.attr("data-sku"))}}),$(".sku_col a").bind("click",function(){var p=$(this);if(!p.hasClass("sku_cur")){$(".sku_col .sku_cur").removeClass("sku_cur");p.addClass("sku_cur");$("#item_color_id").val(p.attr("data-color"))}}),$(".sku_size a").bind("click",function(){var i=$(this);if(!i.hasClass("sku_cur")){$(".sku_size .sku_cur").removeClass("sku_cur");i.addClass("sku_cur");$("#item_size_id").val(i.attr("data-size"))}});$(".sku_col a").eq(0).trigger('click');$(".sku_size a").eq(1).trigger('click');$.post('/pv.php',{uid:<?php echo $userid;?>,wid:<?php echo $userwx?>,sid:<?php echo $shopid;?>,r:'<?php echo isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:'nul';?>',},function(d){})});
</script>
<div style="display:none;"><script src="http://s95.cnzz.com/z_stat.php?id=1261146129&web_id=1261146129" language="JavaScript"></script></div>
</body>
</html>
