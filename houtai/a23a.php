<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
$allow_qx = array( 1,5 );
qx($allow_qx, $adminclass);

ob_end_flush();
echo str_repeat(" ",1024);

$uptime=date('Y-m-d',time()-2*24*60*60).' 17:00:00';
$sql = "select guestname,count(guestname) as gnu from wx_guest where addtime>='$uptime' and userid <> '2099' group by guestname order by id,gnu desc";
$infos = $mysql->query($sql);

if($infos){
    foreach ($infos as $info){
        if($info['gnu'] >= 2){
            $guestname = gl2($info['guestname']);
            echo "<br><br><br>".$guestname."---".$info['gnu']."<br>";
            flush();
            
            $guestname = gl_sql($guestname);
            
            $info2s = $mysql->query("select guesttel,count(guesttel) as telnum from wx_guest where addtime>='$uptime' and guestname='$guestname' group by guesttel order by telnum desc");
            foreach ($info2s as $info2){
                if($info2['telnum']>='2'){
                    $guesttel = $info2['guesttel'];
                    $num1 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guesttel='$guesttel' and gueststate='12'");
                    $num2 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guesttel='$guesttel' and gueststate='8'");
                    $num3 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guesttel='$guesttel' and gueststate='10'");
                    
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;".$info2['guesttel']."---".$info2['telnum'].
                    "&nbsp;&nbsp;&nbsp;
                                                    重复 ".$num1." 个&nbsp;&nbsp;&nbsp;
                                                    取消 ".$num2." 个&nbsp;&nbsp;&nbsp;
                                                    假单 ".$num3." 个<br>";
                    flush();
                }
            }
        }
    }
}

echo '<hr />';


$sql = "select guesttel,count(guesttel) as gnu from wx_guest where addtime>='$uptime' and userid <> '2099' group by guesttel order by id,gnu desc";
$infos = $mysql->query($sql);

if($infos){
    foreach ($infos as $info){
        if($info['gnu'] >= 2){
            $guesttel = gl2($info['guesttel']);
            echo "<br><br><br>".$guesttel."---".$info['gnu']."<br>";
            flush();

            $guesttel = gl_sql($guesttel);

            $info2s = $mysql->query("select guestname,count(guestname) as telnum from wx_guest where addtime>='$uptime' and guesttel='$guesttel' group by guestname order by telnum desc");
            foreach ($info2s as $info2){
                if($info2['telnum']>='2'){
                    $guestname = $info2['guestname'];
                    $num1 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guestname='$guestname' and gueststate='12'");
                    $num2 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guestname='$guestname' and gueststate='8'");
                    $num3 = $mysql->count_table('wx_guest',"addtime>='$uptime' and guestname='$guestname' and guestname='$guestname' and gueststate='10'");

                    echo "&nbsp;&nbsp;&nbsp;&nbsp;".$info2['guestname']."---".$info2['telnum'].
                    "&nbsp;&nbsp;&nbsp;
                                                    重复 ".$num1." 个&nbsp;&nbsp;&nbsp;
                                                    取消 ".$num2." 个&nbsp;&nbsp;&nbsp;
                                                    假单 ".$num3." 个<br>";
                    flush();
                }
            }
        }
    }
}