<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

if (!$_GET['time1']) {
    header("Location:/sale/tongji/");
    exit();
}

$time1 = $_GET['time1'];
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = $_GET['time2'];
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>

    <div id="main" class="clearfix">
        <h2>用户浏览统计  <?php echo $time3;?> - <?php echo $time4;?></h2>
		<div class="uc userlist mtop12">
			<table class="trcol" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="35">ID</th>
					<th width="110">账号</th>
					<th width="95">访问次数</th>
					<th width="135">昵称</th>
					<th width="85">qq</th>
					<th width="115">邀请人</th>
					<th width="80">操作</th>
				</tr>
    
<?php

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
    
    
    // 调用统计表
    $sql = "select count(*) as num,userid from wx_tongji where userid in($uids) and addtime>='$time3' and addtime<='$time4' group by userid order by num desc";
    
    $infos = $mysql->query($sql);
    foreach ($infos as $info){
		foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
		//$info[$k] = guestrizhi($v);
	}else{
		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}
}
		
        $user = $users[$info['userid']];
        $num = $info['num'];
        $yaoqing = yaoqingren($user);
		
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
        <td><?php echo $user['id']; ?></td>
		<td><?php echo $user['loginname']; ?></td>
		<td><?php echo $num;?></td>
		<td><?php echo $user['username']; ?></td>
		<td><?php echo $user['qq']; ?></td>
		<td><?php echo $yaoqing;?></td>
		<td><a href="tjusercon/?id=<?php echo $user['id']; ?>&time1=<?php echo $time3; ?>&time2=<?php echo $time4; ?>">详情</a></td>
	</tr>
    
<?php 
    }
?>
	</table>
			
        <?php require MID_PATH.'tip.php';?>
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>
