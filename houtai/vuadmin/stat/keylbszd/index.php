<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,5);
qx($allow_qx, $adminclass);
?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
        <?php require ADMIN_PATH . 'menu.php';?>
        <div id="main" class="clearfix">

		<h2>
			重点用户 联不上_追单情况&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn"
				style="margin-bottom: 5px;" href="../">返回订单列表</a>
		</h2>
		<div class="uc">
			<table class="items" width="100%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="160">重点用户</th>
					<th>联不上(总共)</th>
					<th width="120">追单(总共)</th>
					<th width="120">已结算(一个月)</th>
					<th width="120">已拒收(一个月)</th>
				</tr>

<?php
        $time3 = date('Y-m-d', time() - 30 * 24 * 60 * 60) . ' 00:00:00';
        $time4 = date('Y-m-d') . ' 23:59:59';
        
        $sql = "select * from wx_user where isimportant='1' order by id desc";
        $infos = $mysql->query($sql);

        $table = 'wx_guest';
        foreach ($infos as $info){
            $userid = $info['id'];
            
            $num1 = $mysql->count_table($table,"userid = '{$userid}' and gueststate='11'");
            $num2 = $mysql->count_table($table,"addtime>='$time3' and addtime<='$time4' and userid = '{$userid}' and gueststate='5'");
            $num3 = $mysql->count_table($table,"addtime>='$time3' and addtime<='$time4' and userid = '{$userid}' and gueststate='6'");
            $sql = "select count(*) as kfgd_num from wx_guest g left join wx_gueststate gs on g.id = gs.guestid where g.userid = '{$userid}' and gs.wuliustate not in (2,4,5)";
            $ret = $mysql->find($sql);
            $num4 = $ret['kfgd_num'];
            
print <<<oo
	           <tr>
					<td>{$info['loginname']}</td>
					<td>{$num1}</td>
					<td>{$num4}</td>
					<td>{$num2}</td>
					<td>{$num3}</td>
				</tr>
oo;

        }
?>

            </table>
        </div>
    </div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>
			
