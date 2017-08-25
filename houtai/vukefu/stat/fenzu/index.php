<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

$kefu = get_kefu_info($kefid);
$level =  $kefu['level'];
if($level != 1){
    go('../','没有权限');
}

$id = isset($_GET['id'])?intval($_GET['id']):0;
$orderstate = isset($_GET['id'])?intval($_GET['orderstate']):0;


//检查传递来的id是不是该组长下面的组员
if($id){
    $check = check_relation($id, $kefid);
    if(!$check){
        go('../','没有权限');
    }
}



$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = isset($_GET['time2'])?$_GET['time2']:'';
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);

$orderstates = get_orderstates();
$shops = get_shops();
$kefus = get_kefus();

?>

<?php require KEFU_PATH . 'head.php';?>

<div id="wrap" class="clearfix">
    <?php require KEFU_PATH . 'menu.php';?>

    <div id="main" class="clearfix">
		<div class="filter widthb110">
			<div class="cxform" style="width: 740px;">
				<form id="search" method="get" action="">
				    <select name="orderstate" id="orderstate">
						<option value="0">全部</option>
                        <?php
                            foreach ($orderstates as $state_id=>$info){
                                $sel = '';
                                if ($orderstate == $state_id) {
                                    $sel = 'selected="selected"';
                                }
                                echo "<option value='{$state_id}' {$sel}>" .$info['orderstate'] . "</option>";
                                $statearr[$state_id] = $info['orderstate'];
                            }
                        ?>
                    </select>

                    <select name="id" style="float: left; margin: 6px 12px;">
                        <option value="0">全部组员</option>
                        <?php 
                            $zuyuans = zuyuan($loginid);
                            if($zuyuans){
                                foreach ($zuyuans as $zy_id=>$row){
                                    $sel = '';
                                    if ($zy_id == $id) {
                                        $sel = " selected='selected'";
                                    }
                                    echo '<option value="'. $row['id'] . '"' . $sel . '>' . $row['adminname'] .'</option>';
                                    $user_arr[] = $row['id'];
                                }
                            }
                        ?>
                    </select>


                    <input ph="开始时间" type="text" id="time1" name="time1" value="<?php echo $time1;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
                    -
                    <input ph="结束时间" type="text" id="time2" name="time2" value="<?php echo $time2;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />　


					<button type="submit" name="sub">查询</button>
				</form>
			</div>
			<div class="cb"></div>
			<div class="cxform" style="width: 900px;">
<?php

//开始统计数据
$w = 'where 1';

if ($id) {
    $w .= " and guestkfid = $id";
} else {
    if ($user_arr) {
        $user_ids = join(',', $user_arr);
        $w .= " and guestkfid in ({$user_ids})";
    } else { // 没有组员 就默认为0 查不到数据
        $w .= " and guestkfid = 2";
    }
}

if ($time1 != '') {
    $w .= " and (addtime between '{$time3}' and '{$time4}')";
}

$sql = array();
foreach ($statearr as $k => $v) {
    $sql[$k] = "(select count(*) as num from wx_guest  $w and gueststate = $k)";
}

$sqls = join(' union all ', $sql);
$result = mysql_query($sqls);
while ($row = mysql_fetch_assoc($result)) {
    $num[] = $row['num'];
}

$i = 0;
$str = '';
foreach ($statearr as $val) {
    $str .= $val . ':' . $num[$i] . '&nbsp;&nbsp;';
    $i ++;
}

echo $str;
?>
</div>

<?php

if ($orderstate) {
    $w .= " and gueststate = '{$orderstate}'";
}
?>

<div class="cb"></div>
		</div>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="80px">购买者</th>
					<th width="72px">金额</th>
					<th width="100px">状态</th>
					<th width="35px">详情</th>
					<th width="35px">客服</th>
				</tr>
    
<?php
        $sql = "select count(*) as num from wx_guest {$w}";
        $ret = $mysql->find($sql);
        $num = $ret['num'];
        
        $page_size = 12;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        $page = $page?$page:1;
        $offset = ($page - 1) * $page_size;
        
        $sql = "select * from wx_guest {$w}";
        $sql .=  " limit {$offset},{$page_size}";
        
        $infos = $mysql->query($sql);
        
        $ww = 1;
        
        foreach ($infos as $info){
			foreach($info as $k=>$v){
				if($k=='guestrizhi'){
					continue;
					//$info[$k] = guestrizhi($v);
				}else{
					$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
				}
			}
			
            $shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $userid         =  $info['userid'];
            $userwx         =  gl2($info['userwx']);
            $guestname      =  gl2($info['guestname']);
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  gl2($info['guestkuanshi']);
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            $orderstate_arr     =  $orderstates[$gueststate];
            $orderstate_name     =  $orderstate_arr['orderstate'];
            $bz             =  gl2(mysubstr($info['guestrem'],0,25));
            $addtime        =  substr($info['addtime'], 5,11);
            $guestkfid      =  $info['guestkfid'];
            $kefu           =  $kefus[$guestkfid];
            $kefname        =  $kefu['adminname'];
            
print <<<EOT
            
<tr onmouseover="statbzxs('bz{$ww}')" onmouseout="statbzxs('bz{$ww}')">
<td>{$addtime}</td>
<td>{$info['id']}</td>
<td>{$gusettitle}</td>
<td>{$guestname}</td>
<td>{$shopsku[1]}</td>
<td>{$orderstate_name}&nbsp;&nbsp;&nbsp;<a href="../orderstate/?id={$info['id']}" target="_blank">更改</a></td>
<td><a href="../statcon/?id={$info['id']}" target="_blank">详情</a></td>
<td>{$kefname}</td>
</tr>

EOT;
            $ww ++;
        }
        
?>
        
	</table>
	
	        <?php 
	           //分页参数
	           $page_config = array(
	                   'orderstate' => $orderstate,
	                   'id'         => $id,   
	           );
	              
	           
	        ?>   
            <?php require KEFU_PATH . 'page2.php';?>
		    <?php require KEFU_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require KEFU_PATH . 'foot.php';?>
