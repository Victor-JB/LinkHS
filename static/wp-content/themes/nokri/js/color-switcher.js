(function($) {
    "use strict";
		  $("#defualt" ).on('click',function(){
			  $("#color" ).attr("href", "css/colors/defualt.css");
			  return false;
		  });
		  
		  $("#yellow" ).on('click',function(){
			  $("#color" ).attr("href", "css/colors/yellow.css");
			  return false;
		  });
		   /*picker buttton*/
		  $(".picker_close").on('click',function(){
			  	$("#choose_color").toggleClass("position");
		   });
		   $(".picker_close").on('click',function(){
			  	$(".picker_close i").toggleClass("rotate-arrow");
		   });

		  
})(jQuery);