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
	$sql_jine4 = intval($_POST['jine4']);
	$sql_jine5 = intval($_POST['jine5']);
	$sql_jine6 = intval($_POST['jine6']);
	$sql_jine7 = intval($_POST['jine7']);
	$sql_jine8 = intval($_POST['jine8']);
	$sql_jine9 = intval($_POST['jine9']);
	$sql_jine10 = intval($_POST['jine10']);
	$sql_jine11 = intval($_POST['jine11']);
	$sql_jine12 = intval($_POST['jine12']);
	
	
	$w = "userid = '{$userid}' and shopid = '{$shopid}'";
	$num = $mysql->count_table('wx_usershopadd',$w);
	if($num){
	    alert('不能重复添加');
	    go('./');   
	}
	

	$sql  = "insert into wx_usershopadd(userid,shopid,jine,jine2,jine3,jine4,jine5,jine6,jine7,jine8,jine9,jine10,jine11,jine12) values('$userid','$shopid','$sql_jine','$sql_jine2','$sql_jine3','$sql_jine4','$sql_jine5','$sql_jine6','$sql_jine7','$sql_jine8','$sql_jine9','$sql_jine10','$sql_jine11','$sql_jine12')";
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
    <td>加额4</td>
    <td><input name="jine4" type="text"></td>
  </tr>
    <tr>
    <td>加额5</td>
    <td><input name="jine5" type="text"></td>
  </tr>
    <tr>
    <td>加额6</td>
    <td><input name="jine6" type="text"></td>
  </tr>
    <tr>
    <td>加额7</td>
    <td><input name="jine7" type="text"></td>
  </tr>
    <tr>
    <td>加额8</td>
    <td><input name="jine8" type="text"></td>
  </tr>
    <tr>
    <td>加额9</td>
    <td><input name="jine9" type="text"></td>
  </tr>
    <tr>
    <td>加额10</td>
    <td><input name="jine10" type="text"></td>
  </tr>
    <tr>
    <td>加额11</td>
    <td><input name="jine11" type="text"></td>
  </tr>
    <tr>
    <td>加额12</td>
    <td><input name="jine12" type="text"></td>
  </tr>
  
  <tr>
    <td><input name="tj" type="hidden" value="1"></td>
    <td><input name=" 提交 " type="submit"></td>
  </tr>
</table>


</form>

