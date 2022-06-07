<div class="dwt_listing_single-product">
<?php
defined( 'ABSPATH' ) || exit;
global  $product;
$full_img = $get_img_thumb = $product_id = '';
$product_id = get_the_ID();
$product = wc_get_product( $product_id );

$sale_banner = '';
if( $product->is_on_sale() ) {
	$sale_banner = '<span class="prod-sale-banner">'.esc_html__('Sale','nokri').'</span>';
}
if( $product->get_image_id() != "")
{
?>
   <div class="produt-slider owl-carousel owl-theme">
    <?php	
	$fetch_images =  nokri_fetch_product_images($product_id); 
	foreach( $fetch_images as $product_images )
	{
		$full_img =	wp_get_attachment_image_src( $product_images ,'full' );
		$get_img_thumb =	wp_get_attachment_image_src( $product_images ,'dwt_listing_woo-single-thumb' );		
	?>
            <div class="item">
            	<?php echo ''.$sale_banner; ?>
                <a href="<?php echo esc_url( $full_img[0]); ?>" data-fancybox="group"><img class="img-responsive" src="<?php echo esc_url( $get_img_thumb[0]); ?>" alt="<?php esc_html__( 'nokri', 'nokri' ); ?>"></a>
            </div>
    <?php 	
	}
	?>
    </div>
<?php
}
else
{
?>
<?php echo ''.$sale_banner; ?>
<img class="img-responsive" alt="<?php esc_html__( 'nokri', 'nokri' ); ?>" src="<?php echo esc_url( wc_placeholder_img_src() ); ?>">
<?php
}
?>
</div>
