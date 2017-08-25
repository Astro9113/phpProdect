<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
    require ROOT."wxdata/kefulimit.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>管理员信息</title>
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
    <h2>管理员信息</h2>
    <div class="uc">
    <hr>
 
<?php
  
  $kefu1114id = $_SESSION['kefu1114id'];
  $sql = "select * from wx_kefu where id='$kefu1114id'";
  $info = $mysql->find($sql);

?>
 
<form class="comform" name="detail" method="post" action="">
<table cellpadding="12" cellspacing="0" border="0" class="table-form">

    <tr>
		<th width="80">姓名</th>
		<td><input type="text" name="adminname" disabled value="<?php echo $info['adminname'];?>" />
        </td>
	</tr>
    
    <tr>
		<th width="80">账号</th>
		<td><input type="text" name="adminloginname" disabled value="<?php echo $info['adminloginname'];?>" /></td>
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