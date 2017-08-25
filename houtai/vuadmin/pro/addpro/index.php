<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1);
qx($allow_qx, $adminclass);

$shopclasses = shopclasses();
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<h2>添加商品</h2>
		<div class="uc">
			<p>
				<a class="btn" href="../">返回商品列表</a>
			</p>
			<hr>
			
			<div class="comform addshop">
				<form action="addpropd/" method="post" enctype="multipart/form-data" name="form1">
					<table cellpadding="12" cellspacing="0" border="0"
						class="table-form">
						<tr>
							<th width="85">商品分类</th>
							<td width="635">
							<select name="shopclass">
							     <option value="" selected>请选择分类</option>
                                 <?php echo_option($shopclasses, 0, 'shopclassid', 'shopclassname');?>    
                            </select>         
                            <span class="addshoptype">商品类型</span> 
                            <select name="shoptype">
									<option value="" selected>请选择类型</option>
									<option value="0">功能型产品</option>
									<option value="1">颜色尺码类</option>
							</select></td>
						</tr>

						<tr>
							<th width="85">商品主名称</th>
							<td width="635"><input name="shopname" type="text"
								style="width: 300px;"> 吸引 客户购买</td>
						</tr>

						<tr>
							<th width="85">商品副名称</th>
							<td width="635"><input name="shopname2" type="text"
								style="width: 300px;"> 精简 订单管理</td>
						</tr>
						<tr>
							<th>推广说明</th>
							<td><textarea name="shopcon" id="shopcon" cols="80" rows="4"></textarea>
							</td>
						</tr>
						<tr>
							<th>宣传文案1</th>
							<td><input name="shopcopya1" type="text" style="width: 450px;">
								文案链接 <br> <input name="shopcopytxt1" type="text"
								style="width: 450px;"> 文案标题</td>
						</tr>
						<tr>
							<th>宣传文案2</th>
							<td><input name="shopcopya2" type="text" style="width: 450px;">
								文案链接 <br> <input name="shopcopytxt2" type="text"
								style="width: 450px;"> 文案标题</td>
						</tr>
						<tr>
							<th>宣传文案3</th>
							<td><input name="shopcopya3" type="text" style="width: 450px;">
								文案链接 <br> <input name="shopcopytxt3" type="text"
								style="width: 450px;"> 文案标题</td>
						</tr>
						<tr>
							<th>商品图片</th>
							<td valign="bottom">

								<div class="wenjy">
									<input type="file" name="upfile" id="upfile" class="wenby"
										onChange="previewImage(this,preview,imghead)">
								</div>

								<div id="preview">
									<img id="imghead" src="../../../images/wupic.jpg" width="200"
										height="200" />
								</div>
								<div class="cb"></div>

							</td>
						</tr>
						
						<tr>
							<th>营业执照</th>
							<td valign="bottom">

								<div class="wenjy">
									<input type="file" name="upfile1" id="upfile1" class="wenby"
										onChange="Image1(this)">
								</div>

								<div id="preview1">
									<img id="imghead1" src="../../../images/wupic.jpg" width="200"
										height="200" />
								</div>
								<div class="cb"></div>

							</td>
						</tr>
						
						<tr>
							<th>生产许可证</th>
							<td valign="bottom">

								<div class="wenjy">
									<input type="file" name="upfile2" id="upfile2" class="wenby"
										onChange="Image2(this)">
								</div>

								<div id="preview2">
									<img id="imghead2" src="../../../images/wupic.jpg" width="200"
										height="200" />
								</div>
								<div class="cb"></div>

							</td>
						</tr>
						
						<tr>
							<th>授权</th>
							<td valign="bottom">

								<div class="wenjy">
									<input type="file" name="upfile3" id="upfile3" class="wenby"
										onChange="Image3(this)">
								</div>

								<div id="preview3">
									<img id="imghead3" src="../../../images/wupic.jpg" width="200"
										height="200" />
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

									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname1" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy1" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget1" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="1" checked></td>
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname2" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy2" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget2" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="2">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname3" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy3" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget3" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="3">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname4" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy4" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget4" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="4">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname5" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy5" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget5" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="5">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname6" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy6" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget6" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="6">
									
									</tr>

									<!-- sku 7--12  -->

									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname7" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy7" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget7" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="7"></td>
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname8" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy8" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget8" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="8">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname9" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy9" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget9" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="9">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname10" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy10" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget10" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="10">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname11" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy11" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget11" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="11">
									
									</tr>
									<tr class="last" bgcolor="#ffffff">
										<td><input name="shopskuname12" type="text"
											style="width: 230px; padding: 2px 4px;"></td>
										<td><input name="shopbuy12" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input name="shopget12" type="text"
											style="width: 30px; padding: 0px 4px;"> 元</td>
										<td><input type="radio" name="skumoren" value="12">
									
									</tr>

								</table> 
									
							</td>
						</tr>
						<tr>
							<th>颜色尺码</th>
							<td>
							    <input name="shopcolor" type="text" style="width: 450px;"> 颜色
								例：黄色_红色_黑色<br> 
								<input name="shopsize" type="text"
								style="width: 450px;"> 尺码 例：M_L_XL_XXL
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
<script language="javascript">
function pk(){
	if(form1.shopclass.value==""){
		alert("请选择商品分类!!!");
		form1.shopclass.focus();
		return false;
	}
	
	if(form1.shoptype.value==""){
		alert("请选择商品类型!!!");
		form1.shoptype.focus();
		return false;
	}
	if(form1.shoptype.value=="1"){
	if((form1.shopcolor.value=="") && (form1.shopsize.value=="")){
		alert("颜色尺码必选一项！!");
		form1.shopcolor.focus();
		return false;
	}
  }
}
</script>