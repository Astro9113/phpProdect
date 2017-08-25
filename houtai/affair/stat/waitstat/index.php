<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";
require CAIWU_PATH . 'head.php';

$page = isset($_GET['page'])?intval($_GET['page']):1;
?>


<div id="wrap" class="clearfix">
    <?php require CAIWU_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<div class="filter">
			<div class="cxform2" style="width: 150px;">
				<h2 class="nobor">未结算订单列表</h2>
			</div>


			<div class="cxform2" style="width: 280px;">
				<form name="form2" method="get" action="">
					订单ID <input name="ddid" type="text"
						style="width: 100px; height: 18px; margin-right: 3px;">
					<button type="submit">查 询</button>
				</form>
			</div>


			<div class="cb"></div>
		</div>
		
		
		<br>
		<a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="outwait/">导出未结算excel表</a> 
		<a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="outtjh/">微信主excel表</a>
	    <a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="outmid/">中间人excel表</a> 
	    <a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="outjiae/">微信主附加表</a>
		<a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="staterr/">结算异常订单</a> 
		<a class="btn" style="margin-bottom: 2px; margin-left: 12px;" href="playmoney/s.php" target="_blank" onClick="return confirm('确定打款吗?')">一键结算</a>

		<div class="uc">
				<table class="items" width="120%" cellpadding="5" border="0"
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
						<th width="30px">结果</th>
					</tr>
    
    <?php
        $lsid = isset($_GET['ddid'])?intval($_GET['ddid']):0;
        if (!$lsid) {
            $sql = "select count(*) as num from wx_guest where gueststate='4'";
        } else {
            $sql = "select count(*) as num from wx_guest where gueststate='4' and id='$lsid'";
        }
        
        $ret = $mysql->find($sql);
        $num = $ret['num'];
        
        if(!$num){
            exit;
        }
        
        $page_size = 12;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        if (!$page){
            $page = 1;
        }
        
        $offset = ($page - 1) * $page_size;
        
        if (!$lsid) {
            $sql = "select * from wx_guest where gueststate='4' order by id limit $offset,$page_size";
        } else {
            $sql = "select * from wx_guest where gueststate='4' and id='$lsid' order by id limit $offset,$page_size";
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
        $xx = 1;
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
            

            echo $tpl = 
                    "<tr>
						<td>{$info['id']}</td>
						<td>{$gusettitle}</td>
						<td>{$guestname}</td>
						<td>{$username}</td>
						<td>{$mjname}</td>
						<td>{$shopsku[1]} / {$shopsku[2]}</td>
						<td>{$topuser}</td>
						<td>{$orderstate}</td>
						<td><a href='statcon/?id={$info['id']}&page={$page}'>打款详情</a></td>
						<td><a href='payerror/?id={$info['id']}&page={$page}'>异常</a></td>
					</tr>";
														
            $xx ++;
        }
    ?>
	</table>
				
				<div class="listpage">
				<?php 
			         $page_config = array();
			         require CAIWU_PATH.'page.php';
			    ?>
				</div>
		</div>
	</div>
</div>