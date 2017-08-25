<?php
include '../init.php';
include 'func.php';


if(isset($_POST['do_upload_remote'])){
    //上传类
    $save_dir = UPLOAD_PATH.'/'.date("ymd").'/';
    $up_class = new upload($save_dir);
    
    //获取源文件
    $upfile = trim($_POST['upfile']);
    $file = curl::get($upfile,0,0,0,0,is_https($upfile));
    
    //mylog($file);
    
    //exit;
    //标题
    $title = pat_title($file);
    
    
    $start_str = '<div class="rich_media_content " id="js_content">';
    $end_str   = 'first_sceen__time';
    
    $s = strpos($file, $start_str) + strlen($start_str);
    $e = strpos($file, $end_str);
    
    $con = substr($file, $s, $e-$s-100);
    
    //mylog($con);
    //exit;
    
    $pat_replace = "@src='data[^']+'@";
    
    
    /*
    preg_match_all($pat_replace, $con,$mat);
    echo '<pre>';
    print_r($mat);
    exit;
    */
    
    $con = preg_replace($pat_replace, '', $con);
    $con = str_replace('data-src', 'src', $con);
    $con = str_replace('_src', 'src', $con);
    
    //echo htmlentities($con);
    
    //匹配文件内的图片
    $pat = '@<img.*?src="([^"]+)"@';
    //$pat = '@<img [^>]+>@';
    
    preg_match_all($pat, $con,$mat);
    
    
    //echo '<pre>';
    //print_r($mat);
    //exit;
    
    
    $imgs = $mat[1];
    
    

    //exit;
    
    //根据图片类型 上传并替换
    foreach ($imgs as $img){
        $img_yp = up_to_yun_wx($img);
        $con = str_replace($img, $img_yp, $con);
    }
    
    //上传源文件自身获取远程地址
    
    $filename = substr($save_dir,0,-7).'html/'.date('ymdhis').'.html';
    file_put_contents($filename,$con);
    echo 'http://ht.hc678114.com/tool/tool/upload/html/'.$filename;
}

?>

<br /><br /><br />
直接上传远程文件<br />
<form action="" method="post">
<input type="text" name=upfile style="width:300px;padding:5px;"/>
<input type="submit" name="do_upload_remote" value="上传" />
</form>
<br />
