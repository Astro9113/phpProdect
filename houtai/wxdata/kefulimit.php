<?php   
if($_SESSION['kefu1114name']==""){
	header("Location:/vukefu/land/"); 
    exit();
}

$loginname = $_SESSION['kefu1114name'];
$loginid = $kefid = $_SESSION['kefu1114id'];
