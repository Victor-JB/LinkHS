<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Pricing_Modern_Sec extends Widget_Base {

    public function get_name() {
        return 'Pricing-modern';
    }

    public function get_title() {
        return __('Pricing Modern', 'nokri-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }

    public function get_categories() {
        return ['nokritheme'];
    }

    public function get_script_depends() {
        return [''];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {




        $this->start_controls_section(
                'basic_section',
                [
                    'label' => __('Basic', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'section_job_txt',
                [
                    'label' => __('Jobs Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'product_section',
                [
                    'label' => __('Products', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'product',
                [
                    'label' => __('Select Product', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(nokri_get_products()),
                ]
        );
        $repeater->add_control(
                'pkg_description',
                [
                    'label' => __('product Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $repeater->add_control(
                'product_bg_img',
                [
                    'label' => __('Product Bg Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('370 x 520', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'woo_products',
                [
                    'label' => __('Select Products', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);
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
        $section_title_for_job = (isset($section_job_txt) && $section_job_txt != "") ? $section_job_txt : esc_html__('Jobs', 'nokri-elementor');

        $rows = $woo_products;
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
                                $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Validity', 'nokri-elementor') . ': ' . __('Lifetime', 'nokri-elementor') . '</span></li>';
                            } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {

                                $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Validity', 'nokri-elementor') . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'nokri-elementor') . '</span></li>';
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
                            /* Getting candidate search */
                            if (get_post_meta($row['product'], 'is_candidates_search', true)) {
                                if (get_post_meta($row['product'], 'candidate_search_values', true) == '-1') {
                                    $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Candidates Search', 'nokri-elementor') . ': ' . __('Unlimited', 'nokri-elementor') . '</span></li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_search_values', true)) {
                                        $li .= '<li><i class="fa fa-check" aria-hidden="true"><span>' . __('Candidates Search', 'nokri-elementor') . ': ' . get_post_meta($row['product'], 'candidate_search_values', true) . '</span></li>';
                                    }
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
                            if (isset($row['product_bg_img']['url'])) {
                                $product_imgeURL = $row['product_bg_img']['url'];
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
                                $price_html = '<div class="nth-pack-primium">' . esc_html__('Free', 'nokri-elementor') . '</div>';
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
									<div class="sb_add_cart" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri-elementor') . '</a> </div>
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
        echo '<section class="nth-packages"> 
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

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {
        
    }

}
