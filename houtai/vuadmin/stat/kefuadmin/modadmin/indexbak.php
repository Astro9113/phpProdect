<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);
$info = get_kefu_info($id);
if(!$info){
    exit('信息不存在');
}


?>

<?php require ADMIN_PATH . 'head.php';?>
    <div id="wrap" class="clearfix">
        <?php require ADMIN_PATH . 'menu.php';?>
        <div id="main" class="clearfix">
 
 
 <h2>修改 客服资料</h2>
 <div class="uc">
<p><a class="btn" href="../">返回 客服列表</a></p><hr>
<form class="comform" name="detail" method="post" action="modadminpd/">
<table cellpadding="12" cellspacing="0" border="0" class="table-form">
<tr>
		<th width="80">姓名</th>
		<td><input type="text" name="adminname" value="<?php echo $info['adminname'];?>" />
        <input name="id" type="hidden" value="<?php echo $id;?>">
        </td>
	</tr>
    <tr>
		<th width="80">账号</th>
		<td><input type="text" name="adminloginname" value="<?php echo $info['adminloginname'];?>" /></td>
	</tr>
       <tr>
		<th width="80">分配订单数</th>
		<td><input type="text" name="kefunum" value="<?php echo $info['kfnum'];?>" /></td>
	</tr>
     <tr>
		<th width="80">联不上数</th>
		<td><input type="text" name="lianxinum" value="<?php echo $info['lbsnum'];?>" /></td>
	</tr>
	<tr class="last">
		<th>&nbsp;</th>
		<td><br/>
			<button class="mid" type="submit">确认修改</button>
		</td>
	</tr>
</table>
</form>
	
 </div>
</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>