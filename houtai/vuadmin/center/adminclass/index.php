<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);
$adminclasses = adminclasses();
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
		<div id="main" class="clearfix">
			<h2>管理员等级 列表</h2>
			<div class="uc">
				<p>
					<a class="btn" href="/vuadmin/center/">返回管理员列表</a>
				</p>
				<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
					cellspacing="1">
					<tr bgcolor="#f5f5f5">
						<th>ID</th>
						<th>等级名称</th>
						<th>等级说明</th>
					</tr>
                    <?php
                    foreach ($adminclasses as $info){
print <<<oo
                        <tr>
                        <td>{$info['adminclassid']}</td>
                        <td>{$info['adminclassname']}</td>
                        <td>{$info['adminclasscon']}</td>
                        </tr>
oo;
                    }
                    ?>
	           </table>
				<div class="uc-pager"></div>
			</div>
		</div>
	</div>
	
<?php require ADMIN_PATH . 'foot.php';?>