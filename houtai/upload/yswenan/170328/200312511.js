function getfahuo(){
var not3str="";
if(not3chanpin.length !=0){not3str=not3str+not3chanpin[Math.floor((Math.random()*not3chanpin.length))];}
if(not3yanse.length !=0){not3str=not3str+not3yanse[Math.floor((Math.random()*not3yanse.length))];}
if(not3chima.length !=0){not3str=not3str+not3chima[Math.floor((Math.random()*not3chima.length))];}
return not3str;
}
document.writeln("<ul>");
document.writeln("<li><span>[最新购买]：<\/span>张**（130****3260）在1分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>李**（136****7163）在3分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>赵**（139****1955）在7分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>刘**（180****6999）在9分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>周**（151****2588）在4分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>王**（133****4096）在10分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>秦**（139****1955）在15分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>朱**（180****6999）在20分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>吴**（151****2588）在12分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<li><span>[最新购买]：<\/span>谭**（133****4096）在18分钟前订购了 "+getfahuo()+" <font color=\'#FF0000\'>√<\/font><\/li>");
document.writeln("<\/ul>");