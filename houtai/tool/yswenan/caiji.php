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
function get_remote($file,$base_file,$other_base = false){
    $type = xd_url_type($file);

    $urlinfo = parse_url($base_file);

	//print_r($urlinfo);	
    $host = $other_base?$other_base:$urlinfo['host'];
    
    //echo 'filetype:'.$type.'<br />';

    switch ($type){
        case 1:
            $remote_file = $urlinfo['scheme'].'://'.$host.$file;
            break;
        case 4:
			//echo $file;
            $path = dirname($urlinfo['path']);
            $remote_file = $urlinfo['scheme'].'://'.$host.$path.'/'.$file;
            $remote_file = str_replace('\/','/',$remote_file);
			break;
        case 3:
            $path = dirname($urlinfo['path']);
            $file = substr($file, 2);
            $remote_file = $urlinfo['scheme'].'://'.$host.$path.'/'.$file;
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
            $remote_file = $urlinfo['scheme'].'://'.$host.'/'.$path.$file;
            break;
        default:
            break;

    }

    return $remote_file;
}

function get_ext($file){

    $arr = explode("\r\n\r\n",$file);
    $info = $arr[0];
    $pat = '@Content-Type: (.*?)\n@i';
    preg_match($pat, $info,$mat);
    
	$type = trim($mat[1]);
    switch ($type){
        case 'image/jpeg':
            return 'jpg';
        case 'image/png':
            return 'png';
        case 'image/gif':
            return 'gif';
		case 'application/x-javascript':
			return 'js';
		case 'text/css':
			return 'css';
		default:
        	return 'gif';
    }
}

function get_file($file){
    $arr = explode("\r\n\r\n",$file,2);
    $info = $arr[1];
    return $info;
}

function up_to_server($remote_file){
    global $save_dir;
    $file = curl::get($remote_file,1,0,0,0,is_https($remote_file));
    //exit;
	
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
    $remote = 'http://i.chinavuw.com/upload/yswenan/'.date('ymd').'/'.$filename;
    return $remote;
}

function check_base($html){
    $pat = '/<base href="([^"]+)"/';
    $m = preg_match($pat, $html,$mat);
    if($m){
        return str_replace('http://', '', $mat[1]);
    }
    
    return false;
}


$cdndomain = 'http://vucps.bkxgr.cn'; 

if(isset($_POST['do_upload_remote'])){
    //上传类
    $save_dir = UPLOAD_PATH.'/yswenan/'.date("ymd").'/';
    if(!is_dir($save_dir)){
        mkdir($save_dir);
    }
    
    //获取源文件
    $upfile = trim($_POST['upfile']);
    $file = curl::get($upfile,0,0,0,0,is_https($upfile));
    
	//编码
	if(strpos($file,'charset=gb2312')!==false){
		$file = mb_convert_encoding($file,'utf-8','gbk');
	}
    
    if(strpos($file,'charset=gbk')!==false){
		$file = mb_convert_encoding($file,'utf-8','gbk');
	}
    
	
	//检查是否有base标签
    $base = false;
    $base = check_base($file);
    
    //mylog($file);
    //匹配文件内的图片
    //$pat = '@<img .*?src="([^"]+)"@si';
    $pat = '@<img.*?src="([^"]+)"|link rel="stylesheet" href="([^"]+)"|<script (?:type="text/javascript" )?src="([^"]+)"@i';
    preg_match_all($pat, $file,$mat);
    
    
    
    $imgs = $mat[1];
    $csses = $mat[2];
	$jses = $mat[3];
	
	$imgs = array_merge($imgs,$csses,$jses);
	
	//$imgs = $jses;
	
	//echo '<pre>';
    //print_r($imgs);
    //exit;
    
	
    //exit;
    
    //根据图片类型 上传并替换
    foreach ($imgs as $img){
		if(!$img){
			continue;
		}
        $remote_img = $img;
        if(is_xd_url($img)){//远程绝对地址
			$remote_img = get_remote($img,$upfile,$base);
            //echo $remote_img;exit;
        }
        
        $img_r = up_to_server($remote_img);
        $file = str_replace($img, $img_r, $file);
    }
    
    //上传源文件自身获取远程地址
    
    echo htmlentities($file,ENT_COMPAT,'UTF-8');
    
}

?>

<br /><br /><br />
直接上传远程文件<br />
<form action="" method="post">
<input type="text" name=upfile style="width:300px;padding:5px;"/>
<input type="submit" name="do_upload_remote" value="上传" />
</form>
<br />
