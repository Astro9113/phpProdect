<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
    
    $uid = intval($_GET['uid']);
    $num = intval($_GET['num']);
    $width = intval($_GET['width']);
    $height = intval($_GET['height'])/$num;
    $pid = $_GET['pid'];

    $imgheight = 0.75 * $height;
    
    if($num<=0 || $num>=5){
        $num = 5;
    }

    $pid = trim($pid);
    
    $sql  = "select ad_img_fang,shopid,file_index,title from wx_shop_addon where hide=0 and shopid in ({$pid}) order by rand() limit $num ";
    
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
        $share = rand(1000,10000);
        $read = rand(10001, 99999);
        
        $infos[] = array('title'=>$_title,'link'=>$link,'img'=>$row['ad_img_fang'],'share'=>$share,'read'=>$read,);
    }
    
    if(isset($_GET['d'])){
        echo '<pre>';
        var_dump($infos);
        //exit;
    }
    
    
    
    
?>



<style>
    @charset "utf-8";

    body, html, a, img, div, form, select, input, ul, ol, ul, li, h1, h2, h3, h4, h5, h6, dd, dl, dt, p, label, em, span {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Microsoft YaHei', sans-serif;
        color: #666;
        font-size: 16px;
        overflow:hidden;
    }

    a {
        color: #607fa6;
        *color: #607fa6;
        text-decoration: none;
    }

        a:hover {
            text-decoration: none;
            color: #ff4a00;
        }

    ol, ul, li {
        list-style: none;
    }

    em, i {
        font-style: normal;
    }

    img {
        border: none;
    }
    /*上面的公告样式可以删除*/
    /*这块保留*/
    .fl {
        float: left;
    }

    .fr {
        float: right;
    }

    .cb {
        clear: both;
    }

    .mlr10 {
        margin: auto 10px;
    }

    .mtb10 {
        margin: 10px auto;
    }

    .ml10 {
        margin-left: 10px;
    }

    .mr10 {
        margin-right: 10px;
    }

    .pl10 {
        padding-left: 10px;
    }

    .pr10 {
        padding-right: 10px;
    }

    body, html {
        height: 100%;
    }

    .hd_main {
        min-width: 320px;
        margin: 0 auto;
        max-width: 640px;
        overflow: hidden;
    }

    .hd_main_sub {
        /*padding: 15px 10px 10px;*/
    }

    .rich_media_title {
        padding: 0 15px;
        margin-bottom: 12px;
        line-height: 100%;
        font-weight: 400;
        font-size: 2.4rem;
        padding-bottom: 10px;
        margin-bottom: 14px;
        border-bottom: 1px solid #e7e7eb;
        color: #000;
    }

    .rich_media_meta_list {
        margin-bottom: 18px;
        line-height: 20px;
        padding: 0 15px;
    }

    .rich_media_meta_list {
        position: relative;
        z-index: 1;
    }

    .rich_media_meta {
        float: left;
        margin-right: 8px;
        margin-bottom: 10px;
    }

    .rich_media_meta {
        float: left;
        margin-right: 8px;
        margin-bottom: 10px;
    }

    img {
    }

    img {
        vertical-align: middle;
    }

    .rich_media_content p {
        clear: both;
        min-height: 1em;
        line-height: 1.6;
    }

    p {
        margin: 0 0 10px;
    }

    .hide_box {
        width: 100%;
        height: 100px;
        background: url('/Public/img/hide_content_bg.png') repeat-x;
        position: absolute;
        bottom: 0;
    }

    a.view_all {
        display: none;
        width: 3.65em;
        margin: 0 auto 0.5em;
        padding: 0.825em 0;
        height: 3.65em;
        line-height: 1;
        text-align: center;
        color: #FFFFFF;
        background: #01ade3;
        border-radius: 1.825em;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

        a.view_all:hover {
            color: #eee;
            text-decoration: none;
        }

    .hide_content {
        height: 700px;
        overflow-y: hidden;
    }

    .rich_media_tool {
        overflow: hidden;
        padding: 0px;
        line-height: 32px;
        margin-bottom: 70px;
    }

        .rich_media_tool .meta_primary {
            float: left;
            margin-right: 10px;
        }

    .tips_global {
        color: #8c8c8c;
    }

    .rich_media_tool .meta_praise {
        margin-right: 0;
        margin-left: 8px;
    }

    .icon_praise_gray {
        background: url(../images/content20151022images/png.png);
        width: 13px;
        height: 13px;
        vertical-align: middle;
        display: inline-block;
        -webkit-background-size: 100% auto;
        background-size: 100% auto;
    }

    .media_tool_meta i {
        vertical-align: 0;
        position: relative;
        top: 1px;
        margin-right: 3px;
    }

    .icon_praise_gray.praised {
        background-position: 0 -18px;
    }

    .rich_media_tool .meta_extra {
        float: right;
        margin-left: 10px;
    }

    .rich_media_content {
        overflow-y: hidden;
    }

    html {
        font-size: 10px;
    }
    /*举报开始*/

    #report h2 {
        color: #8a898e;
        font-size: 1.6rem;
        margin: 0 0 0 18px;
        padding: 12px 0;
        font-weight: normal;
    }

    .ReportReason ul, li {
        list-style: none;
        padding: 0;
        margin: 0;
    }

        .ReportReason ul li span {
            width: 30px;
            height: 25px;
            display: inline-block;
            vertical-align: bottom;
            float: right;
            margin-right: 10px;
        }

            .ReportReason ul li span.sel {
                background: url('../images/content20151022images/correct.png') no-repeat 6px 4px;
            }

    .ReportReason {
        background: #fff;
    }

        .ReportReason ul li {
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
            margin-left: 18px;
            color: #000;
            font-size: 1.4rem;
        }

            .ReportReason ul li a {
                font-size: 1.6rem !important;
            }

    .next_Report {
        background: #04be02;
        border: none;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
        font-weight: bold;
        padding: 8px 0;
        height: 100%;
        transition: all 0.3s ease 0s;
        width: 90%;
        text-align: center;
        margin: 20px auto;
    }

    .pre_Report {
        background: #d1d1d1;
        border: medium none;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
        font-weight: bold;
        padding: 8px 0;
        height: 100%;
        transition: all 0.3s ease 0s;
        width: 90%;
        text-align: center;
        margin: 20px auto;
    }

    .ReportText textarea {
        margin: 0px auto;
        background: #fff;
        border: none;
        width: 100%;
        height: 100px;
        padding: 6px 0px 6px 18px;
    }

    .ReportContent {
        background: #fff;
        padding: 6px 0px 6px 18px;
        font-size: 1.4rem;
    }

    .ReportLink textarea {
        margin: 0px auto;
        background: #fff;
        border: none;
        width: 100%;
        height: 35px;
        padding: 6px 0px 6px 18px;
    }

    #report h3 {
        margin: 8px 12px 6px 0;
        font-size: 1.4rem;
        color: #3594fd;
        text-align: right;
        font-weight: normal;
    }

    #report_1 {
        margin: 20px 0;
    }

        #report_1 h3 {
            margin: 0;
            color: #000;
            font-size: 1.4rem;
            padding: 12px 0;
            margin: 0 12px;
            line-height: 22px;
        }

    .report_img {
        margin: 0 auto;
        text-align: center;
        width: 70%;
    }

    .report_img2 {
        margin: 0 auto;
        text-align: center;
        width: 90%;
    }

    .link_Report {
        background: #04be02;
        border: medium none;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
        font-weight: bold;
        padding: 8px 0;
        height: 100%;
        transition: all 0.3s ease 0s;
        width: 90%;
        text-align: center;
        margin: 20px auto;
    }

    #report_success {
        text-align: center;
    }

        #report_success img {
            padding-top: 55px;
            width: 35.3%;
            margin: 0 auto;
        }

        #report_success h3 {
            color: #000;
            font-size: 2.2rem;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        #report_success span {
            width: 90%;
            color: #888888;
            display: block;
            margin: 20px auto;
        }


    .dsas img, #js_content img {
        width: 100%;
    }

    #js_content iframe {
        width: 100%;
        height: 250px;
    }

    .show2 {
        display: none;
    }
</style>
<div class="hd_main">
    <div class="hd_main_sub">
        <div class="rich_media_area_primary">
            <div class="show2" style="display: block;">
                <!-- 精彩推荐start -->
                <div style="width: 100%; float: left;">
                    <div style="width: 99%;float: left;">
                        <ul>
                            
<?php 
foreach ($infos as $info){

?>    
<li class="article_tj" style="height: <?php echo $height;?>px;">
<a target="_parent" href="<?php echo $info['link'];?>" style="color: #666">
<img src="<?php echo $info['img'];?>" width="20%" height="75" style="float: left; margin-right: 3px;">
<span style="line-height: 20px"><?php echo $info['title'];?></span>
</a>
<br>
<span style="font-size: 12px; line-height: 250%">阅读：<?php echo $info['read'];?> &nbsp;&nbsp;&nbsp;&nbsp;分享：<?php echo $info['share'];?></span>
</li>
<?php     
}
?>
                                        
                                        
                                    
                                        
                                    
                        </ul>
                    </div>
                </div>
                <!-- 精彩推荐end -->
                <div style="clear: both;"></div>

            </div>
<div style="display:none">
<script src="http://s4.cnzz.com/z_stat.php?id=1258342524&web_id=1258342524" language="JavaScript"></script>
</div>
        </div>
    </div>
</div>
<?php mysql_close();?>