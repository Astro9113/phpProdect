<?php 

//======================================================
error_reporting(E_ALL &~E_NOTICE);

require 'func.php';
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require 'CurlMulti-master/CurlMulti/Core.php';

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
$pagesize = 2;
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

$curl->start();
check_end();


