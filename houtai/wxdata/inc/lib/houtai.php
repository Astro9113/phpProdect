<?php

//获取客服验证码
function get_yzm(){
    global $mysql;
    $sql = "select kefuyzm from wx_seting where 1 limit 1";
    $ret = $mysql->find($sql);
    return $ret['kefuyzm'];
}

