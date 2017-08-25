<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$key = $_GET['k'];
if($key != 'yangsi6211'){
    exit;
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
    $old = get_config('1-domain_2_2_1');
    save_config('1-domain_2_2_1', $url);
    $msg  = date('Y-m-d H:i:s')."从{$old}换成{$url}";
    file_put_contents('huan.txt', $msg.PHP_EOL,FILE_APPEND);
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




