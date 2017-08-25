<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,7);
qx($allow_qx, $adminclass);
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
        <div class="filter">
			<div class="cxform2" style="width: 300px;">
				已发货签收情况 <a class="btn" style="margin-top: 8px; margin-left: 12px;" href="yjs.php">改已拒收</a>
				<a class="btn" style="margin-top: 8px; margin-left: 12px;" href="newwuliu/dz.php" target="_blank">对账</a>
				<a class="btn" style="margin-top: 8px; margin-left: 12px;" href="out46.php" target="_blank">跑出签收拒收</a>
			</div>

			<div class="cxform2" style="width: 350px;">
				<form id="search" action="outwait/" target="_blank">
					下单时间：<input ph="开始时间" type="text" id="time1" name="time1" value=""
						size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
						ph="结束时间" type="text" id="time2" name="time2" value="" size="11"
						onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					<button type="submit">导 出</button>
				</form>
			</div>
			<div class="cb"></div>
		</div>
		<div class="uc mtop5">
			<form action="wuliuqs/" method="post" name="form1">
				<table class="items" width="145%" cellpadding="5" border="0"
					bgcolor="#d3d3d3" cellspacing="1">
					<tr bgcolor="#f5f5f5">
						<th width="30px"><input name="box0" id="box0" type="checkbox"></th>
						<th width="82px">下单时间</th>
						<th width="30px">ID</th>
						<th width="180px">订购商品</th>
						<th width="70px">金额</th>
						<th width="50px">购买者</th>
						<th width="90px">手机号</th>
						<th width="90px">微信主</th>
						<th width="60px">物流状态</th>
						<th>物流最新情况</th>
					</tr>
    
<?php
        
        $sql = "select count(*) as num from wx_guest where gueststate = 3 and id in (select guestid from wx_gueststate where wuliustate = 4)";
        $ret = $mysql->find($sql);
        $num = $ret['num'];
        
        $page_size = 200;
        $page_count = ceil($num / $page_size); // 得到页数
        $page = isset($_GET['page'])?intval($_GET['page']):1;
        $page = $page?$page:1;
        $offset = ($page - 1) * $page_size;
        
        $sql = "select gs.wuliustate,gs.newwuliu,g.* from wx_gueststate gs left join wx_guest g on gs.guestid = g.id where gs.wuliustate = 4 and g.gueststate = 3 group by gs.guestid limit $offset,$page_size";
        $infos = $mysql->query($sql);
        
        $shops = get_shops();
        $users = get_users();
        $wuliugses = get_wuliugs();
        $shipstates = get_shipstate();
        
        
        if($infos){
            $xx = 1;
            foreach ($infos as $info){
                foreach($info as $k=>$v){
					if($k=='guestrizhi'){
						continue;
					}
					$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
				}

				
                $id             = $info['id'];
                $shopid         = $info['shopid'];
                $skuid          = $info['skuid'];
                $userid         = $info['userid'];
                $guestname      = $info['guestname'];
                $guesttel       = $info['guesttel'];
                $gueststate     = $info['gueststate'];
                $guestkuanshi   = $info['guestkuanshi'];
                $wuliustate     = $info['wuliustate'];
                $newwuliu       = $info['newwuliu'];
                $addtime        = shorttime($info['addtime']);
                
                $shop           = $shops[$shopid];
                $shopskuid      = "shopsku" . $skuid;
                $shopsku        = $shop[$shopskuid];
                $shopsku        = explode("_", $shopsku);
                $gusettitle     = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" .$shopsku[0] . "&nbsp;&nbsp;" . $guestkuanshi;
                
                $user           = $users[$userid];
                $username       = $user['loginname'];
                $userpercent    = $user['userpercent'] / 100;
                
                $wuliugsname    = $info['wuliugs'];
                $wuliugs        = $wuliugses[$wuliugsname];
                $wuliugscode    = $wuliugs['wuliugscode'];
                
                if ($shop['ischange'] == '1') {
                    $shopsku[2] = $shopsku[2] * $userpercent;
                    $shopsku[2] = round($shopsku[2]);
                }
                
                $shipstate      = $shipstates[$wuliustate];
                $kuaidistate    = $shipstate['kuaidistate'];
                if ($kuaidistate == '已签收') {
                    $kuaidistate = "<font color='#FF0000'>" . $kuaidistate ."</font>";
                } elseif ($kuaidistate == '已拒收') {
                    $kuaidistate = "<font color='#0000FF'>" . $kuaidistate ."</font>";
                }
                
print <<<oo
                <tr>
                	<td><input name="box{$xx}" type="checkbox" value="{$id}"></td>
                	<td>{$addtime}</td>
                	<td><a href="../statcon/index_7.php?id={$id}" target="_blank">{$id}</a></td>
                	<td>{$gusettitle}</td>
                	<td>{$shopsku[1]} / {$shopsku[2]}</td>
                	<td>{$guestname}</td>
                	<td>{$guesttel}</td>
                	<td>{$username}	</td>
                	<td><a href="http://m.kuaidi100.com/index_all.html?type={$wuliugscode}&postid={$info['guestkuaidi']}" target="_blank">{$kuaidistate}</a></td>
                	<td>{$newwuliu}</td>
                </tr>
oo;
                
              $xx++;  
            }
        }
        
?>        

	</table>
				<?php $page_config = array();?>
				<?php require ADMIN_PATH . 'page2.php';?>
                <button id="sub" class="shoporder" type="submit">已签收</button>
			</form>
			
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

<script>
$(function(){
	$("#sub").click(function(){
	    if(confirm('确定执行此操作吗?')){
	    	   document.form1.submit();
		}else{
		    alert('操作取消');
		}
	})
})
</script>