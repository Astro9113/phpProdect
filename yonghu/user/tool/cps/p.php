<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";


$nav1=6;
$nav2=1;


$user11id = $uid = $_SESSION['user1114id'];
$time = time();

$arr = array(
    'vu_domain_zjxd_1'=>'vu:域名:直接下单:1(泛解析)',
    'vu_domain_zjxd_2'=>'vu:域名:直接下单:2(泛解析)',
    'vu_domain_zjxd_2_jump'=>'vu:域名:直接下单:2:跳转(泛解析)',
    'vu_domain_waxd_1'=>'vu:域名:文案下单:1(泛解析)',

    'jumpdomain_1'=>'跳转域名1(负责两个直接下单模式的跳转)',
    'jumpdomain_2'=>'跳转域名2(负责两个文案加下单模式的跳转)',
    'jumpdomain_3'=>'跳转域名2(负责两个文案加下单模式的跳转)',

    'domain_1_1_1'=>'直接下单一域名一',
    'domain_1_1_2'=>'直接下单一域名二',
    'domain_1_2_1'=>'直接下单二域名一',

    'domain_2_1_1'=>'文案加下单一域名一',
    'domain_2_2_1'=>'文案加下单二域名一',
);

//如果媒介下域名没有设置 则获取第一个媒介下面的代替
foreach ($arr as $k=>$v){
    $$k = get_config($target.'-'.$k);
    $$k = $$k?$$k:get_config('1-'.$k);
}


$domain = $jumpdomain_2;
$randPath = '';
$args = "$uid-$time";
$domain_2_2 = 'http://'.rand_str(4).'.'.$domain.'/stw_j.php?r='.$args;
	
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
                        
                        <p><?php echo $domain_2_2;?></p>

                        
                    </div>
                </div>
                   
            </div>               
		
<?php require(ROOT."wxdata/dx_foot.php");?>


<style>
.t_link{color:#000 !important;}
.hide{display:none;}
.chongzhitaocan{color:#000 !important;width:45%;border:1px solid #666;float:left;padding:10px;line-height:1.6em;}
.pre_view{border:1px solid #666;width:45%;float:right;padding:10px;}
</style>
</body>
</html>