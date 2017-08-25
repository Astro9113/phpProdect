<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";
ini_set('display_errors', 'off');

$cdndomain = 'http://vucpsqiniu.bkxgr.cn'; 


if($_POST['sub']){
    $id = isset($_POST['id'])?intval($_POST['id']):0;
    if(!$id){
        exit('id error');
    }
    
    $uparr = array();
    
    $hide = intval($_POST['hide']);
    $uparr['hide'] = $hide;
    
    $con = addslashes($_POST['con']);
    if($con){
        $uparr['con'] = $con;
    }
    
    $save_dir = UPLOAD_PATH.'addon/'.date("ymd").'/';
    $up_class = new upload($save_dir);
    
    //echo '<pre>';var_dump($_FILES);exit;
    
    foreach ($_FILES as $k=>$v){
        if(!$_FILES[$k]['tmp_name']){
            continue;
        }
        $shoppic = '';
        $up = $_FILES[$k];
        $ret = $up_class->move($up);
        $filename = substr($ret,strlen($save_dir));
        $shoppic = $cdndomain.'/upload/addon/'.date("ymd").'/'.$filename;
        $uparr[$k] = $shoppic;
    }
    
    $upstr = array();
    
    foreach ($uparr as $k=>$v){
        $upstr[] = "`$k` = '$v'";
    }
    
    $upstr = join(',', $upstr);
    
    if($upstr){
        $sql = "update wx_shop_addon set {$upstr} where id = {$id}";
        
        //echo $sql;exit;
        
        $ret = $mysql->execute($sql);
    }
    
    $url = "detail.php?id={$id}";
    go($url);
    
}


$id = intval($_GET['id']);
$sql = "select * from wx_shop_addon where id = $id ";
$addon = $mysql->find($sql);


$shopid = $addon['shopid'];
$shop = shopinfo($shopid);

?>


<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $id;?>">


<table>
<tr>
<td>字段</td>
<td>内容</td>
<td>图片</td>
</tr>

<tr>
<td>商品</td>
<td><?php echo $shop['shopname'];?></td>
<td></td>
</tr>

<tr>
<td>标题</td>
<td><?php echo $addon['title'];?></td>
<td></td>
</tr>

<tr>
<td>状态</td>
<td>
<select name="hide">
<option value="0" <?php if(!$addon['hide']){echo 'selected';}?>>显示</option>
<option value="1" <?php if($addon['hide']){echo 'selected';}?>>隐藏</option>
</select>
</td>
<td></td>
</tr>


<tr>
<td>横幅图片</td>
<td><input type="file" name="ad_img_heng"></td>
<td><img src="<?php echo $addon['ad_img_heng']; ?>" style="height:100px"/></td>
</tr>

<tr>
<td>单图文封面</td>
<td><input type="file" name="ad_img_fang"></td>
<td><img src="<?php echo $addon['ad_img_fang']; ?>" style="height:100px"/></td>
</tr>

<tr>
<td>三图文封面_1</td>
<td><input type="file" name="ad_img_san_1"></td>
<td><img src="<?php echo $addon['ad_img_san_1']; ?>" style="height:100px"/></td>
</tr>

<tr>
<td>三图文封面_2</td>
<td><input type="file" name="ad_img_san_2"></td>
<td><img src="<?php echo $addon['ad_img_san_2']; ?>" style="height:100px"/></td>
</tr>

<tr>
<td>三图文封面_3</td>
<td><input type="file" name="ad_img_san_3"></td>
<td><img src="<?php echo $addon['ad_img_san_3']; ?>" style="height:100px"/></td>
</tr>

<tr>
<td>内容</td>
<td colspan=2>
<!-- 加载编辑器的容器 -->
<script id="container" name="con" type="text/plain">
<?php 
    echo $addon['con'];
?>
</script>
</td>
</tr>

</table>

<input type="submit" name="sub" value="提交" /> 
</form>

<script type="text/javascript" src="e/ueditor.config.js"></script>
<script type="text/javascript" src="e/ueditor.all.js"></script>
<script type="text/javascript">
        var ue = UE.getEditor('container');
</script>
    
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script></script>
<style>
table,td{border-collapse:collapse;border:1px solid #000;}
td{padding:5px;}
.bghide{background-color:red}
.bgshow{background-color:green}
</style>