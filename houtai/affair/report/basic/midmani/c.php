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
            3,
            5,
            6,
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
        $topid = "m".$mid;

        $sql = "select id from wx_user where topuser='$topid' or dinguser='$topid'";
        $uids = $mysql->query($sql);
        foreach ($uids as $uid){
            $uid_arr[] = $uid['id'];
        }
        $userzhuid = implode(',',$uid_arr);
        $orderstate = orderstateinfo($aa);
        $gustart = $orderstate['orderstate'];

        
        $w = "userid IN($userzhuid) and gueststate = $aa and addtime < '$time4'";
        $total = $mysql->count_table('wx_guest',$w);
        $size  = 10000;
        $page = ceil($total/$size);
        
        $midzfc=0;
        $bs=0;


        for($i=1;$i<=$page;$i++){
            $offset = ($i-1)*$size;
            $sql = "select id,guestrizhi,shopid,skuid from wx_guest where userid IN($userzhuid) and gueststate='$aa' limit $offset,$size";
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
                        echo $info['id']."&nbsp;&nbsp;";
                        flush();
            
                        $shop = $shops[$shopid];
                        $shopskuid="shopsku".$skuid;
                        $shopsku=$shop[$shopskuid];
                        $shopsku=explode("_",$shopsku);
                        $miduserfc = $shopsku[1];
                        echo $miduserfc."<br/>";
                        flush();
                        $midzfc +=$miduserfc;
                        $bs++;
                    }
                }
            }    
        }
        
        echo "数量：<d class='nowstat'>".$bs."</d>&nbsp;&nbsp;&nbsp; 流水：<d class='nowstat'>".$midzfc."</d>";
        flush();
    }
}    
?>

   
</div>
</div>
<?php require CAIWU_PATH . 'foot.php';?>
<style type="text/css">
.middtj {margin: 30px 10px;}
</style>