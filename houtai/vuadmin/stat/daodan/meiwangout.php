<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array(1,8);
qx($allow_qx, $adminclass);

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment:filename=test.xls");
header("Content-Type: text/html; charset=gb2312");




//$HeadArr = array ('客服','ID','商户号','日期','姓名','电话','地址','产品','金额','备注','寄件人','寄件电话','客服备注');
//creatExcel($HeadArr,'utf-8','gb2312');

$HeadArr = array('序号','下单日期','发运日期','发运单号','收件人','收件地址','收件人电话','代收金额','数量','供应商','产品明细','备注','单号');
creatExcel($HeadArr,'utf-8','gb2312');


//aa

$shops = get_shops();
$kefus = get_kefus();

$sql = "select * from wx_guest where gueststate = 2";
$infos = $mysql->query($sql);
if($infos){
    foreach ($infos as $info){
        $guestrizhi = $info['guestrizhi'];

                $shopid = $info['shopid'];
                $skuid = $info['skuid'];
                $guestname = $info['guestname'];
                $guesttel = $info['guesttel'];
                $gueststate = $info['gueststate'];
                $guestkuanshi = $info['guestkuanshi'];
                 
                $shop = $shops[$shopid];
                $shopskuid = "shopsku".$skuid;
                $shopsku = $shop[$shopskuid];
                $shopsku=explode("_",$shopsku);
                
                
                $gusettitle = $shop['shopname2']." ".$shopsku[0]." ".$guestkuanshi;
                 
                $idname='凯';
                $info['guestdizhi'] = str_replace(array("\n","\t"),'',$info['guestdizhi']);
                $guestdizhi = trim($info['guestdizhi']);

                $kefu = $kefus[$info['guestkfid']];
                $kefuname = $kefu['adminname'];
                
                $row = array(
                    '',
                    $info['addtime'],
                    '',
                    '',
                    $guestname,
                    $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$guestdizhi,
                    $guesttel,
                    $shopsku[1],
                    '',
                    '',
                    $gusettitle,
                    $info['id'],
					$info['guestrem'],
					
                );
                
                
                $row = array(
                        
                        $kefuname,
                        $info['id'],
                        'WG0010077',
                        date("Y/m/d"),
                        $guestname,
                        $guesttel,
                        $info['guestsheng'].$info['guestcity'].$info['guestqu']." ".$guestdizhi,
                        $gusettitle,
                        $shopsku[1],
                        '可开箱看货',
                        '李',
                        '13366690545',
                        $info['guestrem']
                );
                
                creatExcel($row,'utf-8','gb2312');
           }
        }
