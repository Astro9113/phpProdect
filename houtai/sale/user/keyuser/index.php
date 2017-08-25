<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

?>


<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
		<h2>用户出单排行</h2>
		
		
		<a class="btn mtop12 mleft6" href="/sale/user/">返回用户列表</a>
		<div class="uc userlist mtop12">
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
    				<th width="35">ID</th>
    				<th width="200">账号</th>
    				<th width="210">总出单数</th>
    				<th width="210">结算单数</th>
    				<th width="120">昵称</th>
    				<th width="120">qq</th>
    				<th width="120">邀请人</th>
				</tr>

    
<?php
    $users = get_users();

    $topid = $loginid;
    $topid = "m" . $topid;
    $sql = "select * from wx_user where topuser='$topid' or dinguser='$topid'";
    $users = $mysql->query_assoc($sql,'id');
    $num = $mysql->numRows;
    if ($num) {
        $uids = array_keys($users);
        $uids = join(',', $uids);
    } else {
        $uids = '0';
    }

    $infos = $mysql->query("select count(*) as num,userid from wx_guest where userid IN($uids) group by userid order by num desc");
    $num = $num2 = array();
    foreach ($infos as $info){
        $userid = $info['userid'];
        $num[$userid] = intval($info['num']);
    }
    
   $sql = "select count(*) as num,userid from wx_guest where userid IN($uids) and  gueststate = 5 group by userid  order by num desc";
    $infos = $mysql->query($sql);
    foreach ($infos as $info){
        $userid = $info['userid'];
        $num2[$userid] = intval($info['num']);
    }
    
    
    
    if($num){
        foreach ($num as $userid=>$num_z){
            
            $user = $users[$userid]; 
			
					foreach($user as $k=>$v){
	if($k=='guestrizhi'){
		continue;
		//$info[$k] = guestrizhi($v);
	}else{
		$user[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}
}
			
    ?>
				<tr>
    				<td width="35"><?php echo $userid?></td>
    				<td width="200"><?php echo $user['loginname']?></td>
    				<td width="210"><?php echo $num_z?></td>
    				<td width="210"><?php echo isset($num2[$userid])?$num2[$userid]:0;?></td>
    				<td width="120"><?php echo $user['username']?></td>
    				<td width="120"><?php echo $user['qq']?></td>
    				<td width="120"><?php echo yaoqingren($user)?></td>
				</tr>
    
    <?php 
            
        }
    }
    
    ?>
    
   
	</table>
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>