<?php

//权限检查
function qx($allow,$adminclass){
    if(!in_array($adminclass, $allow)){
        exit('没有权限执行此操作');
    }
}

//用户信息
function admininfo($id){
    global $mysql;
    $sql = "select * from wx_admin where id = $id";
    $ret = $mysql->find($sql);
    return $ret;
}

function adminclass($classid){
    if($classid==1){
        $adminclassname="超级管理员";
    }elseif($classid==2){
        $adminclassname="普通管理员";
    }elseif($classid==3){
        $adminclassname="商品管理员";
    }elseif($classid==4){
        $adminclassname="用户管理员";
    }elseif($classid==5){
        $adminclassname="订单管理员";
    }elseif($classid==6){
        $adminclassname="财务管理员";
    }

    return $adminclassname;
}

function adminclasses(){
    global $mysql;
    $sql = "select * from wx_adminclass where 1";
    $ret = $mysql->query_assoc($sql,'id');
    return $ret;
}

function admins(){
    global $mysql;
    $sql = "select * from wx_admin where 1";
    $ret = $mysql->query_assoc($sql,'id');
    return $ret;
}
