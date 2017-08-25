<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";
?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
    <?php require MID_PATH.'menu.php';?>

<div id="main" class="clearfix">
 <div class="filter">
  <div class="cxform gluser"><b>商品统计</b>
  </div>
<div class="cb"></div>
 </div>
 
 
 <div class="tjindex filter">

 <div class="cxform2 mtop12" style="width:500px;"><br>

<form id="search" action="shop/">
查询时间：<input ph="开始时间" type="text" id="time1" name="time1" value="" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input ph="结束时间" type="text" id="time2" name="time2" value="" size="11" onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />　
<button>查 询</button>
</form>
</div>

<div class="cb"></div>
 </div><br><br>
<?php 

$zuotian=date("Y-m-d",time()-24*60*60); 
$yizhou=date("Y-m-d",time()-6*24*60*60); 
$jintian=date('Y-m-d');?>

 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="shop/?time1=<?php echo $jintian;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">今天查询</a>
 
 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="shop/?time1=<?php echo $zuotian;?> 00:00:00&time2=<?php echo $zuotian;?> 23:59:59">昨天查询</a>
 
 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="shop/?time1=<?php echo $yizhou;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">一周查询</a>
 

  <div class="filter mtop50">
  <div class="cxform gluser"><b>用户统计</b>
  </div>
<div class="cb"></div>
 </div>
  <div class="tjindex filter">

 <div class="cxform2 mtop12" style="width:500px;"><br>

<form id="search" action="user/">
查询时间：<input ph="开始时间" type="text" id="time3" name="time1" value="" size="11" onClick="ShowCalendar2(this, ' 00:00:00')" />-<input ph="结束时间" type="text" id="time4" name="time2" value="" size="11" onClick="ShowCalendar2(this, ' 23:59:59')" />　
<button>查 询</button>
</form>
</div>

<div class="cb"></div>
 </div><br><br>

 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="user/?time1=<?php echo $jintian;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">今天查询</a>
 
 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="user/?time1=<?php echo $zuotian;?> 00:00:00&time2=<?php echo $zuotian;?> 23:59:59">昨天查询</a>
 
 <a class="btn" style="margin-bottom:5px; margin-right:22px;"  href="user/?time1=<?php echo $yizhou;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">一周查询</a>
<br>
<br>
<br>
<br>

 
</div>
</div>
<?php require MID_PATH.'foot.php';?>