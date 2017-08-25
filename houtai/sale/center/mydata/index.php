<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$info = miduserinfo($loginid);
$invite = 'http://'.$invite_domain.'/regist/'.rtrim(base64_encode($info['applyma']),'=');

foreach ($info as $k=>$v){
    $info[$k] = gl_sql(gl2($v));
}

?>
<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
		<h2>媒介人信息</h2>
		<div class="uc">
			<hr>
			<form class="comform" name="detail" method="post" action="mydatapd/">
				<table cellpadding="12" cellspacing="0" border="0"
					class="table-form">
                    <tr>
						<input name="id" type="hidden" value="<?php echo $topid;?>">
						<th width="80">姓名</th>
						<td><input type="text" name="midusername" disabled
							value="<?php echo htmlspecialchars($info['username']);?>" /></td>
					</tr>
					<tr>
						<th width="80">邀请码</th>
						<td><input type="text" name="midapplyma"
							value="<?php echo $info['applyma'];?>" /></td>
					</tr>
					<tr>
						<th width="80">邀请链接</th>
						<td><input type='text' onFocus='$(this).select()'
							value='<?php echo $invite;?>'
							style="width: 425px; border: none;" /> <font color="#ff7200">（右击复制，不用发邀请码）</font></td>
					</tr>
    
                    <tr>
						<th width="80">客服昵称</th>
						<td><input type="text" name="midkefuname"
							value="<?php echo $info['midkefuname'];?>" /></td>
					</tr>
					<tr>
						<th width="80">客服qq号</th>
						<td><input type="text" name="midkefuqq"
							value="<?php echo $info['midkefuqq'];?>" /></td>
					</tr>
					<tr>
						<th width="80">客服手机号</th>
						<td><input type="text" name="midkefutel"
							value="<?php echo htmlspecialchars($info['midkefutel']);?>" /></td>
					</tr>
    
                    <tr>
						<th width="80"></th>
						<td>
							<button type="submit" class="big">修 改</button>
						</td>
					</tr>
					<tr>
				
				</table>
			</form>
			
		</div>
	</div>
</div>

<?php require MID_PATH.'foot.php';?>