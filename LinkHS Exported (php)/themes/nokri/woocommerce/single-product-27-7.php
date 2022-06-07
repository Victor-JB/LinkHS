<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();
while (have_posts()) : the_post();
    ?>
    <section class="dwt_listing_shop-container-single">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <?php get_template_part('woocommerce/product-detail/gallery'); ?>
                    </div>
                    <div class="dwt_listing_product-details col-lg-7 col-sm-6 col-xs-12">
                        <?php if (get_the_title() != '') { ?>
                            <div class="dwt_listing_product-title">
                                <h1><?php echo get_the_title(); ?></h1>
                            </div>
                        <?php } ?>
                        <?php get_template_part('woocommerce/product-detail/total_reviews'); ?>
                        <div class="price-section">
                            <?php echo '' . $product->get_price_html(); ?>
                        </div>
                        <?php get_template_part('woocommerce/product-detail/product_info'); ?> 
                        <?php get_template_part('woocommerce/product-detail/desc'); ?>
                        <?php
                        //\\ do_action( 'woocommerce_single_product_summary' );

                        if ($product->get_type() == 'external') {
                            get_template_part('woocommerce/product-type/external');
                        }
                        if ($product->get_type() == 'grouped') {
                            do_action('woocommerce_before_single_product');
                            get_template_part('woocommerce/product-type/grouped');
                        }
                        if ($product->get_type() == 'variable') {
                            do_action('woocommerce_before_single_product');
                            get_template_part('woocommerce/product-type/variable');
                        }
                        if ($product->get_type() == 'simple') {
                            do_action('woocommerce_before_single_product');
                            get_template_part('woocommerce/product-type/add_cart_btn');
                        }
                        ?>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <?php get_template_part('woocommerce/product-detail/specifications'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (dwt_listing_text('related_products') == 1) { ?>
        <?php
        $cats = wp_get_post_terms(get_the_ID(), 'product_cat');
        if (!empty($cats)) {
            $categories = array();
            foreach ($cats as $cat) {
                $categories[] = $cat->term_id;
            }
            $loop_args = array(
                'post_type' => 'product',
                'posts_per_page' => dwt_listing_text('max_related_products'),
                'order' => 'DESC',
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $categories
            )));
            $related_products = new WP_Query($loop_args);
            if ($related_products->have_posts()) {
                ?>
                <section id="dwt_listing_products-related" >
                    <div class="container">
                        <div class="row">
                            <?php if (dwt_listing_text('related_products_title') != '') { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="heading-2 left">
                                        <h2><?php echo dwt_listing_text('related_products_title'); ?></h2>
                                    </div>
                                </div>
                            <?php } ?>   
                            <div class="col-md-12 col-sm-12 col-xs-12 products ">
                                <div  class="related-produt-slider owl-carousel owl-theme">
                                    <?php
                                    $productz = new dwt_listing_products_shop();
                                    $layout_type = 'shop_slider';
                                    $fetch_products = '';
                                    while ($related_products->have_posts()) {
                                        $related_products->the_post();
                                        $product_id = get_the_ID();
                                        $function = "dwt_listing_shop_listings_$layout_type";
                                        echo '' . $fetch_products = $productz->$function($product_id);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } wp_reset_postdata(); ?>        
        <?php } ?>        
    <?php } ?>        
    <?php
endwhile; // end of the loop.        
get_footer();
?>