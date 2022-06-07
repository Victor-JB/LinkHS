<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $product;
?>

<div class="usefull-info">
    <ul class="list-unstyled">
        <?php if (wc_get_product_category_list($product->get_id()) != '') { ?>
            <li><?php echo esc_html__('Category : ', 'nokri'); ?> <span><?php echo wc_get_product_category_list($product->get_id()); ?></span></li>
        <?php } ?>
        <?php if (wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') )) { ?>
            <li><?php echo esc_html__('SKU', 'nokri'); ?> : <span><?php echo ''.( $sku = $product->get_sku() ) ? $sku : esc_html__('N/A', 'nokri'); ?></span></li>
        <?php } ?>
        <?php
        $stock = esc_html__('Out of stock', 'nokri');
        if ($product->is_in_stock()) {
            $stock = esc_html__('In stock', 'nokri');
        }
        ?>
        <li><?php echo esc_html__('Availability', 'nokri'); ?> : <span><?php echo esc_attr($stock); ?></span></li>
        <?php if (wc_get_product_tag_list($product->get_id()) != '') { ?>
            <li><?php echo esc_html__('Tags : ', 'nokri'); ?><span><?php echo wc_get_product_tag_list($product->get_id()); ?></span></li>
        <?php } ?>
    </ul>
</div>
<div class="clearfix"></div>