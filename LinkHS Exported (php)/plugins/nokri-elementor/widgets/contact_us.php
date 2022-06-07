<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Contact_Us_Sec extends Widget_Base {

    public function get_name() {
        return 'contact-us-section';
    }

    public function get_title() {
        return __('Contact Us', 'nokri-elementor');
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
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_desc',
                [
                    'label' => __('Section Detail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'basic_bg_img',
                [
                    'label' => __('Background image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('263x394', 'nokri-elementor'),
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'contact_section',
                [
                    'label' => __('Contact Form', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'contact_form_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'contact_form_input',
                [
                    'label' => __('Form Input', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'contact_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'adress',
                [
                    'label' => __('Adress', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'email',
                [
                    'label' => __('Email', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'phone',
                [
                    'label' => __('Phone', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'fb',
                [
                    'label' => __('Facebook', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'twitter',
                [
                    'label' => __('Twitter', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'linkedin',
                [
                    'label' => __('Linkedin', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'google',
                [
                    'label' => __('Google+', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
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
        $section_title = (isset($section_title) && $section_title != "") ? '<h1>' . $section_title . '</h1>' : "";
        /* Section Desc */
        $section_desc = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        /* cotact title */
        $contact_title = (isset($contact_title) && $contact_title != "") ? '<h3>' . $contact_title . '</h3>' : "";
        /* Adress */
        $adress = (isset($adress) && $adress != "") ? '<li><i class="ti-location-pin"></i><div class="contact-detail"><p>' . $adress . '</p></div></li>' : "";
        /* email */
        $email = (isset($email) && $email != "") ? '<li><i class="ti-email"></i><div class="contact-detail"><p><a href="mailto:' . $email . '">' . $email . '</a></p></div></li>' : "";
        /* phone */
        $phone = (isset($phone) && $phone != "") ? '<li><i class="ti-mobile"></i><div class="contact-detail"><p><a href="callto:' . $phone . '">' . $phone . '</a></p> </div></li>' : "";
        /* Social Contact */
        /* fb */
        $fb = (isset($fb) && $fb != "") ? ' <li><a href="' . esc_url($fb) . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/icons/006-facebook.png" class="img-responsive" alt="' . esc_attr__('icon', 'nokri-elementor') . '"></a></li>' : "";
        /* twitter */
        $twitter = (isset($twitter) && $twitter != "") ? '<li><a href="' . esc_url($twitter) . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/icons/004-twitter.png" class="img-responsive" alt="' . esc_attr__('icon', 'nokri-elementor') . '"></a></li>' : "";
        /* linkedin */
        $linkedin = (isset($linkedin) && $linkedin != "") ? '<li><a href="' . esc_url($linkedin) . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/icons/005-linkedin.png" class="img-responsive" alt="' . esc_attr__('icon', 'nokri-elementor') . '"></a></li>' : "";
        /* google */
        $google = (isset($google) && $google != "") ? '<li><a href="' . esc_url($google) . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/icons/003-google-plus.png" class="img-responsive" alt="' . esc_attr__('icon', 'nokri-elementor') . '"></a></li>' : "";
        /* contact Title */
        $contact_form_title = (isset($contact_form_title) && $contact_form_title != "") ? '<h3>' . $contact_form_title . '</h3>' : "";
        $shortCode = '';
        $shortCode = nokri_clean_shortcode($contact_form_input);
        
        $contact_form_input = do_shortcode($shortCode);

        /* Background Image */
        $bg_img = '';
        if (isset($basic_bg_img['url'])) {
            $bgImageURL = $basic_bg_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }

        echo '<section class="n-pages-breadcrumb" ' . str_replace('\\', "", $bg_img) . '>
  	<div class="container">
    	<div class="row">
        	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
            	<div class="n-breadcrumb-info">
                   ' . $section_title . '
                   ' . $section_desc . '
                </div>
            </div>
        </div>
    </div>
  </section>
	<section class="n-job-pages-section">
  	<div class="container">
    	<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="n-job-pages contact-page">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="n-page-left-side">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="post-job-heading">
                                        ' . $contact_form_title . '
                                    </div>
                                </div>
                                 ' . $contact_form_input . '
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 nopadding">
                        <div class="n-page-right-side">
                            <div class="post-job-heading">
                                ' . $contact_title . '
                            </div>
                            <ul>
                                ' . $adress . '
                                ' . $email . '
                                ' . $phone . '
                            </ul>
                            <ul class="social-links">
                               ' . $fb . '
                               ' . $twitter . '
                                ' . $linkedin . '
                               ' . $google . '
                            </ul>
                        </div>
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
