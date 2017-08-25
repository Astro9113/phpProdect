<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
require ROOT . "wxdata/Jurisdiction.php";
require CLASS_PATH . "upload_class.php";
ini_set('display_errors', 'off');


$sids = array(50,96,115,116,117,119,109,121,112,122,123,124);

$sql = "select * from wx_shop_addon where shopid in (".join(',', $sids).") order by hide";
$infos = $mysql->query($sql);

echo '<a href="add.php">添加新文案</a><br>';
echo '<table>';
echo '<tr>';
echo '<td>Id</td>
    <td>ShopId</td>
    <td>File_INDEX</td>
    <td>titlw</td>
    <td>状态</td>
    <td>编辑</td>
    <td>预览</td>
    <td>预览222</td>';
echo '</tr>';
foreach ($infos as $info){
    $class = $info['hide']?'bghide':'bgshow';
     
    echo '<tr>';
    echo "<td>{$info['id']}</td>";
    echo "<td>{$info['shopid']}</td>";
    echo "<td>{$info['file_index']}</td>";
    echo "<td>{$info['title']}</td>";
    echo "<td class='{$class}'> </td>";
    echo "<td><a target='_blank' href='detail.php?id={$info['id']}'>编辑</a></td>";
    echo "<td><a target='_blank' href='view.php?id={$info['id']}'>预览</a></td>";
    echo "<td><a target='_blank' href='view2.php?id={$info['id']}'>预览</a></td>";
    echo '</tr>';    
}
echo '</table>';
?>

<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script>
$(function(){
	  $("#shopid").change(function(){
	    	var shopid = findex = 0;
	    	shopid = $("#shopid").val();
	    	findex = $("#findex").val();
	    	location.href = '?shopid='+shopid+'&findex='+findex;    
	    })
	    $("#findex").change(function(){
	    	var shopid = findex = 0;
	    	shopid = $("#shopid").val();
	    	findex = $("#findex").val();
	    	location.href = '?shopid='+shopid+'&findex='+findex;    
	    })    
});
</script>

<style>
table,td{border-collapse:collapse;border:1px solid #000;}
td{padding:5px;}
.bghide{background-color:red}
.bgshow{background-color:green}
</style>