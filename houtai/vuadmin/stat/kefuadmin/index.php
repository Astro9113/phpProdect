<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>客服 列表</h2>
		<div class="uc">
			<p>
				<a class="btn" href="addadmin/">新增客服</a> 
				<a class="btn" href="modyzm/modyzmpd/">修改验证码</a>
				<a class="btn" href="blacklist.php">黑名单管理</a>
			</p>
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th>ID</th>
					<th>姓名</th>
					<th>状态</th>
					<th>最大数量</th>
					<th>联不上</th>
					<th>添加时间</th>
					<th>级别</th>
					<th>设置</th>
					<th>成员管理</th>
					<th>操作</th>
					<th>查看</th>
					
				</tr>
<?php
        $sql = "select * from wx_kefu";
        $infos = $mysql->query($sql);
        foreach ($infos as $info){
?>
	<tr>
					<td><?php echo $info['id']; ?></td>
					<td><?php echo $info['adminname']; ?></td>
    
    <?php if ($info['kfupbot'] == "1") {?>
    <td class="green">开启&nbsp;&nbsp;&nbsp;&nbsp;<a href="kfbot/?id=<?php echo $info['id']; ?>">关闭</a></td>
    <?php }else{?>
    <td>关闭&nbsp;&nbsp;&nbsp;&nbsp;<a href="kfup/?id=<?php echo $info['id']; ?>">开启</a></td>
	<?php }?>
	
    <td><?php echo $info['kfnum']; ?></td>
	<td><?php echo $info['lbsnum']; ?></td>
	<td><?php echo date("Y-m-d ",strtotime($info['addtime']));?></td>

    <td> <?php $level = $info['level']==1?'组长':'';echo $level;?> </td>
	<td>
    <?php
            $level = $info['level'];
            if ($level == 1) {
                echo '<a href="#" class="level" data="' . $info['id'] .
                         '">取消</a>';
            } else {
                echo '<a id="" href="#" class="level" data="' . $info['id'] .
                         '">设为组长</a>';
            }
    ?>
    </td>
	<td>
    	<?php
            if ($level == 1) {
                echo '<a href="fenzu/adduser.php?id=' . $info['id'] .
                         '">添加</a>&nbsp;<a href="fenzu/userlist.php?id=' .
                         $info['id'] . '">管理</a>&nbsp;';
            }
        ?>
    </td>


	<td>
	   <a href="modadmin/?id=<?php echo $info['id']; ?>">编辑</a> 
	</td>
	<td>
	   <a href="view/?id=<?php echo $info['id']; ?>">查看</a> 
	</td>
	</tr>
	    <?php

        }
        ?>
	</table>
			
		</div>
	</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>

<script>
$(document).ready(function(){
	$('a.level').click(function(){
		if(confirm('确定更改吗?')==false){
		return;	
		}
		var uid = $(this).attr('data');

		var txt = $(this).text();
		if(txt=='取消'){
			$(this).text('设为组长');
			$(this).parent().prev().text('');
			$(this).parent().next().text('');	
		}

		if(txt=='设为组长'){
			$(this).text('取消');
			$(this).parent().prev().text('组长');
			$(this).parent().next().html('<a href="fenzu/adduser.php?id='+uid+'">添加</a>&nbsp;&nbsp;'+'<a href="fenzu/userlist.php?id='+uid+'">管理</a>');		
		}
		
		$.get('fenzu/level.php?id='+uid);			
	})
});
</script>

<style>
.green{background-color:green;}        
</style>