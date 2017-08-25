<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
	file_put_contents('E:\log\login\vu\logout.txt',date('Y-m-d H:i:s').'_'.$_SESSION['admin1114name'].'_'.$_SESSION['admin1114class'].'_'.$_SESSION['admin1114id'].PHP_EOL,FILE_APPEND);

	$_SESSION['admin1114name']="";
	$_SESSION['admin1114class']="";
	$_SESSION['admin1114id'] = '';
    
    go('/vuadmin/');