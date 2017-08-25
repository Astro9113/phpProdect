<?php 
//vu文案加下单跳转(旧)
include 'wxdata/sjk1114.php';

$r = $_GET['r'];
$r = explode('-',$r);
$userid = $r[0];

/*
$mid = get_mid($userid);
$key = $mid.'-domain_2_2_1';
$key_backup = '1-domain_2_2_1';
$domain = get_config($key);
$domain = $domain?$domain:get_config($key_backup);
*/

$key_backup = '1-domain_2_2_1';
$domain = get_config($key_backup);

$time = time();
$r = "$userid-$time";
$randpath = '6'.rand_str(rand(3,4));
$link = 'http://'.$domain.'/stw.php?r='.$r;

echo '<script>url = "'.$link.'"</script>';
mysql_close();
?>

<script>
eval(function(p,a,c,k,e,r){e=String;if(!''.replace(/^/,String)){while(c--)r[c]=k[c]||c;k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0.1.2=3;',4,4,'window|location|href|url'.split('|'),0,{}))
</script>