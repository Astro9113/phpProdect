<?php

//订单修改日志
function log_orderstate_db($arr){
    global $mysql;
    $str = $mysql->arr2s($arr);
    $sql = "insert into wx_state_log {$str}";
    $mysql->execute($sql);    
}