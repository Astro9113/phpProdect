<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";
require CAIWU_PATH . 'head.php';

$page_config = array();

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

?>

<div id="wrap" class="clearfix">
    <?php require CAIWU_PATH . 'menu.php';?>
    
    <div id="main" class="clearfix">
		<h2>结算异常订单列表</h2>
		<br />
		  <form name="" mehtod="get">
                           订单id: <input type="text" name="id" value="<?php echo $_GET['id'];?>">
                            用户名: <input type="text" name="uname" value="<?php echo $_GET['uname'];?>">
          <input type="submit" name="sub" value="查询">
          </form>
		
		<br> <a class="btn" style="margin-bottom: 2px; margin-left: 12px;"
			href="../">返回待结算订单列表</a>

		<div class="uc">
			<table class="items" width="114%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="70px">购买者</th>
					<th width="90px">微信主</th>
					<th width="72px">金额</th>
					<th width="72px">中间人</th>
					<th width="60px">状态</th>
					<th width="60px">详情</th>
					<th width="30px">结果</th>
				</tr>
<?php
$w = " and gueststate='13'";


if($_GET['id']){
    $id = intval($_GET['id']);
    $w .= " and id = $id";
}

$uname = $_GET['uname'];
if($uname && $uname == gl_sql($uname)){
    $user = find_user_byname($uname);
    if($user){
        $w .= " and userid = ". $user['id'];
    }
}


        $sql = "select count(*) as num from wx_guest where 1 {$w}";
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
        
        $sql = "select * from wx_guest where 1 {$w} order by id limit $offset,$page_size";
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
            
            echo $tpl = 
                    "<tr>
						<td>{$info['id']}</td>
						<td>{$gusettitle}</td>
						<td>{$guestname}</td>
						<td>{$username}</td>
						<td>{$shopsku[1]} / {$shopsku[2]}</td>
						<td>{$topuser}</td>
						<td>{$orderstate}</td>
						<td><a href='statcon/?id={$info['id']}&page={$page}'>打款详情</a></td>
						<td><a href='payzc/?id={$info['id']}&page={$page}'>正常</a></td>
					</tr>";
        }
    ?>
	</table>    
          
          <div class="listpage">
				<?php 
			         $page_config = array(
			             'id'=>$id,
			             'uname'=>$uname,
			         );
			         require CAIWU_PATH.'page.php';
			    ?>
				</div>
			</form>
			
			
		</div>
	</div>
</div>