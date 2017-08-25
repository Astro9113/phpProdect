<?php   

if($_SESSION['caiwu1114name']==""){
	header("Location:/affair/land/"); 
    exit();
}

$loginname = $_SESSION['caiwu1114name'];
