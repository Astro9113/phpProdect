<?php
//物流状态
function get_shipstate(){
    global $mysql;
    $sql = "select * from wx_shipstate where 1";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//物流公司
function get_wuliugs(){
    global $mysql;
    $sql = "select * from wx_wuliugs where 1";
    $ret = $mysql->query_assoc($sql, 'wuliugsname');
    return $ret;
}

function wuliugsinfo($wuliugsname){
    global $mysql;
    $sql = "select * from wx_wuliugs where wuliugsname='$wuliugsname'";
    $ret = $mysql->find($sql);
    return $ret;
}









