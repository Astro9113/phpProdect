<?php 
//vu文案加下单跳转(最新)
include 'wxdata/sjk1114.php';

$r = isset($_GET['r'])?$_GET['r']:'';
if(!$r){
    exit('参数错误');
}

$args = explode('-', $r);


//参数 = 商品 -用户 - 渠道 -时间
$id     = intval($args[0]);
$userid = intval($args[1]);
$userwx = intval($args[2]);
$file_index = intval($args[3]);

/*
$mid = get_mid($userid);
$key = $mid.'-domain_2_2_1';
$key_backup = '1-domain_2_2_1';
$domain = get_config($key);
$domain = $domain?$domain:get_config($key_backup);
*/

$key_backup = '1-domain_2_2_1';
//cps的显示域名 和 文案下单的分开
if(isset($_GET['t']) && $_GET['t']=='cps'){
    $key_backup = '1-vu_domain_zjxd_2';
}

$domain = get_config($key_backup);

$time = time();
$r = "$id-$userid-$userwx-$file_index-$time";
$randpath = '6'.rand_str(rand(3,4));
$link = 'http://'.$domain.'/'.$randpath.'/?r='.$r;
echo r();

echo '<script>url = "'.$link.'"</script>';
mysql_close();

echo r();echo r();echo r();
?>

<script>
eval(function(p,a,c,k,e,r){e=String;if(!''.replace(/^/,String)){while(c--)r[c]=k[c]||c;k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0.1.2=3;',4,4,'window|location|href|url'.split('|'),0,{}))
</script>
<?php echo r();?>