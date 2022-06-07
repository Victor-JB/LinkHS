<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;
if (!$product->is_purchasable()) {
    return;
}
if ($product->is_in_stock()) :
    ?>
    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
        <div class="point-of-action">
                <?php if (!$product->get_sold_individually() == '1') { ?>
                <span class="quantity">
                    <?php
                    woocommerce_quantity_input(array(
                        'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                        'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : $product->get_min_purchase_quantity(),
                    ));
                    ?>
                </span>
            <?php } ?>    
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="btn n-btn-flat"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo esc_html($product->single_add_to_cart_text()); ?></button>
            <?php
            /**
             * @since 2.1.0.
             */
            do_action('woocommerce_after_add_to_cart_button');
            ?>
        </div>
    </form>
    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>