<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);


$id = intval($_GET['id']);
$info = userinfo($id);
if(!$info){
    exit('用户不存在');
}

foreach ($info as $k=>$v){
    $info[$k] = gl2($v);    
}


$userstate = array('冻结','正常');
$isimportant = array('普通','重点');
$invite_type_a = array('按比例','每单5元');

?>
<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>修改用户信息</h2>
		<div class="uc">


<form class="comform" name="detail" action="moduserpd/" method="post">
<input name="id" type="hidden" value="<?php echo $id;?>">
					
    <ul class="comform">
        <li>
            <label>
            <b>登陆名：</b>
            <input type="text" name="loginname" disabled value="<?php echo $info['loginname'];?>" />
            </label>
		</li>
					
					<li><label><b>昵称：</b><input type="text" name="username" disabled
							value="<?php echo $info['username'];?>" /></label></li>
					<li><label><b>QQ：</b><input type="text" name="qq"
							value="<?php echo $info['qq'];?>" /></label></li>
					<li><label><b>手机：</b><input type="text" name="tel"
							value="<?php echo $info['tel'];?>" /></label></li>
					<li><label><b>电子邮箱：</b><input type="text" name="email"
							value="<?php echo $info['email'];?>" /></label></li>
					<li><label><b>支付宝账号：</b><input type="text" name="alipay"
							value="<?php echo $info['alipay'];?>" /></label></li>
					<li><label><b>支付宝姓名：</b><input type="text" name="alipayname"
							value="<?php echo $info['alipayname'];?>" /></label></li>
							
					<li><label>
					<b>用户状态：</b>
					<select name="userstate">
					   <?php echo_option2($userstate, $info['userstate'])?>
					</select>
					
					<li><label><b>重点客户：</b>
					<select name="isimportant">
					   <?php echo_option2($isimportant, $info['isimportant'])?>
					</select>
					</label></li>
							

                    <li><label><b>邀请分成方式：</b>
					<select name="invite_type">
					   <?php echo_option2($invite_type_a, $info['invite_type'])?>
					</select>
					</label></li>
												

							
					<li class="no-label"><button type="submit" onClick="return confirm('您确定修改吗?')" class="big">提 交</button></li>
				</ul>
			</form>
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>