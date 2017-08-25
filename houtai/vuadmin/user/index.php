<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(
        1
);
qx($allow_qx, $adminclass);

$w = ' 1 ';

$time1 = isset($_GET['time1'])?$_GET['time1']:'';
$phptime = strtotime($time1);
$time3 = date('Y-m-d H:i:s',$phptime);
$time2 = isset($_GET['time2'])?$_GET['time2']:'';
$phptime2=strtotime($time2);
$time4=date('Y-m-d H:i:s',$phptime2);

if($time1 && $time2){
    $w .= " and usertime>='{$time3}' and usertime<='{$time4}'";
}

$isimportant = isset($_GET['isimportant'])?intval($_GET['isimportant']):-1;
if($isimportant !== -1){
    $w .= " and isimportant = {$isimportant}";
}

$userstate = isset($_GET['userstate'])?intval($_GET['userstate']):-1;
if($userstate !== -1){
    $w .= " and userstate = {$userstate}";
}

$newdomain = isset($_GET['newdomain'])?intval($_GET['newdomain']):-1;
if($newdomain !== -1){
    $w .= " and newdomain = {$newdomain}";
}

$qq = isset($_GET['qq'])?gl_sql($_GET['qq']):'';
if($qq){
    $w .= " and qq ='{$qq}'";
}

$loginname = isset($_GET['loginname'])?gl_sql($_GET['loginname']):'';

if($loginname){
    $w .= " and loginname ='{$loginname}'";
}
$id = isset($_GET['id'])?intval($_GET['id']):'';

if($id){
    $w .= " and id ='{$id}'";
}
$userstate_a = array(-1 =>'不限','冻结','正常');
$isimportant_a = array(-1 =>'不限','普通','重点');
$newdomain_a = array(-1 =>'不限','旧域名','新域名');

?>

<?php require ADMIN_PATH . 'head.php';?>
<div id="wrap" class="clearfix">
	<?php require ADMIN_PATH . 'menu.php';?>
	
	<div id="main" class="clearfix">
		<div class="filter width110" style="width:112%;">
			<div class="cxform2" style="width: 880px;">
				<form id="search" method="get" action="">
					时间：<input ph="开始时间" type="text" id="time1" name="time1" value="<?php echo $time1;?>"
						size="11" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />-<input
						ph="结束时间" type="text" id="time2" name="time2" value="<?php echo $time2;?>" size="11"
						onClick="WdatePicker({startDate:'%y-%M-%d 23:59:59',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
						qq： <input name="qq" type="text"
						style="width: 80px; height: 18px;" value="<?php echo $qq;?>">
					用户： <input name="loginname" type="text"
						style="width: 80px; height: 18px;" value="<?php echo $loginname;?>">
					ID： <input name="id" type="text"
						style="width: 40px; height: 18px;" value="<?php echo $id;?>">						
				        重点：
					<select name="isimportant">
					   <?php echo_option2($isimportant_a, $isimportant)?>
					</select>
					状态:<select name="userstate">
					   <?php echo_option2($userstate_a, $userstate)?>
					</select>
					域名：
					<select name="newdomain">
					   <?php echo_option2($newdomain_a, $newdomain)?>
					</select>
					
					
					<button type="submit">查 询</button>
				</form>
			</div>
			

			<div class="cb"></div>
		</div>
		
		<a class="btn mtop12 mleft6" href="./?isimportant=1">重点用户</a>
        <a class="btn mtop12 mleft6" href="./?userstate=0">冻结用户</a>
        <?php $zuotian=date("Y-m-d",time()-24*60*60);  ?>
        <a class="btn mtop12 mleft6" href="./?time1=<?php echo $zuotian;?> 00:00:00&time2=<?php echo $zuotian;?> 23:59:59">昨日新增用户</a>
		<a class="btn mtop12 mleft6" href="/vuadmin/user/usershopadd/">用户对商品加额</a>
		
		<div class="uc userlist mtop12">
			<table class="trcol" width="155%" cellpadding="5" border="0"
				bgcolor="#d3d3d3" cellspacing="1">
				<tr bgcolor="#f5f5f5">
					<th width="35">ID</th>
					<th width="110">账号</th>
					<th width="95">昵称</th>
					<!--
					<th width="85">qq</th>
					<th width="100">手机</th>
					-->
					<th width="105">奖励提成</th>
					<th width="105">分成比率</th>
					<th width="125">注册日期</th>
					<th width="90">邀请人</th>
					<th width="50">媒介</th>
					<th width="40">状态</th>
					<th width="30">重点</th>
					<th width="30">域名</th>
					<th width="120">操作</th>
				</tr>
    
<?php
    $users = get_users();
    $midusers = get_midusers();   
    
    $num = $mysql->count_table('wx_user',$w);
    $page_size = 12;
    $page_count = ceil($num / $page_size); // 得到页数
    $page = isset($_GET['page'])?intval($_GET['page']):1;
    $page = $page?$page:1;
    $offset = ($page - 1) * $page_size;
    
    $sql = "select * from wx_user where {$w} order by userstate desc,id desc  limit $offset,$page_size";
    $infos = $mysql->query($sql);
    if($infos){
        foreach ($infos as $info){
			foreach($info as $k=>$v){
				$info[$k] = htmlentities($v,ENT_COMPAT,'UTF-8');
			}
			
            $topid = $info['topuser'];
            if ($topid == "") {
                $topuser = "无中间人";
            } else {
                if(isset($users[$topid])){
                    $top = $users[$topid];
                    $topuser = $top['loginname'];
                }else {
                    $topid = substr($topid, 1);
                    $top = $midusers[$topid];
                    $topuser = $top['username'];
                }
            }
            // 调出媒介
            if (substr($info['topuser'], 0, 1) == 'm') {
                $mjid = substr($info['topuser'], 1);
            } elseif (substr($info['dinguser'], 0, 1) == 'm') {
                $mjid = substr($info['dinguser'], 1);
            }
            
            $miduser = $midusers[$mjid];
            $mjname = $miduser['username'];
            
            

            
            $reg_time = date("y-m-d  H:i",strtotime($info['usertime']));
            $status = $info['userstate']?'正常':'冻结';
            $key = $info['isimportant']?'重点':'普通';
            $domain = $info['newdomain']?'新':'旧';
            
            foreach ($info as $k=>$v){
                $info[$k] = gl2($v);
            }
            $topuser = gl2($topuser);
            $mjname = gl2($mjname);
            
    //<td>{$info['qq']}</td>
    //<td>{$info['tel']}</td>
print <<<oo
    <tr>
    <td>{$info['id']}</td>
    <td>{$info['loginname']}</td>
    <td>{$info['username']}</td>

    <td>{$info['userreward']} % </a></td>
    <td>{$info['userpercent']} % </a></td>
    <td>{$reg_time}</td>
    <td>{$topuser}</td>
    <td>{$mjname}</td>
    <td>{$status}</td>
    <td>{$key}</td>
    <td>{$domain}</td>
    <td><a target="_blank" href="moduser/?id={$info['id']}">修改</a></td>
    </tr>
oo;

        }
    }

?>
    
    

	</table>
	        <?php 
                $page_config = array();
                $page_config['time1'] = $time1;
                $page_config['time2'] = $time2;
                $page_config['isimportant'] = $isimportant;
                $page_config['userstate'] = $userstate;
                $page_config['newdomain'] = $newdomain;
                $page_config['qq'] = $qq;
                $page_config['loginname'] = $loginname;
				$page_config['id'] = $id;
				
                
            ?>   
			<?php require ADMIN_PATH . 'page2.php';?>
			<?php require ADMIN_PATH . 'tip.php';?>
		</div>
	</div>
</div>

<?php require ADMIN_PATH . 'foot.php';?>

<style>
.important {
	color: #FE6100;
	cursor: pointer;
}

.important:hover {
	text-decoration: underline;
}
</style>