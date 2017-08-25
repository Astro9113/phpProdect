<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$w = " 1 ";  

//订单状态
$orderstates = get_orderstates();
$orderstates[0] = array('id' => 0,'orderstate' => '不限',);
ksort($orderstates);
$gueststate_s = isset($_GET['gueststate_s'])?intval($_GET['gueststate_s']):0;
if($gueststate_s){
    $w .= " and gueststate = '{$gueststate_s}'";
}


//id
$id_s = isset($_GET['id_s'])?intval($_GET['id_s']):0;
if($id_s){
    $w .= " and id = '{$id_s}'";
}

//快递单号
$guestkuaidi_s = isset($_GET['guestkuaidi_s'])?gl_sql($_GET['guestkuaidi_s']):'';
if($guestkuaidi_s){
    $w .= " and guestkuaidi = '{$guestkuaidi_s}'";
}


//买家信息
$guestname_s = isset($_GET['guestname_s'])?gl_sql($_GET['guestname_s']):'';
if($guestname_s){
    $w .= " and guestname  = '{$guestname_s}'";
}

$guesttel_s = isset($_GET['guesttel_s'])?gl_sql($_GET['guesttel_s']):'';
if($guesttel_s){
    $w .= " and guesttel  = '{$guesttel_s}'";
}


//商品
$shopname2_s = isset($_GET['shopname2_s'])?gl_sql($_GET['shopname2_s']):'';
if($shopname2_s){
    $shop = find_shop_byname($shopname2_s);
    if($shop){
        $shopid = $shop['id'];
        $w .= " and shopid  = '{$shopid}'";
    }else{
        $w .= " and shopid  = '0'";
    }
}


//下单时间
$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$time2 = isset($_GET['time2'])?$_GET['time2']:'';
if($time1 && $time2){
    $phptime=strtotime($time1);
    $time3=date('Y-m-d H:i:s',$phptime);
    $phptime2=strtotime($time2);
    $time4=date('Y-m-d H:i:s',$phptime2);
    
    $w .= " and addtime >= '{$time3}' and addtime <= '{$time4}'";
}else{
    $time3 = $time4  = '';
}


//客服
$kefus = get_kefus();
$tmp = array('id'=>0,'adminname'=>'不限');
array_unshift($kefus, $tmp);
$tmp = null;
$guestkfid_s = isset($_GET['guestkfid_s'])?intval($_GET['guestkfid_s']):0;
if($guestkfid_s){
    $w .= " and guestkfid = '{$guestkfid_s}'";
}

//媒介
$midusers = get_midusers();
$tmp = array('id'=>0,'username'=>'不限');
array_unshift($midusers, $tmp);
$tmp = null;
$miduserid_s = isset($_GET['miduserid_s'])?intval($_GET['miduserid_s']):0;
if($miduserid_s){
    $uids = get_userids_by_mid($miduserid_s);
    if($uids){
        $w .= " and userid in ({$uids})";
    }else{
        $w .= " and userid in (0)";
    }
}



?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
    <div id="main" class="clearfix">
		<div class="filter widthb110 nobor">
			<div class="cxform" style="width:800px;">
				<form id="search" method="get" action="">
					状态<select name="gueststate_s">
						<?php echo_option($orderstates, $gueststate_s, 'id','orderstate');?>
                    </select>
                                                    客服<select name="guestkfid_s">
						<?php echo_option($kefus, $guestkfid_s, 'id','adminname');?>
                    </select>
                                                      媒介<select name="miduserid_s">
						<?php echo_option($midusers, $miduserid_s, 'id','username');?>
                    </select>   
                                                    订单ID <input name="id_s" type="text"  value="<?php echo $id_s?$id_s:'';?>" style="width: 100px; height: 18px;">
                    <br />                                
                                                    姓名 <input name="guestname_s" type="text" value="<?php echo $guestname_s;?>" style="width: 100px; height: 18px;">
					电话 <input name="guesttel_s" type="text" value="<?php echo $guesttel_s;?>" style="width: 100px; height: 18px;">
					商品 <input name="shopname2_s" type="text" value="<?php echo $shopname2_s;?>" style="width: 100px; height: 18px;">
					<br />
					单号 <input name="guestkuaidi_s" type="text" value="<?php echo $guestkuaidi_s?$guestkuaidi_s:'';?>" style="width: 100px; height: 18px;">
					下单时间：<input type="text" name="time1" value="<?php echo $time3;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					-
					<input type="text"  name="time2" value="<?php echo $time4;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />                                                             
				    <input type="submit" name="sub" value="查询">
				</form>
			</div>
			

            <div class="cb"></div>
		</div>

		
		
<?php
    $table = 'wx_guest';
    $num_30_3 = $mysql->count_table($table,'gueststate = 3 and date_add(addtime,interval 30 day) <= now()');
    $num_3_9 = $mysql->count_table($table,'gueststate = 9 and date_add(addtime,interval 3 day) <= now()');
    $num_7_11 = $mysql->count_table($table,'gueststate = 11 and date_add(addtime,interval 7 day) <= now()');
    $num_7_9 = $mysql->count_table($table,'gueststate = 9 and date_add(addtime,interval 7 day) <= now()');
    
?>    
    
    
<div style='width:130%;'>
    <a class='btn mtop12 mleft6' style='background:#f00;'>一个月前发货中:<?php echo $num_30_3;?>个</a>
    <a class='btn mtop12 mleft6' style='background:#f00;'>3天前待发货:<?php echo $num_3_9?>个</a>
    <a class='btn mtop12 mleft6' style='background:#f00;'>7天前联不上:<?php echo $num_7_11?>个</a>
    <a class='btn mtop12 mleft6' href='kflbszd/'>客服联不上_跟单</a>
    <a class='btn mtop12 mleft6' href='keylbszd/'>重点用户联不上_跟单</a>
    <a class='btn mtop12 mleft6' href='kefuadmin/'>管理客服</a>  
    <a class='btn mtop12 mleft6' href='fahuosea/'>已发货物流查询</a>
    <a class='btn mtop12 mleft6' style='background:#f00;'>7天前待发货:<?php echo $num_7_9?>个</a>
    <a class='btn mtop12 mleft6' href='dz/'>对账</a>
    <a class='btn mtop12 mleft6' id='gbkf'>关闭客服系统</a>
</div>



<?php
if(date('H')>=17){
    $zuotian=date("Y-m-d")." 17:00:00";
    $jintian=date('Y-m-d',time()+24*60*60)." 17:00:00";
}else{
    $zuotian=date("Y-m-d",time()-24*60*60)." 17:00:00";
    $jintian=date('Y-m-d')." 17:00:00";
}
 
$sql = "select count(*) as num,gueststate from wx_guest where addtime between '$zuotian' and  '$jintian' group by gueststate";
$nums = $mysql->query_assoc($sql,'gueststate');

$total = 0;
foreach ($nums as $k=>$v){
    $total += intval($v['num']);
}

for($i=1;$i<=20;$i++){
    if(isset($nums[$i])){
        continue;
    }
    $nums[$i] = 0;
}

?>

<div class="mtop12" style="width: 130%;">
			<d class="nowstatz">今日订单总：</d>
			<d class="nowstat"><?php echo $total;?></d>
			确认中： <d class="nowstat"><?php echo intval($nums[2]['num']);?></d>
			联不上： <d class="nowstat"><?php echo intval($nums[11]['num']);?></d>
			假单：    <d class="nowstat"><?php echo intval($nums[10]['num']);?></d>
			待发货： <d class="nowstat"><?php echo intval($nums[9]['num']);?></d>
			已发货： <d class="nowstat"><?php echo intval($nums[3]['num']);?></d>
			已取消： <d class="nowstat"><?php echo intval($nums[8]['num']);?></d>
			无效重复： <d class="nowstat"><?php echo intval($nums[12]['num']);?></d>
			<a style='margin-bottom: 5px; margin-left: 12px;' href='/vuadmin/stat/waitstat/'>详细统计</a>
</div>




		<div class="uc mtop5">
			<table class="items" width="120%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="112px">时间</th>
					<th width="30px">ID</th>
					<th width="430px">商品</th>
					<th width="122px">金额</th>
					<th width="80px">购买者</th>
					<th width="80px">客服</th>
					<th width="80px">媒介</th>
					<th width="160px">状态</th>
					<th width="45px">详情</th>
				</tr>
    
<?php
    $shops = get_shops();
    $users = get_users();
    $kefus = get_kefus();
    $midusers = get_midusers();

    $num = $mysql->count_table('wx_guest',$w);    
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $page = $page?$page:1;
    $offset = ($page - 1) * $page_size;

    ECHO $sql = "select * from wx_guest where {$w} order by id desc limit $offset,$page_size";
    $ww = 1;
    $infos = $mysql->query($sql);
    if($infos){
            foreach ($infos as $info){
            			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
			
			
            $userid         =  $info['userid'];
            $user           =  $users[$userid];
            $username       =  $user['loginname'];
            
            $shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $guestkuanshi   =  $info['guestkuanshi'];
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            
            $gueststate     =  $info['gueststate'];
            $orderstate     =  $orderstates[$gueststate];
            $orderstate     =  $orderstate['orderstate'];
            
            $guestkfid      =  $info['guestkfid'];
            $kefu           =  $kefus[$guestkfid];
            $kefname        =  $kefu['adminname'];
            
            
            
            $topuser = $user['topuser'];
            if(strpos($topuser, 'm')!==false){
                    $target = $user['topuser'];
            }else{
                    $target = $user['dinguser'];
            }
            $mid = trim(substr($target, 1));
            $miduser = $midusers[$mid];
            $midname = $miduser['username'];            
            
            $guestname      =  $info['guestname'];
            $bz             =  mysubstr($info['guestrem'],0,25);
            $addtime        =  substr($info['addtime'], 5,11);
            
            if ($shop['ischange'] == '1') {
                $shopsku[2] = $shopsku[2] * $userpercent;
                $shopsku[2] = round($shopsku[2]);
            }
            
print <<<oo
<tr onmouseover="statbzxs('bz{$ww}')" onmouseout="statbzxs('bz{$ww}')">
	<td>{$addtime}</td>
	<td>{$info['id']}</td>
	<td>{$gusettitle}</td>
	<td>{$shopsku[1]} / {$shopsku[2]}</td>
	<td>{$guestname}</td>
	<td>{$kefname}</td>
	<td>{$midname}</td>
	<td>{$orderstate}<a target="_blank" href="orderstate/?id={$info['id']}">更改</a></td>
	<td><a target="_blank" href="statcon/index_5.php?id={$info['id']}">详情</a>
	   <div class="statbzd">
			<div class="statbz" id="bz{$ww}">{$bz}</div>
	   </div>
	</td>
	</tr>

oo;
            
            
          $ww ++;  
        }
    }
    
?>
	</table>
	        <?php 
    	        $page_config = array(
    	                'miduserid_s'=>$miduserid_s,
    	                'gueststate_s'=>$gueststate_s,
    	                'id_s'=>$id_s,
    	                'guestname_s'=>$guestname_s,
    	                'guesttel_s'=>$guesttel_s,
    	                'shopname2_s'=>$shopname2_s,
    	                "time1"=>$time3,
    	                "time2"=>$time4,
    	                "guestkfid_s"=>$guestkfid_s,
    	        );
    	    ?>
			<?php require ADMIN_PATH . 'page5.php';?>
		    <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

<script>
$(document).ready(function(){    
	$("#gbkf").click(function(){
		if(confirm('确定关闭吗')){
		alert('验证码已经重置');
		$.get('kefuadmin/modyzm/modyzmpd/index.php');	
		}
	});
});
</script>