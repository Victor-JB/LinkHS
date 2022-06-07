<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Our_Client extends Widget_Base {

    public function get_name() {
        return 'our-client';
    }

    public function get_title() {
        return __('Our Client', 'nokri-elementor');
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
                'section_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_client',
                [
                    'label' => __('Clients', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'section_client',
                [
                    'label' => __('Select client image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('150 x 150', 'nokri-elementor'),
                ]
        );
        $repeater->add_control(
                'client_link',
                [
                    'label' => __('Client Link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'nokri-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'images',
                [
                    'label' => __('Select Clients', 'nokri-elementor'),
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

        if (isset($atts['images']) && $atts['images'] != '') {
            $rows = $atts['images'];
            $images_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['section_client']) && $row['section_client'] != '') {
                        $img =     $row['section_client']['url'];                    
                        $img_html = '<img class="img-responsive"  src="' . $img . '" alt="' . esc_attr__("image", "nokri-elementor") . '">';
                    }
                    /* Client Link  */
                    $link = (isset($row['client_link']['url']) && $row['client_link']['url'] != "") ? $row['client_link']['url'] : "#";
                    /* Story Html */
                    $images_html .= '<div class="item">
						   <a href="' . $link . '">' . $img_html . '</a>
						</div>';
                }
            }
        }
        /* Section Heading */
        $section_heading1 = (isset($section_heading) && $section_heading != "") ? ' <h4>' . $section_heading . '</h4>' : "";

        echo '<section class="n-client ">
    <div class="container">
      <div class="row">
      	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-client-heading">
               ' . $section_heading1 . ' 
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-client-box owl-carousel owl-theme">
                ' . $images_html . '
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
