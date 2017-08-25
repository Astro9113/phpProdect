<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require CLASS_PATH . "upload_class.php";

$pic = urldecode($_GET['pic']);
$ext = substr($pic, -3);

if(!in_array($ext, array('jpg','gif','png'))){
    exit();
}

$filename = date('His').rand(0, 99).'.'.$ext;


$save_dir = UPLOAD_PATH.date("ymd");
if(!is_dir($save_dir)){
   mkdir($save_dir); 
}

$save_dir .= '/';



//$up_class = new upload($save_dir);


$file_path = $save_dir.$filename;
while (file_exists($file_path)){
    $filename = date('His').rand(0, 99).'.'.$ext;
    $file_path = $save_dir.$filename;
}

$file = file_get_contents($pic);
file_put_contents($file_path, $file);


$shoppic = substr($file_path, strlen($save_dir));
$shoppic = 'http://vucpsqiniu.bkxgr.cn/upload/'.date('ymd').'/'.$shoppic;
echo $shoppic;
