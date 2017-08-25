<?php   
    if($_SESSION['admin1114name']==""){
    	header("Location:/vuadmin/land/"); 
        exit();
    }
    
    $adminname = $_SESSION['admin1114name'];
    $adminclass = $_SESSION['admin1114class'];
    $loginid = $_SESSION['admin1114id'];
