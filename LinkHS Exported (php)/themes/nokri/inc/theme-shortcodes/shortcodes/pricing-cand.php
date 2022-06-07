<?php

/* ------------------------------------------------ */
/* Pricing Modern */
/* ------------------------------------------------ */
if (!function_exists('price_classic_short_cand')) {

    function price_classic_short_cand() {
        vc_map(array(
            "name" => __("Candidate Pricing", 'nokri'),
            "base" => "price_classic_short_cand_base",
            "category" => __("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('cand_pricing.png') . __('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Background Options", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select background colour", 'nokri'),
                    "param_name" => "section_background",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Option', 'nokri') => '',
                        esc_html__('White', 'nokri') => '',
                        esc_html__('Light Gray', 'nokri') => 'light-grey',
                    ),
                ),
                array(
                    "group" => esc_html__("Background Options", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select layout ", 'nokri'),
                    "param_name" => "section_layout",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Option', 'nokri') => '',
                        esc_html__('Style 1', 'nokri') => '1',
                        esc_html__('Style 2', 'nokri') => '2',
                    ),
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
                    "heading" => __("Validity text", 'nokri'),
                    "param_name" => "validity_text",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Jobs applied text", 'nokri'),
                    "param_name" => "jobs_applied_text",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => __("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Featured Profile text", 'nokri'),
                    "param_name" => "featured_profile_text",
                    "value" => "",
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
                            "value" => nokri_get_products_cand(),
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Package Description", 'nokri'),
                            "param_name" => "package_description",
                            "value" => "",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'price_classic_short_cand');
if (!function_exists('price_classic_short_cand_base_func')) {

    function price_classic_short_cand_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'woo_products' => '',
            'section_title' => '',
            'section_background' => '',
            'section_description' => '',
            'section_layout' => '',
            'validity_text' => '',
            'jobs_applied_text' => '',
            'featured_profile_text' => '',
                        ), $atts));
        $rows = vc_param_group_parse_atts($woo_products);
        $categories_html = '';
        $html = '';
        if (class_exists('WooCommerce')) {
            if (count($rows) > 0) {
                $count = 1;
                foreach ($rows as $row) {
                    /* Section title */
                    $section_layout = (isset($section_layout) && $section_layout != "") ? $section_layout : "";
                    /* Validity title */
                    $validity = (isset($validity_text) && $validity_text != "") ? $validity_text : esc_html__('Validity', 'nokri');
                    /* Jobs applied title */
                    $Jobs_applied = (isset($jobs_applied_text) && $jobs_applied_text != "") ? $jobs_applied_text : esc_html__('Number Of Jobs', 'nokri');
                    /* Featured profile title */
                    $featured_profile = (isset($featured_profile_text) && $featured_profile_text != "") ? $featured_profile_text : esc_html__('Featured Profile For', 'nokri');
                    if (isset($row['product'])) {
                        $product = wc_get_product($row['product']);
                        if (!empty($product)) {
                            /* Jobs Expiry */
                            $li = '';
                            if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                                $li .= '<li><i class="la la-check"></i>' . $validity . ': ' . __('Lifetime', 'nokri') . '</li>';
                            } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {

                                $li .= '<li>' . $validity . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'nokri') . '</li>';
                            }
                            /* Apply on jobs */
                            if (get_post_meta($row['product'], 'candidate_jobs', true)) {
                                if (get_post_meta($row['product'], 'candidate_jobs', true) == '-1') {
                                    $li .= '<li>' . $Jobs_applied . ': ' . __('Unlimited', 'nokri') . '</li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_jobs', true)) {
                                        $li .= '<li>' . $Jobs_applied . ': ' . get_post_meta($row['product'], 'candidate_jobs', true) . '</li>';
                                    }
                                }
                            }
                            /* Featured Porfile for days */
                            if (get_post_meta($row['product'], 'candidate_feature_list', true)) {
                                if (get_post_meta($row['product'], 'candidate_feature_list', true) == '-1') {
                                    $li .= '<li>' . $featured_profile . ': ' . __('Unlimited Days', 'nokri') . '</li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_feature_list', true)) {
                                        $li .= '<li>' . $featured_profile . ': ' . get_post_meta($row['product'], 'candidate_feature_list', true) . " " . __('Days', 'nokri') . '</li>';
                                    }
                                }
                            }
                            $sale = get_post_meta($row['product'], '_sale_price', true);
                            /* pkg Details */
                            $pkg_details = (isset($row['package_description']) && $row['package_description'] != "") ? '<p>' . $row['package_description'] . '</p>' : "";
                            /* Package  Color */
                            $pkg_clrs = (isset($row['pkg_clr']) && $row['pkg_clr'] != "") ? $row['pkg_clr'] : "";
                            /* Is Free package */
                            $is_pkg_free = get_post_meta($row['product'], 'op_pkg_typ', true);
                            if ($is_pkg_free) {
                                $price_html = " " . '(' . esc_html__('Free', 'nokri') . ')';
                            } else {
                                $price_html = '';
                            }
                            /* Layout selection */
                            if ($section_layout == 1) {
                                $currency = '';
                                if (!$is_pkg_free) {
                                    $currency = '<div class="price"><small>' . get_woocommerce_currency_symbol() . '</small>' . $product->get_price() . '</div>';
                                }
                                $html .= '<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12">
											<div class="pricing-item">
											' . $currency . '
										  <strong>' . get_the_title($row['product']) . '<span class="hidden-sm">' . $price_html . '</span></strong>
										  ' . $pkg_details . '
										  <ul class="cand-pricing">' . $li . '</ul>
										  <div class="sb_add_cart_cand" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri') . '</a> </div></div></div>';
                            } else {
                                $currency = '';
                                if (!$is_pkg_free) {
                                    $currency = '<div class="price-large"> <span class="dollartext">' . get_woocommerce_currency_symbol() . '</span>' . $product->get_price() . '</div>';
                                }
                                $html .= '<div class="col-sm-6 col-lg-4 col-md-4 col-xs-12">
											   <div class="pricing-fancy ">
												  <div class="icon-bg"><i class="flaticon-money-2"></i></div>
												  <h3><strong>' . get_the_title($row['product']) . '</strong> <span class="thin">' . $price_html . '</span></h3>
												  <div class="price-box">
													 ' . $currency . '
													 ' . $pkg_details . '
										  			 <ul class="cand-pricing">' . $li . '</ul>
													 <div class="sb_add_cart_cand" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri') . '</a></div> 
												  </div>
											   </div>
											</div>';
                            }
                        }
                        $count++;
                    }
                }
            }
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";
        /* Section description */
        $section_description = (isset($section_description) && $section_description != "") ? '<p>' . $section_description . '</p>' : "";
        /* Section background */
        $section_background = (isset($section_background) && $section_background != "") ? $section_background : "";
        return '<section class="custom-padding ' . esc_attr($section_background) . '">
				<!-- Main Container -->
				<div class="container">
					<!-- Row -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="heading-title black">' . $section_title . ' ' . $section_description . '</div>
						</div>
						<!-- Middle Content Box -->
						<div class="col-md-12 col-xs-12 col-sm-12">
							<div class="row">' . $html . '</div>
						</div>
					</div>
					<!-- Row End -->
				</div>
				<!-- Main Container End -->
			</section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('price_classic_short_cand_base', 'price_classic_short_cand_base_func');
}