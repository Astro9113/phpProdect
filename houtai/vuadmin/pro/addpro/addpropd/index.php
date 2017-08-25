<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";

$allow_qx = array(1);
qx($allow_qx, $adminclass);

foreach ($_POST as $k=>$v){
    $_POST[$k] = gl_sql(gl2($v));
}

$data['shopclass'] = intval($_POST['shopclass']);
$data['shoptype'] = intval($_POST['shoptype']);

$data['shopname']  = $_POST['shopname'];
$data['shopname2'] = $_POST['shopname2'];

$map = " shopname2 = '{$data['shopname2']}'";
$num = $mysql->count_table('wx_shop',$map);
if($num){
    alert('相同的副标题已经存在,请修改后添加');
    goback();
}

$data['shopcon'] = $_POST['shopcon'];

$data['shopcopytxt'] = $_POST['shopcopytxt1'].'^'.$_POST['shopcopytxt1'].'^'.$_POST['shopcopytxt1'];
$data['shopcopya']  = $_POST['shopcopya1'].'^'.$_POST['shopcopya2'].'^'.$_POST['shopcopya3'];


$data['adduser'] = $adminname;

$save_dir = UPLOAD_PATH.date("ymd").'/';
$up_class = new upload($save_dir);

$up = $_FILES['upfile'];
$ret = $up_class->move($up);
//$shoppic= $up_class->up_yun($ret);

$shoppic = substr($ret, strlen($save_dir));
$shoppic = 'http://ht.dbhpqs.pw/upload/'.date('ymd').'/'.$shoppic;

if(!$shoppic){
    echo $up_class->err;
    exit('上传失败');
}
$data['shoppic'] = $shoppic;



for($i=1;$i<=12;$i++){
    $shopskuname = $_POST['shopskuname'.$i];
    $shopbuy     = $_POST['shopbuy'.$i];
    $shopget     = $_POST['shopget'.$i];
    $data['shopsku'.$i]    = $shopskuname."_".$shopbuy."_".$shopget;
}

$total = $mysql->count_table('wx_shop');
$data['shoporder'] = $total + 1;

$data['shoptype'] = $_POST['shoptype'];
$data['shopcolor'] = $_POST['shopcolor'];
$data['shopsize'] = $_POST['shopsize'];


//默认sku
$data['skumr'] = intval($_POST['skumoren']);
if($data['skumr']<1 || $data['skumr']>12){
	$data['skumr'] = 1;
}

$str = $mysql->arr2s($data);
$sql = "insert into wx_shop {$str}";
$ret = $mysql->execute($sql);

if($ret){
	go('../../');
}else{
    alert('添加失败');
    goback();
}
