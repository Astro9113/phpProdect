<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,
        9
); 


$mid = intval($_REQUEST['mid']);
if(!$mid){
    exit('参数错误');
}

$k = 'vu_zhijiexiadan_xianshi_'.$mid;

if(isset($_POST['sub'])){
    $urls_a = array();
    $urls = $_POST['url'];
    
    foreach ($urls as $url){
        if($url){
            $urls_a[] = $url;
        }
    }


    $urls_a = serialize($urls_a);
    save_config($k, $urls_a);
	echo '<script>location.href="zhijie.php?mid='.$mid.'";</script>';
	exit;
}

$urls_a = get_config($k);
$urls_a = unserialize($urls_a);

if(!$urls_a){
    $urls_a = array();
}

?>


<form action="" method="post">
<?php 
    foreach ($urls_a as $url){
        $tpl = '<input type="text" name="url[]" value="%s">';
        $html = sprintf($tpl,$url);
        echo $html.'<br />'.PHP_EOL;
    }
?>
<input type="text" name="url[]" value=""><br />
<input type="hidden" name="mid" value="<?php echo $mid;?>"><br />
<input type="submit" name="sub" value="gooooooooooooooo">
</form>




