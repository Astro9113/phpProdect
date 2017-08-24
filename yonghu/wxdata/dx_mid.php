<?php
    $topid = get_mid($uid);
    $miduser = miduserinfo($topid);
    $yaoqingma = $miduser['applyma'];
    if($yaoqingma == '001508050424102657'){
    	$yaoqingma = '001508050426255727';
    }
    if($yaoqingma == '001508241147338295'){
    	$yaoqingma = '001508241147539614';
    }
    if($yaoqingma == '001509110218487200'){
    	$yaoqingma = '001509110219232849';
    }
	
    $ys_reg_url = "{$ys_domain}regist/".base64_encode_withouteq2($yaoqingma);
    
?>
    
    <h2>您的专属媒介：<span><?php echo $miduser['midkefuname'];?></span>手机号码：<span><?php echo $miduser['midkefutel'];?></span>QQ：<span> <?php echo $miduser['midkefuqq'];  ?></span>投诉电话：<span><?php echo $kftel;?></span><br /><br />

<a href="<?php echo $ys_reg_url;?>" style="margin-top:8px; color:#F00; text-decoration:underline;" target="_blank">一水平台注册 （手表 金叶子等高单量产品 。 微优，一水 是一个公司）</a>    
    
    </h2>

