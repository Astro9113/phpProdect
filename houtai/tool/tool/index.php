<?php
include 'init.php';

$arr = array(
        '上传文件到云'  =>'up/',
        '解析css文件'  =>'upcss/',
        '解析html文件'  =>'uphtml/',
        '测试'        =>'test/',
        '转换工具'     =>'zhuan/',
		'解析工具'     =>'domain/',
        '解析微信文案'  =>'upwxwan/',
 
);


foreach ($arr as $k=>$v){
    echo "$k : <a href='$v' target='_blank'>开始使用</a><br /><br />";
}

