<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);

$adminclasses = adminclasses();
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>新增 管理员</h2>
		<div class="uc">
			<p>
				<a class="btn" href="/vuadmin/center/">返回 管理员列表</a>
			</p>
			
			<hr>
			<form class="comform" name="detail" method="post" action="addadminpd/">
				<table cellpadding="12" cellspacing="0" border="0"
					class="table-form">
					<tr>
						<th width="80">姓名</th>
						<td><input type="text" name="adminname" /></td>
					</tr>
					<tr>
						<th width="80">账号</th>
						<td><input type="text" name="adminloginname" /></td>
					</tr>
					<tr>
						<th width="80">密码</th>
						<td><input type="text" name="adminpassword" /></td>
					</tr>
					<tr>
						<th width="80">管理员等级</th>
						<td>
                            <select name="adminclass">
								<option value="" selected>请选择等级</option>
                                <?php echo echo_option($adminclasses, 0, 'adminclassid', 'adminclassname');?>
		                    </select>
                        </td>
					</tr>
					<tr class="last">
						<th>&nbsp;</th>
						<td><br />
							<button class="mid" type="submit">确认提交</button></td>
					</tr>
				</table>
			</form>
            <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>