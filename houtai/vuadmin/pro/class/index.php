<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);

if(isset($_POST['add'])){
    $data['shopclassname'] = gl_sql(gl2($_POST['shopclassname']));
    $map = " shopclassname = '{$data['shopclassname']}'";
    $num = $mysql->count_table('wx_shopclass',$map);
    if($num){
        alert('分类名不能重复');
        goback();
    }
    
    $str = $mysql->arr2s($data);
    $sql = "insert into wx_shopclass {$str}";
    $mysql->execute($sql);
    go('./');
}

if(isset($_GET['del'])){
    $id = intval($_GET['id']);
    $sql = "delete from wx_shopclass where shopclassid = '{$id}'";
    $mysql->execute($sql);
    go('./');
}



?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
<?php require ADMIN_PATH . 'menu.php';?>
<div id="main" class="clearfix">
		<h2>商品分类 列表</h2>
		<div class="uc">
			<p>
				<form action="" method="post">
				<input type="text" name="shopclassname" />
				<input  class="btn" type="submit" name="add" value="新增分类">
				</form>
			</p>
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th>ID</th>
					<th>分类名称</th>
					<th>添加时间</th>
					<th>操作</th>
				</tr>
<?php

$infos = shopclasses();
if($infos){
    foreach ($infos as $info){
        $addtime = date("Y-m-d ",strtotime($info['addtime']));
print <<<oo
<tr>
	<td>{$info['shopclassid']}</td>
	<td>{$info['shopclassname']}</td>
	<td>{$addtime}</td>
	<td>
	   <a onClick="return confirm('删除商品分类将删除相关的商品、客户订单等数据！点 确认 继续')" href="?del=1&id={$info['shopclassid']}">删除</a>
	</td>
</tr>
        
oo;
    }
}
	
?>
	       </table>
		</div>
	</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>