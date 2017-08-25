<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';

$sql = "select v from wx_config where k = '1-jumpdomain_2' limit 1";
$ret = $mysql->find($sql);
$domain = $ret['v'];
if(isset($_GET['php'])){
	echo $domain;exit;
}
echo 'var vu_wenan_domain = \''.$domain.'\';';
exit;
