<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";

$id = intval($_POST['id']);
$info = shopinfo($id);
if (! $info) {
    alert('商品不存在');
    goback();
}


$data['shopclass'] = intval($_POST['shopclass']);
$data['shopname']  = $_POST['shopname'];
$data['shopname2'] = $_POST['shopname2'];

$map = " shopname2 = '{$data['shopname2']}' and id <> '{$id}'";
$num = $mysql->count_table('wx_shop',$map);
if($num){
    alert('相同的副标题已经存在,请修改后添加');
    goback();
}



$data['shopcon'] = $_POST['shopcon'];


$data['shopcopytxt'] = join('^', $_POST['shopcopytxt']);
$data['shopcopya']  =  join('^', $_POST['shopcopya']);



$up = $_FILES['upfile'];
if($up['name']){
    $save_dir = UPLOAD_PATH.date("ymd").'/';
    $up_class = new upload($save_dir);
    
    $up = $_FILES['upfile'];
    $ret = $up_class->move($up);
    $shoppic= $up_class->up_yun($ret);
    if(!$shoppic){
        echo $up_class->err;
        exit('上传失败');
    }
    $data['shoppic'] = $shoppic;
    
}else{
	$shoppic=$_POST['oldshoppic'];
}
   
for($i=1;$i<=12;$i++){
    $shopskuname = $_POST['shopskuname'.$i];
    $shopbuy     = $_POST['shopbuy'.$i];
    $shopget     = $_POST['shopget'.$i];
    $data['shopsku'.$i]    = $shopskuname."_".$shopbuy."_".$shopget;
}

$data['shopcolor'] = $_POST['shopcolor'];
$data['shopsize'] = $_POST['shopsize'];


//默认sku
$data['skumr'] = intval($_POST['skumr']);
if($data['skumr']<1 || $data['skumr']>12){
    $data['skumr'] = 1;
}


$data['shopusernum'] = intval($_POST['shopusernum']);
$data['shopfensinum'] = intval($_POST['shopfensinum']);
$data['shopstatinum'] = intval($_POST['shopstatinum']);
$data['shopoutlv'] =  intval($_POST['shopoutlv']);
 

$data['shopcopy'] = gl_sql($_POST['shopcopy']);

$str = $mysql->arr2s($data,'update');
$sql = "update wx_shop set {$str} where id = '{$id}' limit 1";
$ret = $mysql->execute($sql);
if($ret){
    go('../../');
}else{
    alert('修改失败');
    goback();
}


