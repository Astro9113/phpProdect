<?php 

	//检查输入时间格式是否正确
	function check_date($date=''){
		$pat = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
		if(preg_match($pat, $date)){
			return true;
		}else{
			return false;
		}
	}
	
	//根据用户名获取用户id
	function get_uid_by_loginname($loginname){
		$loginname = mysql_real_escape_string($loginname);
		$sql = "select id from wx_user where loginname  = '{$loginname}'";
		$result = mysql_query($sql);
		$r = mysql_fetch_assoc($result);
		return $r['id'];
	}
	
	
	//格式化统计数据   没有数据的日期填充0
	function data_format($arr,$format,$stime,$etime,$s_time_yx=''){
		switch ($format){
			case '%H':
				$format_arr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
				foreach ($format_arr as $v){
					if(array_key_exists($v, $arr)){
						continue;
					}else{
						$arr[$v] = 0;
					}
				}
			break;
			case '%Y-%m-%d':
				if(!$stime && !$etime){
					$stime = key($arr);
					
					if($s_time_yx){
						$stime = $s_time_yx; 
					}
					$etime = date('Y-m-d');
				}
				
				//echo '<pre>';
				//print_r($arr);
				
				$nextday = date('Y-m-d',strtotime('+1 day',strtotime($stime)));
				
				while($nextday!=$etime){
					if(!array_key_exists($nextday, $arr)){
						$arr[$nextday] = 0;
					}
					$nextday = date('Y-m-d',strtotime('+1 day',strtotime($nextday)));
				}
				
				if(!array_key_exists($nextday, $arr)){
					$arr[$nextday] = 0;
				}
				
				//补齐开始时间
				if($s_time_yx){
					if(!array_key_exists($s_time_yx, $arr)){
						$arr[$s_time_yx] = 0;
					}
				}
				break;
				case '%m-%d %H:00':
					$format_arr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
					foreach ($format_arr as $v){
						if(array_key_exists($v, $arr)){
							continue;
						}else{
							$arr[$v] = 0;
						}
					}
				break;
		}

		ksort($arr);
		return $arr;
	}
	
	
	//test
	function t(){
		$arr = array('a'=>'aaa','b'=>'bbb',);
		echo '<pre>';
		print_r(key($arr));
	}
	
?>