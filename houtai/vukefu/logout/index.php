<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
    unset($_SESSION['kefu1114name']);
	unset($_SESSION['kefu1114id']);
    go('http://'.$_SERVER['HTTP_HOST'].'/vukefu/');    
