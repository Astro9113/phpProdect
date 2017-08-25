$(document).ready(function(){
	$('.menu dl').has('dd').not('.cur').find('dt').click(function(){
	$(this).blur();
	o=$(this).parent();
	o.toggleClass('expand');
	});
	
	$("tr:odd").css('background-color','#ffffff');
	$("tr:even").css('background-color','#f5ffe4');
});


function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function statbzxs(targetid){    
 if (document.getElementById){target=document.getElementById(targetid);            
  if (target.style.display=="block")
  {target.style.display="none";} 
  else {target.style.display="block";} 
 }
}

$(function() { 
	$('#box0').click(function() {
		if(this.checked){ 
			$("input[name^='box']").attr('checked', true)
		}else{ 
			$("input[name^='box']").attr('checked', false)
		} 
	}); 
});


