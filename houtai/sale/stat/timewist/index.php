<?php
set_time_limit(0);
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";
$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$time2 = isset($_GET['time2'])?$_GET['time2']:'';

?>


<?php require MID_PATH.'head.php';?>
	<div id="wrap" class="clearfix">
		<?php require MID_PATH.'menu.php';?>
		<div id="main" class="clearfix">
			<div class="filter">
				<div class="cxform gluser">
					<b>订单流水</b>
				</div>
				<div class="cb"></div>
			</div>

			<div class="tjindex filter">
				<div class="cxform2 mtop12" style="width: 500px;">
					<br>

                    <form id="search" action="">
						查询时间：<input ph="开始时间" type="text" id="time1" name="time1" value="<?php echo $time1;?>"
							size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
							ph="结束时间" type="text" id="time2" name="time2" value="<?php echo $time2;?>" size="11"
							onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
						<button>查 询</button>
					</form>
				</div>

				<div class="cb"></div>
			</div>
			<br>
 <?php
if ($time1 && $time2) {
    $xun = array(
            9,
            3,
            4,
            5
    );
    
    $orderstates = get_orderstates();
    foreach ($xun as $i => $class) {
        $orderstate = $orderstates[$class];
        $orderstate = $orderstate['orderstate'];
        
print <<<oo
<script>
function getTextNode{$i}(){
    var x = document.getElementById('frame{$i}').contentWindow.document
    x.body.scrollTop= x.body.offsetHeight;
}
setInterval(getTextNode{$i},50);
</script>
        
<div class='middtj'>{$orderstate}
<iframe id='frame{$i}' width='300px' height='120px' src='jisuan.php?time1={$time1}&time2={$time2}&aa={$class}'></iframe>
</div>
oo;
 }
  
} 
?>

</div>
	</div>

<?php require MID_PATH.'foot.php';?>
<style>.middtj {margin: 20px 10px;}</style>