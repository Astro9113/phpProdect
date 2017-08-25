<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);


$shops = get_shops();
$users = get_users();

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>微优--用户对商品价额--香水卫裤</h2>
		<div class="uc">

<a href="add.php">添加</a>
<table width="900" border="1">
  <tr>
    <td>ID</td>
    <td>用户名</td>
    <td>商品</td>
    <td>加额</td>
    <td>加额2</td>
    <td>加额3</td>
    <td>加额4</td>
    <td>加额5</td>
    <td>加额6</td>
    <td>加额7</td>
    <td>加额8</td>
    <td>加额9</td>
    <td>加额10</td>
    <td>加额11</td>
    <td>加额12</td>
    <td>编辑</td>
  </tr>
 <?php 
      $sql = "select * from wx_usershopadd where 1";
      $infos = $mysql->query($sql);
      if($infos){
          foreach($infos as $res){
              print <<<oo

<tr>
    <td>{$res['id']}</td>
    <td>{$users[$res['userid']]['loginname']} {$res['userid']}</td>
    <td>{$shops[$res['shopid']]['shopname2']} {$res['shopid']}</td>
    <td>{$res['jine']}</td>
    <td>{$res['jine2']}</td>
    <td>{$res['jine3']}</td>
    <td>{$res['jine4']}</td>
    <td>{$res['jine5']}</td>
    <td>{$res['jine6']}</td>
    <td>{$res['jine7']}</td>
    <td>{$res['jine8']}</td>
    <td>{$res['jine9']}</td>
    <td>{$res['jine10']}</td>
    <td>{$res['jine11']}</td>
    <td>{$res['jine12']}</td>
    <td><a href="de.php?id={$res['id']}">删除</a></td>
</tr>   
oo;
              
          }
      }

?>
</table>

		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

<style>
table,td{border-collapse:collapse;}
td{padding:5px;}
</style>

