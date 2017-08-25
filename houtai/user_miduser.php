<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);

echo "<h2>用户转媒介  微优</h2>";

if($_POST['sub']){
    $mid = $_POST['mid'];
    $mid = intval($mid);
    if(!$mid){
        exit;
    }
    
    $value = 'm'.$mid;
    
    $ids = $_POST['ids'];
    $ids = trim($ids);
    $ids = explode(',', $ids);
    foreach ($ids as $uid){
        $target = get_field($uid);
        if(!$target){
            continue;
        }
        $ret = change_mid2($uid,$target,$value);
        $msg = $ret?' ok':' error';
        echo $uid,$msg,'<br />';
    }
}




function get_field($uid){
    $sql = "select topuser,dinguser from wx_user where id = '$uid'";    
    $result = mysql_query($sql);
    $ret = mysql_fetch_assoc($result);
    $target = '';
    $topuser = $ret['topuser'];
    if(strpos($topuser, 'm')!==false){
        $target = 'topuser';
    }else{
        $target = 'dinguser';
    }
    return $target;
}

function change_mid2($uid,$target,$value){
    ECHO $sql = "update wx_user set {$target} = '{$value}' where id='{$uid}'";
    $ret = mysql_query($sql);
    return $ret;
}


function get_mid(){
    $sql = "select id,username from wx_miduser where 1 order by id";
    $result = mysql_query($sql);
    while ($r = mysql_fetch_assoc($result)){
        $ret[] = $r;
    }
    return $ret;
}



$mids = get_mid();
foreach ($mids as $muser){
    echo '<p>',$muser['id'],':',$muser['username'],'</p>';
}

?>

<form action="" method="post">
<input type="text" name="mid" style="width:400px;"> 媒介ID <br />
<textarea name="ids" style="width:400px;height:200px;"></textarea>用户ID 以英文逗号分割 不能有空格<br />
<input type="submit" name="sub" value="ok">
</form>