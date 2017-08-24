<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=6;
$nav2=1;


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
                        
                        <p><a class="t_link" href="cps_1.php"> ① 纯文本 广告</a>  
                        <span style="font-size:9pt;"><a target="_blank" href="preview.php?type=1">效果预览</a></span></p>
                        <p><a class="t_link" href="cps_2.php"> ① 单图文 广告</a>
                        <span style="font-size:9pt;"><a target="_blank" href="preview.php?type=2">效果预览</a></span></p>
                        <p><a class="t_link" href="cps_3.php"> ① 三图文 广告</a>
                        <span style="font-size:9pt;"><a target="_blank" href="preview.php?type=3">效果预览</a></span></p>
                        <p><a class="t_link" href="cps_img.php"> ① 纯图片 广告</a>
                        <span style="font-size:9pt;"><a target="_blank" href="preview.php?type=img">效果预览</a></span></p>
                        
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
		var options = ''; 
		for(var i=0;i<data.length;i++){
			title  = data[i].title;
			findex = data[i].findex;
			option = '<option value="'+ findex +'">'+ title +'</option>';
			options += option;
		}
		$("#addon").html(options);
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
	//初始化文案列表
	get_arc_list();
    
    //商品绑定
    $("#shopid").change(function(){
    	get_arc_list();    
    });

    //自定义控制
    $(".control").click(function(){
        if($(this).prop('checked')==true){
            $(this).parent().children("input[type='text']").show();
        }else{
            $(this).parent().children("input[type='text']").hide();
        }   
    })

    $("#make").click(function(){
        var ad_type,shopid,addon,addontitle,addonimg,user_title_control,
        user_title,user_pic_control,user_pic,pwidth,pheight;
        
        ad_type = $("input[name='ad_type']").filter(':checked').val();
        shopid = $("#shopid").val();
        findex = $("#addon").val();
        //var info = get_arc_info();
        //addontitle = info.title;
        //addonimg = info.img;

        if($("#user_title_control").prop('checked')){
        	addontitle = $("#user_title").val();
        }

        if($("#user_pic_control").prop('checked')){
            addonimg = $("#user_pic").val();
        }

        pwidth = $("#pwidth").val();
        pheight = $("#pheight").val();

        //var ajax_url = '?act=make';
        
        $.ajax({
           cache: false,
  		   async: false,
  		   type: 'post',
  		   url: 'cps.php',
  		   data:{shopid:shopid,findex:findex,ad_type:ad_type,addontitle:addontitle,addonimg:addonimg,pwidth:pwidth,pheight:pheight,act:'make'},
  		   //dataType:'string',
  		   success: function (data) {
  			   $("#code").html(data);
  		   },
        });
    });
	
})
</script>
<style>
.t_link{color:#000 !important;}
.hide{display:none;}
.chongzhitaocan{color:#000 !important;width:45%;border:1px solid #666;float:left;padding:10px;line-height:1.6em;}
.pre_view{border:1px solid #666;width:45%;float:right;padding:10px;}
</style>
</body>
</html>