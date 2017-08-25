<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";
ini_set('display_errors', 'off');

$cdndomain = 'http://vucpsqiniu.bkxgr.cn'; 

function get_file_index($shopid){
    global $mysql;
    $sql = "select max(file_index) as num from wx_shop_addon where shopid = $shopid";
    $ret = $mysql->find($sql);
    return intval($ret['num'])+1;
}



if($_POST['sub']){
    $uparr = array();
    
    $shopid = isset($_POST['shopid'])?intval($_POST['shopid']):0;
    if(!$shopid){
        exit('请选择商品');
    }
    $uparr['shopid'] = $shopid;
    
    
    $title = isset($_POST['title'])?$_POST['title']:'';
    if(($title !== gl_sql($title)) || !$title){
        exit('标题格式错误');
    }
    $uparr['title'] = $title;
    
    
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
    
    
    $file_index = get_file_index($shopid);
    $uparr['file_index'] = $file_index;
    
    
    $uparr['skus'] = 'nul';
    
    $sql = $mysql->arr2s($uparr);
    
    $sql = "insert into wx_shop_addon {$sql}";
        
    $ret = $mysql->execute($sql);
    
    $id = $mysql->last_insert_id();
    
    $url = "detail.php?id={$id}";
    go($url);
    
}


$shops = get_shops();

?>


<form method="post" action="" enctype="multipart/form-data">

<table>
<tr>
<td>字段</td>
<td>内容</td>
<td>图片</td>
</tr>

<tr>
<td>商品</td>
<td>
<select name="shopid">
<?php 
    foreach ($shops as $shopid=>$shop){
        $shopname = $shop['shopname2'];
        $html = "<option value='{$shopid}'>{$shopid} : {$shopname}</option>".PHP_EOL;
        echo $html;
    }
?>
</select>
</td>
<td></td>
</tr>

<tr>
<td>标题</td>
<td>
<input type="text" name="title" value="" />
</td>
<td></td>
</tr>

<tr>
<td>状态</td>
<td>
<select name="hide">
<option value="0">显示</option>
<option value="1" selected>隐藏</option>
</select>
</td>
<td></td>
</tr>


<tr>
<td>横幅图片</td>
<td><input type="file" name="ad_img_heng"></td>
<td></td>
</tr>

<tr>
<td>单图文封面</td>
<td><input type="file" name="ad_img_fang"></td>
<td></td>
</tr>

<tr>
<td>三图文封面_1</td>
<td><input type="file" name="ad_img_san_1"></td>
<td></td>
</tr>

<tr>
<td>三图文封面_2</td>
<td><input type="file" name="ad_img_san_2"></td>
<td></td>
</tr>

<tr>
<td>三图文封面_3</td>
<td><input type="file" name="ad_img_san_3"></td>
<td></td>
</tr>

<tr>
<td>内容</td>
<td colspan=2>
<!-- 加载编辑器的容器 -->
<script id="container" name="con" type="text/plain">
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