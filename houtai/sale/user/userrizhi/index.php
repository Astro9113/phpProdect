<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$id = intval($_GET['id']);
$sql = "select * from wx_user where id = '{$id}' and (topuser = 'm{$loginid}' or dinguser = 'm{$loginid}')";
$info = $mysql->find($sql);
if(!$info){
    exit;
}

foreach ($info as $k=>$v){
    if($k=='userrizhi'){
        continue;
    }
    $info[$k] = gl2($v);
}

$username = $info['loginname'];

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">

        <div class="filter">
			<div class="gluser">
				<b>用户跟进日志  <?php echo $username;?></b>
			</div>
			<div class="cb"></div>
		</div>
		
		<div class="uc userlist mtop12">
			<form class="comform" name="detail" method="post" action="adduserrizhi/">
				<table width="75%" cellpadding="12" cellspacing="0" border="0"
					class="table-form">
					<tr>
						<th width="60">支付宝</th>
						<td><?php echo $info['alipay']." &nbsp;&nbsp;".$info['alipayname'];?></td>
						<td></td>
					</tr>
					
					<tr>
						<th width="60">新增记录</th>
						<td><input name="userrizhi" type="text" style="width: 350px;" /> 
						<input name="id" type="hidden" value="<?php echo $id;?>"></td>
						<td>
							<button class="mid" onClick="return pk()" type="submit">添加</button>
						</td>
					</tr>
				</table>
			</form>
			<div class="userrizhi">
            <?php echo guestrizhi($info['userrizhi']);?>
            </div>
			
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>