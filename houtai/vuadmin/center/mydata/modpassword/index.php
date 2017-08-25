<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";

$info = admininfo($loginid);
if (! $info) {
    exit();
}


if(isset($_POST['old_pwd'])){
    $old_pwd = gl_sql($_POST['old_pwd']);
    $new_pwd_1 = $_POST['new_pwd_1'];
    $new_pwd_2 = $_POST['new_pwd_2'];

    $old_pwd2 = $info['adminpassword'];


    if($old_pwd != $old_pwd2){
        go('./','原密码不正确');
    }

    if($new_pwd_1 !== gl_sql($new_pwd_1)){
        go('./','新密码错误');
    }

    if($new_pwd_1 !== $new_pwd_2){
        go('./','两次输入不一致');
    }

    $sql = "update wx_admin set adminpassword='$new_pwd_1' where id = '{$loginid}'";
    $ret = $mysql->execute($sql);

    if($ret){
        go('./','更改管理员密码成功');
    }else{
        go('./','更改管理员密码失败，请联系技术人员');
    }

}


?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
    <div id="main" class="clearfix">

		<h2>更改管理密码</h2>
		<div class="uc">
			<p><a class="btn" href="/vuadmin/center/mydata/">查看自己信息</a></p>
			<hr>
			<form class="comform" name="detail" method="post" action="">
				<table cellpadding="12" cellspacing="0" border="0"
					class="table-form">
					<tr>
						<th width="80">原密码</th>
						<td><input type="password" name="old_pwd" /></td>
					</tr>
					<tr>
						<th width="80">新密码</th>
						<td><input type="password" name="new_pwd_1" /></td>
					</tr>
					<tr>
						<th width="80">重复新密码</th>
						<td><input type="password" name="new_pwd_2" /></td>
					</tr>
					<tr class="last">
						<th>&nbsp;</th>
						<td><br />
							<button class="mid" onclick="return passwordpk()" type="submit">确认修改</button>
						</td>
					</tr>
				</table>
			</form>
			<?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

<script language="javascript">
function passwordpk(){
	if(detail.new_pwd_1.value==""){
		alert("新密码不可为空，请填写!!!");
		detail.new_pwd_1.focus();
		return false;
	}
	
	if(detail.new_pwd_1.value!=detail.new_pwd_2.value){
		alert("两次密码输入不一致，请填写!!!");
		detail.new_pwd_1.value="";
		detail.new_pwd_2.value="";
		detail.new_pwd_1.focus();
		return false;
	}
}
</script>