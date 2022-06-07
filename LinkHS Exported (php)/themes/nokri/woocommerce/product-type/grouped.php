<?php
defined( 'ABSPATH' ) || exit;
global $product, $post;
do_action( 'woocommerce_before_add_to_cart_form' ); 

?>
<form class="cart" action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype='multipart/form-data'>
<ul>
<?php
$all_childs = $product->get_children();
if(isset($all_childs) && count((array) $all_childs) > 0)
{
	$price =  $product_slug = $product_name = '';
	foreach($all_childs as $child_prod)
	{
		$_product = wc_get_product($child_prod);
		if(isset($_product) && count((array) $_product) > 0 && !empty($_product))
		{
			$product_name =  $_product->get_name();
			$product_slug = $_product->get_slug();
			$product_id = $_product->get_id();
			$pricing = $_product->get_price_html();
			if ( ! $_product->is_purchasable() || $_product->has_options() || ! $_product->is_in_stock() ) {
				woocommerce_template_loop_add_to_cart();
			}
			elseif($_product->get_sold_individually() == '1') {
			echo '<li><input type="checkbox" name="' . esc_attr( 'quantity[' . $product_id . ']' ) . '" value="1" class="custom-checkbox"></span> <label> <a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink($product_id ), $product_id ) ) . '">' .$product_name . '</a>'.$pricing.'</label></li>';	
			}
			 else {
								do_action( 'woocommerce_before_add_to_cart_quantity' );
								
			echo '<li>';
								woocommerce_quantity_input( array(
									'input_name'  => 'quantity[' . $product_id . ']',
									'input_value' => isset( $_POST['quantity'][ $product_id ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $product_id ] ) ) ) : 0, // WPCS: CSRF ok, input var okay, sanitization ok.
									'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $_product ),
									'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product ),
								) );
								
							echo ' <label> <a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink($product_id ), $product_id ) ) . '">' .$product_name . '</a>'.$pricing.'</label></li>';	
								
								do_action( 'woocommerce_after_add_to_cart_quantity' );
							}
		}
	}	
}
?>
</ul>
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<button type="submit" class="btn btn-theme"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
 	<?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
