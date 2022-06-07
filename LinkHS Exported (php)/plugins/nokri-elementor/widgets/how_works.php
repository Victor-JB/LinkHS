<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class How_Works extends Widget_Base {

    public function get_name() {
        return 'how_works';
    }

    public function get_title() {
        return __('How it Works', 'nokri-elementor');
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
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_img',
                [
                    'label' => __('Section Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('1296*316', 'nokri-elementor'),
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'Steps_section',
                [
                    'label' => __('Steps', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'section_img_icon',
                [
                    'label' => __('Select Image option', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select option', 'nokri-elementor'),
                        'icon' => esc_html__('Icon', 'nokri-elementor'),
                        'img' => esc_html__('Image', 'nokri-elementor'),
                    ),
                ]
        );
        $repeater->add_control(
                'step_img',
                [
                    'label' => __('Add Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
        );
        $repeater->add_control(
                'step_icon',
                [
                    'label' => __('Add Icon', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'description' => __('Click to explore more icons', 'nokri-elementor') . ' ' . nokri_make_link('https://icons8.com/line-awesome/cheatsheet', __('Get Icons', 'nokri-elementor')),
                ]
        );
        $repeater->add_control(
                'step_title',
                [
                    'label' => __('Step Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater->add_control(
                'step_description',
                [
                    'label' => __('Step Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->add_control(
                'steps',
                [
                    'label' => __('Add Steps', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'second_section',
                [
                    'label' => __('Second Secetion', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_title2',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_details2',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'section_img2',
                [
                    'label' => __('Section Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('570x468', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'btn1_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'link',
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
require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

        $bg_img = '';
        if (isset($section_img['url'])) {
            $bgImageURL = $section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') no-repeat; -webkit-background-size: contain; -moz-background-size: contain; -o-background-size: contain; background-size: contain; background-position: center center; background-attachment:scroll;"' : "";
        }
        if (isset($atts['steps']) && !empty($atts['steps']) != '') {
            $rows = $atts['steps'];
            $steps_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    /* Step Image */
                    $astep_img = '';
                    if (isset($row['step_img']['url'])) {
                        $img = $row['step_img']['url'];
                        $img_thumb = $img;
                    }
                    /* Step Icon */
                    $astep_icon = '';
                    if (isset($row['step_icon'])) {
                        $icon_html = '<i class="la ' . trim($row['step_icon']) . ' la-4x"></i>';
                    }

                    if (isset($row['step_img']['url'])) {
                        $astep_img = ( isset($img_thumb) && $img_thumb != "" ) ? '<img src="' . esc_url($img_thumb) . '" class="img-responsive main-img" alt="' . esc_attr__('image', 'nokri-elementor') . '" />' : '';
                    } else {
                        $astep_img = $icon_html;
                    }

                    /* Step Title */
                    $astep_title = (isset($row['step_title']) && $row['step_title'] != "") ? ' <h4>' . $row['step_title'] . '</h4>' : "";
                    /* Step Description */
                    $astep_desc = (isset($row['step_description']) && $row['step_description'] != "") ? ' <p>' . $row['step_description'] . '</p>' : "";
                    /* Step Html */
                    $steps_html .= '<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="h-i-w-content-box">
						' . $astep_img . '
						' . $astep_title . '
						' . $astep_desc . '
					  </div></div>';
                }
            }
        }
        /* Section title 2 */
        $section_title2 = (isset($section_title2) && $section_title2 != "") ? '<h3>' . $section_title2 . '</h3>' : "";
        /* Section details 2 */
        $section_details2 = (isset($section_details2) && $section_details2 != "") ? $section_details2 : "";
        $paras = explode("|", $section_details2);
        $paragraph_html = '';
        foreach ($paras as $para) {
            $paragraph_html .= '<p>' . $para . '</p>';
        }
        /* Link  */
        $btn = '';
         $read_more = '';
        if (isset($btn1_txt)) {
            $btn = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid', false, '', '', $btn1_txt);
        }
        /* Section Image */
        $img_thumb2 = '';
        if (isset($section_img2['url'])) {
            $section_imag2 = $section_img2['url'];
            $img_thumb2 = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><img src="' . $section_imag2 . '" class="img-responsive" alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>';
        }
        echo ' <section class="how-it-works style-2" >
    <div class="container">
      <div class="row">
        ' . $header . '
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="h-i-w-box" ' . str_replace('\\', "", $bg_img) . ' >
                <div class="work-points">
                 ' . $steps_html . '
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="row">
            	<div class="n-call-to-box mt40">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="n-call-to-action-text">
                           ' . $section_title2 . '
                            ' . $paragraph_html . '
                        </div>
                        <div class="n-extra-btn-section">
                           ' . $btn . '
                        </div>
                    </div>
                    ' . $img_thumb2 . '
                </div>
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
