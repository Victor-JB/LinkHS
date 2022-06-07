<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Emp_Slider extends Widget_Base {

    public function get_name() {
        return 'emp-slider';
    }

    public function get_title() {
        return __('Top Hiring employers', 'nokri-elementor');
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
                'section_img',
                [
                    'label' => __('Select Backgroun color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('2560*1707', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'section_tagline',
                [
                    'label' => __('Section tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'section_heading',
                [
                    'label' => __('Section heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'employer_section',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'employer',
                [
                    'label' => __('Select employer', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_top_employers_lists_elementor(),
                ]
        );
        $this->add_control(
                'employers',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
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
        $employers_array = array();
        if (isset($atts['employers']) && $atts['employers'] != '') {
            $rows = $atts['employers'];
            $stories_html = '';
            $current_user_id = get_current_user_id();
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $employers_array[] = (isset($row['employer']) && $row['employer'] != "") ? $row['employer'] : array();
                }
            }
        }
        global $nokri;
        if (count((array) $employers_array) > 0 && $employers_array != "") {
            foreach ($employers_array as $key => $value) {
                $employers_array[] = $value;
            }
        }


        /* WP User Query */
         $args = array();
                if(!empty($employers_array)){
		$args 			= 	array (
		'order' 		=> 	'DESC',
		'include'       => $employers_array,
                );}
        $user_query = new \WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = '';
        if (!empty($authors)) {
            $fb_link = $twitter_link = $google_link = $linkedin_link = $follow_btn = '';
            foreach ($authors as $author) {
                $user_id = $author->ID;
                $user_name = $author->display_name;
                /* Profile Pic  */
                $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                    $image_dp_link = array($nokri['nokri_user_dp']['url']);
                }
                if (get_user_meta($user_id, '_sb_user_pic', true) != '') {
                    $attach_dp_id = get_user_meta($user_id, '_sb_user_pic', true);
                    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                }
                if (empty($image_dp_link[0])) {
                    $image_dp_link[0] = get_template_directory_uri() . '/images/default-job.png';
                }

                $required_user_html .= '<div class="item"> <a href="' . esc_url(get_author_posts_url($user_id)) . '"><img src="' . esc_url($image_dp_link[0]) . '" class="img-responsive" alt="' . esc_attr__('image', 'nokri-elementor') . '" /></a> </div>';
            }
        }

        /* Section tagline */
        $section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<h3>' . $section_tagline . '</h3>' : "";
        /* Section title */
        $section_heading = (isset($section_heading) && $section_heading != "") ? '<h2>' . $section_heading . '</h2>' : "";
        /* Section Image */
        $style = '';
        if (isset($section_img['url']) ) {
            $bgImageURL = $section_img['url'];
            $style = ( $bgImageURL != "" ) ? ' style="background:  url(' . $bgImageURL . ') no-repeat fixed top center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        echo '<section class="client-section" ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="heading-2">
          ' . $section_tagline . '
          ' . $section_heading . '
        </div>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="top-hiring-company-slider owl-carousel owl-theme">
          ' . $required_user_html . '
        </div>
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
