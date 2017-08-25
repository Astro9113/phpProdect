<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,10);
qx($allow_qx, $adminclass);


if(isset($_POST['up'])){
    
    $file = $_FILES['f'];
    
    $dh = file_get_contents($file['tmp_name']);
    
    
    $dh = trim($dh);
    $dh_arr = explode("\n", $dh);
    
    if(!trim($dh)){
        exit('请输入单号');
    }
    
    foreach($dh_arr as $k=>$v){
        $dh_arr[$k] = trim($v);
        if(!$dh_arr[$k]){
            unset($dh_arr[$k]);
            continue;
        }
    }
    
    //提交的总数
    $total = count($dh_arr);
    echo "提交总数{$total}<br /><br />";
    
    //重复的单号
    $chongfu = array();
    $distant = array_count_values($dh_arr);
    
    $dhs = array_keys($distant);
    foreach ($dhs as $v){
        $_sdhs[] = "'".trim($v)."'";
    }
    
    $_sdhs = join(',',$_sdhs);
    $sql = " select id,guestkuaidi,gueststate,guestrizhi from wx_guest where guestkuaidi in (". $_sdhs .")";
    $infos = $mysql->query($sql);
    
    
    foreach ($infos as $info){
        $rizhi = $info['guestrizhi'];
        $pos = strpos($rizhi, '， 已签收');
        if($pos!==false){
            $rizhi = substr($rizhi, $pos-20,37);
        }else{
            $rizhi = '';
        }
        echo "id:{$info['id']},dh:{$info['guestkuaidi']},日志:{$rizhi}<br/>";
    }
    
    

}


?>

<style>
table,td,th{border:1px solid #ccc;}
table{border-collapse:collapse;}
th{background-color:#ccc;}
td{padding:5px 8px;}
span.orderstate{font-weight:700;color:blue;}
</style>

<div id="form">
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="f">
<br /><br />
<input type="submit" name="up" value="提交数据">
</form>
</div>