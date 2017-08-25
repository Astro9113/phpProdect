<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/cwlimit.php";
?>

<?php require CAIWU_PATH . 'head.php';?>

<div id="wrap" class="clearfix">
    <?php require CAIWU_PATH . 'menu.php';?>

	<div id="main" class="clearfix">
		<div class="filter">
			<div class="cxform gluser">
				<b>媒介订单流水</b>
			</div>
			<div class="cb"></div>
		</div>
		
    <?php
    $time1 = isset($_GET['time1'])?$_GET['time1']:'';
    $phptime = strtotime($time1);
    $time3 = date('Y-m-d H:i:s', $phptime);
    $time2 = isset($_GET['time2'])?$_GET['time2']:'';
    $phptime2 = strtotime($time2);
    $time4 = date('Y-m-d H:i:s', $phptime2);
    $mid = isset($_GET['mid'])?intval($_GET['mid']):0;
    ?>

        <div class="tjindex filter">

			<div class="cxform2 mtop12" style="width: 800px;">
				<br>

				<form id="search" action="">
					查询时间：
					<input ph="开始时间" type="text" id="time1" name="time1" value="<?php echo $time1;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" /> 
					- 
					<input ph="结束时间" type="text" id="time2" name="time2" value="<?php echo $time2;?>" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" /> 
					 
					 &nbsp;&nbsp; 媒介：
<select name="mid">
<option value="0">媒介订单查询</option>
<?php
$midusers = get_midusers();
foreach ($midusers as $miduser){
    $sel = "";
    if ($mid == $miduser['id']) {
        $sel = " selected='selected'";
    }
    echo "<option value='{$miduser ['id']}' {$sel}>{$miduser['username']}</option>" .PHP_EOL;
}
?>
</select>

					<button>查 询</button>
				</form>
			</div>


			<div class="cb"></div>
		</div>


<?php

if ($time1 && $time2 && $mid) {
    
    $xun = array(
            9,
            3,
            4,
            5,
            2,
            8,
            10,
            6,
            7,
            11,
            12,
            13
    );
    
    $orderstates = get_orderstates();
    
    foreach ($xun as $i => $class) {
        $orderstate = $orderstates[$class];
        $state_name = $orderstate['orderstate'];
        echo "<div class='middtj'> " . $state_name .
                 "：<iframe id='frame" .
                 $i . "' width='300px' height='80px' src='jisuan.php?time1=" .
                 $time1 . "&time2=" . $time2 . "&aa=" . $class . "&mid=" . $mid . "'></iframe>
              </div>";
        
        echo "<script>
            function getTextNode" . $i . "(){
                var x = document.getElementById('frame" . $i . "').contentWindow.document
                x.body.scrollTop= x.body.offsetHeight;
            }
            setInterval(getTextNode" . $i . ",50);
            </script>";
    }
    
    ?>

    <?php

    $topid = "m" . $mid;
    $sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
    $uids = $mysql->query($sql);
    

    foreach ($uids as $uid){
        $uid_arr[] = $uid['id'];
    }
    
    $userzhuid = implode(',', $uid_arr);
    
    $sql = "select g.shopid,g.skuid,s.shopsku1,s.shopsku2,s.shopsku3,s.shopsku4,s.shopsku5,s.shopsku6 from wx_guest g left join wx_shop s on g.shopid = s.id where g.userid IN($userzhuid) and g.addtime>='$time3' and g.addtime<='$time4' order by g.id";
    
    $infos = $mysql->query($sql);
    $num = $mysql->numRows;
    $midzfc = 0;
    foreach ($infos as $info){
        $miduserfc = null;
        $shopid = $info['shopid'];
        $skuid = $info['skuid'];
        $shopskuid = "shopsku" . $skuid;
        $shopsku = $info[$shopskuid];
        $shopsku = explode("_", $shopsku);
        $miduserfc = $shopsku[1];
        $midzfc += $miduserfc;
    }
    
    ?>
        <div class="middtj">
			总数：
			<d class="nowstat"><?php echo $num;?></d>
			&nbsp;&nbsp;&nbsp; 流水：
			<d class="nowstat"><?php echo $midzfc;?></d>
			（以上为更改状态时间，此条为下单时间）
		</div>

<?php 
}
?> 
</div>
</div>
<?php require CAIWU_PATH . 'foot.php';?>

<style type="text/css">
.middtj {
	margin: 30px 10px;
}
</style>
