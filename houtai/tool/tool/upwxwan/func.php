<?php

//判断是相对地址 还是 绝对地址  
//true = 相对地址  
//false = 绝对地址
function is_xd_url($url){
    return strpos($url, 'http')===false;
}

//判断是http 还是 https
//true = https  
//false = http
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




//上传远程文件到又拍云
function up_to_yun($remote_file){
    global $up_class;
    $file = curl::get($remote_file,1,0,0,0,is_https($remote_file));
    $file_info = array(
            'name'=>$remote_file,
            'file'=>$file,
            'size'=>strlen($file),
    );
    
    //var_dump($file_info);
    
    $ret = $up_class->save_file($file_info);
    
    $pic= $up_class->up_yun($ret);
    return $pic;
}


function up_to_yun_wx($remote_file){
    global $up_class;
    $file = curl::get($remote_file,1,0,0,0,is_https($remote_file));
    $file_info = array(
        'ext'=>get_ext($file),
        'name'=>$remote_file,
        'file'=>get_file($file),
        'size'=>strlen($file),
    );

    
    //var_dump($file_info);
    //exit;
    
    $ret = $up_class->save_file_wx($file_info);

    $pic = 'http://ht.hc678114.com/tool/tool/upload/'.date('ymd').'/'.$ret;
    $pic = file_get_contents('http://ht.hc678114.com/tool/cdn/up.php?pic='.urlencode($pic));
    return $pic;
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


function pat_title($file){
    $pat = '@<h2 class="rich_media_title">([^<]+)</h2>@'; 
    preg_match($pat, $file,$mat);
    return $mat[1];
}




