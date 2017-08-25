<div class="menu">
		<dl class="expand cur">
			<dt>
				<a href="/sale/">媒介管理中心<i class="only"></i></a>
			</dt>
		</dl>
		<dl>
			<dt>
				<a href="/sale/stat/">订单统计<i class="only"></i></a>
			</dt>
		</dl>
		<dl>
			<dt>
				<a href="/sale/user/">微信主统计<i class="only"></i></a>
			</dt>
		</dl>
 <?php if($_SESSION['mid1114class']=="1"){?>
  <dl class="">
			<dt>
				<a>推广统计<i></i></a>
			</dt>
			<dd>
				<a href="/sale/tongji/shop/">● 商品统计</a>
			</dd>
			<dd class="last">
				<a href="/sale/tongji/user/">● 用户统计</a>
			</dd>
		</dl> 
  <?php }?>
  <dl class="">
			<dt>
				<a>信息设置<i></i></a>
			</dt>
			<dd>
				<a href="/sale/center/mydata/">● 我的信息</a>
			</dd>
			<dd class="last">
				<a href="/sale/center/mydata/modpassword/">● 修改密码</a>
			</dd>
		</dl>
		<dl>
			<dt>
				<a href="/sale/logout/">退出登录<i class="only"></i></a>
			</dt>
		</dl>
	</div>