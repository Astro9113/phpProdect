<?php

//商品数量 
function shop_get_num(){
    global $mysql;
    $sql = "select count(*) as num from wx_shop";
    $result = $mysql->find($sql);
    $num = $result['num'];
    return $num;
}

//获取所有商品信息
function get_shops(){
    global $mysql;
    $sql = "select * from wx_shop where 1";
    $ret = $mysql->query_assoc($sql, 'id');
    return $ret;
}

//根据获取sku名称
function get_shop_sku_name($shop, $skuid)
{
    $shopskuid = "shopsku" . $skuid;
    $shopsku = $shop[$shopskuid];
    $shopsku = explode("_", $shopsku);
    return $shopsku[0];
}

//商品信息
function shopinfo($shopid){
    global $mysql;
    $sql = "select * from wx_shop where id = $shopid";
    $ret = $mysql->find($sql);
    return $ret;
}

//商品信息
function find_shop_byname($shopname2){
    global $mysql;
    $sql = "select * from wx_shop where shopname2 = '{$shopname2}'";
    $ret = $mysql->find($sql);
    return $ret;
}


//sku 信息
function shopsku($shop,$skuid){
    $shopskuid = "shopsku" . $skuid;
    $shopsku = $shop[$shopskuid];
    $shopsku = explode("_", $shopsku);
    return $shopsku;
}

//商品分类
function shopclasses(){
    global $mysql;
    $sql = "select * from wx_shopclass order by shopclassid desc";
    $ret = $mysql->query_assoc($sql, 'shopclassid');
    return $ret;
}

function upbot_num(){
    global $mysql;
    $w = "upbot = 0";
    $num1 = $mysql->count_table('wx_shop',$w);
    $w = "upbot = 1";
    $num2 = $mysql->count_table('wx_shop',$w);
    
    return array($num1,$num2);
}

function shopimg($img,$path){
    if (strpos($img, 'http') !== false) {
        return $img;
    } else {
        return  $path . $img;
    }
}

function shopskus($shopid){
    $shop = shopinfo($shopid);
    $skus = array();
    for ($i = 1;$i <= 12;$i++){
        $field = 'shopsku'.$i;
        $skus[$i] = array('id'=>$i,'name'=>$shop[$field]);
    }
    return $skus;
}