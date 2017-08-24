<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT."wxdata/userlimit.php";
require ROOT."wxdata/dx_fun.php";

$nav1=1;
$nav2=1;

$user11id = $uid =  $_SESSION['user1114id'];
$userpercent = 1;

$where  = "where 1 and upbot='1'";

$classid = isset($_GET['classid'])?intval($_GET['classid']):0;
if($classid){
    $where .= " and shopclass = '{$classid}'";
}

$page_arr = array(
    "classid={$classid}",
);

$pagestr = join('&',$page_arr);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="Generator" content="ZhangJi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/dx_user_shop.css" rel="stylesheet" type="text/css">
<title>微优 - 浏览商品</title>
<?php require("../../wxdata/dx_head.php");?>

<div class="vip">
    <div class="vip-content">
    	<?php require("../../wxdata/dx_left.php");?>
    	<div class="vip-content-r" id="vip-content-r">
            <div class="vip-content-main">
            <?php require("../../wxdata/dx_mid.php");?>
            <div class="vip-content-r-notice" style="height:48px;">
                <div class="vip-content-r-notice-l" id="state" style="margin-top:5px; width:100%;">
                <span class="sousuo" style="margin-left: 5px;" >商品分类 : </span>
            <?php
            $active = !$classid?' statexz':'';
            echo "<a class='state{$active}' class-id='0'>全部</a>";
            $shopclasses = shopclasses();
            foreach ($shopclasses as $_classid=>$shopclass){
                $active = '';
                if($classid == $_classid){
                    $active = ' statexz';
                }
                $classname = $shopclass['shopclassname'];
                
                echo "<a class='state{$active}' class-id='".$_classid."'>".$classname."</a>";
            } 
            ?>
                </div>
            </div>

            <table width="1080" border="0" cellpadding="0" cellspacing="0" class="vip-xiangmu">
                <tr height="10"><td colspan="9"></td></tr>                      
                <tr class="xiangmu">
                           
<?php
$num = $mysql->count('wx_table',$where);
$page_size=12;
$page_count=ceil($num/$page_size);  //得到页数

$page = isset($_GET['page'])?intval($_GET['page']):1;
$offset=($page-1)*$page_size;
			  
$sql=mysql_query("select id,addtime,ischange,shoppic,shopname,shopcon,shopsku1,shopsku2,shopsku3,shopsku4,shopsku5,shopsku6,shopsku7,shopsku8,shopsku9,shopsku10,shopsku11,shopsku12 from wx_shop {$where} order by shoporder desc,id limit $offset,$page_size");	
 
while($info=mysql_fetch_array($sql)){
	
?>
                           
                           
<td width="30%" valign="top" align="center" class="gong9">
<p> 
<a href="commodon/?id=<?php echo $info['id']; ?>">
<img src="<?php echo $info['shoppic'];?>" width="98%"  height="200" />
</a>
</p>
                            
<p class="splist" style="text-align:left;"> 	
<b><a href="commodon/?id=<?php echo $info['id']; ?>"class="spcona"><?php echo $info['shopname'];?></a></b>
<span><?php echo substr($info['shopcon'],0,60);?> </span>
                               
   <?php
	    for($i=1;$i<=3;$i++){
$skuname='shopsku'.$i;
$shopsku=$info[$skuname];
$shopsku=explode("_",$shopsku);
if($shopsku[0]!=""){
if($info['ischange']=='1'){
	$shopsku[2]=$shopsku[2]*$userpercent;
	$shopsku[2]=round($shopsku[2]);
}
	echo "<span class='statexz'> ".$shopsku[1]." / ".$shopsku[2]."</span>";
		}
		}
	   ?>
                               
                              <div style="clear:both;"></div>
                             <A href="commodon/?id=<?php echo $info['id']; ?>"> <span class='statexz2'> 详 情</span></A>
                               </p>
                                
                            </td>
                            
   <?php }?>
   
   <div style="clear:both;"></div>  
                        </tr>
                        

                </table>
                
                    <div class="Paging" style="margin-left:630px; text-align:left;">
                    <a>总计：<?php echo $page_count;?> 页记录</a><a href="?page=1&<?php echo $pagestr;?>">首页</a><a href="?page=<?php echo ($page-1)."&".$pagestr;?>">上一页</a><span class="current"><?php echo $page;?></span><a href="?page=<?php echo ($page+1)."&".$pagestr;?>">下一页</a><a href="?page=<?php echo $page_count."&".$pagestr;?>">尾页</a>
                </div>      
                
                                         <div class="vip-content-r-notice" style="background: #FB9D44;">
                            <p style="color:#fff;">提示：我们会找网上热卖的产品，也会自己开发一些，希望大家积极尝试，如果有好的产品也可以说给媒介或者提交工单！</p>	
                        </div>
                   
            </div>               
		
<?php require("../../wxdata/dx_foot.php");?>

<!-- 时间控件 -->
<script language="javascript">
		$("#state a").bind("click",function(){//尺码点击
			var o = $(this);
			var _state_id = o.attr('class-id');
			location.href="?classid=" + _state_id;
		});
</script>

</body>
</html>