<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
    require ROOT."wxdata/kefulimit.php";

    if(isset($_POST['old_pwd'])){
        $old_pwd = gl_sql($_POST['old_pwd']);
        $new_pwd_1 = $_POST['new_pwd_1'];
        $new_pwd_2 = $_POST['new_pwd_2'];
        
        $sql = "select * from wx_kefu where id='$loginid'";
        $ret = $mysql->find($sql);
        $info = $ret;
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
        
        $sql = "update wx_kefu set adminpassword='$new_pwd_1' where id = '{$loginid}'";
        $ret = $mysql->execute($sql);
        
        if($ret){
        	go('./','更改管理员密码成功');
        }else{
            go('./','更改管理员密码失败，请联系技术人员');
        }
        
    }   
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>修改管理员密码</title>
<link rel="stylesheet" href="/css/main.css" />
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script src="/js/j.js"></script>

</head>
<body>
<div id="top">
	<div class="top"><img src="/images/logo.png">微信公众号盈利平台</div>
</div>

<div id="wrap" class="clearfix">
<?php 
    require KEFU_PATH.'menu.php';
?>

<div id="main" class="clearfix">
    <h2>更改管理密码</h2>
    <div class="uc">
        <p><a class="btn" href="/vukefu/center/mydata/">查看自己信息</a></p>
        <hr>

        <form class="comform" name="detail" method="post" action="">
        <table cellpadding="12" cellspacing="0" border="0" class="table-form">
        <tr>
        		<th width="80">原密码</th>
        		<td><input type="password" name="old_pwd" />
                </td>
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
        		<td><br/>
        			<button class="mid" type="submit">确认修改</button>
        		</td>
        	</tr>
        </table>
        </form>
    
    </div>
</div>
</div>

<div id="footer">
<p>北京微优网络科技有限公司</p>
</div>

</body>
</html>