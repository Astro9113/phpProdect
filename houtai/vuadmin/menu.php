<?php 
    $stat = $adminclass == 5 ? 'index_5.php':'index.php';
?>
<div class="menu">
	<dl class="expand cur">
		<dt>
			<a href="/vuadmin/">管理中心首页<i class="only"></i></a>
		</dt>
	</dl>
 
 <dl>
		<dt>
			<a href="/vuadmin/stat/<?php echo $stat;?>">订单统计<i class="only"></i></a>
		</dt>
	</dl>


 <dl class="">
		<dt>
			<a>用户管理<i></i></a>
		</dt>
		<dd>
			<a href="/vuadmin/user/adduser/">● 添加用户</a>
		</dd>
		<dd class="last">
			<a href="/vuadmin/user/">● 用户列表</a>
		</dd>
	</dl>

 <dl class="">
		<dt>
			<a>商品管理<i></i></a>
		</dt>
		<dd>
			<a href="/vuadmin/pro/addpro/">● 添加商品</a>
		</dd>
		<dd>
			<a href="/vuadmin/pro/">● 商品列表</a>
		</dd>
		<dd class="last">
			<a href="/vuadmin/pro/class/">● 商品分类管理</a>
		</dd>
	</dl>

 <dl class="">
		<dt>
			<a>管理员设置<i></i></a>
		</dt>
		<dd>
			<a href="/vuadmin/center/">● 管理员列表</a>
		</dd>
		<dd class="last">
			<a href="/vuadmin/center/adminclass/">● 管理员等级</a>
		</dd>
	</dl>

   <dl class="">
		<dt>
			<a>系统设置<i></i></a>
		</dt>
		<dd>
			<a href="/vuadmin/seting/">● 基本设置</a>
		</dd>
		<dd class="last">
			<a href="/vuadmin/miduser/">● 中间人设置</a>
		</dd>
	</dl>

 
  <dl class="">
		<dt>
			<a>信息设置<i></i></a>
		</dt>
		<dd>
			<a href="/vuadmin/center/mydata/">● 我的信息</a>
		</dd>
		<dd class="last">
			<a href="/vuadmin/center/mydata/modpassword/">● 修改密码</a>
		</dd>
	</dl>
	<dl>
		<dt>
			<a href="/vuadmin/logout/">退出登录<i class="only"></i></a>
		</dt>
	</dl>
</div>