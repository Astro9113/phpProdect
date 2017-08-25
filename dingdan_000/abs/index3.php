<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
    
    $colorarr = array('black','red','green','gray');
    $color = intval($_GET['color']);
    if(!array_key_exists($color, $colorarr)){
        $color = 0;
    }
    $color = $colorarr[$color];
    
    $uid = intval($_GET['uid']);
    $num = intval($_GET['num']);
    $pid = $_GET['pid'];

    if($num<=0 || $num>=5){
        $num = 5;
    }

    $pid = trim($pid);
    
    $sql  = "select ad_img_san_1,ad_img_san_2,ad_img_san_3,shopid,file_index,title from wx_shop_addon where hide=0 and shopid in ({$pid}) order by rand() limit $num ";
    
    $result = mysql_query($sql);
    $num  = mysql_num_rows($result);
    if(!$num){
        exit;
    }

    
    $key = '1-vu_domain_waxd_1';
    $domain = get_config($key);
    
    $rand = rand_str(3);
    $randParh = '5'.rand_str(4);
    $cid = 0;
    
    $infos = array();
    while ($row = mysql_fetch_assoc($result)){
        $time = time();
        $_title = $row['title'];
        $_shopid = $row['shopid'];
        $_findex = $row['file_index'];
        $args = "$_shopid-$uid-$cid-$_findex-$time"; 
        $link = "http://{$domain}/{$randParh}/?r={$args}&t=cps";
        $read = rand(10001, 99999);
        
        $infos[] = array(
            'title'=>$_title,
            'link'=>$link,
            'img1'=>$row['ad_img_san_1'],
            'img2'=>$row['ad_img_san_2'],
            'img3'=>$row['ad_img_san_3'],
            'read'=>$read,
        );
    }
    
    if(isset($_GET['d'])){
        echo '<pre>';
        var_dump($infos);
        //exit;
    }
    
    
    
    
?>




<!DOCTYPE HTML>
<html lang="zh-cn">
<head>
    <meta content="IE=11.0000" http-equiv="X-UA-Compatible">


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="applicable-device" content="mobile">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <link href="/newcss/074422852.css" rel="stylesheet">
    <link href="/newcss/074441778.css" rel="stylesheet">
    <link href="/newcss//074457711.css" rel="stylesheet">
    <link href="/newcss//074540830.css" rel="stylesheet">
    <script src="/newcss/074634836.js"></script>
    <style>
    h2{color:<?php echo $color;?> !important;}
    </style>
</head>
<body>

    <div id="mainListContainer">
        <?php 
        foreach ($infos as $info){
        ?>

                <section>
                    <a  target="_parent" href="<?php echo $info['link'];?>">
                        <h2><?php echo $info['title'];?></h2>
                        <div class="images-list-box">
                            <ul>
                                <li>
                                    <div class="image_container">
                                        <img src="<?php echo $info['img1'];?>">
                                    </div>
                                </li>
                                <li>
                                    <div class="image_container">
                                        <img src="<?php echo $info['img2'];?>">
                                    </div>
                                </li>
                                <li>
                                    <div class="image_container">
                                        <img src="<?php echo $info['img3'];?>">
                                    </div>
                                </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </a>
                    <div class="item-info-box">
                        <span class="box-mr5">宅男福利</span>
                        <span class="fa fa-comments-o box-mr5"><?php echo $info['read'];?></span>                 <span class="fr">4天前</span>
                    </div>
                </section>
            
           <?php 
        }
           ?> 
            
<div style="display:none">
<script src="http://s4.cnzz.com/z_stat.php?id=1258342524&web_id=1258342524" language="JavaScript"></script>
</div>
    </div>
</body>
</html>
<?php mysql_close();?>