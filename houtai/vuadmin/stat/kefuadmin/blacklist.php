<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

if(isset($_POST['sub'])){
    foreach ($_POST as $k=>$v){
        if($v !== gl_sql($v)){
            exit('参数错误');
        }
    }
     
    $tel = preg_replace('/[^0-9]/', '', trim($_POST['tel']));
    $remark = trim($_POST['remark']);
    
    if($tel && $remark){
        $sql = "insert into wx_blacklist (tel,remark) values('$tel','$remark')";
        $ret = $mysql->execute($sql);
        //var_dump($ret);
        //exit;
    }
    
    alert('添加成功');
    go('blacklist.php');
}

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>黑名单列表</h2>
		<div class="uc">
			<p>
            <form action="" method="post">
                                    电话<input type="text" name="tel" />
                                    备注<input type="text" name="remark" />
                <input type="submit" name="sub" value="提交" />
            </form>
			</p>
			<table width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th>ID</th>
					<th>电话</th>
					<th>备注</th>
				</tr>
<?php
        $sql = "select * from wx_blacklist";
        $infos = $mysql->query($sql);
        foreach ($infos as $info){
?>
	<tr>
					<td><?php echo $info['id']; ?></td>
					<td><?php echo $info['tel']; ?></td>
                    <td><?php echo $info['remark']; ?></td>
            
    	</tr>
	    <?php

        }
        ?>
	</table>
			
		</div>
	</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>

<script>

</script>

<style>
.green{background-color:green;}        
</style>