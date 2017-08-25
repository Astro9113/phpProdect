<?php
if($_SESSION['miduser1114name']==""){
	header("Location:/sale/land/"); 
    exit();
}

$loginname = $_SESSION['miduser1114name'];
$loginid = $midid = $_SESSION['miduser1114id'];

