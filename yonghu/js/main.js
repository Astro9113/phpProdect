$(function(){
  
  $(".rbox4_l .t").click(function(){
	  $(this).parent(".rbox4_l").children("div.m").slideToggle();
  });
  
  $(".rbox7_l .t").click(function(){
	  $(this).parent(".rbox7_l").children("div.m").slideToggle();
  });
	
  $(".select1 .t").click(function(){
	  $(this).parent(".select1").children("div.m").slideToggle();
  });
	
  $(".rtable tr:odd").css("background-color","#fff");
  $(".rtable tr:even").css("background-color","#f6f6f6");
	
  $(".rtable3 tr:odd").css("background-color","#fff");
  $(".rtable3 tr:even").css("background-color","#f6f6f6");
	
    $(".select4 .t").click(function(){
	  $(this).parent(".select4").children("div.m").slideToggle();
  });
  
  $(".select4 .m a").click(function(){
	  $(".select4 .m").hide();
	  $(".select4 .t").html($(this).text());  
  });
  
});


$(document).ready(function(){
	
	$(".input_v").blur(function(){ 
		$(this).removeClass("input_vs");   
		if($(this).val()==""){   
		$(this).val(this.defaultValue);   
		}
	}).focus(function(){
		$(this).addClass("input_vs");
		if($(this).val()==this.defaultValue){   
		$(this).val("");   
		}
	}); 

  
	if ( $(".mainr").height()<$(".mainl").height() ){
	  $(".mainr").height($(".mainl").height()+50)
	}
});