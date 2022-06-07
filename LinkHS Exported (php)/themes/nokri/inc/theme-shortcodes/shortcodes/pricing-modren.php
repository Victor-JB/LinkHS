<?php

/* ------------------------------------------------ */
/* Pricing Modern */
/* ------------------------------------------------ */
if (!function_exists('price_modern_short')) {

    function price_modern_short() {
        vc_map(array(
            "name" => __("Pricing Modern", 'nokri'),
            "base" => "price_modern_short_base",
            "category" => __("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('pricing-modrens.png') . __('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => __("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Title", 'nokri'),
                    "param_name" => "section_title",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "nokri"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Section Description", 'nokri'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Jobs Text", 'nokri'),
                    "param_name" => "section_job_txt",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                    (
                    'group' => __('Products', 'nokri'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'nokri'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Product", 'nokri'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => nokri_get_products(),
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Description", 'nokri'),
                            "param_name" => "pkg_description",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Image", 'nokri'),
                            "param_name" => "product_bg_img",
                            "description" => esc_html__('370 x 520', 'nokri'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'price_modern_short');
if (!function_exists('price_modern_short_base_func')) {

    function price_modern_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'woo_products' => '',
            'section_title' => '',
            'section_background' => '',
            'section_description' => '',
            'section_job_txt' => '',
            'section_bg' => '',
            'prcing_bg_img' => '',
            'product_bg_img' => '',
                        ), $atts));

        $user_id = get_current_user_id();
        $user_type = get_user_meta($user_id, '_sb_reg_type', true);
        $pkg_updated = get_user_meta($user_id, 'pkg_updated', true);
        /* Is applying job package base */
        global $nokri;
        $is_apply_pkg_base = ( isset($nokri['job_apply_package_base']) && $nokri['job_apply_package_base'] != "" ) ? $nokri['job_apply_package_base'] : false;
        if ($is_apply_pkg_base && !$pkg_updated && $user_type != '0') {
            /* update products */
            echo nokri_update_products();
        }
        /* Section Job text */
        $section_title_for_job = (isset($section_job_txt) && $section_job_txt != "") ? $section_job_txt : esc_html__('Jobs', 'nokri');

        $rows = vc_param_group_parse_atts($woo_products);
        $categories_html = '';
        $html = '';
        if (class_exists('WooCommerce')) {
            if (count($rows) > 0) {
                $count = 1;
                foreach ($rows as $row) {
                    if (isset($row['product'])) {
                        $product = wc_get_product($row['product']);
                        if (!empty($product)) {
                            /* Jobs Expiry */
                            $li = '';
                            if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                                $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Validity', 'nokri') . ': ' . __('Lifetime', 'nokri') . '</span></li>';
                            } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {

                                $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Validity', 'nokri') . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'nokri') . '</span></li>';
                            }

                            /* Getting candidate search */
                            if (get_post_meta($row['product'], 'is_candidates_search', true)) {
                                if (get_post_meta($row['product'], 'candidate_search_values', true) == '-1') {
                                    $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Candidates Search', 'nokri') . ': ' . __('Unlimited', 'nokri') . '</span></li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_search_values', true)) {
                                        $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Candidates Search', 'nokri') . ': ' . get_post_meta($row['product'], 'candidate_search_values', true) . '</span></li>';
                                    }
                                }
                            }
                           
                            if ((isset($nokri['allow_bump_jobs'])) && $nokri['allow_bump_jobs']) {
                            
                            $bump_ads_limit = get_post_meta($row['product'], 'pack_bump_ads_limit', true);
                                if ($bump_ads_limit == '-1') {
                                    $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Bump up Jobs', 'nokri') . ': ' . __('Lifetime', 'nokri'). '</span></li>';
                                } else {
                                    if ($bump_ads_limit != "") {
                                        $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' .  __('Bump up Jobs', 'nokri') . ': ' . $bump_ads_limit . '</span></li>';
                                    }
                                }
                            
                            }                        
                            $feature_profile = get_post_meta($row['product'], 'pack_emp_featured_profile', true);
                                if ($feature_profile == '-1') {
                                    $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . esc_html__( 'Featured profile', 'nokri' ) . ': ' . __('Lifetime', 'nokri'). '</span></li>';
                                } else {
                                    if ($feature_profile != "") {
                                        $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Featured profile', 'nokri') . ': ' . $feature_profile . ' ' . __('Days', 'nokri') . '</span></li>';
                                    }
                                }                       

                            $table = '';
                            $c_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
                            if (count($c_terms) > 0) {
                                $table = '';
                                foreach ($c_terms as $c_term) {
                                    $meta_name = 'package_job_class_' . $c_term->term_id;
                                    $meta_value = get_post_meta($row['product'], $meta_name, true);
                                    $meta_value =  $meta_value == "-1"  ?   esc_html__("Unlimited","nokri") : $meta_value;
                                    if ($meta_value != "") {
                                        $table .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . $meta_value . " " . ucfirst($c_term->name) . ' ' . $section_title_for_job . '</span></li>';
                                    }
                                }
                            }
                            $sale = get_post_meta($row['product'], '_sale_price', true);
                            /* pkg Details */
                            $pkg_details = (isset($row['pkg_description']) && $row['pkg_description'] != "") ? '<p>' . $row['pkg_description'] . '</p>' : "";
                            /* pkg Link */
                            $read_more = '';
                            if (isset($row['link']))
                                $read_more = nokri_ThemeBtn($row['link'], 'btn', false);
                            /* Package  Color */
                            $pkg_clrs = (isset($row['pkg_clr']) && $row['pkg_clr'] != "") ? $row['pkg_clr'] : "";


                            /* product image */
                            $product_img = '';
                            if (isset($row['product_bg_img']) && $row['product_bg_img'] != "") {
                                $product_imgeURL = nokri_returnImgSrc($row['product_bg_img']);
                                $product_img = ( $product_imgeURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $product_imgeURL . ')  no-repeat; -webkit-background-size: contain; -moz-background-size: contain; -o-background-size: contain; background-size: contain; background-position: bottom center; background-attachment:scroll;"' : "";
                            }

                            if ($count == 2) {
                                $id_price = 'featured-price';
                            } else {
                                $id_price = '';
                            }
                            /* Is Free package */
                            $is_pkg_free = get_post_meta($row['product'], 'op_pkg_typ', true);
                            if ($is_pkg_free) {
                                $price_html = '<div class="nth-pack-primium">' . esc_html__('Free', 'nokri') . '</div>';
                            } else {
                                
                                $price_html = '<div class="nth-pack-primium"><span class="n-ex">' . get_woocommerce_currency_symbol() . "</span> " . $product->get_price() . '</div>';
                            }

                            $html .= '<div class="col-lg-4 col-xs-12 col-md-4 col-sm-4">
									<div class="nth-pck-table" ' . str_replace('\\', "", $product_img) . '>
								<div class="nth-pckg-content">
									' . $price_html . '
									<span>' . get_the_title($row['product']) . '</span>
									' . $pkg_details . '
								</div>
								<div class="nth-pck-details">
									<ul>
									' . $li . '
									' . $table . '
									</ul>
									<div class="sb_add_cart" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri') . '</a> </div>
								</div>
								</div>
								</div>';
                        }
                        $count++;
                    }
                }
            }
        }

        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h3>' . $section_title . '</h3>' : "";
        /* Section description */
        $section_description = (isset($section_description) && $section_description != "") ? '<p>' . $section_description . '</p>' : "";
        return '<section class="nth-packages"> 
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
			<div class="heading-penel">
				' . $section_title . '
				' . $section_description . '
			</div>
		</div>
		' . $html . '
	</div>
</div>
 </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('price_modern_short_base', 'price_modern_short_base_func');
}