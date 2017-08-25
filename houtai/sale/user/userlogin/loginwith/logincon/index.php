<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$time1 = isset($_GET['time1']) ? $_GET['time1'] : '';
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s', $phptime);
$time2 = isset($_GET['time2']) ? $_GET['time2'] : '';
$phptime2 = strtotime($time2);
$time4 = date('Y-m-d H:i:s', $phptime2);


$id = intval($_GET['id']);
$user = userinfo($id);
$username = $user['username'];
?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">

	


    <h2>用户 <?php echo $username;?> 登陆统计&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time3;?> -- <?php echo $time4;?></h2>
		<div class="uc userlist mtop12">
			<table width="50%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="180">登陆时间</th>
					<th width="100">次数</th>
				</tr>
    
<?php
    $sql = "select * from wx_userlogin where userid='$id' and logintime>='$time3' and logintime<='$time4'";
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){

?>  
                <tr>
					<td><?php echo date("m-d H:i:s",strtotime($info['logintime']));?></td>
					<td>1</td>
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