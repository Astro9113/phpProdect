// JavaScript Document
if(navigator.userAgent.indexOf("iPhone")!=-1||navigator.userAgent.indexOf("iPad")!=-1||navigator.userAgent.indexOf("Android")!=-1)
{
	document.writeln("<style type='text/css' style='display:none;'>");
	document.writeln("<"+"!--");
	document.writeln(".a324_4325{position:absolute;left:0px;right:0px;bottom:0px;width:100%;max-width:450px;min-width:200px;margin:0px auto;z-index:2147483647}");
	document.writeln(".a324_4325 iframe{padding:0px;margin:0px;border:none;width:100%;margin-bottom:-5px;}");
	document.writeln("--"+">");
	document.writeln("</style>");
	document.writeln("<div class='a324xf_zw_4325' style='clear:both;height:0px;width:100%;overflow:hidden;'></div>");
	document.writeln("<div class='a324_4325' id='a324_4325'><iframe class='u324adifr_4325' scrolling='no' id='u324adifr_4325' src='http://hmty.sufgps.cn/abs/tt3.php' scrolling='no' ></iframe></div>");

	if(typeof(a324first)=="undefined"){
		a324first=true;
	}
	window.onmessage = function(e){
		e = e || event;
		var msg = e.data;
		msg = msg.split(":");
		switch(msg[0]){
			case "setheight":
				var posid = msg[1];
				var height = msg[2];
				
                document.getElementById("a324_4325").style.position="fixed";
                
                var a33div=document.getElementsByClassName("a324_"+posid);                
                for(i=0;i<a33div.length;i++){ 
                    var posi = getStyle(a33div[i]).getPropertyValue("position");
                    if(posi == 'absolute'){
                        a33div[i].style.position = 'fixed';
                    }
                }
				
				var adifrs=document.getElementsByClassName("u324adifr_"+posid);
				for(i=0;i<adifrs.length;i++){
					adifrs[i].height = height;
				}
				
				var zw =  document.getElementsByClassName("a324xf_zw_"+posid);
				for(i=0;i<zw.length;i++){
					zw[i].style.height=height+"px";
				}
				
				break;
			case "closead":
				var posid = msg[1];
				var adbox = document.getElementsByClassName("a324_"+posid);
				for(i=0;i<adbox.length;i++){
					adbox[i].style.display="none";
				}
				
				break;
			default:
				break;
		}
	}
}
function getStyle(ele) {  
    var style = null;     
    if(window.getComputedStyle) {    
        style = window.getComputedStyle(ele, null);  
    }else{
        style = ele.currentStyle;  
    }     
    return style;
}