<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";

$info = admininfo($loginid);
if(!$info){
    exit;
}

$adminclasses = adminclasses();
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
    <div id="main" class="clearfix">
		<h2>管理员信息</h2>
		<div class="uc">
			<hr>
			<form class="comform" name="detail" method="post" action="">
				<table cellpadding="12" cellspacing="0" border="0"
					class="table-form">
                    <tr>
						<th width="80">姓名</th>
						<td><input type="text" name="adminname" disabled
							value="<?php echo $info['adminname'];?>" /></td>
					</tr>
					<tr>
						<th width="80">账号</th>
						<td><input type="text" name="adminloginname" disabled
							value="<?php echo $info['adminloginname'];?>" /></td>
					</tr>
					<tr>
						<th width="80">管理员等级</th>
						<td><select name="adminclass" disabled>
								<option value="" selected>请选择等级</option>
								<?php echo_option($adminclasses, $info['adminclass'], 'adminclassid', 'adminclassname');?>

                            </select>
                        </td>
					</tr>
				</table>
			</form>
            <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>