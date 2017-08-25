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
    $kfid =  isset($_GET['kfid'])?intval($_GET['kfid']):0;
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
<select name="kfid">
<option value="0">客服查询</option>
<?php

$kefus = get_kefus();
foreach ($kefus as $kefu){
    $sel = "";
    if ($kfid == $kefu['id']) {
        $sel = " selected='selected'";
    }
    echo "<option value='{$kefu ['id']}' {$sel}>{$kefu['adminname']}</option>" .PHP_EOL;
}
?>
</select>

					<button>查 询</button>
				</form>
			</div>


			<div class="cb"></div>
		</div>


<?php

if ($time1 && $time2 && $kfid) {
    $xun = array(
            5,
    );
    $shops = get_shops();
    $orderstates = get_orderstates();
    
    foreach ($xun as $i => $aa) {
        $time1=$_GET['time1'];
        $phptime=strtotime($time1);
        $time3=date('Y-m-d H:i:s',$phptime);
        $time2=$_GET['time2'];
        $phptime2=strtotime($time2);
        $time4=date('Y-m-d H:i:s',$phptime2);
        
        
        $orderstate = orderstateinfo($aa);
        $gustart = $orderstate['orderstate'];

        
        $w = "guestkfid = $kfid and gueststate = $aa and addtime < '$time4'";
        $total = $mysql->count_table('wx_guest',$w);
        $size  = 10000;
        $page = ceil($total/$size);
        
        $midzfc=0;
        $bs=0;

        for($i=1;$i<=$page;$i++){
            $offset = ($i-1)*$size;
            $sql = "select id,guestrizhi,shopid,skuid from wx_guest where guestkfid = $kfid and gueststate='$aa' limit $offset,$size";
            $infos = $mysql->query($sql);
            
            foreach ($infos as $info){
                $gurizhi=$info['guestrizhi'];
                $youfh="， ".$gustart;
                if(strpos($gurizhi,$youfh)!==false){
                    $bb = explode($youfh,$gurizhi);
                    $cc = substr($bb[0],-19);
                    if($cc > $time3 and $cc < $time4){
                        $miduserfc = 0;
                        $shopid=$info['shopid'];
                        $skuid=$info['skuid'];
                        //echo $info['id']."&nbsp;&nbsp;";
                        //flush();
            
                        $shop = $shops[$shopid];
                        $shopskuid="shopsku".$skuid;
                        $shopsku=$shop[$shopskuid];
                        $shopsku=explode("_",$shopsku);
                        $miduserfc = $shopsku[1];
                        //echo $miduserfc."<br/>";
                        //flush();
                        $midzfc +=$miduserfc;
                        $bs ++;
                    }
                }
            }    
        }
        
        echo "状态 :{$gustart},数量：<d class='nowstat'>".$bs."</d>&nbsp;&nbsp;&nbsp; 流水：<d class='nowstat'>".$midzfc."</d><br />";
        
        flush();
    }
	?>
    
<?php
//算核单签收率



function tnum_tmp($aa,$i){
    global $mysql;
	global $time3;
	global $time4;
	global $kfid;

    $num = $mysql->count_table('wx_guest',"addtime>='$time3' and addtime<='$time4' and gueststate IN($aa) and guestkfid = '$kfid'");
    return $num;
}

    $num = $mysql->count_table('wx_guest',"addtime>='$time3' and addtime<='$time4' and guestkfid = '$kfid'");
    
    ?>

<div class="mtop12 waitstat">
			<d class="nowstatz hongse"><?php echo $time3.'--'.$time4;?><br/></d>
			订单总数：
			<d class="nowstat"><?php echo $num;?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=2&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">确认中</a>：
			<d class="nowstat"><?php echo tnum_tmp('2',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=11&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">联不上</a>：
			<d class="nowstat"><?php echo tnum_tmp('11',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=10&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">假单</a>：
			<d class="nowstat"><?php echo tnum_tmp('10',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=9&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">待发货</a>：
			<d class="nowstat"><?php echo $df = tnum_tmp('9',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=3&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已发货</a>：
			<d class="nowstat"><?php echo $fh = tnum_tmp('3',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=4&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已签收</a>：
			<d class="nowstat"><?php echo $qs = tnum_tmp('4',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=5&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已结算</a>：
			<d class="nowstat"><?php echo $js = tnum_tmp('5',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=6&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">拒收</a>：
			<d class="nowstat"><?php echo $jus = tnum_tmp('6',$i);?></d>
			<a
				href="<?php echo $file;?>?gueststate_s=8&time1=<?php echo $zuotian;?>&time2=<?php echo $jintian;?>">已取消</a>：
			<d class="nowstat"><?php echo tnum_tmp('8',$i);?></d>
			<a href="#">签收率</a>：
			<d class="nowstat">
<?php
    $aa = $qs + $js;
    $bb = $qs + $js + $fh + $jus;
    $ret_q = $bb==0?0:(number_format($aa / $bb, 4) * 100 .'%');
    echo $ret_q;
    ?>
</d>
			<a href="#">核单率</a>：
			<d class="nowstat">
<?php
    $bb = $qs + $js + $fh + $jus + $df;
    $ret_h= $bb==0?0:(number_format(($bb / $num) * 100, 2). '%');
    echo $ret_h;
    ?>
</d>
		</div>

		<hr style="margin-top: 12px;">

<?php

//算核单签收率
  echo '结算单数，结算额度 '.$bs.'--'.$midzfc.'<br/>';
  echo '签收率，核单率 '.$ret_q.'--'.$ret_h.'<br/>';
  
  echo '<br/><br/>';
 $suan_zong = $bs/$ret_q*100;
   echo round($suan_zong,2);
  echo '<br/><br/>';
  
  $gongzi5 = $suan_zong*0.5/$bs*$midzfc*0.005;
  echo round($gongzi5,2);
    echo '<br/>';
	$gongzi7 = $suan_zong*0.2/$bs*$midzfc*0.008;
	 echo round($gongzi7,2);
    echo '<br/>';
    $gongzi8 = $suan_zong*($ret_q-70)/100/$bs*$midzfc*0.01;
	echo round($gongzi8,2);
    echo '<br/><br/>';
	
	$gong_zong = $gongzi5+$gongzi7+$gongzi8;
	echo round($gong_zong,2);
}    
?>

   
</div>
</div>
<?php require CAIWU_PATH . 'foot.php';?>
<style type="text/css">
.middtj {margin: 30px 10px;}
</style>