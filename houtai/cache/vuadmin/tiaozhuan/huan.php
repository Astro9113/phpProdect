<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$key = $_GET['k'];
if($key != 'yangsi6211'){
    exit;
}


$wait_time = 60 * 3;
$tag = isset($_GET['tag'])?$_GET['tag']:'';
$logfile = 'log.txt';
$log = trim(file_get_contents($logfile));
if($log){
    $logs = explode('_', $log);
    $last_tag  = $logs[0];
    $last_time = $logs[1];
    if($last_tag !== $tag){
        $jiange = time() - $last_time;
        if($jiange >= $wait_time){
            $newlog = $tag.'_'.time();
            file_put_contents($logfile, $newlog);
            $msg = date('Y-m-d H:i:s').':客户端'.$tag.'检测到链接已封,并且客户端'.$last_tag.'已经超过'.$wait_time.'秒未活动,由'.$tag.'执行更换';
            file_put_contents('huan.txt', $msg.PHP_EOL,FILE_APPEND);
        }else{
            $msg = date('Y-m-d H:i:s').':客户端'.$tag.'检测到链接已封,但客户端'.$last_tag.'正在活动,直接跳过';
            file_put_contents('huan.txt', $msg.PHP_EOL,FILE_APPEND);
            exit;
        }
    }else{
        $newlog = $tag.'_'.time();
        file_put_contents($logfile, $newlog);
    }
}else{
    $newlog = $tag.'_'.time();
    file_put_contents($logfile, $newlog);
}


//echo $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
//exit;
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require 'set.php';


if($_GET['a']=='huan'){
    foreach ($arr as $k=>$data){
        $url = trim($data['url']);
        $able = $data['able'];
        if(!$able){
            continue;
        }
    
        //换链接
        huan($url);
    
        //更新备用
        $arr[$k]['able'] = 0;
        update_set($arr);
    
        break;
    }
}else{ 
    
    echo '<pre>';
    print_r($arr);
    
}



function huan($url){
	global $tag;
    $old = get_config('1-jumpdomain_2');
    save_config('1-jumpdomain_2', $url);
    $msg  = date('Y-m-d H:i:s')."从{$old}换成{$url}:{$tag}";
    file_put_contents('huan.txt', $msg.PHP_EOL,FILE_APPEND);
    file_get_contents('http://wx.mecnss.top/check_and_mark.php?url='.$old);
}

function update_set($arr){
	if(!$arr){
		exit;
	}
    $str = '<?php'.PHP_EOL;
    $str .= '$arr = ';
    $str .= var_export($arr,true);
    $str .= ';';
    $str .= PHP_EOL;    
    file_put_contents('set.php', $str);
}




