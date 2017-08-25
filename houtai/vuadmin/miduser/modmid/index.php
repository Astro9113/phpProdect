<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);
$info = miduserinfo($id);
if (! $info) {
    exit();
}


?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>修改 中间人资料</h2>
		<div class="uc">
			<p>
				<a class="btn" href="/vuadmin/miduser/">返回 中间人列表</a>
			</p>
			<hr>
			<form class="comform" name="detail" method="post" action="modmidpd/">
				<table cellpadding="12" cellspacing="0" border="0"
					class="table-form">

                    <tr>
						<th width="80">姓名</th>
						<td><input type="text" name="adminname"
							value="<?php echo $info['username'];?>" /> <input
							name="id" type="hidden" value="<?php echo $id;?>"></td>
					</tr>
					<tr>
						<th width="80">账号</th>
						<td><input type="text" name="adminloginname"
							value="<?php echo $info['midloginname'];?>" /></td>
					</tr>
					<tr>
					<tr>
	
					<tr class="last">
						<th>&nbsp;</th>
						<td><br />
							<button class="mid" type="submit">确认修改</button></td>
					</tr>
				</table>
			</form>
            <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>