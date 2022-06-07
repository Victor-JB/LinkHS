<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Cat_Slider extends Widget_Base {

    public function get_name() {
        return 'categories-slider';
    }

    public function get_title() {
        return __('Categories Slider', 'nokri-elementor');
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
                'cats_section_clr',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Blue', 'nokri-elementor') => 'light-blue',
                        esc_html__('White', 'nokri-elementor') => '',
                        
                            )),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Hot Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
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

        if (isset($atts['cats']) && $atts['cats'] != '') {
            $rows = $atts['cats'];
            $cats = false;
            $cats_html = '';
            if (count((array) $rows) > 0) {
                $cats_html = '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img'])) {
                            $img = wp_get_attachment_image_src($row['cat_img'], '');
                            $img_thumb = $img[0];
                            $cat_img = '<span class="images-icon"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '"></span>';
                        }
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '<div class="item">
							<div class="category-style-3-box"> <a href="' . nokri_cat_link_page($category->term_id) . '">
							  <div class="inner-box">
								<h4>' . $category->name . '</h4>
								<span> (' . $custom_count . ')</span> </div>
							  </a> </div>
						  </div>
							';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    /* Category Image */
                    $cat_img = '';
                    if (isset($row['cat_img'])) {
                        $img = wp_get_attachment_image_src($row['cat_img'], '');
                        $img_thumb = $img[0];
                        $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '
							<div class="item">
							<div class="category-style-3-box"> <a href="' . nokri_cat_link_page($cat->term_id) . '">
							  <div class="inner-box">
								<h4>' . $cat->name . '</h4>
								<span> (' . $custom_count . ')</span> </div>
							  </a> </div>
						  </div>
							
							';
                    }
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
        echo '<section class="category-float-slider-sectoion ' . $section_clr . '">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="category-style-3-slider owl-carousel owl-theme">
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
