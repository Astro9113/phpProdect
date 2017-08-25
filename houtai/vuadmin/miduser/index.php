<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);

?>
<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>中间人 列表</h2>
		<div class="uc">
			<p>
				<a class="btn" href="/vuadmin/miduser/addmid/">新增中间人</a>
			</p>
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th>ID</th>
					<th>姓名</th>
					<th width="200">邀请码</th>
					<th>奖励提成</th>
					<th>添加时间</th>
					<th>类型</th>
					<th>操作</th>
				</tr>
<?php
    $midusers = get_midusers();
    foreach ($midusers as $info){
			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
		
        $tmp_time = date("Y-m-d ",strtotime($info['addtime']));
        $tmp_name = $info['midclass']=='0'?"中间人":"媒介";
        print <<<oo
    <tr>
        <td>{$info['id']}</td>
        <td>{$info['username']}</td>
        <td>{$info['applyma']}</td>
        <td>&nbsp;&nbsp;{$info['midreward']} % </td>
        <td>{$tmp_time}</td>
        <td>{$tmp_name}</td>
        <td>
                <a href="/vuadmin/miduser/modmid/?id={$info['id']}">编辑</a>
				<a onClick="return confirm('删除此管理员！点 确认 继续')" href="/vuadmin/miduser/demid/?id={$info['id']}">删除</a>
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