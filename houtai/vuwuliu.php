<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array( 1,6,7 );
qx($allow_qx, $adminclass);


function get_total(){
    global $mysql;
    $num = $mysql->count_table('wx_guest','gueststate=3');
    return $num;
}

function get_num($tag=0){
    global $mysql;
    $w = $tag?'wuliustate = 4':1;
    $num = $mysql->count_table('wx_gueststate',$w);
    return $num;
}

$today = date('Y-m-d');
$s_file = dirname(dirname(dirname(__FILE__))).'\vu\sms\wuliu\flag\\'.$today.'_start';
$e_file = dirname(dirname(dirname(__FILE__))).'\vu\sms/wuliu/flag/'.$today.'_end';

if(!file_exists($s_file)){
    echo '今日尚未开始运行<br />';
    //exit;
}

$total = get_total();
$num_total = get_num();
$num_qianshou = get_num(1);

if(file_exists($s_file) && !file_exists($e_file)){
    echo '正在执行,尚未结束<br />';
    echo "共需要获取数据{$total};已获取数据{$num_total}条,其中已签收{$num_qianshou}条";
    //exit;
}


if(file_exists($s_file) && file_exists($e_file)){
    echo '今日数据获取结束<br />';
    echo "共需要获取数据{$total};已获取数据{$num_total}条,其中已签收{$num_qianshou}条";
    //exit;
}

?>

<p><span id="sec">10</span>秒之后刷新页面</p>
<style>
#sec{font-weight:700;}
</style>
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script>

function uptime(){
    var t = $("#sec").html() - 0;
    t = t-1;
    console.log(t);
    t = t<0?10:t;
    $("#sec").html(t);
    if(t==0){
        location.href = location.href;
    }
}
setInterval(uptime,1000);
</script>

