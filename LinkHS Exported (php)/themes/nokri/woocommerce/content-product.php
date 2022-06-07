<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
$sale_banner = '';
if ($product->is_on_sale()) {
    $sale_banner = '<span class="prod-sale-banner">' . esc_html__('Sale', 'nokri') . '</span>';
}
?>
<li class="col-md-4 masonery_item">
    <div class="dwt_listing_shop-grid foo">
        <?php do_action('woocommerce_before_shop_loop_item'); ?>
        <div class="dwt_listing_shop-grid-description">
            <div class="shop-img-rapper">
                <?php
                echo '' . $sale_banner;
//do_action( 'woocommerce_before_shop_loop_item_title' );
                $img = $product->get_image_id();
                $photo = wp_get_attachment_image_src($img, 'dwt_listing_woo-thumb');
                if ($photo != '') {
                    if ($photo[0] != "") {
                        ?>
                        <img class="img-responsive" alt="<?php echo get_the_title(get_the_ID()); ?>" src="<?php echo esc_url($photo[0]); ?>">
                        <?php
                    }
                } else {
                    ?>
                    <img class="img-responsive " alt="<?php echo get_the_title(get_the_ID()); ?>" src="<?php echo esc_url(wc_placeholder_img_src()); ?>">
                    <?php
                }
                ?>
                <figcaption>
                    <div><i class="ti-eye"></i></div>
                </figcaption>
            </div>
            <?php
            echo '<div class="title-wrapper">';
            do_action('woocommerce_shop_loop_item_title');
            echo '</div>';
            echo '<div class="price-wrapper">';
            do_action('woocommerce_after_shop_loop_item_title');
            echo '</div>';
            ?>
        </div>
        <?php do_action('woocommerce_after_shop_loop_item'); ?>
    </div>
</li>