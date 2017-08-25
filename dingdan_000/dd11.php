<?php 
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

if(!$id){
    $id = 96;
    $userid = 1;
}


//商品信息
$sql=mysql_query("select * from wx_shop where id = $id limit 1");	
$info=mysql_fetch_array($sql);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
<meta content="telephone=no" name="format-detection">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>订单信息..</title>
<link href="/newcss/shop2.css" type="text/css" rel="stylesheet">
<script language="javascript">

function trim(str){ 
  return str.replace(/(^\s*)|(\s*$)/g, ""); 
}

function shoppk(){
    if(shop.skuid.value==""){
        alert("请选择一个商品规格！");
        return false;
    }

	if(shop.shopcolor.value==""){
	    alert("请选择颜色！");
	    return false;
	}

	if(shop.shopsize.value==""){
	    alert("请选择尺寸！");
	    return false;
	}

	if(trim(shop.guestname.value)==""){
		alert("请填写收货人名字！");
        return false;
	}
	if(trim(shop.guesttel.value).length != 11){
	    alert("请正确填写手机号！");
	    return false;
	}

	if(shop.guestsheng.value==""||shop.guestcity.value==""||shop.guestqu.value==""){
	    alert("请选择省市县！");
	    return false;
	}
	
	if(trim(shop.guestdizhi.value)==""){
	    alert("请填写详细收货地址！");
	    return false;
	}

}

</script>
</head>
<body>

<form id="form_buy" name="shop" method="post" action="/wxa/shoppd/">
<section class="item_sec">
	<div class="item_wrap rel">
		<?php 
		  $piclink = $info['shoppic'];
        ?>
		<img src="<?php echo $piclink;?>" width="100%">
		<p class="item_tle"><?php echo $info['shopname'];?></p>
        <input name="shopid" type="hidden" value="<?php echo $id;?>">
        <input name="userid" type="hidden" value="<?php echo $userid;?>">
        <input name="userwx" type="hidden" value="<?php echo $userwx;?>">
		<p class="item_pay">货到付款并包邮<span style="color: red;">（支持开箱验货）</span></p>
	
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
	               echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}' class='sku_cur'>{$shopsku[0]}</a></li>";
	           }else{//非默认
	               echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}'>{$shopsku[0]}</a></li>";
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
                echo "<li><a data-price='{$yijia}.00' data-color='{$shopcolor[$i]}'>{$shopcolor[$i]}</a></li>";
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
                echo "<li><a data-price='{$yijia}.00' data-size='{$shopsize[$i]}'>{$shopsize[$i]}</a></li>";
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
                    echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}' class='sku_cur'>{$shopsku[0]}</a></li>";
                }else{//非默认
                    echo "<li><a data-price='{$shopsku[1]}.00' data-sku='{$i}'>{$shopsku[0]}</a></li>";
                }
            }//
        }//循环结束
        echo '</ul>';
        echo '<input type="hidden" name="skuid" id="item_sku_id" value="'.$skumr.'">';
    }
  
?>



<p class="row">
<label>价　格 </label><input type="hidden" id="item_num" name="shopprice" value="1" /><span class="i_pri" id="item_price">￥<?php echo $yijia;?>.00</span></p>

</div>
</div>
</div>
</section>


<section class="item_sec">
	<div class="item_wrap add">
		<p class="row">
			<label for="name">收货人</label>
			<input required id="guestname" name="guestname" class="block input" tabindex="1" type="text" value="" />
		</p>
		<p class="row">
			<label for="tel">联系手机</label>
			<input required id="guesttel" name="guesttel" maxlength="11" class="block input" tabindex="2" type="tel" value="" />
		</p>
		<p class="row">
			<label for="province">选择地区</label>
			<select class="select" id="province" name="guestsheng" tabindex="3">
			</select><select class="select" id="city" name="guestcity" tabindex="4">
			</select><select class="select" id="area" name="guestqu" tabindex="5">
			</select>
		</p>
		<p class="row ">
			<label for="address">详细地址</label>
			<input required id="address" name="guestdizhi" class="block input" placeholder="街道门牌信息" tabindex="6" type="text" value="">
		</p>
        <p class="row row_area">
			<label for="beizhu">备注留言</label>
			<input id="beizhu" name="guestbeizhu" class="block input"  type="text" value="">
		</p>

		</div>
</section>
<footer>
	<img src="/newcss/082751438.png" style="width: 100%;" alt="">
	<button onClick="return shoppk()"  type="submit" class="c_txt orange_bg" id="buy_now" name="buy_now">提交订单</button>
    <p class="note">注：提交订单后会显示微信客服信息，若有疑问请关注咨询。</p>
	
</footer>
</form>


<script src="/newcss/shop1.js"></script>
<script src="/newcss/shop22.js"></script>
<script>
var pcas = new PCAS("province,省份","city,城市","area,地区");
var Item = {
	getItemInfo : function(){
		
		$(".sku_ul a").bind("click",function(){//尺码点击
			var o = $(this);
			if(!o.hasClass("sku_cur")){//点击的不是当前已经选中的
				$(".sku_cur").removeClass("sku_cur");
				o.addClass("sku_cur");
				/*更新对应的选中尺码的数据*/
				$("#item_price").html("￥"+ o.attr("data-price"));
				$("#item_num").val(1);
				$("#item_sku_id").val(o.attr("data-sku"));
				$("#item_color_id").val(o.attr("data-color"));
			}
		}),
		
		$(".sku_col a").bind("click",function(){//尺码点击
			var p = $(this);
			if(!p.hasClass("sku_cur1")){//点击的不是当前已经选中的
				$(".sku_cur1").removeClass("sku_cur1");
				p.addClass("sku_cur1");
				/*更新对应的选中尺码的数据*/
				$("#item_num").val(1);
				$("#item_color_id").val(p.attr("data-color"));
			}
		}),
		
		$(".sku_size a").bind("click",function(){//尺码点击
			var i = $(this);
			if(!i.hasClass("sku_cur2")){//点击的不是当前已经选中的
				$(".sku_cur2").removeClass("sku_cur2");
				i.addClass("sku_cur2");
				/*更新对应的选中尺码的数据*/
				$("#item_num").val(1);
				$("#item_size_id").val(i.attr("data-size"));
			}
		})
		
	},
	
	changeCount : function(){
		$("#item_num").bind("focusout",function(){
			var _this = $(this);
			var val = _this.val();
			if(!val){
				M._alert("数量不可为空");
				_this.val(1);
				return;
			}
			if(isNaN(val)){
				M._alert("数量必须为数字");
				_this.val(1);
				return;
			}
			if(Number(val) < 1){
				M._alert("客官至少买一件嘛");
				_this.val(1);
				return;
			}
			
			var _v = val;
			var noInt = false;
			if(_v.toString().indexOf(".") != -1){//有小数点 则先转化一下
				noInt = true;
				_v = Math.floor(val);//优化后的整数
			}
			noInt && M._alert("数量必须为整数");
			_this.val(_v);
		})
	},
	init : function(){
		Item.changeCount();
		Item.getItemInfo();
		$("#dsd").bind("click", function() {
			$(this).attr("disabled", "disabled");
			document.getElementById("form_buy").submit();
		});
	}
}
Item.init();
</script>

<script>
$(".sku_col a").eq(0).trigger('click');
$(".sku_size a").eq(1).trigger('click');
</script>

<?php
   $tourl=$_SERVER['HTTP_REFERER'];
   $tourl=substr($tourl,0,40);
   $sql=mysql_query("insert into wx_tongji(userid,wxid,shopid,tourl) values('$userid','$userwx','$id','$tourl')");
   mysql_close();

?>

<div style="display:none !important;">
</div>
</body>
</html>