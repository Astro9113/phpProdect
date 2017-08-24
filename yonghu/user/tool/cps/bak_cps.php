<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=6;
$nav2=1;


if(isset($_GET['act']) && ($_GET['act']=='get_addon_list')){
    $shopid = intval($_GET['shopid']);
    $sql = "select title,file_index as findex,ad_img as img from wx_shop_addon where hide = 0 and shopid = '$shopid';";
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
    $key = '1-jumpdomain_2';
    $domain = get_config($key);

    $ad_type = $_POST['ad_type']; 
    $shopid = intval($_POST['shopid']);
    $findex = intval($_POST['findex']);
    
    $sql = "select title,file_index as findex,ad_img as img from wx_shop_addon where hide = 0 and shopid = '$shopid' and file_index = $findex;";
    $info = $mysql->find($sql);
    
    $addontitle = $info['title'];
    $addonimg = $info['img'];
    
    if($_POST['addontitle']){
        $addontitle = urldecode($_POST['addontitle']);        
    }
    
    if($_POST['addonimg']){
        $addonimg = urldecode($_POST['addonimg']);
    }
    
    $addontitle = urlencode($addontitle);
    
    $pwidth = isset($_POST['pwidth'])?$_POST['pwidth'].'px':'';
    $pheight = isset($_POST['pheight'])?$_POST['pheight'].'px':'';
    
    $args = "$shopid-$uid-0-$findex-";
    
$tpl = <<<EOF
<script>
function generateMixed(n) {
    var chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    var res = "";
    for (var i = 0; i < n ; i++) {
        var id = Math.ceil(Math.random() * 35);
        res += chars[id];
    }
    return res;
}

(function(){
var type = '{$ad_type}';
var randstr = generateMixed(4);
var randstr2 = generateMixed(4);
var randstr3 = generateMixed(4);

var link = 'http://'+randstr+'.{$domain}/5'+randstr2+'/?r={$args}'+randstr3;
var text = '{$addontitle}';
var img = '$addonimg';
var pwidth = '{$pwidth}';
var pheight = '{$pheight}';

if(type=='text'){
    var s = '<a href="'+link+'">'+decodeURI(text)+'</a>';
    document.write(s);
}

if(type=='img'){
    var s = '<a href="'+link+'"><img src="'+ img +'" width="'+pwidth+'" height="'+height+'" alt="'+decodeURI(text)+'" /></a>';
    document.write(s);
}

if(type=='text_img'){
    var s = '<a href="'+link+'">'+decodeURI(text)+'</a>';
    document.write(s);
    var s1 = '<a href="'+link+'"><img src="'+ img +'" width="'+pwidth+'" height="'+pheight+'" alt="'+decodeURI(text)+'" /></a>';
    document.write(s1);
}  
})()
 

    
</script>
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
<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
        	  <h3 class="zaixiancz-icon" style="background-position: 0 -300px;">推广工具</h3>
                <div class="vip-content-r-zijinsousuo" style="height: 1150px; min-width:1000px;">
                
                    <div class="chongzhitaocan">
                        
                        <span>商品</span>
                        <select name="shopid" id="shopid">
                        <option value="96" selected>英国卫裤</option>
                        <option value="50" selected>费洛蒙香水</option>
                        </select>
                        <br />
                        
                        <span>宣传文案</span>
                        <select name="addon" id="addon" style="width:200px;">
                        
                        </select>
                        <br />
                        
                        <div>
                        <input class="control" type="checkbox" name="user_title_control" id="user_title_control" value="1" />自定义标题
                        <input class="hide" type="text" name="user_title" id="user_title" />
                        </div>
                        
                        <div>
                        <input class="control" type="checkbox" name="user_pic_control" id="user_pic_control" />自定义图片
                        <input class="hide" type="text" name="user_pic" id="user_pic" />
                        </div>
                        
                        <div>
                                                                    宽度
                        <input type="text" name="pwidth" id="pwidth" />
                                                                    高度
                        <input type="text" name="pheight" id="pheight" />
                        </div>
                        
                        <div>
                                                                   广告类型
                        <input type="radio" value="text" name="ad_type" checked />文字广告
                        <input type="radio" value="img" name="ad_type"/>图片广告
                        <input type="radio" value="text_img" name="ad_type"/>图文广告
                        </div>
                        
                        
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
		
<?php require("../../wxdata/dx_foot.php");?>

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
.hide{display:none;}
.chongzhitaocan{width:45%;border:1px solid #666;float:left;padding:10px;line-height:1.6em;}
.pre_view{border:1px solid #666;width:45%;float:right;padding:10px;}
</style>
</body>
</html>