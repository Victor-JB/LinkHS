<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
if ( ! $short_description ) {
	return;
}
if($short_description  != ''){
?>      
<div class="product-short-description">
 <h2><?php echo esc_html__('Quick Overview','nokri'); ?></h2>
<?php echo ''.$short_description;  ?>              
</div>
<div class="clearfix"></div>
<?php } ?>
