<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=6;
$nav2=1;

if(isset($_GET['act']) && ($_GET['act']=='get_addon_list')){
    $shopid = intval($_GET['shopid']);
    $sql = "select title,file_index as findex,ad_img_heng as img from wx_shop_addon where hide = 0 and shopid = '$shopid';";
    $infos = $mysql->query($sql);
    echo json_encode($infos);
    exit;
}

if(isset($_GET['act']) && ($_GET['act']=='get_addon_info')){
    $shopid = intval($_GET['shopid']);
    $findex = intval($_GET['findex']);
    $sql = "select title,file_index as findex,ad_img as img from wx_shop_addon where hide = 0 and shopid = '$shopid' and file_index = $findex;";
    $infos = $mysql->find($sql);
    echo json_encode($infos);
    exit;
}

if(isset($_POST['act']) && ($_POST['act']=='make')){
    $key = '1-domain-ad-js';
    $domain = get_config($key);
    //$domain = 'aa.com';
    $shopid = intval($_POST['shopid']);
    $findex = intval($_POST['findex']);
   
    $rand = rand_str(4);
    
$tpl = <<<EOF
<script type="text/javascript" src="http://{$rand}.{$domain}/abs/imgs.php?type=1&uid={$uid}&cid=0&pid={$shopid}&findex={$findex}"></script>
EOF;
    
    echo htmlentities($tpl,ENT_COMPAT,'UTF-8');
    //echo $tpl;
    exit;
}


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优 - 推广工具</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require(ROOT ."wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require(ROOT."wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require(ROOT."wxdata/dx_mid.php");?>
        	  <h3 class="zaixiancz-icon" style="background-position: 0 -300px;">推广工具</h3>
                <div class="vip-content-r-zijinsousuo" style="height: 1150px; min-width:1000px;">
                
                    <div class="chongzhitaocan">
                        <form action="" method="post">
                        
                        
                        <span>商品</span>
                        <select name="shopid" id="shopid">
                        <option value="119" selected>英国vk</option>
                        <option value="96" selected>英国卫裤</option>
                        <option value="50" selected>费洛蒙香水</option>
                        <option value="109" selected>印度神油</option>
                        </select>
                        <br />
                        
                        <span>宣传文案</span>
                        <select name="addon" id="addon" style="width:200px;">
                        
                        </select>
                        <br />
                        
                        <span>广告图片</span>
                        <img id="ad_img_heng" src="#" style="height:100px;width:550px;"/>
                        <br />
                        
                        
                        <div>
                            <button id="make" type="button">生成</button>
                        </div>
                        
                    </div>
                    
                    <div class="pre_view">
                    <p>
                    <textarea id="code" style="width:100%;height:300px;"></textarea>
                    </p>
                        
                    </div>
                </div>
                   
            </div>               
		
<?php require(ROOT."wxdata/dx_foot.php");?>

<script>

function get_arc_list(){
	var shopid = $("#shopid").val();
	var ajax_url = '?act=get_addon_list&shopid='+shopid;
	$.get(ajax_url,function(data){
	    var option = title = findex = '';
		var options = imgs = ''; 
		for(var i=0;i<data.length;i++){
			title  = data[i].title;
			findex = data[i].findex;
			img = data[i].img;
			option = '<option value="'+ findex +'" data-i="'+i+'">'+ title +'</option>';
			hideimg = '<input type="hidden" id="a_img_'+i+'"value="'+img+'">';  
			options += option;
			imgs += hideimg;
		}
		
		$("#addon").html(options);
		$("#hideimg").html(imgs);
		$("#ad_img_heng").attr('src',data[0].img);
	},'json');
}

function get_arc_info(){
	var shopid = $("#shopid").val();
	var addon = $("#addon").val();
	var ajax_url = '?act=get_addon_info&shopid='+shopid+'&findex='+addon;
	var info;
	$.ajax({
		   cache: false,
		   async: false,
		   type: 'get',
		   url: ajax_url,
		   dataType:'json',
		   success: function (data) {
			   info = data;
		   },
	});
	return info;       
}

$(function(){
	get_arc_list();

    $("#shopid").change(function(){
    	get_arc_list();    
    });

    $("#addon").change(function(){
    	var imgindex = $(this).children('option:selected').attr('data-i');
    	console.log(imgindex);
    	var imgsrc = $("#a_img_"+imgindex).val();
    	console.log(imgsrc);
    	$("#ad_img_heng").attr('src',imgsrc);    
    });

    $("#make").click(function(){
        var ad_type,shopid,addon,addontitle,addonimg,user_title_control,
        user_title,user_pic_control,user_pic,pwidth,pheight;
        
        shopid = $("#shopid").val();
        findex = $("#addon").val();

        $.ajax({
           cache: false,
  		   async: false,
  		   type: 'post',
  		   url: 'cps_img.php',
  		   data:{shopid:shopid,findex:findex,act:'make'},
  		   success: function (data) {
  			   $("#code").html(data);
  		   },
        });
    });
	
})

</script>

<style>
.hide{display:none;}
.chongzhitaocan{width:55%;border:1px solid #666;float:left;padding:10px;line-height:1.6em;}
.pre_view{border:1px solid #666;width:35%;float:right;padding:10px;}
</style>
<div style="display:none;" id="hideimg">

</div>
</body>
</html>