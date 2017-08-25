<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,8);
qx($allow_qx, $adminclass);

//先清空临时数据表
$mysql->execute('TRUNCATE TABLE  `daosj`');


if(isset($_FILES['excel']['name'])){
	$name = $_FILES['excel']['name'];
	$tmp_name = $_FILES['excel']['tmp_name'];
	$size = $_FILES['excel']['size'];
	
	//上传开始解析
	if(!preg_match('/\.csv$/', $name)){
		exit('只允许上传csv格式表格文件');
	}
	
	if($size>(10*1024*1024)){
		exit('文件太大');//10 MB
	}
	
	$target = CACHE_PATH.'vuadmin/wuliudh/'.date('Y-m-d').'_'.time().'.csv'; 
	if(move_uploaded_file($tmp_name, $target)){
		$up_ok = true;
	}else{
		$up_ok = false;
	}
	
	$ycdd = '';
	if($up_ok){//上传成功,开始入库
		$arr = file($target); 
		foreach ($arr as $k=>$v){
			$v = trim($v);
			$v = explode(',',$v); 
			if(count($v)<>3){
				$ycdd.=date('Y-m-d H:i:s').'#入库失败#'.join(',',$v).'<br>';
				continue;
			}
			$guestid = $v[0];
			$guesttel = $v[1];
			$wuliudh = $v[2];
				
			$pat1 = '/^\d+$/';
			$pat2 = '/^\d{11}$/';
		    $pat3 = '/^D?D?\d{8,13}$/';

				
			if(!preg_match($pat1,$guestid)){
				$ycdd .= '订单号不是数字'.join(',', $v).'<br />';	
				continue;
			}
			
			if(!preg_match($pat2,$guesttel)){
				$ycdd .= '手机号不是11位'.join(',', $v).'<br />';
				continue;
			}
				
			if(!preg_match($pat3,$wuliudh)){
				$ycdd .= '物流单号格式不对'.join(',', $v).'<br />';
				continue;
			}

			if(!$guestid || !$guesttel || !$wuliudh){
				$ycdd.=date('Y-m-d H:i:s').'#数据异常#'.$guestid.'#'.$guesttel.'#'.$wuliudh.'<br>';
				continue;
			}else{
				$sql = "select * from daosj where wuliudh='{$wuliudh}'";
				$has = $mysql->find($sql);
				if($has){
				    $ycdd.=date('Y-m-d H:i:s').'#入库失败,本次上传存在相同单号#'.$guestid.'#'.$guesttel.'#'.$wuliudh.'<br>';
				    continue;
				}
				
			
				$sql = "select * from wx_guest where guestkuaidi='{$wuliudh}'";
				$has = $mysql->find($sql);    
			    if($has){
				    $ycdd.=date('Y-m-d H:i:s').'#入库失败,订单库已存在此单号#'.$guestid.'#'.$guesttel.'#'.$wuliudh.'<br>';
				    continue;
				}
		   
				
				$sql = "insert into daosj(guestid,guesttel,wuliudh) values('{$guestid}','{$guesttel}','{$wuliudh}')";
				$rs = $mysql->execute($sql);
				if(!$rs){
					$ycdd.=date('Y-m-d H:i:s').'#入库失败#'.$guestid.'#'.$guesttel.'#'.$wuliudh.'<br>';
					continue;
				}
			}
		}		
		
		$num = $mysql->count_table('daosj');
		echo $ycdd."<br><a href='up.php' target='_blank'>开始传单号</a> 个数：".$num;
		
	}else{
		echo '上传失败';
	}
	
}



?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<div class="main">
		<p>请按照模板格式组织文件,否则无法正常解析,&nbsp;&nbsp;&nbsp;<a target='_blank' href="javascript:history.go(-1);">返回上一页</a></p>
		<form name="up" method="post" action="" enctype="multipart/form-data">
			<input type="file" name="excel">
			<input type="submit" name="sub" value="上传">
		</form>
		</div>
	<style>
		div.main{width:600px;padding:20px;margin-left:5px;margin-top:20px;border:1px solid #000;}
	</style>
</body> 
</html>