<?php
global $product;
?>

<div class="dwt_listing_product-single-detial">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs clearfix" role="tablist">
        <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><?php echo esc_html__('Description', 'nokri'); ?></a></li>
        <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><?php echo esc_html__('Reviews', 'nokri'); ?></a></li>
        <?php 
        $product = wc_get_product(get_the_ID());
        $attributes = $product->get_attributes();
        if (is_array($attributes) && count($attributes) > 0) {
            ?>
            <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"><?php echo esc_html__('Additional Information', 'nokri'); ?></a></li>
            <?php
        }
        ?>
    </ul>

    <div class="tab-content clearfix">
        <div role="tabpanel" class="tab-pane active" id="Section1">
            <?php the_content(); ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="Section2">
            <div class="comments">
                <?php comments_template('', true); ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="Section3">
            <?php do_action('woocommerce_product_additional_information', $product); ?>
        </div>

    </div>
</div>