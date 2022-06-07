<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Cand_Emp_Sec1 extends Widget_Base {

    public function get_name() {
        return 'cand-emp-section1';
    }

    public function get_title() {
        return __('Candidate/employer Section 1', 'nokri-elementor');
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
                'emp_section',
                [
                    'label' => __('Employer', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'emp_img',
                [
                    'label' => __('Employer Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('570 x 303', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'emp_heading',
                [
                    'label' => __('Emploer Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'emp_desc',
                [
                    'label' => __('Employer Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
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
                'emp_link',
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
        $this->start_controls_section(
                'cand_sec',
                [
                    'label' => __('Candidates', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'cand_img',
                [
                    'label' => __('Candidate Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('570 x 299', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'cand_heading',
                [
                    'label' => __('Candidate Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'cand_desc',
                [
                    'label' => __('Candidate Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'btn2_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'cand_link',
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

        $style1 = '';
        if (isset($emp_img['url'])) {
            $bgImageURL = $emp_img['url'];
            $style1 = ( $bgImageURL != "" ) ? ' style="background:  url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        /* Employer Heading */
        $emp_heading = (isset($emp_heading) && $emp_heading != "") ? ' <h3>' . $emp_heading . '</h3>' : "";
        /* Employer desc */
        $emp_desc = (isset($emp_desc) && $emp_desc != "") ? ' <p>' . $emp_desc . '</p>' : "";
        /* Employer Link  */
      $btn = '';
        if (isset($btn1_txt)) {
            $btn =  elementor_ThemeBtn($emp_link, 'btn n-btn-flat btn-mid', false,'','',$btn1_txt);
          
        }
        /* Candidate Image */
        $style2 = '';
        if (isset($cand_img['url'])) {
            $bgImageURL = $cand_img['url'];
            $style2 = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        /* Candidate Heading */
        $cand_heading = (isset($cand_heading) && $cand_heading != "") ? '<h3>' . $cand_heading . '</h3>' : "";
        /* Candidate desc */
        $cand_desc = (isset($cand_desc) && $cand_desc != "") ? '<p>' . $cand_desc . '</p>' : "";
        /* Candidate Link  */
         $btn2 = '';
        if (isset($btn2_txt)) {
            $btn2 = elementor_ThemeBtn($emp_link, 'btn n-btn-flat btn-mid', false,'','',$btn2_txt);
        }

        /* Arrow Image */
       
        echo '<section class="nth-success n-padding-bottom">
			<div class="container">
				<div class="row nth-sc-product">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<div class="nth-sc-content" ' . $style1 . '>
						' . $emp_heading . '
						' . $emp_desc . '
						' . $btn . '
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<div class="nth-sc-content-2 nth-sc-content" ' . $style2 . '>
						' . $cand_heading . '
						' . $cand_desc . '
						' . $btn2 . '
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
