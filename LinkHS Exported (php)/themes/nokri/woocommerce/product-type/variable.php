<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$attributes = $product->get_variation_attributes();
$attribute_keys = array_keys( $attributes );
$available_variations = $product->get_available_variations();

// making varitions for JS
$com_options	=	array();
foreach( $available_variations as $variation )
{
	if( $variation['variation_is_active'] == 1 )
	{
		$values	=	'';
		foreach( $variation['attributes'] as $val )
		{
			$values .=  str_replace(' ', '', $val) . '_';
		}
		$com_options[$values] =  $variation['display_price'] . '-' . $variation['display_regular_price'] . '-' . $variation['variation_id'];
	}

}
foreach( $com_options as $index => $value )
{
	?>
    	<input type="hidden" id="<?php echo esc_attr( $index ); ?>" value="<?php echo esc_attr( $value ); ?>" />
    <?php 	
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="alert custom-alert custom-alert--warning hidden" id="v_msg" role="alert">
          <div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
            <div class="custom-alert__body">
              <h6 class="custom-alert__heading">
               <?php echo esc_html__('No Combination Found.', 'nokri'); ?>
              </h6>
              <div class="custom-alert__content">
                <?php echo esc_html__("This product is currently out of stock and unavailable.", 'nokri'); ?>
              </div>
            </div>
          </div>
        </div>
<form class="variations_form cart" action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
    
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html__( 'This product is currently out of stock and unavailable.', 'nokri' ); ?></p>
	<?php else : ?>
    <div class="row">
        <div class="variations">
        <?php foreach ( $attributes as $attribute_name => $options ) : ?>
         	<div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
             <label for="<?php echo sanitize_title( $attribute_name ); ?>" class="control-label"><?php echo wc_attribute_label( $attribute_name ); ?></label>
			<?php
                $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
                wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected , 'class' => 'shop_variation' ) );
            ?>
            </div>
        <?php endforeach;?>
        </div>
	</div>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<div class="single_variation_wrap">
        <div id="new_sale_price"></div>
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );
				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				 do_action( 'woocommerce_single_variation' );
				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>
	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' ); ?>