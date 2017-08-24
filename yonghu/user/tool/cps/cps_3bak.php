<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$user11id = $uid = $_SESSION['user1114id'];

$nav1=6;
$nav2=1;

if(isset($_POST['act']) && ($_POST['act']=='make')){
    $key = '1-domain-ad-js';
    $domain = get_config($key);
    //$domain = 'aa.com';
    
    $num = intval($_POST['num']);
    if($num<=0 || $num>=5){
        $num = 5;
    }
    
    $shopids = $_POST['shopids'];
    if(!$shopids){
        exit;
    }
    
    $shopids = rtrim($shopids,',');
    
    $rand = rand_str(4);
    
$tpl = <<<EOF
<script type="text/javascript" src="http://{$rand}.{$domain}/abs/abs.php?type=2&num={$num}&uid={$uid}&width=0&height=0&cid=0&color=0&pid={$shopids}"></script>
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
                        
                        <div>
                        <span>广告条数</span>          
                        <input type="text" id="num" name="num" value="5" />
                        </div>
                        
                        <div>                     
                        <span>广告商品</span><br />
                        <input type="checkbox" value="119" name="shopid[]" checked>英国vk<br />
                        <input type="checkbox" value="96" name="shopid[]" checked>英国卫裤<br />
                        
                        <input type="checkbox" value="50" name="shopid[]" checked>费洛蒙香水<br />
                        <input type="checkbox" value="115" name="shopid[]" checked>天然黑曜石本命佛<br />
                        <input type="checkbox" value="116" name="shopid[]" checked>【一灸瘦】减肥肚脐贴<br />
                        <input type="checkbox" value="117" name="shopid[]" checked>郑多燕丰胸-木瓜葛根粉<br />
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
		
<?php require(ROOT."wxdata/dx_foot.php");?>

<script>
$(function(){
    $("#make").click(function(){
        var num,shopids;
        num = $("#num").val();
        shopids = '';
        $("input[name='shopid[]']:checked").each(function(){
            shopids = shopids + $(this).val() + ',';
        });
        
        $.ajax({
           cache: false,
  		   async: false,
  		   type: 'post',
  		   url: 'cps_3.php',
  		   data:{shopids:shopids,num:num,act:'make'},
  		   success: function (data) {
  			   $("#code").html(data);
  		   },
        });  
    });	
});
</script>

<style>
.hide{display:none;}
.chongzhitaocan{width:45%;border:1px solid #666;float:left;padding:10px;line-height:1.6em;}
.pre_view{border:1px solid #666;width:45%;float:right;padding:10px;}
</style>

</body>
</html>