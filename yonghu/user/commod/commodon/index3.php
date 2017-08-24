<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=1;
$nav2=1;

$user11id = $uid = $_SESSION['user1114id'];

//渠道id
$cid = isset($_GET['cid'])?intval($_GET['cid']):0;

//随机时间
$time = time();

//用户id
$uid = $_SESSION['user1114id'];
$user = userinfo($uid);

//商品id
$shopid = isset($_GET['id'])?intval($_GET['id']):0;
if(!$shopid){
    exit('商品信息不存在');
}

//商品信息
$shopinfo = shopinfo($shopid);
if(!$shopinfo){
    exit('商品信息不存在');
}

//用户所属媒介id
//$target = get_mid($uid);
$target = 1;//暂时全部使用同一个

//获取配置表中储存的域名信息
//第一个数字  1 = 直接下单 2 = 文案加下单 
//第二个数字  1 = 模式一  2 = 模式2  ....
//第三个数字  1 = 第一个域名 2 = .....
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


//以下域名都加跳转 并且取消泛解析


//直接下单-模式1
//==============================================
$domain = $vu_domain_zjxd_2_jump;

//商品id-用户id-渠道id-域名索引-随机
$args = "$shopid-$uid-$cid-$time";

//随机路径
$randPath = '4'.rand_str(rand(3, 8));
$domain_1_1 = 'http://'.rand_str(4).'.'.$domain.'/'.$randPath.'/?r='.$args;


/*
//直接下单-模式2 
//==============================================
//商品 96 和 50 有直接下单2模式

if(in_array($shopid, array(96,50))){
    $randPath = '1'.rand_str(rand(3, 8));
    $domain = $vu_domain_zjxd_2_jump;
    //模式id-商品id-用户id-渠道id-域名索引-随机
    $args = "$shopid-$uid-$cid-$time";
    $domain_1_2 = 'http://'.rand_str(4).'.'.$domain.'/'.$randPath.'/?r='.$args;
}
*/


//文案加下单模式一  和直接下单共用跳转域名
//==============================================

$domain = $vu_domain_zjxd_2_jump;
$args = "$shopid-$uid-$cid-$time";
$randPath = '7'.rand_str(rand(3, 8));
$domain_2_1 = "http://".rand_str(4).'.'.$domain.'/'.$randPath.'/?r='.$args;


//用户渠道
$userChannel = userChannel($uid);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微优商品详情</title>
<link href="/css/dx_user.css" rel="stylesheet" type="text/css">
<?php require("../../../wxdata/dx_head.php");?>

<div class="vip">
	<div class="vip-content">
    	<?php require("../../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
			<div class="vip-content-main">
            <?php require("../../../wxdata/dx_mid.php");?>
            	<div class="vip-content-r-notice" style="height: 48px;">
					<div class="vip-content-r-notice-l"
						style="margin-top: 5px; width: 100%;">
						<span class="sousuo" style="margin-left: 5px;">BUTTON : </span> 
						<a
							class="state" href="javascript:history.go(-1);">返回浏览商品</a> 
							<a
							class="state"
							href="<?php echo $domain_1_1;?>"
							target="_blank">录单</a>
					</div>
                </div>

				<h3>
				<a class="tianjmb">商品详情</a>  &nbsp;&nbsp;  <?php echo $shopinfo['shopname'];?>
				</h3>
				


				<h3 class="zaixiancz-icon2" style="background-position: 0 0px;">链接发布</h3>

				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="vip-mb-add">
					<tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><p class="tittle">选择渠道</p></td>
						<td align="left" valign="top" id="userchannel">
							<p style="padding-bottom: 15px;">
                            <?php
                            //渠道
                            $list = '';
                            foreach($userChannel as $channelid=>$cname){
                                $tpl = '<a class="proconqd cid" wx-id="%s">%s</a>';
                                $tpl = sprintf($tpl,$channelid,$cname);
                                $list .= $tpl;
                            }
                            
                            echo $list;
                            ?>
                            </p>
						</td>
					</tr>
					<tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><p class="tittle">微信公众号</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 8px;" class="tittle">
								<img src="/images/procon_wx.gif" />
							</p>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><p class="tittle">阅读原文链接</p></td>
						<td align="left" valign="top">
							<p>
								<input type="text" name="sms_remind" id="wxa11" class="vip-test"
									value="<?php echo $domain_1_1;?>"
									style="width: 550px;">
							</p>
							<p style="padding-bottom: 0px; color: #F00;">请添加阅读原文链接后，预览下单测试。以确保出单成功！</p>
						</td>
					</tr>

                    <tr>
						<td align="right" valign="top"><p class="tittle">宣传文案</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
                            <?php 
                            $shopcopytxt=$shopinfo['shopcopytxt'];
                            $shopcopytxt=explode("^",$shopcopytxt);
                            $shopcopya=$shopinfo['shopcopya'];
                            $shopcopya=explode("^",$shopcopya);
                            $copynum=count($shopcopytxt);
                            /*
                            if($shopcopya[1]==''){
                            $copynum=$copynum-2;
                            }elseif($shopcopya[2]==''){
                            	$copynum=$copynum-1;
                            	}
                            */
                            for($i=0;$i<$copynum;$i++){
                               if($shopcopya[$i]<>''){
                            ?>
                            <a target="_blank" href="<?php echo $shopcopya[$i];?>" class="spcona"><?php echo $i+1;?>..  <?php echo $shopcopytxt[$i];?>~</a><br />
                                                        
                            <?php 
                                }
                            }
                            ?>
                            </p>
						</td>
					</tr>
                                
                    
					<?php
					
					/*
                    //文案加下单模式一
                    if($shopinfo['shopcopy']){
					?>
				
					<tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><p class="tittle">其他推广平台</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 8px;" class="tittle">
								<img src="/images/procon_m2.jpg" />
							</p>
						</td>
					</tr>
					
					<tr>
						<td align="right" valign="top"><p class="tittle">推广链接</p></td>
						<td align="left" valign="top">
							<p>
								<input type="text" name="telephone" id="wxa21" class="vip-test"
									value="<?php echo $domain_2_1;?>"
									style="width: 350px;">
							</p>
							<p style="padding-bottom: 12px; color: #F00;">先打开自己的链接，尝试下单后再推广</p>
						</td>
					</tr>          
                    <?php
                    }
                    
                    */
                    ?>
                   
                   <?php 
                    $wenan_arr = array(96,50,115,117,116,119,109,121,112,122,123,124);
					if(in_array($shopid,$wenan_arr)){
				   ?>
                    <tr>
						<td align="right" valign="top"><p class="tittle">单独推广</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
                           <?php
						     $sql = "select * from wx_shop_addon where shopid = $shopid and hide = 0 order by file_index";
						     $result = mysql_query($sql);
						     while($r = mysql_fetch_assoc($result)){
								 $index = $r['file_index'];
								 $domain = $jumpdomain_2;
								 $randPath = '5'.rand_str(4);
								 $args = "$shopid-$uid-$cid-$index-$time";
								 $domain_2_2 = 'http://'.rand_str(4).'.'.$domain.'/'.$randPath.'/?r='.$args;
								 $domain_2_2_js = 'http://'.rand_str(4).'.'.$domain.'/domain21.php?r='.$args;
								 	
								 
								 
						   ?>
						   <a class="spcona"><?php echo $r['file_index'];?>..  <?php echo $r['title'];?></a>
								<span class="danjia"><input type="text" name="sms_remind"
									id="wxa1" class="vip-test"
									value="<?php echo $domain_2_2;?>"
									style="width: 350px;"></span>
									

								<!-- JiaThis Button BEGIN -->
							
							<div class="jiathis_style"
								onmouseover="setShare('<?php echo $r['title'];?>','<?php echo $domain_2_2;?>','');">
								<span class="jiathis_txt">分享到：</span> <a
									class="jiathis_button_weixin spcona">微信</a> <a
									class="jiathis_button_cqq spcona">QQ好友</a> <a
									class="jiathis_button_qzone spcona">QQ空间</a> <a
									class="jiathis_button_copy spcona">复制网址</a> <a
									href="http://www.jiathis.com/share"
									class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis"
									target="_blank">更多</a>
							</div> <script type="text/javascript"
								src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
							<!-- JiaThis Button END -->
							
							<br/>使用js方式发布<br/>
							
							
							<?php 
							 $js_tpl =  '<script src="%s"></script><script>var vu_tit = \'%s\';document.write(\'<a href="\'+vu_url+\'">\'+vu_tit+\'</a>\');</script>';
							 $js_con = sprintf($js_tpl,$domain_2_2_js,$r['title']);
							 $js_con = htmlentities($js_con);
							?>
							<span class="danjia"><input type="text" name="sms_remind"
									id="wxa1" class="vip-test"
									value="<?php echo $js_con;?>"
									style="width: 350px;"></span>
							
							
							<br>

						   <?php       
						     }
						   ?>
                            </p>
						</td>
					</tr>
<script type="text/javascript">
function setShare(title,url,img) {
    jiathis_config.title = title;
    jiathis_config.url = url;
    jiathis_config.img = img;
     }
    var jiathis_config = {
    url: "",
    img: "",
    title: ""
    }
</script>
     			  <?php }?>		
                        
                    <tr>
						<td align="right" valign="top"><p class="tittle">商品状态</p></td>
						<td align="left" valign="top">
							<p>
								<span id="span_status">正常</span>
							</p>
						</td>
					</tr>

					<tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>

				</table>


				<h3 class="zaixiancz-icon" style="background-position: 0 -200px;">商品介绍</h3>

				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="vip-mb-add">
					<tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><p class="tittle">商品名称</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
                         <?php echo $shopinfo['shopname'];?> 
                            </p>
						</td>
					</tr>

					<tr>
						<td align="right" valign="top"><p class="tittle">商品图片</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
								<img
									src="<?php 
                            
                            
                            if(strpos($shopinfo['shoppic'], 'http')!==false){
                                echo $shopinfo['shoppic'];
                            }else{
                                echo 'http://pic.dllvu.com/'.$shopinfo['shoppic'];
                            }
                            
                            
                            ?>"
									width="40%" />
							</p>
						</td>
					</tr>

					<tr>
						<td align="right" valign="top"><p class="tittle">推广描述</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
                            <?php echo $shopinfo['shopcon'];?>
                            </p>
						</td>
					</tr>

					<tr>
						<td align="right" valign="top"><p class="tittle">商品SKU</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px;" class="tittle">
<?php
	    for($i=1;$i<=12;$i++){
$skuname='shopsku'.$i;
$shopsku=$shopinfo[$skuname];
$shopsku=explode("_",$shopsku);
if($shopsku[0]!=""){
if($shopinfo['ischange']=='1'){
	$shopsku[2]=$shopsku[2]*$userpercent;
	$shopsku[2]=round($shopsku[2]);
}
	echo   $shopsku[0].'  '.$shopsku[1].'  '.$shopsku[2].'<br/>';
		}
		}
	   ?>
                            </p>
						</td>
					</tr>
                  
                   <?php if($shopinfo['shopyyzz']<>''||$shopinfo['shopscyk']<>''||$shopinfo['shopsqs']<>''){ ?>
                     <tr>
						<td align="right" valign="top"><p class="tittle">商品资料</p></td>
						<td align="left" valign="top">
							<p style="padding-bottom: 15px; padding-top: 20px;"
								class="tittle">
                            <?php if($shopinfo['shopyyzz']<>''){ ?>
                            <img
									src="http://pic.dllvu.com/<?php echo $shopinfo['shopyyzz'];?>"
									width="30%" />
                            <?php }?>
                             <?php if($shopinfo['shopscyk']<>''){ ?>
                             <img
									src="http://pic.dllvu.com/<?php echo $shopinfo['shopscyk'];?>"
									width="30%" />
                             <?php }?>
                             <?php if($shopinfo['shopsqs']<>''){ ?>
                              <img
									src="http://pic.dllvu.com/<?php echo $shopinfo['shopsqs'];?>"
									width="30%" />
                              <?php }?>
                            </p>
						</td>
					</tr>
                   <?php }?>
                   <tr>
						<td width="250" align="right" height="30"></td>
						<td align="left"></td>
					</tr>
				</table>

			</div>             
		
<?php require("../../../wxdata/dx_foot.php");?>



<!-- 时间控件 -->
<script language="javascript">
$("#userchannel a").bind("click",function(){//尺码点击
    var shopid = <?php echo $shopid;?>;
    var o = $(this);
	var wxid=o.attr("wx-id");
		
    location.href = 'index.php?id='+shopid+'&cid='+wxid;
})
</script>


<style>
span.danjia {
	margin: 5px 0px;
	display: block;
}
</style>

</body>
</html>