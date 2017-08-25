<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

require KEFU_PATH . 'head.php';
$cur = 'queren';
$page = $class = 0;


$type = $_GET['type'];
if(!in_array($type, array('guestname','guesttel','guestkuaidi'))){
    go('../','搜索参数错误');
}

$guestname = trim($_GET['guestname']);
$guestname = urldecode($guestname);

if($guestname !== $mysql->escapse($guestname)){
   go('../','搜索参数错误'); 
}

?>

<div id="wrap" class="clearfix">
	<?php require KEFU_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
		<div class="filter">
            <b><?php echo $guestname;?> </b> 
            <a class="btn" style="margin-bottom: 2px;" href="/vukefu/stat/">返回订单列表</a>
		</div>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
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
        
        switch ($type){
            case 'guestname':
                $sql = "select * from wx_guest where guestkfid = '$kefid' and guestname ='$guestname'";
                break;
            case 'guesttel':
                $sql = "select * from wx_guest where guesttel ='$guestname'";
                break;
            case 'guestkuaidi':
                $sql = "select * from wx_guest where guestkfid = '$kefid' and guestkuaidi ='$guestname'";
                break;
            default:
                exit();             
        }

        $infos = $mysql->query($sql);
        
        $ww = 1;
        
        if(!$infos){
            go('../','没有此 姓名/电话 的订单');
        }else{
            
            foreach ($infos as $info){
            
			foreach($info as $k=>$v){
				if($k=='guestrizhi'){
					continue;
					//$info[$k] = guestrizhi($v);
				}else{
					$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
				}
			}
			
            $shopid         =  $info['shopid'];
            $skuid          =  $info['skuid'];
            $userid         =  $info['userid'];
            $userwx         =  $info['userwx'];
            $guestname      =  $info['guestname'];
            $gueststate     =  $info['gueststate'];
            $guestkuanshi   =  $info['guestkuanshi'];
            $shop           =  shopinfo($shopid);
            $shopskuid      =  "shopsku" . $skuid;
            $shopsku        =  $shop[$shopskuid];
            $shopsku        =  explode("_", $shopsku);
            $gusettitle     =  $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
            $orderstate     =  orderstateinfo($gueststate);
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
					    <a href="../orderstate/?id={$info['id']}&class={$class}">更改</a>
					</td>
					<td>
					 <a href="../statcon/?id={$info['id']}&class={$class}&page={$page}">详情</a>
    					<div class="statbzd">
    					   <div class="statbz" id="bz{$ww}">{$bz}</div>
    					</div>
					</td>
			 </tr>
EOT;
        
           }
        }
        ?>
        </table>
        	
        		    <?php require KEFU_PATH . 'tip.php';?>
        		</div>
        	</div>
        </div>
        <?php require KEFU_PATH . 'foot.php';?>