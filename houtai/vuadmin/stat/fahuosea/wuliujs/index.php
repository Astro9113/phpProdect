<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,7);
qx($allow_qx, $adminclass);


for($i=1;$i<=50;$i++){
    $fx="box".$i;
    
    $k = false;
    if(isset($_POST[$fx])){
        $k = $_POST[$fx];
    }
    if($k){
        $id = $k;
		$ret = jushou($id);
		
		
		$log = array(
		        'guestid'=>$id,
		        'ip'=>get_client_ip(),
		        't'=>date('Y-m-d H:i:s'),
		        'type'=>'admin',
		        'uid'=>$loginid,
		        'uname'=>$adminname,
		        'f'=>3,
		        'to'=>6,
		        'ok'=>0,
		        'rem'=>'物流改拒收',
		);
		
		$ok = $ret?1:0;
		$log['ok'] = $ok;
		log_orderstate_db($log);
	}
}

alert('修改成功');
go('../yjs.php');