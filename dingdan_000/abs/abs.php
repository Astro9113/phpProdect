var getArgs=(function(){
    var sc=document.getElementsByTagName("script");
    var paramsArr=sc[sc.length-1].src.split('?')[1].split('&');
    var args={},argsStr=[],param,t,name,value;
    for(var ii=0,len=paramsArr.length;ii<len;ii++){
        param=paramsArr[ii].split('=');
        name=param[0],value=param[1];
        if(typeof args[name]=="undefined"){ //参数尚不存在
            args[name]=value;
        }else if(typeof args[name]=="string"){ //参数已经存在则保存为数组
            args[name]=[args[name]]
            args[name].push(value);
        }else{ 
            args[name].push(value);
        }
    }
    return function(){return args;} 
})();
var getUrl = (function () {
    var sc = document.getElementsByTagName("script");
    var url = "";
    for (var i = 0; i < sc.length; i++) {
        if (sc[i].src.indexOf("/ads/") > 0) {
            var s = sc[i].src.split("/ads/")[0];
            url= s + "/ads/c.aspx";
            break;
        }
    }
    return function(){return url;} 
})();
var generateMixed = function (n) {
    var chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    var res = "";
    for (var i = 0; i < n ; i++) {
        var id = Math.ceil(Math.random() * 35);
        res += chars[id];
    }
    return res;
} 
var num = getArgs()["num"];
var width = getArgs()["width"];
var height = getArgs()["height"];
var cid = getArgs()["cid"];
var color = getArgs()["color"];
var type = getArgs()["type"];
var pid = getArgs()["pid"];
var index ="index";
var height=(num*100);
if(type =="1"){
    index ="index2";
height=(num*40);
}
else if(type =="2"){
    index ="index3";
height=(num*200);
}
var uid = getArgs()["uid"];var url = "http://"+generateMixed(4)+".<?php 
require $_SERVER['DOCUMENT_ROOT'].'/wxdata/sjk1114.php';
$key = '1-domain-ad-js';
$domain = get_config($key);
mysql_close();
//$domain = 'aa.com';
echo $domain;?>/abs/" + index + ".php?uid=" + uid + "&num="+num+"&width="+width+"&height="+height+"&cid="+cid+"&color="+color+"&pid="+pid;url = url.replace("$rnd$", generateMixed(4));url = url+"&rnd="+generateMixed(4);
document.write("<img src=\"" + getUrl() + "\" style=\"display:none;\"/>");
document.write('<iframe id="content" width="100%" height="'+height+'px" marginwidth="0" marginheight="0" frameborder="0" src="' + url + '"></iframe>');