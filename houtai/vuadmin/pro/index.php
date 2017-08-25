<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$w = ' 1 ';

$shopclass = isset($_GET['shopclass']) ? intval($_GET['shopclass']) : - 1;
if ($shopclass !== - 1) {
    $w .= " and shopclass = {$shopclass}";
}

$upbot = isset($_GET['upbot']) ? intval($_GET['upbot']) : - 1;
if ($upbot !== - 1) {
    $w .= " and upbot = {$upbot}";
}

$shopname2 = isset($_GET['shopname2']) ? gl_sql($_GET['shopname2']) : '';
if ($shopname2) {
    $w .= " and shopname2 like '%{$shopname2}%'";
}


if ($adminclass == 3) {
    $w .= "and adduser = '{$adminname}'";
}



$shopclasses = shopclasses();
$shopclasses[-1] = array('shopclassid'=>-1,'shopclassname'=>'不限');
ksort($shopclasses);

$upbot_a = array(-1 =>'不限','下架','上架');
list($num_0,$num_1) = upbot_num();

?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
    <?php require ADMIN_PATH . 'menu.php';?>
<div id="main" class="clearfix">
		<div class="filter">
			<div class="cxform" style="width:310px;">
				<form id="search" method="get" action="">
					<select name="shopclass">
						<?php echo_option($shopclasses, $shopclass, 'shopclassid', 'shopclassname')?>
                    </select>
					<select name="upbot">
						<?php echo_option2($upbot_a, $upbot);?>
                    </select>
					<input type="text" name="shopname2" value="<?php echo $shopname2;?>" size="11" />
					<button>筛 选</button>
				</form>
			</div>



            <div class="cxform" style="width: 250px; margin-top: 6px;">
                                        上架商品：<?php echo $num_1;?> 个 &nbsp;&nbsp;&nbsp; 下架商品： <?php echo $num_0;?> 个
            </div>


            <div class="cb"></div>
		</div>
		
		<div class="uc">
			<form action="ordergg/" method="post" name="form1">
				<table class="items" width="100%" cellpadding="5" border="0"
					bgcolor="#d3d3d3" cellspacing="1">
					<tr bgcolor="#f5f5f5">
						<th width="160px">商品图片</th>
						<th>商品名称</th>
						<th width="110px">管理员及价格</th>
						<th width="80px">推广详情</th>
					</tr>
    
<?php
        
    $num = $mysql->count_table('wx_shop',$w);
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $page = $page?$page:1;
    $offset = ($page - 1) * $page_size;

    $sql = "select * from wx_shop where {$w} order by upbot desc,shoporder desc limit $offset,$page_size";
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
            foreach ($info as $k=>$v){
                $info[$k] = gl2($v);
            }
            $ee = 1;
            $shopsku = $info['shopsku1'];
            $shopsku = explode("_", $shopsku);
            $shopimg = shopimg($info['shoppic'], '../../');
            $shupming = mysubstr($info['shopcon'],0,54);;
            $status  = $info['upbot']?'下架':'上架';
            
print <<<oo
           	<tr>
                <td align="center"><img src="{$shopimg}" width="150px"></td>
        		<td>
        		<h3>{$info['shopname']}</h3>
        		<p><em>推广说明：</em>{$shupming}...</p>
        		</td>
        		<td>{$shopsku[1]} / <em>{$shopsku[2]}</em><br>{$info['adduser']}
        		</td>
        		<td align="center">
        		<input name="id{$ee}" type="hidden" value="{$info['id']}"><br>    
                <input class="mtop5 shoporder" name="order{$ee}" type="text" value="{$info['shoporder']}">
                <a class="btn mtop5" href="modpro/?id={$info['id']}">修改</a> <br />
                <a class="btn mtop5" href="botpro/?id={$info['id']}">{$status}</a>
        		</td>
        	</tr>         
oo;
            $ee++;
        }
    }            
            

            
        ?>
	</table>
</form>
				<div class="listpage mtop5">
                <?php 
                    $page_config = array();
                    $page_config['shopclass'] = $shopclass;
                    $page_config['upbot'] = $upbot;
                    $page_config['shopname2'] = $shopname2;
                    
                ?>   
			    <?php require ADMIN_PATH . 'page2.php';?>
				<button class="shoporder" type="submit">更新排序</button>
				</div>
			</form>
            <?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>
