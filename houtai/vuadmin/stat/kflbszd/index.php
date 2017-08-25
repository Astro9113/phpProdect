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
				客服 联不上_追单情况&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn"
					style="margin-bottom: 5px;" href="../">返回订单列表</a>
			</h2>
			
			<div class="uc">
				<table class="items" width="100%" cellpadding="5" border="0"
					bgcolor="#d3d3d3" cellspacing="1">
					<tr bgcolor="#f5f5f5">
						<th width="100">客服</th>
						<th>联不上(总共)</th>
						<th width="120">联不上(剩余)</th>
						<th>追单(总共)</th>
						<th width="120">追单(剩余)</th>
						<th>已结算(一个月)</th>
						<th>已拒收(一个月)</th>
					</tr>

<?php
        
        $time3 = date('Y-m-d', time() - 30 * 24 * 60 * 60) . ' 00:00:00';
        $time4 = date('Y-m-d') . ' 23:59:59';
        
        $sql = "select * from wx_kefu order by id desc";
        $infos = $mysql->query($sql);
        
        foreach ($infos as $info){
            $kefid = $info['id'];
            $sql  = "select id,guestrizhi from wx_guest where guestkfid = '{$kefid}' and gueststate='11'";
            $rows = $mysql->query($sql);
            $num1 = $mysql->numRows;
            $sy_num1 = 0;
            
            foreach ($rows as $row){
                $aa = $row['guestrizhi'];
                $youfh = "<br/>";
                
                $bb = explode($youfh, $aa);
                $js = count($bb) - 2;
                $cc = substr($bb[$js], 0, 10);
                $dd = date("Y-m-d");
                if ($cc != $dd) {
                    $sy_num1 ++;
                }
            }
            
            
            $num_5 = $mysql->count_table('wx_guest',"addtime>='$time3' and addtime<='$time4' and guestkfid = '{$kefid}' and gueststate='5'");
            $num_6 = $mysql->count_table('wx_guest',"addtime>='$time3' and addtime<='$time4' and guestkfid = '{$kefid}' and gueststate='6'");
            
            
            
            $sql2 = "select g.id,g.guestrizhi from wx_guest g left join wx_gueststate gs on g.id = gs.guestid where g.guestkfid = '{$kefid}' and gs.wuliustate not in (2,4,5)";
            $infos = $mysql->query($sql2);
            $num2 = 0;
            $sy_num2 = 0;
            
            foreach ($infos as $info2){
                $aa = $info2['guestrizhi'];
                $youfh = "<br/>";
                $bb = explode($youfh, $aa);
                $js = count($bb) - 2;
                $cc = substr($bb[$js], 0, 10);
                $dd = date("Y-m-d");
                $dd2 = date("Y-m-d", time() - 3 * 24 * 3600);
                if ($cc != $dd) {
                    if ($cc < $dd2) {
                        $num2 ++;
                    }
                } else {
                    $num2 ++;
                    $sy_num2 ++;
                }
            }
            
            
            
            $num_tmp = $num2-$sy_num2;
            
print <<<oo
	               <tr>
						<td>{$info['adminname']}</td>
						<td>{$num1}</td>
						<td>{$sy_num1}</td>
						<td>{$num2}</td>
						<td>{$num_tmp}</td>
						<td>{$num_5}</td>
						<td>{$num_6}</td>
					</tr>
	
oo;




}?>
	</table>
        </div>
    </div>
</div>
<?php require ADMIN_PATH . 'foot.php';?>
