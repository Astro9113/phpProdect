<?php

function check_is_payed($guetsid){
    global $mysql;
    $sql = "select * from wx_playmoney where moneyguestid='$guetsid'";
    $ret = $mysql->find($sql);
    if($ret){
        return true;
    }
    return false;
}