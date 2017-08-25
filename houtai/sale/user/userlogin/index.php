<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

$zuotian = date("Y-m-d", time() - 24 * 60 * 60);
$yizhou = date("Y-m-d", time() - 6 * 24 * 60 * 60);
$jintian = date('Y-m-d');

?>


<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	<div id="main" class="clearfix">
		<h2>用户登陆 详细统计</h2>
		<div class="tjindex filter">

			<div class="cxform2 mtop12" style="width: 350px;">
				<form id="search" action="loginwith/">
					查询时间：<input ph="开始时间" type="text" id="time1" name="time1" value=""
						size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
						ph="结束时间" type="text" id="time2" name="time2" value="" size="11"
						onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					<button>查 询</button>
				</form>
			</div>
			<div class="cxform2 mtop20" style="width: 400px;">
                <a class="btn" style="margin-bottom: 5px; margin-right: 18px;"
					href="loginwith/?time1=<?php echo $jintian;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">今天查询</a>

				<a class="btn" style="margin-bottom: 5px; margin-right: 18px;"
					href="loginwith/?time1=<?php echo $zuotian;?> 00:00:00&time2=<?php echo $zuotian;?> 23:59:59">昨天查询</a>

				<a class="btn" style="margin-bottom: 5px; margin-right: 18px;"
					href="loginwith/?time1=<?php echo $yizhou;?> 00:00:00&time2=<?php echo $jintian;?> 23:59:59">一周查询</a>
			</div>
			<div class="cb"></div>
		</div>
		<br>
		<br>

		<h2>用户登陆 普通统计</h2>
		<a class="btn mtop12 mleft6" href="/sale/user/">返回用户列表</a>
		<div class="uc userlist mtop12">
			<table width="65%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="180">登陆时间</th>
					<th width="130">用户ID</th>
					<th width="180">用户名</th>
				</tr>
    
<?php
    $topid = $loginid;
    $topid = "m" . $topid;
    $sql = "select * from wx_user where topuser='$topid' or dinguser='$topid'";
    $users = $mysql->query_assoc($sql,'id');
    $num = $mysql->numRows;
    if ($num) {
        $uids = array_keys($users);
        $uids = join(',', $uids);
    } else {
        $uids = '0';
    }

    $sql = $mysql->query("select * from wx_userlogin where userid IN($uids)");
    $num = $mysql->numRows;
    
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $offset = ($page - 1) * $page_size;
    $sql = "select * from wx_userlogin where userid IN($uids) order by id desc limit $offset,$page_size";
    
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
    ?>
     <tr>
        <td><?php echo date("m-d H:i:s",strtotime($info['logintime']));?></td>
        <td><?php echo $info['userid']; ?></td>
        <td><?php echo htmlentities($info['username']); ?></td>
    </tr>
    
    <?php 
            
        }
    }
    
    ?>
    
   
	</table>
			<?php 
			     $page_config = array();
			?>
			<?php require MID_PATH.'page2.php';?>
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>