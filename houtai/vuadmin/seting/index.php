<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,9); 

qx($allow_qx, $adminclass);

$mid = isset($_GET['mid'])?intval($_GET['mid']):0;

if($mid){
    $miduser = miduserinfo($mid);
}else{
    $midusers = get_midusers();
}

?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>系统设置</h2>
		<div class="uc">
			<hr>
<?php 
    if($mid){//单人设置模式
        //第一个数字  1 = 直接下单 2 = 文案加下单 
        //第二个数字  1 = 模式一  2 = 模式2  ....
        //第三个数字  1 = 第一个域名 2 = .....
        $arr = array(
				//'domain-ad-js'=>'cps_js调用域名(泛解析)',
                //'vu_domain_waxd_1'=>'cps跳转域名',
                //'vu_domain_zjxd_2'=>'cps域名',
                
                'vu_domain_zjxd_2_jump'=>'直接下单',
                //'vu_domain_zjxd_1'=>'直接下单域名(泛解析)',
                
                //'jumpdomain_2'=>'文案加下单跳转域名',
                //'domain_2_2_1'=>'文案加下单域名',
        );
        
        $remark = get_config('remark');
?>
    <h1><?php echo $miduser['username'];?></h1>
    <form class="comform" name="detail" method="post" action="modsetingpd/">
	<input type="hidden" name="mid" value="<?php echo $mid?>">
				<table cellpadding="12" cellspacing="0" border="0" class="table-form">
                    <?php 
                        foreach ($arr as $k=>$v){
                            $k = $mid.'-'.$k;
                            $value = get_config($k);
                            
                    ?>
                    <tr>
						<th><?php echo $v;?></th>
					</tr>
					<tr>
						<td><input type="text" name="<?php echo $k;?>"
							value="<?php echo $value;?>" style="width: 400px;" /></td>
					</tr>
					
                    <?php         
                            
                        }
                    ?>
                    
                    
                    <tr>
						<td><textarea name="remark" style="width: 400px; height: 200px;" /><?php echo $remark;?></textarea>
						</td>
					</tr>

					<tr class="last">
						<td><br />
							<button class="mid" type="submit">确认修改</button></td>
					</tr>
				</table>
			</form>
    
<?php 
    }else{//多人列表        
?>
    
    <?php 
        foreach ($midusers as $info){
            $name = $info['username'];
            $id = $info['id'];
            echo $tpl = "<a href='?mid={$id}'>{$name}</a><br />";
        }
        
    ?>
    
<?php 
    }
?>			
			

		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>