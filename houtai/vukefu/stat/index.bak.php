<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

$kefu = get_kefu_info($loginid);


$class = isset($_GET['class'])?intval($_GET['class']):0;
$orderstates = get_orderstates();

require KEFU_PATH . 'head.php';

?>


<div id="wrap" class="clearfix">
    <?php require KEFU_PATH.'menu.php'?>
    <div id="main" class="clearfix">
		<div class="filter widthb110">
			<div class="cxform">
				<form id="search" method="get" action="">
					<select name="jumpMenu" id="jumpMenu"
						onChange="MM_jumpMenu('parent',this,0)">
						<option value="?class=0">订单状态查询</option>
						<option value="?class=0">全部</option>
                        <?php
                            foreach ($orderstates as $id=>$info){
                                $sel = '';
                                //$id = $info['id'];
                                if ($class == $id) {
                                    $sel = 'selected="selected"';
                                }
                                echo "<option value='?class=" . $id . "' {$sel}>" .$info['orderstate'] . "</option>";
                            }
                        ?>
                    </select>
				</form>
			</div>
			
			<div class="cxform2" style="width: 250px;">
				<form name="form1" method="get" action="guestidsea/">
					订单ID <input name="guestid" type="text"
						style="width: 100px; height: 18px;">
					<button type="submit">查 询</button>
				</form>
			</div>
			
			<div class="cxform2" style="width: 300px;">
				<form name="form1" method="get" action="guestnamesea/">
					姓名/电话/单号 <input name="guestname" type="text"
						style="width: 100px; height: 18px;">
					<button type="submit">查 询</button>
				</form>
			</div>
			
			
			<div class="cb"></div>
			

			<div class="cxform2" style="width: 100px;">
				<a class="btn" style="margin-top: 8px; margin-left: 12px;"
					href="important/queren/">重点客户</a>
			</div>

            <?php
            if ($kefu['level'] == 1) {
            ?>
                <div class="cxform2" style="width: 120px;">
                    <a class="btn" style="margin-top: 8px; margin-left: 12px;" href="/vukefu/stat/fenzu/">组员订单</a>
                </div>
            <?php
                }
            ?>
            
            
            <div class="cb"></div>
		</div>
		
		
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0" bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="80px">购买者</th>
					<th width="72px">金额</th>
					<th width="100px">状态</th>
					<th width="35px">详情</th>
				</tr>
    
<?php

        $shops = get_shops();        

        
        
        $num = kefu_get_num($loginid, $class);
        $page_size = 12;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        $page = $page?$page:1;
        $offset = ($page - 1) * $page_size;
        
        $ww = 1;
        
        $sql = "select * from wx_guest where guestkfid='$loginid' order by id desc limit $offset,$page_size";
        if($class){
            $sql = "select * from wx_guest where guestkfid='$loginid' and gueststate='$class' order by id desc limit $offset,$page_size";
        }
        
        $infos = $mysql->query($sql);
        foreach ($infos as $info){
			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
			
			$shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $userid         =  $info['userid'];
            $userwx         =  $info['userwx'];
            $guestname      =  $info['guestname'];
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  $info['guestkuanshi'];
            $shop           =  $shops[$shopid];
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            $orderstate     =  $orderstates[$gueststate];
            $orderstate     =  $orderstate['orderstate'];
            $bz             =  mysubstr($info['guestrem'],0,25);
            $addtime        =  substr($info['addtime'], 5,11);

print <<<EOT
            <tr onmouseover="statbzxs('bz{$ww}')" onmouseout="statbzxs('bz{$ww}')">
					<td>{$addtime}</td>
					<td>{$info['id']}</td>
					<td>{$gusettitle}</td>
					<td>{$guestname}</td>
					<td>{$shopsku[1]}</td>
					<td>{$orderstate}
					    <a href="orderstate/?id={$info['id']}&class={$class}">更改</a>
					</td>
					<td>
					 <a href="statcon/?id={$info['id']}&class={$class}&page={$page}">详情</a>
    					<div class="statbzd">
    					   <div class="statbz" id="bz{$ww}">{$bz}</div>
    					</div>
					</td>
			 </tr>
EOT;
            $ww ++;
            
        }
        
       ?> 
               
	</table>
            <?php require KEFU_PATH . 'page.php';?>
		    <?php require KEFU_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require KEFU_PATH . 'foot.php';?>