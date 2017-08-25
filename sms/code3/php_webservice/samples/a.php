<?php
require_once '../lib/nusoap.php';
$wsdl = '../lib/a.wsdl';  
$client = new nusoap_client($wsdl, 'wsdl');
$client->soap_defencoding = 'utf-8';
$client->decode_utf8 = false;
$client->xml_encoding = 'utf-8';
$params = array(
		'account'=>'mkbl@mkbl',
		'password'=>'123456',
		'mtpack'=>array(
				'uuid'=>$uid,
				'batchID'=>$uid,
				'batchName'=>'xu_test',
				'sendType'=>0,
				'msgType'=>1,
				'msgs'=>array(
						'MessageData'=>array(
								array(
										'Content'=>'this is SMS test',
										'Phone'=>'18601070550',
										'vipFlag'=>true
								)
							
						)
				),
				'distinctFlag'=>true,
				'bizType'=>0,
				'scheduleTime'=>0
		)
);
$result = $client->call('Post', $params);
?>