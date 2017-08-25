<?php

$urls = $_POST['url'];
$ables = $_POST['able'];

$arr = array();


foreach($urls as $k=>$url){
	$url = trim($url);
	if($url){
	    $tmp = array('url'=>$url,'able'=>intval($ables[$k]));
		$arr[] = $tmp;
	}
}



$news = trim($_POST['news']);
$news = explode("\n", $news);
foreach ($news as $new_url){
    $new_url = trim($new_url);
    if($new_url){
        $tmp = array('url'=>$new_url,'able'=>1);
        $arr[] = $tmp;
    } 
}

function update_set($arr){
	if(!$arr){
		exit;
	}
    $str = '<?php'.PHP_EOL;
    $str .= '$arr = ';
    $str .= var_export($arr,true);
    $str .= ';';
    $str .= PHP_EOL;    
    file_put_contents('set.php', $str);
}

echo '<pre>';
print_r($arr);

update_set($arr);
echo 'done';

echo '<script>location.href="do.php";</script>';


