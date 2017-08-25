<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = isset($_GET['time2'])?$_GET['time2']:'';
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
        <h2>用户登陆 详细统计&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time3;?> -- <?php echo $time4;?></h2>
		<div class="uc userlist mtop12">
			<table width="80%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="130">用户ID</th>
					<th width="180">用户名</th>
					<th width="180">登陆次数</th>
					<th width="180">详情</th>
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
    
    $users = get_users();
    $sql = "select count(*) as num,userid from wx_userlogin where userid in($uids) and logintime>='$time3' and logintime<='$time4' group by userid order by userid desc";
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
            $userid = $info['userid'];
            $user = $users[$userid];
    ?>
    <tr>
					<td><?php echo $info['userid']; ?></td>
					<td><?php echo gl2($user['username']);?></td>
					<td><?php echo $info['num'];?></td>
					<td><a href="logincon/?id=<?php echo $userid; ?>&time1=<?php echo $time1; ?>&time2=<?php echo $time2; ?>">详情</a></td>
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