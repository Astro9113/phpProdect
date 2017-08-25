<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1); 
qx($allow_qx,$adminclass);

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
	
	<div id="main" class="clearfix">
		<h2>管理员 列表</h2>
		<div class="uc">
			<p>
				<a class="btn" href="/vuadmin/center/addadmin/">新增管理员</a>
			</p>
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th>ID</th>
					<th>姓名</th>
					<th>等级</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
<?php
    $infos = admins();
    foreach ($infos as $info){
        $tmp_id = $info['id'];
        $tmp_class =  adminclass($info['adminclass']);
        $tmp_date = date("Y-m-d ",strtotime($info['addtime']));

print <<<oo
<tr>
    <td>{$info['id']}</td>
    <td>{$info['adminname']}</td>
    <td>{$tmp_class}</td>
    <td>{$tmp_date}</td>
    <td>
        <a href="/vuadmin/center/modadmin/?id={$tmp_id}">编辑</a> 
        <a onClick="return confirm('删除此管理员！点 确认 继续')" href="/vuadmin/center/deadmin/?id={$tmp_id}">删除</a>
    </td>
</tr>     
    
oo;

    }
?>
	       </table>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>