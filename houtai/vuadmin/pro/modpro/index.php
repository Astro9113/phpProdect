<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$shopclasses = shopclasses();

$id = intval($_GET['id']);
$info = shopinfo($id);
if (! $info) {
    alert('商品不存在');
    goback();
}

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
    <div id="main" class="clearfix">
		<h2>修改商品</h2>
		<div class="uc">
			<p>
				<a class="btn" href="/vuadmin/pro/">返回商品列表</a>
			</p>
			<hr>
			<div class="comform addshop">
				<form action="modpropd/" method="post" enctype="multipart/form-data" name="form1">
				    <input name="id" type="hidden" value="<?php echo $id;?>">
					<input type="hidden" name="shoptype" value="<?php echo $info['shoptype'];?>">
					<table cellpadding="12" cellspacing="0" border="0" class="table-form">
						<tr>
							<th width="85">商品分类</th>
							<td width="635">
							     <select name="shopclass">
									<option value="" selected>请选择分类</option>
                                    <?php echo_option($shopclasses, $info['shopclass'], 'shopclassid', 'shopclassname');?>
                                  </select>
                            </td>
						</tr>

						<tr>
							<th width="85">商品名称</th>
							<td width="635"><input name="shopname" type="text"
								style="width: 300px;" value="<?php echo $info['shopname'];?>">
								吸引 客户购买
							</td>
						</tr>

						<tr>
							<th width="85">商品副名称</th>
							<td width="635"><input name="shopname2" type="text"
								style="width: 300px;" value="<?php echo $info['shopname2'];?>">
								精简 订单管理</td>
						</tr>
						<tr>
							<th>推广说明</th>
							<td><textarea name="shopcon" id="shopcon" cols="80" rows="4"><?php echo $info['shopcon'];?></textarea>
							</td>
						</tr>
    
    
                        <?php
                        $shopcopytxt = $info['shopcopytxt'];
                        $shopcopytxt = explode("^", $shopcopytxt);
                        $shopcopya = $info['shopcopya'];
                        $shopcopya = explode("^", $shopcopya);
                        
                        for ($i = 0; $i < 8; $i ++) {
                        $sub  = $i+1;
print <<<oo
                        <tr>
                        	<th>宣传文案{$sub}</th>
                        	<td>
                        	<input name="shopcopya[]" type="text" style="width: 450px;" value="{$shopcopya[$i]}">文案链接<br> 
                        	<input name="shopcopytxt[]" type="text" style="width: 450px;" value="{$shopcopytxt[$i]}">文案标题</td>
                        </tr>
oo;
                        }
                        ?>
    
                        <tr>
							<th>商品图片</th>
							<td valign="bottom">

								<div class="wenjy">
									<input type="file" name="upfile" id="upfile" class="wenby" onChange="previewImage(this)"> 
									<input name="oldshoppic" type="hidden" value="<?php echo $info['shoppic'];?>">
								</div>

								<div id="preview">
									<img id="imghead" src="<?php echo shopimg($info['shoppic'], '../../../')?>" width="200" />
								</div>
								<div class="cb"></div>

							</td>
						 </tr>
						
						
						<tr>
							<th>商品SKU</th>
							<td>

								<table width="100%" cellpadding="4" border="0" bgcolor="#d3d3d3"
									cellspacing="1">
									<tr class="last" bgcolor="#f5f5f5">
										<th width="300">销售SKU</th>
										<th>价格</th>
										<th>分成</th>
										<th>默认</th>
									</tr>

									
									
<?php 
    for ($i=1;$i<=12;$i++){
        $shopsku = $info['shopsku'.$i];
        $shopsku = explode('_', $shopsku);
        $checked = '';
        if($info['skumr'] == $i){
            $checked  = ' checked';
        }
        
print <<<oo

<tr class="last" bgcolor="#ffffff">
	<td>
	   <input name="shopskuname{$i}" type="text" style="width: 230px; padding: 2px 4px;" value="{$shopsku[0]}">
	</td>
	<td>
	   <input name="shopbuy{$i}" type="text" style="width: 30px; padding: 0px 4px;" value="{$shopsku[1]}"> 元
	</td>
	<td>
	   <input name="shopget{$i}" type="text" style="width: 30px; padding: 0px 4px;" value="{$shopsku[2]}"> 元
	</td>
	<td>
	   <input type="radio" name="skumr" value="{$i}"{$checked}>
	</td>
</tr>

oo;
        
    }
?>
									
                                </table> 
							</td>
						</tr>
						
						<tr>
							<th>颜色尺码</th>
							<td><input name="shopcolor" type="text" style="width: 450px;"
								value="<?php echo $info['shopcolor'];?>"> 颜色 例：黄色_红色_黑色<br> 
								<input name="shopsize" type="text" style="width: 450px;"
								value="<?php echo $info['shopsize'];?>"> 尺码 例：M_L_XL_XXL</td>
						</tr>
						
						<tr>
							<th>出单统计</th>
							<td>参与账号 <input name="shopusernum" type="text"
								style="width: 50px;" value="<?php echo $info['shopusernum'];?>">
								&nbsp;&nbsp;&nbsp;&nbsp;总粉丝数 <input name="shopfensinum"
								type="text" style="width: 50px;"
								value="<?php echo $info['shopfensinum'];?>">
								&nbsp;&nbsp;&nbsp;&nbsp;总出单数 <input name="shopstatinum"
								type="text" style="width: 50px;"
								value="<?php echo $info['shopstatinum'];?>">
								&nbsp;&nbsp;&nbsp;&nbsp;出单率 <input name="shopoutlv" type="text"
								style="width: 50px;" value="<?php echo $info['shopoutlv'];?>">
							</td>
						</tr>
						<tr>
							<th>第二模式</th>
							<td>
							<textarea name="shopcopy" id="shopcopy" cols="80" rows="8"><?php echo $info['shopcopy'];?></textarea>
							</td>
						</tr>
					</table>
					<div class="tijan">
						<button class="mid" type="submit" onClick="return pk()">确认提交</button>
					</div>
				</form>
			</div>
            <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>


<?php require ADMIN_PATH . 'foot.php';?>
<script src="/js/jstu.js"></script>
<script>
function pk(){
	if((form1.shoptype.value == 1) &&(form1.shopcolor.value=="") && (form1.shopsize.value=="")){
		alert("请颜色尺码必选一项!!!");
		form1.shopcolor.focus();
		return false;
	}
}
</script>