<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Call_Action extends Widget_Base {

    public function get_name() {
        return 'call-to-action';
    }

    public function get_title() {
        return __('Call To Action', 'nokri-elementor');
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
                'call_action_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => nokri_ELImage('nokri_call_action.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri-elementor'),
                    ],
                    "description" => esc_html__('263x394', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'call_action_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'call_action_details',
                [
                    'label' => __('Button 1 Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'link_section',
                [
                    'label' => __('Links)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'btn1_txt',
                [
                    'label' => __('Some Detail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'link1',
                [
                    'label' => __('Link', 'nokri-elementor'),
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
                'btn2_txt',
                [
                    'label' => __('Button 2 title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'link2',
                [
                    'label' => __('Link', 'nokri-elementor'),
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
        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);

        $section_btn = (isset($featured_projects_clr) && $featured_projects_clr != "") ? $featured_projects_clr : "";
        /* Section Heading */
        $section_heading = (isset($call_action_heading) && $call_action_heading != "") ? '<h2>' . $call_action_heading . '</h2>' : "";
        /* Section Details */
        $section_details = (isset($call_action_details) && $call_action_details != "") ? '<p>' . $call_action_details . '</p>' : "";

        /* Background Image */
        $bg_img = '';
        if (isset($call_action_img['url']) ) {
            $bgImageURL = $call_action_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }



        /* Link 1 */
        $btn1 = '';
        if (isset($btn1_txt)) {
            $btn1 = elementor_ThemeBtn($link1, 'btn n-btn-flat btn-mid', false,'','',$btn1_txt);
        }
        /* Link 2 */
        $btn2 = '';
        if (isset($btn2_txt)) {
            $btn2 = elementor_ThemeBtn($link2, 'btn n-btn-flat btn-mid btn-clear', false,'','',$btn2_txt);
        }




        echo '<section class="n-call-to-action" ' . str_replace('\\', "", $bg_img) . '>
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="heading-title black">
              ' . $section_heading . '
              ' . $section_details . '
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-extra-btn-section">
            	' . $btn2 . '
				' . $btn1 . '
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
