<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
	<style type="text/css">
		*{margin:0px;padding:0px;overflow:none;}
		a{width:100%;height:auto;overflow:hidden;text-decoration:none;}
		a img{width:100%;height:auto;overflow:hidden;}
		.adalt{color:#fff;z-index:99;position:absolute;top:0px;left:0px;width:20px;height:12px;background:url(./static/img/ads2.png) no-repeat;background-size:100%;}
	</style>
</head>
<body>
<div id="imgswf">
<span class="adalt"></span>
<a style='display:none;position:relative;' target='_blank' href='http://mp.weixin.qq.com/s?__biz=MzI1NjQ1MTc0Mg==&mid=2247483723&idx=1&sn=febcbe7bc45d2f4913e1503dffe4f353&chksm=ea2734badd50bdac4feda05f46397be3e370bf6c57ee192f3d0c52646cfda8f1d9542ca29504&mpshare=1&scene=23&srcid=0114hRERnDdY17fyPCDMvE0u#rd'>
	<img src='http://i.chinavuw.com/upload/addon/170113/064756249.gif' alt=''/>
	<div style='position:absolute;right:0;top:0;height:22px;line-height:22px;width:30px;text-align:center;margin:auto;background:rgba(132,123,129,.5);color:#fff;' onclick='closead();'> X </div>
	</a></div>
<script type="text/javascript" src="https://apps.bdimg.com/libs/zepto/1.1.4/zepto.min.js"></script>
<script type="text/javascript">
var imgswf = document.getElementById("imgswf");
var ads = imgswf.getElementsByTagName("a");
var number = ads.length;
var curnumber = 0;
var adposid=4325;

function closead(){
	var url ="?c=Ad&m=closecount&apd="+adposid;
	$.get(url,function(result){
		console.log(result);
	});
	window.parent.postMessage("setheight:"+adposid+":0","*");
	window.parent.postMessage("closead:"+adposid,"*");
	window.open("index.php?c=Ad&m=goadurl&data=FdRsciMq9K9Ja4En8WRvw4UifLerwElGMQSWRG6MiUnO0qZMJCjAsHUatJomarDxiHuJCyacezbMPJFV3WGKmSMzGTrcofANcvm3PXlJgmZHeJ8VthWgR4PFZYfE3c7BG0wn%252FMpNrBsY1MnLpBk%252BQ%252Fx%252BuvhKMrzW8X05aCnmk3gAwpvJGOBM%252ByJbJuqOs7K8KBXq4z0h0aLlGsSO4FaHTzRsz9GFxVM0%252BljPKVTCFhNloyFH04PMIwh5On9E1Inmw8RhbkxaxIHyO0Uq2l3fo4gxkNqyWlGknXZckapD%252B2jyDLl8XFsCsurEgGVmlvpi19bdkC8E89PhpIUPAoR0fGiFr%252FbScd73JMmJEgjcau0VrymSBOl2Gs9bgtBGUBmjX%252BNfb%252BHFx%252Btzr8zNfBfOPvmGEo3mKf1BAJ1q64H4ky7Zz%252Fl8HYWW0mg1BJNhbr5b8YR1ZxWUvk7Zz%252Fl8HYWW0uEcbF2LFR45pwkeMRpWtGMOHuza3KwA1DPpFl5fUzQZLCS0aEE2M1MiWLJ8v6WNSNSzOsGgQVQTHkRrFmqwK952YCIuTxQJfHSl3wT4WaIIYRHjl0TexW2%252FCXzAnc3Y%252BxaCqU%252FFsccUjVZb%252Fg%252F1OLfldSyO5pcyDxT1ezwn2zlKT7tL9ZB7M%252BmFjKqkRjNOCRnAgto%252Bq%252FgSGqYBAGOqSGG3o%252FeHhvRqWpD2ZkrMSqu7JvXu%252BKCx81FIKoQVIIgRuYRigy7bTUr54zXBEbNA%252B9tAu3Ps%252FXC2JpQq%252B2DE1FEoRIurMdUe0ADaWEbV%252FzOLViGremwQLRHBe%252BgQ6TBaTfgqpxSFRQ0%252BFOSXuGOF3hQuHssnDC5nC873AeFhJJ3UphqJgxzuIhOJ7mHJaV7PuR7UZJNU8PxaFCTIVj7nYBYcfFBRsRwPP%252FIX3bS2EAnQxyHL9Y0o2ilnnMDvHGmZKWc7yROvJxY2lgHUSqxxFLFOS1RFipGGRzdrUd3ZIpf21R5EaxZqsCve80CByKr%252BgB3tmMhy1rjc67i2zYE%252FGSO4NZPUxApouWD0fYUtmC67jKy8nYW5G76RjZnVxRrU6%252BeELGWhxnp7xvCz3P9dDEXwqv6NHVWDKcBSPXRmuqAsLg%253D%253D");
}

function playimg(){
	curnumber++;
	if(curnumber>number-1) curnumber=0;
	for(i=0;i<number;i++){
		if(i==curnumber){
			ads[i].style.display="block";
		}else{
			ads[i].style.display="none";
		}
	}
	setTimeout("playimg();",2000);
}
playimg();

$(window).ready(function(){
	var height = $("body").height();
	window.parent.postMessage("setheight:"+adposid+":"+height,"*");
});
$(window).resize(function(){
	var height = $("body").height();
	window.parent.postMessage("setheight:"+adposid+":"+height,"*");
	
});
var height = 0;
	setInterval(function(){
		if($("body").height()!=height){
			height = $("body").height();
			window.parent.postMessage("setheight:"+adposid+":"+height,"*");
		}
		
	},400);
</script>

</body>
</html>