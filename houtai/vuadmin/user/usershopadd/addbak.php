<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$shops = get_shops();


if(isset($_POST['tj'])){
	$username = gl_sql($_POST['username']);
	$ret = find_user_byname($username);
	if(!$ret){
	    exit('用户不存在');
	}
	
	$userid  = $ret['id'];
	$shopid = intval($_POST['shopid']);
	$shop = $shops[$shopid];
	
    $sql_jine = intval($_POST['jine']);
	$sql_jine2 = intval($_POST['jine2']);
	$sql_jine3 = intval($_POST['jine3']);
	
	$w = "userid = '{$userid}' and shopid = '{$shopid}'";
	$num = $mysql->count_table('wx_usershopadd',$w);
	if($num){
	    alert('不能重复添加');
	    go('./');   
	}
	

	$sql  = "insert into wx_usershopadd(userid,shopid,jine,jine2,jine3) values('$userid','$shopid','$sql_jine','$sql_jine2','$sql_jine3')";
	$ret = $mysql->execute($sql);
	
	if($ret){
        go('./index.php');
	}else{
		alert('添加失败');
		goback();
	}

}


?>

<h2>微优--用户对商品价额--添加</h2>

<form action="" method="post">

<table width="800" border="1">
  <tr>
    <td>用户名</td>
    <td><input name="username" type="text"></td>
  </tr>
  <tr>
    <td>商品</td>
    <td><select name="shopid">
    <?php 
	foreach ($shops as $i => $n)  {
	
     echo "<option value='".$i."'>".$n['shopname2']." ".$i."</option>";
      
      }?>
    </select></td>
  </tr>
  <tr>
    <td>加额</td>
    <td><input name="jine" type="text"></td>
  </tr>
    <tr>
    <td>加额2</td>
    <td><input name="jine2" type="text"></td>
  </tr>
    <tr>
    <td>加额3</td>
    <td><input name="jine3" type="text"></td>
  </tr>
  <tr>
    <td><input name="tj" type="hidden" value="1"></td>
    <td><input name=" 提交 " type="submit"></td>
  </tr>
</table>


</form>

