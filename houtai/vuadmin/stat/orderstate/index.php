<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);

$id = intval($_GET['id']);
$info = guestinfo($id);
if (! $info) {
    alert('订单信息不存在');
    goback();
}

foreach($info as $k=>$v){
	if($k=='guestrizhi'){
		continue;
	}
	$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
}


$skus = shopskus($info['shopid']);
$gueststate = $info['gueststate'];
$orderstate = orderstateinfo($gueststate);
$sql = "select * from wx_orderstate where id in ({$orderstate['fenji']})";
$orderstate_show = @$mysql->query_assoc($sql,'id');
$wuliugs = get_wuliugs();



$shopid     = $info['shopid'];
$skuid      = $info['skuid'];
$userid     = $info['userid'];
$guestkuanshi   = $info['guestkuanshi'];
$shop           = shopinfo($shopid);
$shopsku        = shopsku($shop, $skuid);
$gusettitle = $shop['shopname2'] . "&nbsp;&nbsp;&nbsp;" . $shopsku[0] .
"&nbsp;&nbsp;" . $guestkuanshi;

?>


<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	<div id="main" class="clearfix">
        <h2>订单详情</h2>
		<div class="uc">
			<div class="comform">
				<form name="form1" method="post" action="orderstatepd/">
				<input name="id" type="hidden" value="<?php echo $id;?>">
							
					<table cellpadding="12" cellspacing="0" border="0" class="table-form">
                        <tr>
							<th width="80">订单信息</th>
							<td>订单ID：<?php echo $id;?>， 下单时间：<?php echo $info['addtime'];?>，购买者：<?php echo $info['guestname'];?>，地址：<?php echo $info['guestsheng'].$info['guestcity'].$info['guestqu'];?></td>
						</tr>
						
						<tr>
							<th>购买商品</th>
							<td><?php echo $gusettitle; ?>， <?php echo $shopsku[1]; ?>.00 元 &nbsp;&nbsp;&nbsp;提成：<?php echo $shopsku[2]; ?>.00 元  </td>
						</tr>

						<tr>
							<th>商品SKU</th>
							<td>
							 <select name="shopsku">
							     <?php echo_option($skus, $info['skuid'], 'id', 'name');?>
                             </select> 
                        </tr>
						<tr>
							<th>订单状态</th>
							<td>
							<select name="orderstate" id="orderstate">
							<?php echo_option($orderstate_show, $orderstate['orderstate'], 'orderstate', 'orderstate');?>
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

						<tr>
							<th>发货状态</th>
							<td>
							         物流公司： <select name='wuliugs'>
									<option value='' selected>选择快递公司</option>
									<?php echo_option($wuliugs, $info['wuliugs'], 'wuliugsname', 'wuliugsname');?>
                                </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    快递号：<input name='kuaidihao' type='text' value="<?php echo $info['guestkuaidi'];?>" style='height: 10px; width: 180px; margin-right: 100px;' />

							</td>
						</tr>
						
						<th valign="top">订单日志</th>
						<td>
                            <?php echo $info['addtime'];?>， 下单成功 客服确认中<br>
                            <?php echo guestrizhi($info['guestrizhi']);?>    
						</td>
						<tr>
						</tr>
						<tr>
							<th>备注信息</th>
							<td><input name="guestrem" type="text" value="<?php echo $info['guestrem']?>"></td>
						</tr>
	
	
                        <?php
                        $kefu = get_kefus();
                        $kfid = $info['guestkfid'];
                        $dis = $info['userid']!=1?' style="display:none;"':'';
                        ?>
                        
                        
                        <tr<?php echo $dis?>>
                                <th>客服</th>
                        		<td>
                                    <select name="kfid">
                                    <?php echo_option($kefu, $kfid, 'id', 'adminname');?>
                                    </select>
                                </td>
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
            
		</div>
	</div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>

<script>
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
