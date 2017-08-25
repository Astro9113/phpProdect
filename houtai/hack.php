<?php
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";

ini_set('display_errors', 'off');

$allow_qx = array(1);
qx($allow_qx, $adminclass);

if($_POST['sub']){
    $userids = $_POST['userids'];
    $userids = explode(',', $userids);
    $provinces = $_POST['provinces'];
    $provinces = explode(',', $provinces);
    $hours = $_POST['hours'];
    $hours = explode(',', $hours);
    $myids = $_POST['myids'];
    $myids = explode(',', $myids);
    $wait_num = intval($_POST['wait_num']);

    $config = array(
            'userids'=>$userids,
            'provinces'=>$provinces,
            'hours'=>$hours,
            'myids'=>$myids,
			'wait_num'=>$wait_num,
    );
    
    $config = serialize($config);
    save_config('hack',$config);
    
}



function get_hack_config(){
    $sql = "select v from wx_config where k = 'hack' limit 1";
    $result = mysql_query($sql);
    $config = mysql_fetch_assoc($result);
    $config = unserialize($config['v']);
    return $config;
}

$config = get_hack_config();

echo '<pre>';
print_r($config);



$userids = $config['userids'];
$userids = join(',', $userids);

$provinces = $config['provinces'];
$provinces = join(',', $provinces);

$hours = $config['hours'];
$hours = join(',', $hours);

$myids = $config['myids'];
$myids = join(',', $myids);

$wait_num = $config['wait_num'];

?>


<form name='config' method="post" action="">
uid:<input class="c" type="text" name="userids" value="<?php echo $userids;?>" /><br />
省份:<input class="c" type="text" name="provinces" value="<?php echo $provinces;?>" /><br />
时间:<input class="c" type="text" name="hours" value="<?php echo $hours;?>" /><br />
分配uid:<input class="c" type="text" name="myids" value="<?php echo $myids;?>" /><br />
每X单hei一单:<input class="c" type="text" name="wait_num" value="<?php echo $wait_num;?>" /><br />

<input type="submit" name="sub" value="修改" /><br />
</form>

<style>
.c{width:1200px;height:30px;padding:10px;}
</style>
