<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
?>

<form method="get">
订单id : <input type="text" name="id">
<input type="submit">
</form>

<?php 
if(!$_GET['id']){
	exit;
}

$id = isset($_GET['id'])?intval($_GET['id']):0;

if(!$id){
	exit;
}

$sql = "select * from wx_guest where id = $id";
$rs = mysql_query($sql);
$r = mysql_fetch_assoc($rs);
$shopid = $r['shopid'];
if($shopid<>122){
	exit('不可以修改');
}


if(isset($_GET['act'])&&($_GET['act']=='change')){
	$skuid = intval($_GET['skuid']);
	$sql = "update wx_guest set shopid = 50 ,skuid = $skuid where id = $id and shopid = 122";
	$rs = mysql_query($sql);
	echo '修改成功';
	exit;
}


?>


<form method="get">
<input type="hidden" name="act" value="change">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="radio" name="skuid" value="1" checked>1瓶（男款）
<br />
<input type="radio" name="skuid" value="2">1瓶（女款）
<br />
<input type="submit" value="修改">
</form>


