<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product	=	wc_get_product( get_the_ID() );
?>
<a class="btn btn-theme" target="_blank" href="<?php echo esc_url( $product->get_product_url() ); ?>" rel="nofollow">
    <i class="fa fa-rocket" aria-hidden="true"></i> <span id="cart_msg"><?php echo esc_html( $product->get_button_text() ); ?></span>
</a>