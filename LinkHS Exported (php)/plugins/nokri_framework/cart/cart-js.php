<?php
function sb_add_to_cart_func()
{
?>
	<script type="text/javascript">
 (function($) {
	"use strict";
        $('.sb_variation').on('change', function()
        {
            var get_var	=	'';
            $( ".sb_variation" ).each(function() {
                var val	=	$( this ).val();
                get_var	= get_var + val.replace(/\s+/g, '') + '_';
            });
            var res	=	$('#' + get_var ).val();
			
            var arr = res.split("-");
            var sale_price	=	arr[0];
            var old_price	=	arr[1];
            var vid	=	arr[2];
            if( sale_price == "0" )
            {
                $('#v_msg').html( '<?php echo crane_translate( 'variation_not_available' ); ?>' );
                $('#sale_price').html('');
                $('#old_price').html('');
				$('#sb_add_to_cart').hide();
				$('#quantity').hide();
				$('#product_qty').hide();
            }
            else
            {
                $('#sale_price').html( '<?php echo get_woocommerce_currency_symbol(); ?>' + sale_price );
                $('#old_price').html('<?php echo get_woocommerce_currency_symbol(); ?>' + old_price );
                $('#v_msg').html('');
				$('#sb_add_to_cart').show();
				$('#quantity').show();
				$('#product_qty').show();
            }
            $('#variation_id').val( vid );
        });
        $( ".sb_variation" ).trigger( "change" );
        
        $('#sb_add_to_cart').on('click', function()
        {
			if( $('#cart_msg').html() != 'Adding...' )
			{
				$('#cart_msg').html( "<?php echo crane_translate( 'adding_to_cart' ); ?>" );
				
				//Getting values
				var variation_id	=	$('#variation_id').val();
				var pid	=	$('#product_id').val();
				var qty	=	$('#product_qty').val();
				$.post('<?php echo admin_url('admin-ajax.php'); ?>',
				{action : 'sb_cart' , product_id:pid, qty:qty,variation_id:variation_id   }).done(function(response) 
				{
					
					$('#cart_msg').html( "<?php echo crane_translate( 'add_to_cart' ); ?>" );
					if( response != 0 )
					{ 
					var cart_url	=	'';
					 <?php
					 if ( class_exists( 'WooCommerce' ) )
					 {
					 ?>
					 var cart_url	=	'<br /><a href="<?php echo get_permalink( WC_Admin_Settings::get_option( 'woocommerce_cart_page_id' ) ); ?>"><?php echo crane_translate( 'view_cart' ); ?></a>';
					 <?php
					 }
					 ?>
						toastr.success('<?php echo crane_translate( 'cart_success_msg' ); ?>'+cart_url, '<?php echo crane_translate( 'cart_success' ); ?>!', {timeOut: 10000,"closeButton": true, "positionClass": "toast-bottom-right"})	
					}
					else
					{
						toastr.error('<?php echo crane_translate( 'cart_error_msg' ); ?>', '<?php echo crane_translate( 'cart_error' ); ?>!', {timeOut: 15000,"closeButton": true, "positionClass": "toast-bottom-right"})	
	
					}
				});
			}

        });
})( jQuery );
    </script>
<?php	
}
add_action( 'wp_footer', 'sb_add_to_cart_func' );

// Ajax handler for add to cart
add_action( 'wp_ajax_sb_cart', 'sb_chimppro_add_to_cart' );
add_action( 'wp_ajax_nopriv_sb_cart', 'sb_chimppro_add_to_cart' );

function sb_chimppro_add_to_cart()
{
	$product_id	= $_POST['product_id'];
	$qty	=	$_POST['qty'];
	$variation_id	=	$_POST['variation_id'];
	global $woocommerce;
	if( $variation_id != 0 )
	{
		echo $woocommerce->cart->add_to_cart($product_id, $qty, $variation_id);
	}
	else
	{
		echo $woocommerce->cart->add_to_cart($product_id, $qty);
	}
	die();
}
