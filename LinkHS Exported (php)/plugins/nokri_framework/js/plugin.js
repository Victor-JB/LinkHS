(function($) {
	"use strict";

	$('#ad_catsdiv').hide();
	$('#ad_tagsdiv').hide();
	$('#ad_conditiondiv').hide();
	$('#ad_typediv').hide();
	$('#ad_warrantydiv').hide();
	$('#ad_currencydiv').hide();
	$('#ad_countrydiv').hide();
	
	
})( jQuery );
function nokri_fresh_install()
{
		 var is_fresh_copy =	confirm("Are you installating it with fresh copy of WordPress? Please only select OK if it is fresh installation.");
		 if( is_fresh_copy )
		 {
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: { action: 'demo_data_start' , is_fresh: 'yes' }
				}).done(function( msg ) {
				//alert( msg );
			});
			///////////////////////
		 }
}