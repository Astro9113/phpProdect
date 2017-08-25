<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,10);
qx($allow_qx, $adminclass);

function get_orderstate_tmp(){
    global $mysql;
    $o = array();
    $sql = "select id,orderstate from wx_orderstate";
    $ret = $mysql->query($sql);
    foreach ($ret as $row){
        $o[$row['id']] = $row['orderstate'];
    }
    
    return $o;
}

//检查状态  一致返回true,不一致返回原因
function check_state($state,$dh){
    global $orderstate;
    global $mysql;
    $sql = "select * from wx_guest where guestkuaidi = '{$dh}'  limit 1";
    $data = $mysql->find($sql);
    if(!$data){
        return -1;
    }

    $gueststate = $data['gueststate'];//订单中状态
    $GLOBALS['remark'] = "{$data['id']}";//记录订单号
    switch ($state){
        case 5:
        case 6:
        default:
            if($state!=$gueststate){
                return "订单状态为<span class='orderstate'>{$orderstate[$gueststate]}</span>,需要的状态为<span class='orderstate'>{$orderstate[$state]}</span>";
            }    
        break;
    }
    return true;
}

$orderstate = get_orderstate_tmp();

$result_default   = array();//保存正常数据的数组
$result_yc        = array();//保存状态异常数据的数组
$result_notexists = array();//保存匹配不到订单数据的数组

if(isset($_POST['up'])){
    
    $file = $_FILES['f'];
    
    $dh = file_get_contents($file['tmp_name']);
    
    
    $dh = trim($dh);
    $dh_arr = explode("\n", $dh);
    
    if(!trim($dh)){
        exit('请输入单号');
    }
    
    /*
    
    $dh = trim($_POST['dh']);
    $dh_arr = explode("\n", $dh);
    
    if(!trim($dh)){
        exit('请输入单号');
    }
    */
    
    foreach($dh_arr as $k=>$v){
        $dh_arr[$k] = trim($v);
        if(!$dh_arr[$k]){
            unset($dh_arr[$k]);
            continue;
        }
    }
    
    //提交的总数
    $total = count($dh_arr);
    echo "提交总数{$total}<br /><br />";
    
    //重复的单号
    $chongfu = array();
    $distant = array_count_values($dh_arr);
    
    foreach ($distant as $dh=>$num){
        if($num>1){
            $chongfu[$dh] = $num;
        }
    }
    
    //重复的数量
    $num_chongfu = count($chongfu);
    echo "重复数{$num_chongfu}<br /><br />";
    echo "重复单号<br /><br />";
    
    foreach($chongfu as $dh=>$num){
        echo "单号:{$dh},重复次数:{$num}<br /><br />";
    }
    
    
    $arr_bucunzai  =array();
    $dhs = array_keys($distant);
    foreach ($dhs as $v){
        $_sdhs[] = "'".trim($v)."'";
    }
    
    $_sdhs = join(',',$_sdhs);
    $sql = " select id,guestkuaidi,gueststate from wx_guest where guestkuaidi in (". $_sdhs .")";
    $infos = $mysql->query($sql);
    //在系统内的数量
    $num_cunzai = count($infos);
    echo "单号在系统内存在{$num_cunzai}<br /><br />";
    
    //结算数量
    $num_jiesuan = 0;
    
    //拒收数量
    $num_jushou = 0;
    
    $arr_guest = array();
    $arr_jiesuan = array();
    $arr_jushou = array();
    
    
    foreach ($infos as $info){
       $_guestkuaidi = $info['guestkuaidi'];
       $_gueststate = $info['gueststate'];
       $_guestid = $info['id'];
       
       $arr_guest[$_guestid] = 1;
       
       if($_gueststate==5){
           $num_jiesuan++;
           $arr_jiesuan[] = $_guestid;
       }
       
       if($_gueststate==6){
           $num_jushou++;
           $arr_jushou[] = $_guestid;
       }

       unset($distant[$_guestkuaidi]); 
    }
    
    echo "结算数量{$num_jiesuan}<br /><br />";
    echo "拒收数量{$num_jushou}<br /><br />";
    
    //不在系统的单号数量
    
    $arr_bucunzai = $distant;
    $num_bucunzai = count($arr_bucunzai);
    echo "系统内匹配不到的单号数量:{$num_bucunzai}<br /><br />";
    //不存在系统内的单号
    echo '系统内匹配不到的单号<br /><br />';
    foreach ($distant as $k=>$v){
        echo "{$k}<br /><br />";
    }
    

    $atate_arr = array(
        1=>'退回签收',
        2=>'退回异常',
        3=>'已回款',
        4=>'回款异常',
    );
    //计算对账表数量
    echo $sql = "select count(*) as num,stateid from wx_dzguest where guestid in (".join(',',array_keys($arr_guest)).") group by stateid";
    $infos = $mysql->query($sql);
    foreach ($infos as $info){
        $stateid = $info['stateid'];
        $num = $info['num'];
        echo "对账表状态:{$atate_arr[$stateid]},对账表数量:{$num}<br /><br />";
    }
    
    
    //系统结算 但没在在对账表是3，4的列出来
    $sql = "select g.id,g.guestkuaidi,d.stateid from wx_guest g left join wx_dzguest d on g.id = d.guestid where g.id in (".join(',',$arr_jiesuan).") and d.stateid not in(3,4)";
    $infos = $mysql->query($sql);
    echo '系统结算 但没在在对账表是3，4: '.count($infos).' 个<br /><br />';
    
    foreach ($infos as $info){
        echo "{$info['id']}:{$info['guestkuaidi']}<br /><br />";
    }
    
    
    //系统拒收 但没在对账表是1，2的列出来
    $sql = "select g.id,g.guestkuaidi,d.stateid from wx_guest g left join wx_dzguest d on g.id = d.guestid where g.id in (".join(',',$arr_jushou).") and d.stateid not in(1,2)";
    $infos = $mysql->query($sql);
    echo '系统拒收 但没在对账表是1，2: '.count($infos).' 个<br>';
    foreach ($infos as $info){
        echo "{$info['id']}:{$info['guestkuaidi']}<br /><br />";
    }
    

}


?>

<style>
table,td,th{border:1px solid #ccc;}
table{border-collapse:collapse;}
th{background-color:#ccc;}
td{padding:5px 8px;}
span.orderstate{font-weight:700;color:blue;}
</style>

<div id="form">
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="f">
<br /><br />
<input type="submit" name="up" value="提交数据">
</form>
</div>