<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1,5
);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);

if(!$id){
	exit;
}


$info = get_kefu_info($id);
$zzname = $info['adminname'];

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
<?php require ADMIN_PATH . 'menu.php';?>
<div id="main" class="clearfix">

<h2>组长 <?php echo $zzname;?> 组员列表</h2>
 <div class="uc">
    <p><a class="btn" href="javascript:history.go(-1);">返回</a>  <a class="btn" href="userlist.php?id=<?php echo $id;?>">组员列表</a></p>
	<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3" cellspacing="1">
	<tr bgcolor="#f5f5f5"><th>ID</th><th>姓名</th><th>添加时间</th><th>操作</th></tr>
<?php
    $sql= "select * from wx_kefu where level = 0 and pid = {$id}";
    $infos = $mysql->query($sql);
    if($infos){
        foreach($infos as $info){
?>
<tr>
	<td><?php echo $info['id']; ?></td>
	<td><?php echo $info['adminname']; ?></td>
    <td><?php echo date("Y-m-d ",strtotime($info['addtime']));?></td>
    <td><a href="#" class="minus_user" data="<?php echo $info['id'];?>">退出该组</a></td>
</tr>

<?php 
        }
    }
?>
	</table>
		
 </div>
</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>
<script>
$(document).ready(function(){
	$('a.minus_user').click(function(){
		var uid = $(this).attr('data');
		$(this).parent().parent().hide();
		$.get('do_minususer.php?id='+uid);			
	})
});
</script>