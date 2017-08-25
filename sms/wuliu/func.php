<?php 
//采集开始
function check_start(){
    $today = date('Y-m-d');
    $start = dirname(__FILE__).'/flag/'.$today.'_start';
    $end   = dirname(__FILE__).'/flag/'.$today.'_end';
    if(!file_exists($start)){
        file_put_contents($start, 1);
        init_table();
        return 1;
    }//尚未开始采集
    
    if(file_exists($start) && file_exists($end)){
        echo '今日已采集结束'.PHP_EOL;
        exit;
        //return -1;
    }//采集结束
    
    return 2;//开始采集尚未结束
}


//采集结束
function check_end(){
    $today = date('Y-m-d');
    $end   = dirname(__FILE__).'/flag/'.$today.'_end';
    if(!file_exists($end)){
        file_put_contents($end, 1);
        return 1;
    }//采集结束
}

//清空采集表
function init_table(){
    $sql = "TRUNCATE TABLE  `wx_gueststate`";
    mysql_query($sql);    
}


//获取任务至任务池 因为数量不多 所以一次性全部添加到任务池
function addTask(){
    global $curl;
    
    //添加顺丰任务
    $base ="http://www.zto100.com/restv.aspx?id=sf&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s";
    $sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate = 3 and wuliugs ='顺丰速运' and id not in (select guestid as id from wx_gueststate where 1) order by id";
    $sql  = mysql_query($sql);
    while(($info = mysql_fetch_assoc($sql))!==false){
            $ret[] = $info;
    }
    
    $total = count($ret);
    $pagesize = 10;
    $totalpage = ceil($total/$pagesize);
    for ($i=0;$i<$totalpage;$i++){
        $dhs = array();
        for ($j = $i*$pagesize;$j<$i*$pagesize+$pagesize;$j++){
            if(isset($ret[$j])){
                $guest = $ret[$j];
                $id = $guest['id'];
                $guestkuaidi = $guest['guestkuaidi'];
                $dhs[$id] = $guestkuaidi;                
            }
        }
        
        $dhs_str = join(',', $dhs);
        $url = sprintf($base,$dhs_str);
        $task_config = array('url'=>$url,'args'=>array('hash'=>array_flip($dhs),'wuliugs'=>'shunfeng',));
        $curl->add($task_config,'pat_con_shunfeng','err_shunfeng');
        
        echo 'add:sf'.$dhs_str.PHP_EOL;
        $dhs_str = $url = $task_config = null;
    }
    
    $base = $sql = $info = $ret = $total = $pagesize = $totalpage = null;
    
    //添加ems任务
    $base ="http://www.sto-a.com/rest/?id=ems&key=789b606599bd4b6786e2a7c2e3855bf1&order=%s";
    $sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate= 3 and wuliugs ='EMS' and id not in (select guestid as id from wx_gueststate where 1) order by id";
    $sql  = mysql_query($sql);
    while(($info = mysql_fetch_assoc($sql))!==false){
        $ret[] = $info;
    }
    
    $total = count($ret);
    $pagesize = 10;
    $totalpage = ceil($total/$pagesize);
    
    $ci = 0;
    for ($i=0;$i<$totalpage;$i++){
        $dhs = array();
        for ($j = $i*$pagesize;$j<$i*$pagesize+$pagesize;$j++){
            if(isset($ret[$j])){
                $guest = $ret[$j];
                $id = $guest['id'];
                $guestkuaidi = $guest['guestkuaidi'];
                $dhs[$id] = $guestkuaidi;
            }
        }
        
        
        
        $dhs_str = join(',', $dhs);
        $url = sprintf($base,$dhs_str);
        $task_config = array('url'=>$url,'args'=>array('hash'=>array_flip($dhs),'wuliugs'=>'ems',));
        $curl->add($task_config,'pat_con_ems','err_ems');
        
        //echo 'add:ems'.$dhs_str.PHP_EOL;
        $dhs_str = $url = $task_config = null;
        echo $i.PHP_EOL;
    }
    
    $base = $sql = $info = $ret = $total = $pagesize = $totalpage = null;
    
    
    //添加宅急送任务
    $base ="http://www.kuaidiapi.cn/rest/?uid=21550&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s&id=zjs";
    $sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate= 3 and wuliugs ='宅急送' and id not in (select guestid as id from wx_gueststate where 1) order by id";
    $sql  = mysql_query($sql);
    while(($guest = mysql_fetch_assoc($sql))!==false){
        $id = $guest['id'];
        $guestkuaidi = $guest['guestkuaidi'];
        $url = sprintf($base,$guestkuaidi);
        $task_config = array('url'=>$url,'args'=>array('guestid'=>$id));
        $curl->add($task_config,'pat_con_zjs','err_zjs');
        $url = $task_config = null;
        echo 'add:zjs'.$id.PHP_EOL;
    }
    
    $base = $sql = $info = $ret = $total = $pagesize = $totalpage = null;
}


//获取物流状态
function get_ship_status(){
    $sql = "select id,kuaidistate from wx_shipstate where 1";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $key = $row['kuaidistate'];
        $status_arr[$key] = $row['id'];
    }
    return $status_arr;
}

//转义入库数据
function maddslashes($str){
    if(get_magic_quotes_gpc()){
        return $str;
    }
    return addslashes($str);
}

//添加一条新的物流信息
function add_wuliu($guestid,$wuliustate,$newwuliu,$gend_ru,$notice=0){
	$notice = intval($notice);
    $sql = "insert into wx_gueststate(guestid,wuliustate,newwuliu,gendan,notice) values('$guestid','$wuliustate','$newwuliu','$gend_ru',$notice)";
    
	if($notice){
		myLog($sql);	
	}
	mysql_query($sql);

    //追单两次发短信
    if(!in_array($wuliustate,array(2,4,5))){
        $sql=mysql_query("insert into wx_zhuidan(guestid,zdstate) values('$guestid','$wuliustate')");
    }
}



//解析采集返回值:中通
function pat_con_zto($r,$args){
    global $status_arr;
    $guestid = $args['guestid'];

    if($r['info']['http_code']==200){
        $output = $r['content'];
        $return = jiexi_zto($output);

        if($return){
            $newwuliu = $return['last'];
            $gend_con = $return['gendan'];
            $newwuliu = maddslashes($newwuliu);
            $status_text = $return['status'];
            $wuliustate = $status_arr[$status_text];
            add_wuliu($guestid, $wuliustate, $newwuliu, $gend_con);
        }
        echo 'get:'.$guestid.PHP_EOL;
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
    }
}


//解析采集返回值
function pat_con_shunfeng($r,$args){
    global $status_arr;
    $hash = $args['hash'];
    //$wuliugs = $args['wuliugs'];
    //$function_name = 'jiexie_'.$wuliugs;
    
    if($r['info']['http_code']==200){
        $output = $r['content'];
        $obj = json_decode($output);
        $datas = $obj->datas;
        if($datas){
            foreach($datas as $data){
                $dh  = $data->order;
                $guestid = $hash[$dh];
                $return = jiexi_shunfeng($data);
                if($return){
                    $newwuliu = $return['last'];
                    $gend_con = $return['gendan'];
                    $newwuliu = maddslashes($newwuliu);
                    $status_text = $return['status'];
                    $wuliustate = $status_arr[$status_text];
					add_wuliu($guestid, $wuliustate, $newwuliu, $gend_con,$return['notice']);
                }
                echo 'get:'.$guestid.PHP_EOL;
            }
        }
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', join(',',$hash).PHP_EOL,FILE_APPEND);
    }
}


//解析采集返回值
function pat_con_ems($r,$args){
    global $status_arr;
    $hash = $args['hash'];
    //$wuliugs = $args['wuliugs'];
    //$function_name = 'jiexie_'.$wuliugs;

    if($r['info']['http_code']==200){
        $output = $r['content'];
        $obj = json_decode($output);
        $datas = $obj->datas;
        if($datas){
            foreach($datas as $data){
                $dh  = $data->order;
                $guestid = $hash[$dh];
                $return = jiexi_ems($data);
                if($return){
                    $newwuliu = $return['last'];
                    $gend_con = $return['gendan'];
                    $newwuliu = maddslashes($newwuliu);
                    $status_text = $return['status'];
                    $wuliustate = $status_arr[$status_text];
                    add_wuliu($guestid, $wuliustate, $newwuliu, $gend_con);
                }
                echo 'get:'.$guestid.PHP_EOL;
            }
        }
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', join(',',$hash).PHP_EOL,FILE_APPEND);
    }
}


//解析采集返回值
function pat_con_ems_s($r,$args){
    global $status_arr;
	$guestid = $args['guestid'];
    
	if($r['info']['http_code']==200){
        $output = $r['content'];
        $return = jiexi_ems_s($output);
		
		
        if($return){
					$newwuliu = $return['last'];
					$gend_con = $return['gendan'];
                    $newwuliu = maddslashes($newwuliu);
                    $status_text = $return['status'];
                    $wuliustate = $status_arr[$status_text];
                    add_wuliu($guestid, $wuliustate, $newwuliu, $gend_con);
        }
        echo 'get:'.$guestid.PHP_EOL;
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
    }
}

//解析采集返回值
function pat_con_zjs($r,$args){
    global $status_arr;
    $guestid = $args['guestid'];

    if($r['info']['http_code']==200){
        $output = $r['content'];
        $return = jiexi_zjs($output);
        if($return){
        	$newwuliu = $return['last'];
        	$newwuliu=mysql_real_escape_string($newwuliu);
        	$status_text = $return['status'];
        	$status_text = $status_text=='拒收2'?'刚拒收':$status_text;//因为拒收有两个关键字,这里统一标注为拒收
        	
        	$wuliustate = $status_arr[$status_text];
        	$sql=mysql_query("insert into wx_gueststate(guestid,wuliustate,newwuliu) values('$guestid','$wuliustate','$newwuliu')");
        	
        	if(!in_array($wuliustate,array(2,4,5))){
        	    $sql=mysql_query("insert into wx_zhuidan(guestid,zdstate) values('$guestid','$wuliustate')");
        	}
        }
        echo 'get:'.$guestid.PHP_EOL;
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
    }
}


//解析采集返回值 yuantong
function pat_con_yuantong($r,$args){
    global $status_arr;
    $guestid = $args['guestid'];

    if($r['info']['http_code']==200){
        $output = $r['content'];
        $return = jiexi_yuantong($output);
        if($return){
            $newwuliu = $return['last'];
            $newwuliu = mysql_real_escape_string($newwuliu);
            $status_text = $return['status'];
            //$status_text = $status_text=='拒收2'?'刚拒收':$status_text;//因为拒收有两个关键字,这里统一标注为拒收
            $wuliustate = $status_arr[$status_text];
            $sql=mysql_query("insert into wx_gueststate(guestid,wuliustate,newwuliu) values('$guestid','$wuliustate','$newwuliu')");
             
            if(!in_array($wuliustate,array(2,4,5))){
                $sql=mysql_query("insert into wx_zhuidan(guestid,zdstate) values('$guestid','$wuliustate')");
            }
        }
        echo 'get:'.$guestid.PHP_EOL;
    }else{
        file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
    }
}



//错误处理
function err_shunfeng($err,$args){
    $guestid = $args['hash'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', join(',',$hash).PHP_EOL,FILE_APPEND);
}

//错误处理
function err_ems($err,$args){
    $guestid = $args['hash'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', join(',',$hash).PHP_EOL,FILE_APPEND);
}

//错误处理
function err_ems_s($err,$args){
    $guestid = $args['guestid'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
}

//错误处理:中通
function err_zto($err,$args){
    $guestid = $args['guestid'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
}

//错误处理
function err_zjs($err,$args){
    $guestid = $args['guestid'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
}

//错误处理
function err_yuantong($err,$args){
    $guestid = $args['guestid'];
    file_put_contents(dirname(__FILE__).'/errCon.txt', $guestid.PHP_EOL,FILE_APPEND);
}



function myLog($var){
    if(is_array($var)){
        $var = var_export($var,true);
    }
	
	$var .= PHP_EOL;
    file_put_contents(dirname(__FILE__).'/debug.txt', $var,FILE_APPEND);
}

//解析物流返回状态_ems
function jiexi_ems2($o){
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
    foreach($items as $k=>$zhan){
        $str = (string)$zhan->content;
        if(strpos($str, '退回')!==false){
            $return = array();
            $return = array('status'=>'已拒收','last'=>$last_info);
            return $return;
        }
    }

    //物流状态 是否==4
    if($status==4){
        $return = array();
        $return = array('status'=>'已签收','last'=>$last_info);
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



//解析物流返回状态_ems
function jiexi_ems_s($o){
    //自定义关键字
    $keywords = array(
		'未妥投'=>'未妥投',
		'已拒收'=>'北京市,退回 妥投',
	);

    if(!$o){
        return false;
    }

    $o = json_decode($o);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->data;

	
	
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


//解析物流返回状态_zto
function jiexi_zto($o){
    //自定义关键字
    $keywords = array(
        '已拒收'=>'北京丰台看丹中通 的派件已签收',
    );

    if(!$o){
        return false;
    }

    $o = json_decode($o);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->data;



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

                $return = array('status'=>'已签收','last'=>$last_info);
                return $return;
     
    }
  

    /*
    //最新一条信息检测关键字
    foreach($keywords as $db_status=>$keyword){
        if(strpos($last_item_content_jiansuo,$keyword)!==false){
            $return = array();
            $return = array('status'=>$db_status,'last'=>$last_info,'gendan'=>$gendan);
            return $return;
        }
    }
    */
    
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

//解析物流返回状态_zjs
function jiexi_zjs($data){
    //自定义关键字
    $keywords = array('未妥投'=>'未妥投',);

    if(!$data){
        return false;
    }

    $o = json_decode($data);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->data;

    $item_count = count($items);
    $sub = $item_count-1;
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
    foreach($items as $k=>$zhan){
        $str = (string)$zhan->content;
        if(strpos($str, '返货')!==false){
            $return = array();
            $return = array('status'=>'已拒收','last'=>$last_info);
            return $return;
        }
    }

    //物流状态 是否==4
    if($status==4){
        $return = array();
        $return = array('status'=>'已签收','last'=>$last_info);
        return $return;
    }

    //最新一条信息检测关键字
    foreach($keywords as $db_status=>$keyword){
        if(strpos($last_item_content,$keyword)!==false){
            $return = array();
            $return = array('status'=>$db_status,'last'=>$last_info);
            return $return;
        }
    }

    $return = array();
    $return = array('status'=>'在途中','last'=>$last_info);
    return $return;

}

//解析圆通返回信息
function jiexi_yuantong($data){
    //自定义关键字
    $keywords = array('失败签收'=>'失败签收',);

    if(!$data){
        return false;
    }

    $o = json_decode($data);
    $status = (int)$o->status;//物流返回的状态
    $items = $o->data;

    $item_count = count($items);
    $sub = $item_count-1;
    $sub2 = $item_count-2;
    $sub3 = $item_count-3;

    //echo "<pre>";
    //var_dump($items);

    $firstline = $items[0]->content;

    $last_item_content_jiansuo = $items[$sub]->content.$items[$sub2]->content.$items[$sub3]->content;

    $gendan=$items[$sub3]->time.' '.$items[$sub3]->content.'<br/>'.$items[$sub2]->time.' '.$items[$sub2]->content.'<br/>'.$items[$sub]->time.' '.$items[$sub]->content.'<br/>';

    $last_item_content = $items[$sub]->content;
    $lat_item_time = $items[$sub]->time;
    $last_info = "time:{$lat_item_time}###content:{$last_item_content}";

    //小于三条信息直接返回在途中
    if($item_count < 4){
        $return = array();
        $return = array('status'=>'在途中','last'=>$last_info,'firstline'=>$firstline);
        return $return;
    }

    /*遍历每一站检查状态
     foreach($items as $k=>$zhan){
     $str = (string)$zhan->content;
     if(strpos($str, '失败签收')!==false){
     $return = array();
     $return = array('status'=>'失败签收','last'=>$last_info);
     return $return;
     }
     }
     */

    $new_arr = array();
    foreach($items as $k=>$zhan){
        $time = (string)$zhan->time;
        $content = (string)$zhan->content;
        $new_arr[] = $time.$content;
    }
    $new_arr = array_flip(array_flip($new_arr));
    $new_arr = array_values($new_arr);



    foreach($new_arr as $k=>$v){
        if(is_back($v)){
            if($k>4){
                $return = array();
                $return = array('status'=>'已拒收','last'=>$last_info,'firstline'=>$firstline);
                //var_dump($return);
                //exit;
                return $return;
            }
        }
    }


    //物流状态 是否==5
    if($status==5){
        $return = array();
        $return = array('status'=>'已拒收','last'=>$last_info,'firstline'=>$firstline);
        return $return;
    }

    //物流状态 是否==4
    if($status==4){
        $return = array();
        $return = array('status'=>'已签收','last'=>$last_info,'firstline'=>$firstline);
        return $return;
    }

    //最新一条信息检测关键字
    foreach($keywords as $db_status=>$keyword){
        if(strpos($last_item_content_jiansuo,$keyword)!==false){
            $return = array();
            $return = array('status'=>$db_status,'last'=>$last_info,'gendan'=>$gendan,'firstline'=>$firstline);
            return $return;
        }
    }

    $return = array();
    $return = array('status'=>'在途中','last'=>$last_info,'firstline'=>$firstline);
    return $return;

}

//圆通判断退回关键字
function is_back($str){
    $arr = array('北京市朝阳区工体公司','北京市大兴区亦庄开发区公司',);
    foreach ($arr as $v){
        if(strpos($str, $v)!==false){
            return true;
        }
    }
    return false;
}