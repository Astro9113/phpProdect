<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";

?>

<?php
require CAIWU_PATH . 'head.php';
?>

<div id="wrap" class="clearfix">
    <?php require CAIWU_PATH . 'menu.php';?>
    
	<div id="main" class="clearfix">
		<div class="filter">
			<div class="cxform2" style="width: 150px;">
				<h2 class="nobor">已结算订单列表</h2>
			</div>


			<div class="cxform2" style="width: 220px;">
				<form name="form2" method="get" action="">
					订单ID <input name="ddid" type="text"
						style="width: 100px; height: 18px; margin-right: 3px;">
					<button type="submit">查 询</button>
				</form>
			</div>
			
			<div class="cxform2" style="width: 350px;">
				<form id="search" action="outwait/">
					结算时间：<input ph="开始时间" type="text" id="time1" name="time1" value=""
						size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
						ph="结束时间" type="text" id="time2" name="time2" value="" size="11"
						onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					<button type="submit">导 出</button>
				</form>
			</div>

			<div class="cb"></div>
		</div>
		
		
		<div class="uc">
			<table class="items" width="110%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="70px">购买者</th>
					<th width="90px">微信主</th>
					<th width="50px">媒介</th>
					<th width="72px">金额</th>
					<th width="72px">中间人</th>
					<th width="60px">状态</th>
					<th width="68px">详情</th>
				</tr>
    
<?php

        $lsid = isset($_GET['ddid'])?intval($_GET['ddid']):0;
        if (!$lsid) {
            $sql = "select count(*) as num from wx_guest where gueststate='5'";
        } else {
            $sql = "select count(*) as num from wx_guest where gueststate='5' and id='$lsid'";
        }
        
        $ret = $mysql->find($sql);
        $num = $ret['num'];
        
        $page_size = 12;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        if (!$page){
            $page = 1;
        }
        $offset = ($page - 1) * $page_size;
        
        if (!$lsid) {
            $sql = "select * from wx_guest where gueststate='5' order by id desc limit $offset,$page_size";
        } else {
            $sql = "select * from wx_guest where gueststate='5' and id='$lsid' order by id desc limit $offset,$page_size";
        }
        
        $infos = $mysql->query($sql);
        
        foreach ($infos as $info){
            $uid_arr[] = $info['userid'];
        }
        $sql = "select * from wx_user where id in (".join(',', $uid_arr).")";
        $users = $mysql->query_assoc($sql, 'id');
        
        $shops = get_shops();
        $midusers = get_midusers();
        $orderstates = get_orderstates();
        
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
            $userwx         =  $info['userwx'];
            $guestname      =  $info['guestname'];
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  $info['guestkuanshi'];
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0];
            $orderstate     =  $orderstates[$gueststate];
            $orderstate     =  $orderstate['orderstate'];
            $bz             =  mysubstr($info['guestrem'],0,25);
            $addtime        =  substr($info['addtime'], 5,11);
            
            $user = $users[$userid];
            $username = htmlentities($user['loginname']);
            $userpercent = $user['userpercent'] / 100;
            
            if ($shop['ischange'] == '1') {
                $shopsku[2] = $shopsku[2] * $userpercent;
                $shopsku[2] = round($shopsku[2]);
            }
            
            $topid = $user['topuser'];
            if ($topid == "") {
                $topuser = "无中间人";
            } else {
                $sql = "select * from wx_user where id='$topid'";
                $top = $mysql->find($sql);
                if ($top) {
                    $topuser = htmlentities($top['loginname']);
                } else {
                    $topuser = "无中间人";
                }
            }
            
            // 调出媒介
            if (substr($user['topuser'], 0, 1) == 'm') {
                $mjid = substr($user['topuser'], 1);
            } elseif (substr($user['dinguser'], 0, 1) == 'm') {
                $mjid = substr($user['dinguser'], 1);
            }
            
            $miduser = $midusers[$mjid];
            $mjname  = htmlentities($miduser['username']);
            
            $states= get_orderstates();
            $state = $states[$gueststate];
            $orderstate = $state['orderstate'];

print <<<EOT
                            
                <tr>
					<td>{$info['id']}</td>
					<td>{$gusettitle}</td>
					<td>{$guestname}</td>
					<td>{$username}	</td>
					<td>{$mjname}</td>
					<td>{$shopsku[1]} / {$shopsku[2]}</td>
					<td>{$topuser}</td>
					<td>{$orderstate}</td>
					<td><a href="statcon/?id={$info['id']}&page={$page}">打款详情</a></td>
				</tr>
EOT;


        }
        ?>
	</table>
			<div class="listpage">
			<?php 
			     $page_config = array();
			     require CAIWU_PATH.'page2.php';
			?>
			</div>
			<?php  require CAIWU_PATH.'tip.php'; ?>
		</div>
	</div>
</div>

<?php  require CAIWU_PATH.'foot.php';?>
