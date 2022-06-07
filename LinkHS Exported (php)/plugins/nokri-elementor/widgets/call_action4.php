<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Call_Action4 extends Widget_Base {

    public function get_name() {
        return 'call-to-action4';
    }

    public function get_title() {
        return __('Call To Action 4', 'nokri-elementor');
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
                    'label' => __('Basic', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'sec_bg_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('1920 x 473', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'section_img',
                [
                    'label' => __('Section Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('692 x 463', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'tagline',
                [
                    'label' => __('Section tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
                'counut_section',
                [
                    'label' => __('Count', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'number',
                [
                    'label' => __('Number', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater->add_control(
                'title',
                [
                    'label' => __('Story title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'numbers',
                [
                    'label' => __('Select', 'nokri-elementor'),
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
        $stories_html = "";
        if (isset($atts['numbers']) && $atts['numbers'] != '') {
            $rows_story = $atts['numbers'];
            if ((array) count($rows_story) > 0) {
                foreach ($rows_story as $row_story) {
                    /* Title */
                    $astory_title = (isset($row_story['title']) && $row_story['title'] != "") ? ' <p>' . $row_story['title'] . '</p>' : "";
                    /* Story Description */
                    $astory_no = (isset($row_story['number']) && $row_story['number'] != "") ? '<span class="counter" data-to="' . $row_story['number'] . '" data-time="2000" data-fps="20"></span>' : "";
                    /* Story Html */
                    $stories_html .= '<li> 
									<div class="counter-js">
									' . $astory_no . '
									' . $astory_title . '
									</div>
									</li>';
                }
            }
        }
        /* Section Tagline */
        $section_tagline = (isset($tagline) && $tagline != "") ? '<span>' . $tagline . '</span>' : "";
        /* Section Heading */
        $section_heading = (isset($heading) && $heading != "") ? '<h3>' . $heading . '</h3>' : "";
        /* Section Details */
        $section_desc = (isset($description) && $description != "") ? '<p>' . $description . '</p>' : "";
        /* Background Image */
        $bg_img = '';
        if (isset($sec_bg_img['url'] )) {
            $bgImageURL = $sec_bg_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }
        /* Section Image */
        $sec_img = '';
        if (isset($section_img['url'])) {
         
            $img_thumb = $section_img['url'];
            $sec_img = '<div class="n-8-img"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive"></div>';
        }
        echo '<section class="n-callto-action-8" ' . str_replace('\\', "", $bg_img) . '> 
			<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
				<div class="n-callto-details">
					' . $section_tagline . '
					' . $section_heading . '
					' . $section_desc . '
				</div>
				<ul>
					' . $stories_html . '
				</ul>
				</div>
				' . $sec_img . '
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
