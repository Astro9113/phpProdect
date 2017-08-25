<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

require KEFU_PATH . 'head.php';
$cur = 'queren';
$page = $class = 0;
?>


<div id="wrap" class="clearfix">
<?php require KEFU_PATH . 'menu.php';?>


<div id="main" class="clearfix">
		<div class="filter widthb110">
			<div class="cxform2" style="width: 500px; line-height: 38px;">
				<font color="#000000">普通订单 追单</font> <font color="#FF0000">当天更新信息的
					不在此显示 不知道改了没 就刷新本页
                </font>
			</div>
			<div class="cb"></div>
		</div>


		<div class="uc">
			<table class="items" width="108%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="82px">下单时间</th>
					<th width="30px">ID</th>
					<th>订购商品</th>
					<th width="80px">购买者</th>
					<th width="72px">金额</th>
					<th width="100px">手机</th>
					<th width="100px">物流状态</th> 
				</tr>
    
<?php
        
//使用 不等号导致索引失效 有时间改写
$sql = "select g.*,gs.wuliustate,gs.guestid,gs.newwuliu,gs.gendan from wx_gueststate gs left join wx_guest g on g.id = gs.guestid where g.guestkfid = '{$kefid}' and gs.wuliustate not in (2,4,5) and g.userid in(select id as userid from wx_user where isimportant = 1)  group by g.id order by g.id desc;";


$shops = get_shops(); // 所有的商品信息
$shipstates = get_shipstate(); //物流状态
$wuliugses = get_wuliugs();

$infos = $mysql->query($sql);
if($infos){
    $ww = 1;
    foreach ($infos as $info) {
        $aa = $info['guestrizhi'];
        $youfh = "<br/>";
        $bb = explode($youfh, $aa);
        $js = count($bb) - 2;
        $cc = substr($bb[$js], 0, 10);
        $dd = date("Y-m-d", time() - 3 * 24 * 3600);
    
		foreach($info as $k=>$v){
			if($k=='guestrizhi'){
				continue;
				//$info[$k] = guestrizhi($v);
			}else{
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
		}
	
        //if ($cc < $dd) { 为什么不判断时间了?
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
            $addtime        =  substr($info['addtime'], 5,11);
            $dizhi          =  $info['guestsheng'].$info['guestcity'].$info['guestqu'].$info['guestdizhi'];
            $gendan         =  $info['gendan'];
            $guesttel       =  $info['guesttel']; 
            
            $shipstate      =  $shipstates[$info['wuliustate']];
            $orderstate     =  $shipstate['kuaidistate'];
            
            $wuliugsname    = $info['wuliugs'];
            $wuliugs        = $wuliugses[$wuliugsname];
            $wuliugscode    = $wuliugs['wuliugscode'];
            
print <<< EOT

<tr bgcolor="#f5ffe4"  onmouseover="statbzxs('bz{$ww}')" onMouseOut="statbzxs('bz{$ww}')">
   <td>{$addtime}</td>
   <td>{$info['id']}</td>
   <td>{$gusettitle}</td>
   <td>{$guestname}</td>
   <td>{$shopsku[1]}</td>
   <td>{$guesttel}</td>
   <td><font color="#FF0000">{$orderstate}</font></a></td>
</tr>


<tr  bgcolor="#f5ffe4">
    <td colspan="6" style="padding:3px 3px 20px 3px;">
                地址：{$dizhi}   
        <A href="http://m.kuaidi100.com/index_all.html?type={$wuliugscode}&postid={$info['guestkuaidi']}" class="caozuo" target="_blank">快递查询</A><br><br>
        {$info['gendan']}
    </td>
    <td><A href="../../orderstate/?id={$info['id']}" target="_blank" class="diana">更新状态</A></td>
</tr>

<tr>
    <td colspan="7" height="10" bgcolor="#FFFFFF"></td> 
</tr>

EOT;
            
           $ww ++;
        //}
    }    
}

?>

</table>
	
		    <?php require KEFU_PATH . 'tip.php';?>
		</div>
	</div>
</div>
<?php require KEFU_PATH . 'foot.php';?>

<style type="text/css">
a.diana:visited {color: #CCC;}
</style>