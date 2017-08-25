<?php 

//vu 物流 每日计划任务运行
//======================================================
error_reporting(E_ALL &~E_NOTICE);

require 'func.php';
require  'sjk1114.php';
require 'CurlMulti-master/CurlMulti/Core.php';

file_put_contents(dirname(__FILE__).'/log.txt', date('Y-m-d H:i:s').PHP_EOL,FILE_APPEND);

//检查开始以及结束标志 决定任务进程
check_start();
$status_arr = get_ship_status();

$curl = new CurlMulti_Core ();
$curl->maxThread = 1;//并发数量
$dir = dirname(__FILE__) . '/cache';
$curl->cache = array (
        'enable' => true,
        'dir' => $dir,
        'expire' => 12*3600
);

//$curl->cbTask=array('addTask');





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


/*
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

    echo 'add:ems'.$dhs_str.PHP_EOL;
    $dhs_str = $url = $task_config = null;
}

$base = $sql = $info = $ret = $total = $pagesize = $totalpage = null;
*/


//添加中通任务
$base ="http://www.kuaidiapi.cn/rest/?uid=21550&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s&id=zhongtong";
$sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate= 3 and wuliugs ='中通快递' and id not in (select guestid as id from wx_gueststate where 1) order by id";
$sql  = mysql_query($sql);
while(($guest = mysql_fetch_assoc($sql))!==false){
    $id = $guest['id'];
    $guestkuaidi = $guest['guestkuaidi'];
    $url = sprintf($base,$guestkuaidi);
    $task_config = array('url'=>$url,'args'=>array('guestid'=>$id));
    $curl->add($task_config,'pat_con_zto','err_zto');
    $url = $task_config = null;
    echo 'add:zto'.$id.PHP_EOL;
}



//添加ems任务
$base ="http://www.kuaidiapi.cn/rest/?uid=21550&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s&id=ems";
$sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate= 3 and wuliugs ='ems' and id not in (select guestid as id from wx_gueststate where 1) order by id";
$sql  = mysql_query($sql);
while(($guest = mysql_fetch_assoc($sql))!==false){
    $id = $guest['id'];
    $guestkuaidi = $guest['guestkuaidi'];
    $url = sprintf($base,$guestkuaidi);
    $task_config = array('url'=>$url,'args'=>array('guestid'=>$id));
    $curl->add($task_config,'pat_con_ems_s','err_ems_s');
    $url = $task_config = null;
    echo 'add:ems'.$id.PHP_EOL;
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

//添加圆通任务
$base ="http://www.zto100.com/rest.aspx?uid=21550&key=958b606599bd4b6786e2a7c2e3855bf1&order=%s&id=yuantong";
$sql = "select id,guestkuaidi,wuliugs from wx_guest where gueststate= 3 and wuliugs ='圆通快递' and id not in (select guestid as id from wx_gueststate where 1) order by id";
$sql  = mysql_query($sql);
while(($guest = mysql_fetch_assoc($sql))!==false){
    $id = $guest['id'];
    $guestkuaidi = $guest['guestkuaidi'];
    $url = sprintf($base,$guestkuaidi);
    $task_config = array('url'=>$url,'args'=>array('guestid'=>$id));
    $curl->add($task_config,'pat_con_yuantong','err_yuantong');
    $url = $task_config = null;
    echo 'add:yuantong'.$id.PHP_EOL;
}

$base = $sql = $info = $ret = $total = $pagesize = $totalpage = null;



$curl->start();
check_end();

file_put_contents(dirname(__FILE__).'/log.txt', date('Y-m-d H:i:s').PHP_EOL,FILE_APPEND);
