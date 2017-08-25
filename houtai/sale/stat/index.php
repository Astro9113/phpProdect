<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";


$w = " 1 ";

//初始条件  userid  in  (该媒介下面的用户id)
$topid = $loginid;
$topid = "m" . $topid;
$sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
$users = $mysql->query_assoc($sql,'id');
$num = $mysql->numRows;
if ($num) {
    $uids = array_keys($users);
    $uids = join(',', $uids);
} else {
    $uids = '0';
}
$w .= " and userid in ({$uids})";


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

//微信主
$username_s = isset($_GET['username_s'])?gl_sql($_GET['username_s']):'';

if($username_s){
    $user = find_user_byname($username_s);
    if($user){
        $userid = $user['id'];
        $w .= " and userid = '{$userid}'";
    }else{
        $w .= " and userid = '0'";
    }
}


//用户 端显示的 订单 id
$user_id_s = isset($_GET['user_id_s'])?intval($_GET['user_id_s']):'';
if($user_id_s && $username_s && $user){
    //查询用户的订单
    $tmp_limit = $user_id_s-1;
    $num = $mysql->count_table('wx_guest','userid = '.$userid);
    $sql = "select * from wx_guest where userid = $userid limit $tmp_limit,1";
    
    
    $tmp_guest = $mysql->find($sql);
    if($tmp_guest){
        $tmp_guestid = $tmp_guest['id'];
        $w .= " and id = $tmp_guestid";
    }else{
        $w .= " and id = 0";
    }
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

$zuotian = date('Y-m-d',strtotime('-1 day'));
$jintian = date('Y-m-d');


?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>
    <div id="main" class="clearfix">
        <div class="filter">
			<div class="cxform" style="width:1060px;">
				<form id="search" method="get" action="">
					状态<select name="gueststate_s">
						<?php echo_option($orderstates, $gueststate_s, 'id','orderstate');?>
                    </select>
                                                    订单ID <input name="id_s" type="text" value="<?php echo $id_s?$id_s:'';?>" style="width: 100px; height: 18px;">
                                                    微信主 <input name="username_s" type="text" value="<?php echo $username_s;?>" style="width: 100px; height: 18px;">
                                                    用户订单id <input name="user_id_s" type="text" value="<?php echo $user_id_s?$user_id_s:'';?>" style="width: 100px; height: 18px;">
                                                    商品 <input name="shopname2_s" type="text"  value="<?php echo $shopname2_s;?>" style="width: 100px; height: 18px;">
					下单时间：<input type="text" name="time1" id="time1" value="<?php echo $time3;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					-
					<input type="text"  name="time2" id="time2" value="<?php echo $time4;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 17:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />                                                             
				    <input type="submit" name="sub" value="查询">
				</form>
			</div>
			
			
			
			<div class="cxform2"
				style="width: 300px; margin-left: 30px; margin-bottom: 5px;">
				<a class="btn" style="margin-top: 5px;" href="/sale/stat/timewist/">订单时间统计</a>
				<a class="btn" style="margin-top: 5px;" href="?time1=<?php echo $zuotian.' 18:00:00'?>&time2=<?php echo $jintian.' 18:00:00'?>">今日出单统计</a>
			</div>
			

<div class="cb"></div>
		</div>
		<div class="uc">
			<table class="items" width="105%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="70px">订单ID</th>
					<th width="70px">买家</th>
					<th>订购商品</th>
					<th width="110px">微信主</th>
					<th width="72px">金额</th>
					<th width="72px">客服</th>
					<th width="60px">状态</th>
					<th width="35px">详情</th>
				</tr>
    
<?php
    $num = $mysql->count_table('wx_guest',$w);
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $page = $page?$page:1;
    $offset = ($page - 1) * $page_size;
    
    $shops = get_shops();
    $users = get_users();
    $kefus = get_kefus();
    
    $sql = "select * from wx_guest where {$w} order by id desc limit $offset,$page_size";
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
            
			foreach($info as $k=>$v){
            	if($k=='guestrizhi'){
            		continue;
            		//$info[$k] = guestrizhi($v);
            	}else{
            		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
            	}
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
            
            
            $guestname      =  $info['guestname'];
            $addtime        =  substr($info['addtime'], 5,11);
            
            if ($shop['ischange'] == '1') {
                $shopsku[2] = $shopsku[2] * $userpercent;
                $shopsku[2] = round($shopsku[2]);
            }
            
            $kfid = $info['guestkfid'];
            $kefu = isset($kefus[$kfid])?$kefus[$kfid]:false;
            $kefuname = $kefu?$kefu['adminname']:'';   
            
            print <<<oo
            
                <tr>
					<td>{$addtime}</td>
					<td>{$info['id']}</td>
					<td>{$guestname}</td>
					<td>{$gusettitle}</td>
					<td>{$username}	</td>
					<td>{$shopsku[1]} / {$shopsku[2]}</td>
					<td>{$kefuname}	</td>
					<td>{$orderstate}</td>
					<td><a target="_blank" href="statcon/?id={$info['id']}">详情</a></td>
				</tr>
            
            
oo;
            
        }
    }
        
?>

	</table>
	       <?php 
    	        $page_config = array(
    	                'gueststate_s'=>$gueststate_s,
    	                'id_s'=>$id_s,
    	                'username_s'=>$username_s,
    	                'shopname2_s'=>$shopname2_s,
    	                "time1"=>$time3,
    	                "time2"=>$time4,
    	        );
    	    ?>
			<?php require MID_PATH . 'page2.php';?>
	
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>