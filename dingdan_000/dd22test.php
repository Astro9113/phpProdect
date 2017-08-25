<?php 
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);

//参数 = 商品 -用户 - 渠道 -时间
$shopid     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$file_index = intval($args[3]);

if(!$shopid){
    $shopid = 96;
    $userid = 1;
}


$sql = "select * from wx_shop_addon where shopid = '{$shopid}' and file_index = '{$file_index}'";
$result = mysql_query($sql);
$info = mysql_fetch_assoc($result);


?>


<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <title>
		<?php 
		//$tituserid = array(1200,1155,1524,1167,1217,948,1147,1182,947,1726,1682,1196,1788,1988,2019);
		//if(in_array($userid, $tituserid)){
        echo $info['title'];
       //}else{
		 //echo ';';
	   //}
		?>
        </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
        <link rel="stylesheet" href="http://vujiasu.b0.upaiyun.com/upload/160225/104406706.css" />
        <style type="text/css">
            body {
            margin: 10px 10px;
            background-image: none;
            background-color: #fff;
            }
            h5{font-weight:bold;font-size:12px;}
            .small{font-size:12px;color:#808080}
            .lh40{margin-top:5px;margin-bottom:5px;}
            .pl0{padding-left:0px;}
            .price {padding-left:10px;height:34px;line-height:34px;font-size:16px;}
            .price strong {color:#d02d1a;font-weight:normal;}
            .mt10{margin-top:10px;}
            .mt20{margin-top:20px;}
            .mt-20{margin-top:-20px;}
            #order-btn {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 20px;
            margin-top:15px;
            }
			.yinq{display:none;}
        </style>
    </head>
    <body>
	<a name="showcontent"></a>
    
     <div class="yinq">
 一只蜻蜓飞来了。小猫看见了，放下钓鱼
竿，就去捉蜻蜓。蜻蜓飞走了，小猫没捉着，空着手回到河边来。小猫一看，
老猫钓着了一条大鱼。
    </div>

    <div class="panel panel-info">
        <div class="panel-body" style="padding:0px;">			
			
			
			<div class="rich_media_content" id="js_content" style="margin: 0px; padding: 0px; overflow: hidden; color: rgb(62, 62, 62); position: relative; min-height: 350px; font-family: &#39;Helvetica Neue&#39;, Helvetica, &#39;Hiragino Sans GB&#39;, &#39;Microsoft YaHei&#39;, Arial, sans-serif; line-height: 25px; white-space: normal;">

<?php echo $info['con'];?>

</div>
        </div>
    </div>
    
     <div class="yinq">
清晨，太阳刚刚升起，湖面上飘着薄薄的雾。天边的星晨和山上的点点灯光，隐隐约约地倒映在湖水中。
　　中午，太阳高照，整个日月潭的美景和周围的建筑，都清晰地展现在眼前。要是下起蒙蒙细雨，日月潭好像披上轻纱，周围的景物一片朦胧，就像童话中的仙境。
　　日月潭风光秀丽，吸引了许许多多中外游人。 
    </div>
    
    <a name="buy"></a>
    <form name="shop" method="post" class="form parsley-form" action="/wxa/shoppd/index.php">
	<input type="hidden" name="shopid" id="shopid" value="<?php echo $shopid;?>">
	<input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>">
	<input type="hidden" name="userwx" id="userwx" value="<?php echo $userwx;?>">
	
	
        <?php echo $info['skus'];?>
        
        <!-- /#portlet-header -->

        <div class="panel panel-info mt10">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-user"></i>
                    收货人信息
                </h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <input value="" autocomplete="off" data-required-message="请填写收货人" data-required="true" placeholder="收货人" name="guestname" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <input value="" autocomplete="off" data-required-message="请填写手机号" data-required="true" placeholder="手机号" name="guesttel" type="text" class="form-control" />
                </div>
                <div class="row">
                    <!-- 省/直辖市 -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select id="province" name="guestsheng" tabindex="3" class="form-control ui-select2"></select>
                        </div>
                    </div>
                    <!-- 市 -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select id="city" name="guestcity" tabindex="4" class="form-control ui-select2"></select>
                        </div>
                    </div>
                    <!-- 区/县 -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select id="area" name="guestqu" tabindex="5" class="form-control ui-select2"></select>
                        </div>
                    </div>
                </div>
                <!-- /#region -->
                <div class="form-group">
                    <input value="" autocomplete="off" data-required-message="请填写详细街道地址" data-required="true" placeholder="详细街道地址" name="guestdizhi" type="text" class="form-control" />
                </div>

            </div>
            <!-- /#portlet-content -->
        </div>
        <button type="submit" id="order-btn" class="btn btn-lg btn-block btn-primary">提交订单</button>
    </form>
    <div class="alert alert-warning mt10">
        提交订单后，客服将会与你联系进行确认，请保持手机通讯畅通。
    </div>


	<script src="http://tiantian62.b0.upaiyun.com/PCASClass.js"></script>

    <script type="text/javascript">

		function init_events() {

            var $label = $("input[name='skuid']").parent('label').click(function () {
                var self = $(this);
                var value = self.find('input').attr('data');
                $('.price strong').html('<i class="fa fa-cny"></i> ' + value);
                self.parent().find('.active').removeClass('active');
                self.addClass('active');
            });
            

            var $label = $("input[type='radio']").parent('label').click(function () {
                var self = $(this);
                self.parent().find('.active').removeClass('active');
                self.addClass('active');
            });
            

            $('img').css('max-width', '100%');
            if ($(document.body).width() > 700) {
                $(document.body).css({
                    'width': '700px',
                    'margin': '0px auto',
                });
            }

			var pcas = new PCAS("province,省 必选","city,市 必选","area,区 必选");//地区
        };
    </script>




    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script type="text/javascript">
        $(function () {
            init_events();

            $("#order-btn").click(function(){
                if(shop.guestname.value==''){
                    alert('请填写收货人');
                    shop.guestname.focus();
                    return false;
                }

                if($.trim(shop.guesttel.value).length !=11){
                    alert('手机号不是11位，请检查');
                    shop.guesttel.focus();
                    return false;
                }

                if(shop.guestsheng.value==''){
                    alert('请选择省份');
                    shop.guestsheng.focus();
                    return false;
                }

                if(shop.guestcity.value==''){
                    alert('请选择市');
                    shop.guestcity.focus();
                    return false;
                }

                if(shop.guestqu.value==''){
                    alert('请选择区');
                    shop.guestqu.focus();
                    return false;
                }
                
                if(shop.guestdizhi.value==''){
                    alert('请填写详细街道地址');
                    shop.guestdizhi.focus();
                    return false;
                }

                
            });
            
        });
    </script>
    
    

<div style="position: fixed; bottom: 5px; width: 100%; left: 0px; display: block;" id="buy_button">
    <a href="#buy" class="btn btn-block btn-danger btn-lg" style="font-size:18px;">
        立即购买
    </a>
</div>
    
<style>
        body>#buy_button{
            background-color:#D45353;
            font-size:16px;
            line-height:40px;
            text-align:center;
            border-radius: 3px;
        }
        body>#buy_button:hover{
            background-color:#EE3D3D;
        }
        body>#buy_button>a{
            color:#fff;
        }
</style>

<script>
    var btn = $('body>#buy_button');
    var count = 100;
    btn.click(buy_button);
    $(window).scroll(function(){
        var h = $('.rich_media_content').height()* 0.9;
         if( $(this).scrollTop() > h ){
            buy_button();
           }else{
            btn.css('display','block');
         }
    });
    function buy_button(){
        btn.css('display','none');
    }
</script>

	
<div style="display:none">

</div>
</body>
</html>
<?php
   $tourl=$_SERVER['HTTP_REFERER'];
   $tourl=substr($tourl,0,40);
   $sql=mysql_query("insert into wx_tongji(userid,wxid,shopid,tourl) values('$userid','$userwx','$shopid','$tourl')");
?>