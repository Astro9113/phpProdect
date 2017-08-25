<?php
require 'set.php';

echo '<form method="post" action="doset.php">';

foreach($arr as $k => $v){
	$able = $v['able'];
	$url = $v['url'];
	echo '<input type="text" name="url[]" value="'.$url.'">';
	echo '<input type="text" name="able[]" value="'.$able.'">';
	echo '<br />';
}

echo '<textarea name="news" style="width:348;height:200px;"></textarea>';
echo '<br />';

echo '<input type="submit" name="sub" value="go">';
echo '</form>';

?>

<button type="button" id="clr">清除失效</button>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.js"></script>
<script>
$("#clr").click(function(){
	$("input[name='able[]']").each(
		function(){
			if($(this).val()==0){
				$(this).prev().val('');
			}
		}
	);
});
</script>






