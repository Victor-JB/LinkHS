<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Pricing_Cand extends Widget_Base {

    public function get_name() {
        return 'Pricing-cand';
    }

    public function get_title() {
        return __('Pricing Candidates', 'nokri-elementor');
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
                'bg_section',
                [
                    'label' => __('Background options', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_background',
                [
                    'label' => __('Section Background', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Sky BLue', 'nokri-elementor') => 'light-grey',
                        esc_html__('White', 'nokri-elementor') => '',
                            )),
                ]
        );

        $this->add_control(
                'section_layout',
                [
                    'label' => __('Section Layout', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Style 1', 'nokri-elementor') => '1',
                        esc_html__('Style 2', 'nokri-elementor') => '2',
                            )),
                ]
        );
        $this->end_controls_section();

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
                'validity_text',
                [
                    'label' => __('Validity txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'jobs_applied_text',
                [
                    'label' => __('Jobs applied text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'featured_profile_text',
                [
                    'label' => __('Featured Profile text', 'nokri-elementor'),
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
                    'options' => array_flip(nokri_get_products_cand()),
                ]
        );
        $repeater->add_control(
                'package_description',
                [
                    'label' => __('product Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
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
        $rows = $woo_products;
        $categories_html = '';
        $html = '';
        if (class_exists('WooCommerce')) {
            if (count($rows) > 0) {
                $count = 1;
                foreach ($rows as $row) {
                    /* Section title */
                    $section_layout = (isset($section_layout) && $section_layout != "") ? $section_layout : "";
                    /* Validity title */
                    $validity = (isset($validity_text) && $validity_text != "") ? $validity_text : esc_html__('Validity', 'nokri-elementor');
                    /* Jobs applied title */
                    $Jobs_applied = (isset($jobs_applied_text) && $jobs_applied_text != "") ? $jobs_applied_text : esc_html__('Number Of Jobs', 'nokri-elementor');
                    /* Featured profile title */
                    $featured_profile = (isset($featured_profile_text) && $featured_profile_text != "") ? $featured_profile_text : esc_html__('Featured Profile For', 'nokri-elementor');
                    if (isset($row['product'])) {
                        $product = wc_get_product($row['product']);
                        if (!empty($product)) {
                            /* Jobs Expiry */
                            $li = '';
                            if (get_post_meta($row['product'], 'package_expiry_days', true) == "-1") {
                                $li .= '<li><i class="la la-check"></i>' . $validity . ': ' . __('Lifetime', 'nokri-elementor') . '</li>';
                            } else if (get_post_meta($row['product'], 'package_expiry_days', true) != "") {

                                $li .= '<li>' . $validity . ': ' . get_post_meta($row['product'], 'package_expiry_days', true) . ' ' . __('Days', 'nokri-elementor') . '</li>';
                            }
                            /* Apply on jobs */
                            if (get_post_meta($row['product'], 'candidate_jobs', true)) {
                                if (get_post_meta($row['product'], 'candidate_jobs', true) == '-1') {
                                    $li .= '<li>' . $Jobs_applied . ': ' . __('Unlimited', 'nokri-elementor') . '</li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_jobs', true)) {
                                        $li .= '<li>' . $Jobs_applied . ': ' . get_post_meta($row['product'], 'candidate_jobs', true) . '</li>';
                                    }
                                }
                            }
                            /* Featured Porfile for days */
                            if (get_post_meta($row['product'], 'candidate_feature_list', true)) {
                                if (get_post_meta($row['product'], 'candidate_feature_list', true) == '-1') {
                                    $li .= '<li>' . $featured_profile . ': ' . __('Unlimited Days', 'nokri-elementor') . '</li>';
                                } else {
                                    if (get_post_meta($row['product'], 'candidate_feature_list', true)) {
                                        $li .= '<li>' . $featured_profile . ': ' . get_post_meta($row['product'], 'candidate_feature_list', true) . " " . __('Days', 'nokri-elementor') . '</li>';
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
                                $price_html = " " . '(' . esc_html__('Free', 'nokri-elementor') . ')';
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
										  <div class="sb_add_cart_cand" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri-elementor') . '</a> </div></div></div>';
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
													 <div class="sb_add_cart_cand" data-product-is-free = "' . esc_attr($is_pkg_free) . '" data-product-id="' . $row['product'] . '" data-product-qty="1"> <a href="javascript:void(0)" class="btn n-btn-flat">' . __('Select Plan', 'nokri-elementor') . '</a></div> 
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
        echo '<section class="custom-padding ' . esc_attr($section_background) . '">
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
