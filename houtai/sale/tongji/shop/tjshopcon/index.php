<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$time1 = $_GET['time1'];
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = $_GET['time2'];
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);


$id = intval($_GET['id']);
$shop = shopinfo($id);


?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
        <h2>统计商品：<?php echo gl2($shop['shopname2']);?> &nbsp;&nbsp;&nbsp;  
            <?php echo $time3;?> -- <?php echo $time4;?>
        </h2>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="160px">用户</th>
					<th width="110px">浏览次数</th>
				</tr>
    
<?php

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


$users = get_users();        
$sql = "select count(*) as num ,userid from wx_tongji where addtime>='$time3' and addtime<='$time4' and shopid = $id and userid in ({$uids}) group by userid order by num desc";
        $infos = $mysql->query($sql);
        
        if($infos){
            foreach ($infos as $info){
                $userid = $info['userid'];
                $user = $users[$userid];
                $num = $info['num'];
								
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
        <td><?php echo $user['loginname']; ?></td>
		<td align="center"><em><?php echo $num;?></em></td>
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