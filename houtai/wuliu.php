<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
?>

<form method="get">
<input type="text" name="id">
<select name="wuliu">
<option value="ems">EMS</option>
<option value="shunfeng">sf</option>
</select>

<select name="type">
<option value="dh">danhao</option>
<option value="id">id</option>
</select>

<input type="submit">
</form>

<?php 

if(!$_GET['id']){
exit;
}


$type = $_GET['type'];
$id = $_GET['id'];
$wuliu = $_GET['wuliu'];


if($type=='id'){
	$sql = "select * from wx_guest where id = $id";
	$rs = mysql_query($sql);
	$r = mysql_fetch_assoc($rs);
	$dh = $r['guestkuaidi'];  
}else{
	$dh = $id;
}

if($wuliu=='ems'){
    $base ="http://www.sto-a.com/rest/?id=ems&key=789b606599bd4b6786e2a7c2e3855bf1&order=%s";
}else{
    $base ="http://www.zto100.com/restv.aspx?id=sf&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s";
    
}


echo $url = sprintf($base,$dh);

$ret = file_get_contents($url);
$ret = json_decode($ret);
$ret = $ret->datas[0];

echo '<pre>';
print_r($ret);


$function = "jiexi_{$wuliu}";

$ret2 = $function($ret);

print_r($ret2);


//解析物流返回状态_ems
function jiexi_ems($o){
    //自定义关键字
    $keywords = array('未妥投'=>'未妥投',);

    if(!$o){
        return false;
    }

    //$o = json_decode($data);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->orders;
	
	
	
    $item_count = count($items);
    $sub = $item_count-1;
    $sub2 = $item_count-2;
    $sub3 = $item_count-3;

    $last_item_content_jiansuo = $items[$sub]->content.$items[$sub2]->content.$items[$sub3]->content;

    $gendan=$items[$sub3]->time.' '.$items[$sub3]->content.'<br/>'.$items[$sub2]->time.' '.$items[$sub2]->content.'<br/>'.$items[$sub]->time.' '.$items[$sub]->content.'<br/>';


    $last_item_content = $items[$sub]->content;
    $lat_item_time = $items[$sub]->time;
    $last_info = "time:{$lat_item_time}###content:{$last_item_content}";

    //小于三条信息直接返回在途中
    if($item_count < 3){
        $return = array();
        $return = array('status'=>'在途中','last'=>$last_info);
        return $return;
    }


    //遍历每一站检查状态
    /*
     foreach($items as $k=>$zhan){
     $str = (string)$zhan->content;
     if(strpos($str, '退回')!==false){
     $return = array();
     $return = array('status'=>'已拒收','last'=>$last_info);
     return $return;
     }
     }
     */


    //物流状态 是否==4
    if($status==4){
        $return = array();
        if(strpos($last_item_content, '投递并签收')!==false){
            if(strpos($last_item_content, '北京')!==false){
                $return = array('status'=>'已拒收','last'=>$last_info);
                return $return;
            }else{
                $return = array('status'=>'已签收','last'=>$last_info);
                return $return;
            }
        }

    }


    //最新一条信息检测关键字
    foreach($keywords as $db_status=>$keyword){
        if(strpos($last_item_content_jiansuo,$keyword)!==false){
            $return = array();
            $return = array('status'=>$db_status,'last'=>$last_info,'gendan'=>$gendan);
            return $return;
        }
    }

    $return = array();
    $return = array('status'=>'在途中','last'=>$last_info);
    return $return;

}

//解析物流返回状态_shunfeng
function jiexi_shunfeng($o){
    $keywords = array(
        '派送不成功'=>'派送不成功',
        '自取'=>'自取快件',
        '联系不上'=>'无法联系',
        '拒付款'=>'未支付',
        '刚拒收'=>'拒收快件',
        '改派时间'=>'派送时间',

    );
    if(!$o){
        return false;
    }

    //$o = json_decode($data);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->orders;

    $item_count = count($items);
    $sub = $item_count-1;
    $sub2 = $item_count-2;
    $sub3 = $item_count-3;

    $last_item_content_jiansuo = $items[$sub]->content.$items[$sub2]->content.$items[$sub3]->content;

    $gendan=$items[$sub3]->time.' '.$items[$sub3]->content.'<br/>'.$items[$sub2]->time.' '.$items[$sub2]->content.'<br/>'.$items[$sub]->time.' '.$items[$sub]->content.'<br/>';

    $last_item_content = $items[$sub]->content;
    $lat_item_time = $items[$sub]->time;
    $last_info = "time:{$lat_item_time}###content:{$last_item_content}";

    //小于三条信息直接返回在途中
    if($item_count < 3){
        $return = array();
        $return = array('status'=>'在途中','last'=>$last_info);
        return $return;
    }

    //遍历每一站检查状态

    $notice = 0;//检查是否出现拒收

    foreach($items as $k=>$zhan){
        $str = (string)$zhan->content;
        if((strpos($str, '退回')!==false)){
            $return = array();
            $return = array('status'=>'已拒收','last'=>$last_info);
            return $return;
        }

        if((strpos($str, '拒收')!==false) &&($status==4)){
            //myLog($o->order);
            $notice = 1;
        }
    }

    //物流状态 是否==4
    if($status==4){
        $return = array();
        $return = array('status'=>'已签收','last'=>$last_info,'notice'=>$notice);
        return $return;
    }

    //最新一条信息检测关键字
    foreach($keywords as $db_status=>$keyword){
        if(strpos($last_item_content_jiansuo,$keyword)!==false){
            $return = array();
            $return = array('status'=>$db_status,'last'=>$last_info,'gendan'=>$gendan);
            return $return;
        }
    }

    $return = array();
    $return = array('status'=>'在途中','last'=>$last_info);
    return $return;

}
