<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
include 'curl.class.php';

ini_set('display_errors', 'On');

function is_xd_url($url){
    return strpos($url, 'http')===false;
}

function is_https($url){
    return strpos($url, 'https')!==false;
}

//相对地址的类型
function xd_url_type($xd_url){
    //相对域名开始
    if($xd_url[0] ==='/'){
        return 1;
    }
    //相对当前路径的上一级
    if($xd_url[0] ==='.' && $xd_url[1] ===  '.'){
        return 2;
    }
    //相对当前路径开始
    if($xd_url[0] ==='.' && $xd_url[1] ===  '/'){
        return 3;
    }
    //就在当前文件夹下
    return 4;
}

//根据相对地址 和 文件路径 获取绝对地址
function get_remote($file,$base_file){
    $type = xd_url_type($file);

    $urlinfo = parse_url($base_file);

    echo 'filetype:'.$type.'<br />';

    switch ($type){
        case 1:
            $remote_file = $urlinfo['scheme'].'://'.$urlinfo['host'].$file;
            break;
        case 4:
            $path = dirname($urlinfo['path']);
            $remote_file = $urlinfo['scheme'].'://'.$urlinfo['host'].$path.'/'.$file;
            break;
        case 3:
            $path = dirname($urlinfo['path']);
            $file = substr($file, 2);
            $remote_file = $urlinfo['scheme'].'://'.$urlinfo['host'].$path.'/'.$file;
            break;
        case 2:
            $path = substr(dirname($urlinfo['path']),1);
            $path_arr = explode('/', $path);
            $file_arr = explode('/',$file);

            $top = array_shift($file_arr);
            while ($top == '..'){
                array_pop($path_arr);
                $top = array_shift($file_arr);
            }
            array_unshift($file_arr, $top);

            $path = join('/', $path_arr);
            $file = join('/', $file_arr);

            $path = $path?$path.'/':'';
            $remote_file = $urlinfo['scheme'].'://'.$urlinfo['host'].'/'.$path.$file;
            break;
        default:
            break;

    }

    return $remote_file;
}

function get_ext($file){

    $arr = explode("\r\n\r\n",$file);
    $info = $arr[0];
    $pat = '@Content-Type: (.*?)\n@';
    preg_match($pat, $info,$mat);
    $type = $mat[1];
    switch ($type){
        case 'image/jpeg':
            return 'jpg';
        case 'image/png':
            return 'png';
        case 'image/gif':
            return 'gif';
        default:
            return 'gif';
    }
}

function get_file($file){
    $arr = explode("\r\n\r\n",$file);
    $info = $arr[1];
    return $info;
}

function up_to_server($remote_file){
    global $save_dir;
    $file = curl::get($remote_file,1,0,0,0,is_https($remote_file));
    $file_info = array(
        'ext'=>get_ext($file),
        'name'=>$remote_file,
        'file'=>get_file($file),
        'size'=>strlen($file),
    );
    
    $filename = date('His').rand(100, 999).'.'.$file_info['ext'];
    $save_file = $save_dir.$filename;
    while (file_exists($save_file)){
        $filename = date('His').rand(100, 999).'.'.$file_info['ext'];
        $save_file = $save_dir.$filename;
    }
    
    file_put_contents($save_file, $file_info['file']);
    $remote = 'http://vucpsqiniu.bkxgr.cn/upload/'.date('ymd').'/'.$filename;
    return $remote;
}


$cdndomain = 'http://vucps.bkxgr.cn'; 

if(isset($_POST['do_upload_remote'])){
    //上传类
    $save_dir = UPLOAD_PATH.'/'.date("ymd").'/';
    if(!is_dir($save_dir)){
        mkdir($save_dir);
    }
    
    //获取源文件
    $upfile = trim($_POST['upfile']);
    $file = curl::get($upfile,0,0,0,0,is_https($upfile));
    
    //mylog($file);
    //匹配文件内的图片
    //$pat = '@<img .*?src="([^"]+)"@si';
    $pat = '@<img.*?src="([^"]+)"@';
    
    preg_match_all($pat, $file,$mat);
    
    /*
    echo '<pre>';
    print_r($mat);
    exit;
    */
    
    $imgs = $mat[1];
    
    //exit;
    
    //根据图片类型 上传并替换
    foreach ($imgs as $img){
        $remote_img = $img;
        if(is_xd_url($img)){//远程绝对地址
            $remote_img = get_remote($img,$upfile);
        }

        echo $remote_img;
        exit;
        $img_r = up_to_server($remote_img);
        $file = str_replace($img, $img_r, $file);
    }
    
    //上传源文件自身获取远程地址
    
    echo htmlentities($file);
    
}

?>

<br /><br /><br />
直接上传远程文件<br />
<form action="" method="post">
<input type="text" name=upfile style="width:300px;padding:5px;"/>
<input type="submit" name="do_upload_remote" value="上传" />
</form>
<br />
