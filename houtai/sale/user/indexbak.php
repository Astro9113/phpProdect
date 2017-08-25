<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/midlimit.php";

foreach ($_GET as $k=>$v){
    $_GET[$k] = gl_sql(gl2($v));
}

$w = " 1 and (topuser='m{$loginid}' or dinguser='m{$loginid}')";  


//注册时间
$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$time2 = isset($_GET['time2'])?$_GET['time2']:'';
if($time1 && $time2){
    $phptime=strtotime($time1);
    $time3=date('Y-m-d H:i:s',$phptime);
    $phptime2=strtotime($time2);
    $time4=date('Y-m-d H:i:s',$phptime2);
    $w .= " and usertime >= '{$time3}' and usertime <= '{$time4}'";
}else{
    $time3 = $time4  = '';
}

//微信主
$loginname_s = isset($_GET['loginname_s'])?gl_sql($_GET['loginname_s']):'';
if($loginname_s){
    $w .= " and loginname = '{$loginname_s}'";
}

//qq
$qq_s = isset($_GET['qq_s'])?gl_sql($_GET['qq_s']):'';
if($qq_s){
    $w .= " and qq = '{$qq_s}'";
}

//tel
$tel_s = isset($_GET['tel_s'])?gl_sql($_GET['tel_s']):'';
if($tel_s){
    $w .= " and tel = '{$tel_s}'";
}

//重点客户
$isimportant = isset($_GET['isimportant'])?intval($_GET['isimportant']):-1;
if($isimportant !== -1){
    $w .= " and isimportant = {$isimportant}";
}

$topuser_s = isset($_GET['topuser_s'])?$_GET['topuser_s']:'';
if($topuser_s){
    $top = find_user_byname($topuser_s);
    if($top){
        $topid = $top['id'];
        $w .= " and topuser='$topid' and dinguser='m{$loginid}'";
    }else{
        $w .= " and 0";
    }    
}

$isimportant_a = array(-1 =>'不限','普通','重点');

?>

<?php require MID_PATH.'head.php';?>
<div id="wrap" class="clearfix">
	<?php require MID_PATH.'menu.php';?>
	
	<div id="main" class="clearfix">
		<div class="filter widthb110">

			<div class="cxform2" style="width: 1010px;">
				<form id="search" action="" method="get">
					入驻时间：<input ph="开始时间" type="text" id="time1" name="time1" value="<?php echo $time3;?>"
						size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
						ph="结束时间" type="text" id="time2" name="time2" value="<?php echo $time4;?>" size="11"
						onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
						<select name="isimportant">
						<?php echo_option2($isimportant_a, $isimportant);?>
						</select>
						用户名<input name="loginname_s" value="<?php echo $loginname_s;?>" type="text" style="width: 110px; height: 18px;">
						qq<input name="qq_s" value="<?php echo $qq_s;?>"  type="text" style="width: 110px; height: 18px;">
						电话<input name="tel_s" value="<?php echo $tel_s;?>"  type="text" style="width: 110px; height: 18px;">
						邀请人： <input name="topuser_s" value="<?php echo $topuser_s;?>" type="text"
						style="width: 110px; height: 18px;">
					<button>查 询</button>
				</form>
			</div>

			<div class="cb"></div>
		</div>

 <a class="btn mtop12 mleft6" href="userlogin/">查看用户登陆记录</a>
 <a class="btn mtop12 mleft6" href="keyuser/">重点用户</a>
 <?php $zuotian=date("Y-m-d",time()-24*60*60);  ?>
 <a class="btn mtop12 mleft6" href="?time1=<?php echo $zuotian;?> 00:00:00&time2=<?php echo $zuotian;?> 23:59:59">昨日新增用户</a>

 <div class="uc userlist mtop12">
			<table width="120%" cellpadding="5" border="0" bgcolor="#d3d3d3"
				cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="35">ID</th>
					<th width="130">账号</th>
					<th width="150">注册日期</th>
					<th width="150">昵称</th>
					<th width="120">qq</th>
					<th width="120">手机</th>
					<th width="120">邀请人</th>
					<th width="55">状态</th>
					<th width="55">密码</th>
					<th width="70">跟进</th>
                </tr>
    
<?php
    $num = $mysql->count_table('wx_user',$w);
    
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $offset = ($page - 1) * $page_size;
    
    $sql = "select * from wx_user where {$w} order by userstate desc,id desc limit $offset,$page_size";
    
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
            foreach ($info as $k=>$v){
                $info[$k] = gl2($v);
            }
            $uid = $info['id'];
            $yaoqinren = yaoqingren($info);
            $addtime = shorttime($info['usertime']);
            $state = $info['userstate']?'正常':'冻结';
            
print <<<oo
    <tr>
					<td>{$info['id']}</td>
					<td>{$info['loginname']}</td>
					<td>{$addtime}</td>
					<td>{$info['username']}</td>
					<td>{$info['qq']}</td>
					<td>{$info['tel']}</td>
					<td>{$yaoqinren}</td>
					<td widtd="45">{$state}</td>
					<td widtd="45">{$info['password']}</td>
					<td><a href="userrizhi/?id={$info['id']}">详细</a></td>
    </tr>
oo;
            
        }
    }
?>    


	</table>
	        <?php
                $page_config = array(
                        'time1' => $time1,
                        'time2' => $time2,
                        'loginname_s' => $loginname_s,
                        'qq_s' => $qq_s,
                        'tel_s' => $tel_s,
                        'isimportant' => $isimportant,
                        'topuser_s' => $topuser_s,
                        
                );
	        ?>
			<?php require MID_PATH.'page2.php';?>
		</div>
	</div>
</div>
<?php require MID_PATH.'foot.php';?>