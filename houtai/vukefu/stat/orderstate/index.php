<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/kefulimit.php";

require KEFU_PATH . 'head.php';

$id = intval($_GET['id']);
$sql = "select * from wx_guest where id = '{$id}' and guestkfid = '{$loginid}'";
$info = $mysql->find($sql);

// 这样客服端口 组长也看不了组员的订单详情
if (! $info) {
    alert('订单信息不存在');
    goback();
}


//黑名单信息
$blacklist = $mysql->query_assoc('select * from wx_blacklist where 1', 'tel');


foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
		//$info[$k] = guestrizhi($v);
	}else{
		$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
	}
}


$gueststate = intval($info['gueststate']);

/*
$oos = array(4,6,7);
if (in_array($gueststate, $oos)) {
    exit("<script>alert('不在修改权限内！'); javascript:history.go(-1);</script>");
}
*/

$shopid     = $info['shopid'];
$skuid      = $info['skuid'];
$userid     = $info['userid'];

$guestname  = $info['guestname'];
$guestkuanshi   = $info['guestkuanshi'];
$guesttel = guesttel_kefu($info['guesttel'],$gueststate);
$dizhi  = $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$info['guestdizhi'];
$guestrizhi = guestrizhi($info['guestrizhi']);
$guestrem = $info['guestrem'];
$guestage = $info['guestage'];
$guestsex = $info['guestsex'];
$guestkuaidi = $info['guestkuaidi'];

$shop           = shopinfo($shopid);
$shopsku        = shopsku($shop, $skuid);
$gusettitle = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] .
"&nbsp;&nbsp;" . $guestkuanshi;
$skus = shopskus($info['shopid']);


$user  = userinfo($userid);
$username = $user['loginname'];
$alipay = $user['alipay'];
$alipayname = $user['alipayname'];


?>

<div id="wrap" class="clearfix">
    <?php require KEFU_PATH . 'menu.php';?>
    <div id="main" class="clearfix">
		<h2>
			订单详情 &nbsp;&nbsp;&nbsp; <a class="btn" style="margin-bottom: 3px;"
				href="/vukefu/stat/queren/">返回订单列表</a>
		</h2>

		<div class="uc">
			<div class="comform">
				<form name="form1" method="post" action="orderstatepd/">
				<input name="id" type="hidden" value="<?php echo $id;?>">
				
					<table cellpadding="12" cellspacing="0" border="0"
						class="table-form">
                        <?php
    					if(array_key_exists(trim($info['guesttel']),$blacklist)){
    						echo '<tr style="background-color:#b7785d !important;">
    						<th width="80">提醒</th>
    						<td>电话:'.$info['guesttel'].'在黑名单内,原因:'.$blacklist[trim($info['guesttel'])]['remark'].'</td>
    						</tr>';
    					}
    					?>
    					<?php
    					$jushou = $redis->hGet('jushoushouji',trim($info['guesttel']));
    					if($jushou){
    						echo '<tr style="background-color:#b7785d !important;">
    						<th width="80">提醒</th>
    						<td>电话:'.$info['guesttel'].'有<span style="color:blue">'.$jushou.'</span>单拒收,注意核实是否恶意下单 . </td>
    						</tr>';
    					}
    					?>
                        <tr>
							<th width="80">订单信息</th>
							<td>订单ID：<?php echo $id;?>， 下单时间：<?php echo $info['addtime'];?></td>
						</tr>
						<tr>
							<th>购买商品</th>
							<td><?php echo $gusettitle; ?>， <?php echo $shopsku[1]; ?>.00 元</td>
						</tr>
                        <tr>
							<th>商品SKU</th>
							<td>
							 <select name="shopsku">
							     <?php echo_option($skus, $info['skuid'], 'id', 'name');?>
                             </select> 
                        </tr>
						<tr>
						  <th width="80">收货信息</th>
    						<td>
    						  收货人：<?php echo $guestname;?>，
    						  联系方式：<?php echo $guesttel;?>
    		                 <br>
                                                                            收货地址：<?php echo $dizhi;?>
                            </td>
					   </tr>

<tr>
<th>订单状态</th>

<td>
<!-- 订单状态 -->							
<select name="orderstate" id="orderstate">
<?php
//此处显示 订单状态 + 允许修改的状态
$allow  = array(
    2  => array(9,11,8,12,10),
    8  => array(10,11,12),
    10 => array(11,12),
    11 => array(9,8,12,10),
    12 => array(10,11),
	9  => array(11),  
);

if(array_key_exists($gueststate, $allow)){
    $orderstates_arr = array($gueststate);
    $orderstates_arr = array_merge($orderstates_arr,$allow[$gueststate]);
}else{
    $orderstates_arr = array($gueststate);
}

$orderstates_str = join(',', $orderstates_arr);
$sql = "select * from wx_orderstate where id in ({$orderstates_str}) order by find_in_set(id,'$orderstates_str')";
$states = $mysql->query_assoc($sql, 'id');


foreach ($states as $state_id=>$state){
    $sel = '';
    $statename = $state['orderstate'];
    if($state_id == $gueststate){
        $sel = ' selected="selected" ';
    }
    echo "<option value='{$statename}'{$sel}>{$statename}</option>"; 
}

?>
</select> 
        
<!-- 连不上的状态 -->        
<select id="no_connect_state" name="no_connect_state" style="display: none;" disabled="disabled">
        <option value="">请选择</option>
        <?php
        // 先检查关联表是否已经有值 有设置标志传递至下一页 直接更新
        // 否则插入新数据
        $sql = "select * from wx_lbsguest where guestid = " . $id;
        $lbs = $mysql->find($sql);
        if ($lbs) {
            $lbs_id = $lbs['id'];
        } else {
            $lbs = array();
            $lbs_id = 0;
        }
        
        $lbs_states = get_lbsstates();
        foreach ($lbs_states as $lbs_state){
            $sel = '';
            if ($lbs_state['id'] == $lbs['stateid']) {
                $sel = 'selected="selected"';
            }
            echo '<option value="' . $lbs_state['id'] . '" ' . $sel . '>' . $lbs_state['name'] .'</option>';
        }
        ?>
</select>

        <?php
        	//下一个页面根据此字段值判断是插入还是更新 
        	if($lbs_id){
        		echo '<input type="hidden" name="lbs_id" value="'.$lbs_id.'">';
        	}else{
        		echo '<input type="hidden" name="lbs_id" value="0">';	
        	}
        	
        	
        ?>

</td>
</tr>


						

						<tr></tr>
						
						<tr>
							<th>发货状态</th>
							<td>
							物流公司： 
							<select name='wuliugs'>
									<option value='' selected>选择快递公司</option>
                                    <?php
                                    $wuliugses = get_wuliugs();
                                    foreach ($wuliugses as $wuliugs){
                                        $sel = '';
                                        if ($wuliugs['wuliugsname'] == $info['wuliugs']) {
                                            $sel = 'selected="selected"';
                                        }
                                    
                                        echo '<option value="' . $wuliugs['id'] . '" ' . $sel . '>' . $wuliugs['wuliugsname'] .'</option>';
                                    }
                                    ?>

                            </select> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;快递号：
                            <input name='kuaidihao' type='text' value="<?php echo $guestkuaidi;?>" style='height: 10px; width: 180px; margin-right: 100px;' />

							</td>
						</tr>
						
						<th valign="top">订单日志</th>
						<td>
                        <?php echo $info['addtime'];?>， 下单成功 客服确认中<br>
                        <?php echo $guestrizhi;?>
    					</td>
						
						<tr></tr>
						
						<tr>
							<th>备注信息</th>
							<td><input name="guestrem" type="text" value="<?php echo $guestrem;?>"></td>
						</tr>
						
						<tr class="last">
							<th>&nbsp;</th>
							<td><br />
								<button class="mid" type="submit" onClick="return wuliu()">确认提交</button>
							</td>
						</tr>

					</table>
				</form>
			</div>
			<?php require KEFU_PATH . 'tip2.php';?>
		</div>
	</div>
</div>

<?php require KEFU_PATH . 'foot.php';?>

<script type="text/javascript">
$(document).ready(function(){
    //订单为联系不上状态时 显示联系不上下面的子选项
	var v = $('#orderstate').val();
	if(v=='联不上'){
		$('#no_connect_state').show();
		$('#no_connect_state').attr('disabled',false);
	}

    $('#orderstate').change(function(){
        var this_cur_val = $('#orderstate').val();
        if(this_cur_val=='联不上'){
            $('#no_connect_state').show();
            $('#no_connect_state').attr('disabled',false);
        }else{
            $('#no_connect_state').hide();
            $('#no_connect_state').attr('disabled',true);
        }
    });
});

/*   选联不上 改备注   */
$(function(){
    $('#no_connect_state').change(function(){
        $("input[name='guestrem']").val($(this).find('option:selected').text());
	})
});
  
</script>

<script language="javascript" type="text/javascript">
function wuliu(){
	if(form1.orderstate.value=="确认中"){
		alert("请选择状态!!!");
		form1.orderstate.focus();
		return false;
	    }
	
    if(form1.orderstate.value=="已发货"){
    	if(form1.wuliugs.value==""){
    		alert("请选择物流公司!!!");
    		form1.wuliugs.focus();
    		return false;
    	}
    	if(form1.kuaidihao.value==""){
    		alert("物流单号不可为空，请填写!!!");
    		form1.kuaidihao.focus();
    		return false;
    	}
    }
    if(form1.orderstate.value=="联不上"){
    	if(form1.no_connect_state.value==""){
    		alert("请选择联不上状态!!!");
    		form1.no_connect_state.focus();
    		return false;
    	}
    }
}
</script>
