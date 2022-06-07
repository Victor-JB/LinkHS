<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Location_Images extends Widget_Base {

    public function get_name() {
        return 'job-images';
    }

    public function get_title() {
        return __('Location With Images', 'nokri-elementor');
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
        /* for About Us tab */
        $this->start_controls_section(
                'basic_section',
                [
                    'label' => __('Basic)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_desc',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'Location_section',
                [
                    'label' => __('Location', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'country',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(nokri_get_all('ad_location', 'yes')),
                ]
        );
        $repeater->add_control(
                'country_img',
                [
                    'label' => __('Select Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('190 x 125', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'countries',
                [
                    'label' => __('Select Countries', 'nokri-elementor'),
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

         $cats_html = ''; 
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {
            $rows = $atts['countries'];
            $cats = false;
            $cats_html = '';
            if (count((array) $rows) > 0) {
                $cats_html = '';
                foreach ($rows as $row) {
                    if (isset($row['country'])) {
                        if ($row['country'] == 'all') {
                            $cats = true;
                            break;
                        }
                        $category = get_term_by('slug', $row['country'], 'ad_location');
                        if (count((array) $category) == 0)
                            continue;
                        /* Location Image */
                        $loc_img = '';
                        if (isset($row['country_img']['url'])) {
                            
                            $img_thumb = $row['country_img']['url'];
                            $loc_img = '<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
                        }
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'ad_location');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '<div class="col-lg-3 col-sm-4 col-md-3 col-xs-12">
									<a href="' . nokri_location_page_link($category->term_id) . '">
									<div class="n-location-style"> 
										' . $loc_img . '
										<div class="n-city-location">
										<ul>
										<li>' . $category->name . '</li>
											<li class="n-style2"><span class="badge">' . $custom_count . " " . $count_cat . '</span></li>
										</ul>
										</div>
									</div>
									</a>
								</div>';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('ad_location', 0);
                    /* Location Image */
                    $loc_img = '';
                    if (isset($row['country_img']['url'])) {
                        $img = $row['country_img']['url'];
                        $img_thumb = $img[0];
                        $loc_img = '<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'ad_location');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '<div class="col-lg-3 col-sm-4 col-md-3 col-xs-12">
								<a href="' . nokri_location_page_link($cat->term_id) . '">
								<div class="n-location-style"> 
									' . $loc_img . '
									<div class="n-city-location">
									<ul>
										<li>' . $cat->name . '</li>
										<li class="n-style2"><span class="badge">' . $custom_count . " " . $count_cat . '</span></li>
									</ul>
									</div>
								</div>
								</a>
								</div>';
                    }
                }
            }
        }
        /* Section name */
        $section_title = (isset($section_title) && $section_title != "") ? '<h3>' . $section_title . '</h3>' : "";
        /* Section desc */
        $section_descs = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        echo '<section class="n-location space2">
			   <div class="container">
				 <div class="row">
				   <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					 <div class="heading-penel">
					   ' . $section_title . '
					   ' . $section_descs . '
					 </div>
				   </div>
                                   </div>
                                    <div class="row clear-custom">
				   ' . $cats_html . '
                                       </div>
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
