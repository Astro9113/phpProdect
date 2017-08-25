<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,10
);
qx($allow_qx, $adminclass);



$type_arr = array('5ycto5zc','6ycto6zc');

$err = '';

if($_POST['sub']){
    $type = $_POST['type'];
    if(!in_array($type, $type_arr)){
        exit('参数错误');
    }
    
    if($type == '5ycto5zc'){
        $id = $_POST['id'];
        if(count($id)<=0){
            exit('没有要处理的数据');
        }
        
        foreach ($id as $i){
            $guest = guestinfo($i);
            $gueststate = intval($guest['gueststate']);
            if($gueststate!=5){
                $err .= "订单:{$i}--状态不是已结算不能改为 <<已回款>><br />";
                continue;
            }else{
                change_dzstate($i, 3);
            }
        }
    }else if($type == '6ycto6zc'){
        $id = $_POST['id'];
        if(count($id)<=0){
            exit('没有要处理的数据');
        }
        
        foreach ($id as $i){
            $guest = guestinfo($i);
            $gueststate = intval($guest['gueststate']);
            
            if($gueststate != 6){
                $err .= "订单:{$i}--状态不是拒收不能改为 <<退回签收>><br />";
                continue;
            }else{
                change_dzstate($i, 1);
            }
        }
    }
    
    if($err){
        echo $err;
    }else{
        echo '修改成功';
    }
}

//改对账状态
function change_dzstate($guestid,$stateid){
    global $mysql;
    $sql = "update wx_dzguest set stateid = '{$stateid}' where guestid  ='{$guestid}'";
    $mysql->execute($sql);
}