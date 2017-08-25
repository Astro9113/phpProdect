<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,10);
qx($allow_qx, $adminclass);


$shops  = get_shops();

function get_guests($_dhs){
    global $mysql;
    foreach ($_dhs as $dh){
        $dh_s .= "'$dh',";
    }
    $dh_s = rtrim($dh_s,',');
    $sql = "select id,gueststate,guestkuaidi,shopid,skuid from wx_guest where guestkuaidi in ($dh_s)";
    $infos = $mysql->query_assoc($sql, 'guestkuaidi');
    return $infos;
}

function get_orderstate_tmp(){
    global $mysql;
    $o = array();
    $sql = "select id,orderstate from wx_orderstate";
    $ret = $mysql->query($sql);
    foreach ($ret as $row){
        $o[$row['id']] = $row['orderstate'];
    }
    
    return $o;
}

//检查状态  一致返回true,不一致返回原因
function check_state($state,$dh,$price){
    global $orderstate;
    global $mysql;
    global $shops;
    global $_guests;
    
    /*
    $sql = "select * from wx_guest where guestkuaidi = '{$dh}'  limit 1";
    $data = $mysql->find($sql);
    if(!$data){
        return -1;
    }
    */
    
    $dh = trim($dh);
    $price = trim($price);
    
    
    $data = $_guests[$dh];
    if(!$data){
        return -1;
    }
    
    
    $gueststate = $data['gueststate'];//订单中状态
    $GLOBALS['remark'] = "{$data['id']}";//记录订单号
    
    //对比价格
    $shopid = $data['shopid'];
    $skuid = $data['skuid'];
    $shop = $shops[$shopid];
    $skuField = 'shopsku'.$skuid;
    $sku = $shop[$skuField];
    $sku_info = explode('_', $sku);
    $need_price = $sku_info[1];
    
    
    switch ($state){
        case 5:
        case 6:
        default:
            if($state!=$gueststate){
                $ret = "订单状态为<span class='orderstate'>{$orderstate[$gueststate]}</span>,需要的状态为<span class='orderstate'>{$orderstate[$state]}</span>";
            }
            if($price!=$need_price && $state!=6){
                $ret .= "订单价格为<span class='price'>{$need_price}</span>,需要的价格为<span class='price'>{$price}</span>";
            }
            if($ret){
                return $ret;
            }
        break;
    }
    return true;
}

$orderstate = get_orderstate_tmp();

$result_default   = array();//保存正常数据的数组
$result_yc        = array();//保存状态异常数据的数组
$result_notexists = array();//保存匹配不到订单数据的数组

if(isset($_POST['up'])&&isset($_POST['state'])){
    $state = intval($_POST['state']);
    if(!in_array($state, array(5,6))){
        exit('参数错误');
    }
    
    $file = $_FILES['f'];
    
    $dh = file_get_contents($file['tmp_name']);
    
    $dh = trim($dh);
    $dh_arr = explode("\n", $dh);
    
    if(!trim($dh)){
        exit('请输入单号');
    }
     
    foreach ($dh_arr as $dh_price){
        $dh_price = trim($dh_price);
        list($dh,$price) = explode("\t", $dh_price);
        $_dhs[] = $dh;
    }
    

    
    $_guests = get_guests($_dhs);

	
	//echo '<pre>';var_dump($_guests);exit;
	
	
    foreach ($dh_arr as $dh_price){
        $dh_price = trim($dh_price);
        list($dh,$price) = explode("\t", $dh_price);
        
        $remark = '';//全局变量
        
        //检查状态是否匹配  '找不到该单号对应的订单'
        $check_state = check_state($state,$dh,$price);
        if($check_state!==true){
            if($check_state==-1){
                $result_notexists[] = array(
                        'dh'=>$dh,
                        'reason'=>'找不到匹配的单号',
                        'remark'=>'',
                );
            }else{
                $result_yc[] = array(
                        'dh'=>$dh,
                        'reason'=>$check_state,
                        'remark'=>$remark,
                );
            }
        }else{
            $result_default[] = array(
                        'dh'=>$dh,
                        'reason'=>'',
                        'remark'=>$remark,
            );
        }
        
    }
}



?>

<style>
table,td,th{border:1px solid #ccc;}
table{border-collapse:collapse;}
th{background-color:#ccc;}
td{padding:5px 8px;}
span.orderstate{font-weight:700;color:blue;}
</style>

<div id="form">
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="f">
<br />
要检查的状态&nbsp;&nbsp;签收<input type="radio" name="state" value="5" checked="checked">&nbsp;
拒收/退回<input type="radio" name="state" value="6">
<input type="submit" name="up" value="提交数据">
</form>
</div>

<table>
<tr>
    <th>正常数据</th>
    <th>匹配不到的数据</th>
    <th>异常的数据</th>
</tr>
<tr>
    <td valign="top">
<?php 
    if($result_default){
        echo '<form name="form_default" action="dz_do.php" method="post" onsubmit="return check_default();" target="_blank">';
        echo '<input type="submit" name="sub" value="处理正常数据">';
        echo '<input type="hidden" name="type" value="'.$state.'_default">';
        echo '<table width="350px"><tr>
        <th style="vnd.ms-excel.numberformat:@"><input type="checkbox" id="id_default"></th>
        <th style="vnd.ms-excel.numberformat:@">序号</th>
        <th style="vnd.ms-excel.numberformat:@">物流单号</th>
        <th style="vnd.ms-excel.numberformat:@">异常原因</th>
        <th style="vnd.ms-excel.numberformat:@">订单ID</th>
        </tr>';    
        foreach ($result_default as $k=>$v){
            $xu = $k+1;
            echo "<tr>
            <td style='vnd.ms-excel.numberformat:@'><input class='c_default' type='checkbox' name='id[]' value='{$v['remark']}'></td>
            <td style='vnd.ms-excel.numberformat:@'>{$xu}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['dh']}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['reason']}</td>
            <td style='vnd.ms-excel.numberformat:@'><a href='/vuadmin/stat/statcon/?id={$v['remark']}' target='_blank'>{$v['remark']}</a></td>
            </tr>";
        }
        echo '</table>';
        echo '</form>';
    }
?>
    </td>
    <td valign="top">
<?php 
    if($result_notexists){
        echo '<table width="370px"><tr>
        <th style="vnd.ms-excel.numberformat:@">序号</th>
        <th style="vnd.ms-excel.numberformat:@">物流单号</th>
        <th style="vnd.ms-excel.numberformat:@">异常原因</th>
        <th style="vnd.ms-excel.numberformat:@">附加信息</th>
        </tr>';    
        foreach ($result_notexists as $k=>$v){
            $xu = $k+1;
            echo "<tr>
            <td style='vnd.ms-excel.numberformat:@'>{$xu}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['dh']}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['reason']}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['remark']}</td>
            </tr>";
        }
        echo '</table>';
    }
?>    
    </td>
    <td valign="top">
<?php 
    if($result_yc){
        echo '<form name="form_yc" action="dz_do.php" method="post" onsubmit="return check_yc();" target="_blank">';
        echo '<input type="submit" name="sub" value="处理异常数据" style="color:red">';
        echo '<input type="hidden" name="type" value="'.$state.'_yc">';
        echo '<table width="551px"><tr>
        <th style="vnd.ms-excel.numberformat:@"><input type="checkbox" id="id_yc"></th>
        <th style="vnd.ms-excel.numberformat:@">序号</th>
        <th style="vnd.ms-excel.numberformat:@">物流单号</th>
        <th style="vnd.ms-excel.numberformat:@">异常原因</th>
        <th style="vnd.ms-excel.numberformat:@">订单ID</th>
        </tr>';    
        foreach ($result_yc as $k=>$v){
            $xu = $k+1;
            echo "<tr>
            <td style='vnd.ms-excel.numberformat:@'><input class='c_yc' type='checkbox' name='id[]' value='{$v['remark']}'></td>
            <td style='vnd.ms-excel.numberformat:@'>{$xu}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['dh']}</td>
            <td style='vnd.ms-excel.numberformat:@'>{$v['reason']}</td>
            <td style='vnd.ms-excel.numberformat:@'><a href='/vuadmin/stat/statcon/?id={$v['remark']}' target='_blank'>{$v['remark']}</a></td>
            </tr>";
        }
        echo '</table>';
        echo '</form>';
    }
?>    
    </td>
</tr>
</table>




<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script>
$(function(){
	$('#id_default').click(function(){
	    if($('#id_default').is(':checked')){
	       $(".c_default").each(function(){
	    	    $(this).attr('checked',true);
		   }) 
		}else{
			 $(".c_default").each(function(){
		    	    $(this).attr('checked',false);
			 }) 
		}
	});

	$('#id_yc').click(function(){
	    if($('#id_yc').is(':checked')){
	       $(".c_yc").each(function(){
	    	    $(this).attr('checked',true);
		   }) 
		}else{
			 $(".c_yc").each(function(){
		    	    $(this).attr('checked',false);
			 }) 
		}
	});
});



<?php 
    if($state){
        if($state==5){
            $msg = " <<回款>> ";
        }else{
           $msg = " <<退回>> "; 
        }
    }
?>


function check_default(){
	return confirm('<?php echo $msg;?>正常,请确认操作');
}

function check_yc(){
	return confirm('<?php echo $msg;?>异常,请确认操作');
}

</script>