<?php

function go($url){
    echo '<script>location.href="'.$url.'";</script>';
    exit;
}


function mylog($log,$rn=1,$logfile=''){
    if(!$logfile){
        global $commonLog;
        $logfile = $commonLog;
    }
    if($rn){
        $log .= PHP_EOL;
    }
    file_put_contents($logfile, $log,FILE_APPEND);
}