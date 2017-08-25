<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";
?>

<?php
require CAIWU_PATH . 'head.php';
?>

<div id="wrap" class="clearfix">
    <?php require CAIWU_PATH . 'menu.php';?>

	<div id="main" class="clearfix">
		<h2>详细打款信息列表</h2>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="30px">ID</th>
					<th>收款人</th>
					<th width="60px">金额</th>
					<th width="100px">账号</th>
					<th width="72px">姓名</th>
					<th width="68px">订单ID</th>
					<th width="60px">类型</th>
					<th width="168px">时间</th>
				</tr>
    
<?php
        
        $sql = "select count(*) as num from wx_playmoney";
        $ret = $mysql->find($sql);
        $num = $ret['num'];

        $page_size = 12;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        $page = $page?$page:1;
        $offset = ($page - 1) * $page_size;
        
        $sql = "select * from wx_playmoney order by id desc limit $offset,$page_size";
        $infos = $mysql->query($sql);
        
        foreach ($infos as $info){
			foreach($info as $k=>$v){
				if($k=='guestrizhi'){
						continue;
						//$info[$k] = guestrizhi($v);
					}else{
						$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
					}
			}
			
            $name = $info['moneyname'];
            $zhifubao = $info['moneynum'];
            $quanming = $info['moneyfullname'];
print <<<EOT
                <tr>
					<td>{$info['id']}</td>
					<td>{$name}</td>
					<td>{$info['moneyhow']}</td>
					<td>{$zhifubao}</td>
					<td>{$quanming}</td>
					<td>{$info['moneyguestid']}</td>
					<td>微信返利</td>
					<td>{$info['addtime']}</td>
				</tr>   
EOT;

        }
        
        ?>
	</table>
			<div class="listpage">
			<?php $page_config = array();?>
			<?php require CAIWU_PATH . 'page2.php';?>
			</div>
        <?php require CAIWU_PATH . 'tip.php';?>
		</div>
	</div>
</div>

<?php require CAIWU_PATH . 'foot.php';?>
