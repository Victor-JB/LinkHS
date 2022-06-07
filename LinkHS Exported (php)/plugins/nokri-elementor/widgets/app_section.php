<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class App_Section extends Widget_Base {

    public function get_name() {
        return 'app_section';
    }

    public function get_title() {
        return __('App Section', 'nokri-elementor');
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
                'appsection_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'appsection_details',
                [
                    'label' => __('Section Detail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
      
        $this->end_controls_section();
        
         $this->start_controls_section(
                'image_section',
                [
                    'label' => __('Image Section)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
       
        $this->add_control(
                'appsection_bg_img',
                [
                    'label' => __('Back ground image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                     "description" => esc_html__('767 x 467', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'appsection_img',
                [
                    'label' => __('Section image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                     "description" => esc_html__('444 x 592', 'nokri-elementor'),
                ]
        );
      
        $this->end_controls_section();
        
         $this->start_controls_section(
                'playstore_section',
                [
                    'label' => __('Play store', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
         $this->add_control(
                'play_store_img',
                [
                    'label' => __('Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                     "description" => esc_html__('150 x 50', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'play_store_link',
                [
                    'label' => __('Play Store Link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
         $this->end_controls_section();
          $this->start_controls_section(
                'appstore_section',
                [
                    'label' => __('App store', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
         $this->add_control(
                'app_store_img',
                [
                    'label' => __('Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                     "description" => esc_html__('150 x 50', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'app_store_link',
                [
                    'label' => __('Play Store Link', 'nokri-elementor'),
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

        $section_heading = (isset($appsection_heading) && $appsection_heading != "") ? '<h2>' . $appsection_heading . '</h2>' : "";
        /* Section Details */
        $section_details = (isset($appsection_details) && $appsection_details != "") ? '<p>' . $appsection_details . '</p>' : "";
        /* Section Image */
        $appsection_img_html = '';
        if (isset($appsection_img)) {
            $img =$appsection_img['url'];
            
            $appsection_img_html = '<div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mobile-app-new-img"><img src="' . esc_url($img) . '" class="img-responsive" alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>
                    </div>';
        }

        /* Play Store Link */
        $play_store = (isset($play_store_link) && $play_store_link != "") ? $play_store_link : "#";
        /* Play Store Image */
        $play_store_imgURL = $play_store_imag = '';
        if (!empty($play_store_img)){ 
            $play_store_imgURL = $play_store_img['url'];
            $play_store_imag = '<img src="' . $play_store_imgURL . '" alt="' . esc_attr__("playStore", "nokri-elementor") . '">';
        }

        /* App Store Link */
        $app_store = (isset($app_store_link) && $app_store_link != "") ? $app_store_link : "#";
        /* App Store Image */
        $app_store_imgURL = '';
        if (isset($app_store_img['url'])) {
            $app_store_imgURL = $app_store_img['url'];
            $app_store_img = '<img src="' . $app_store_imgURL . '"  alt="' . esc_attr__("AppStore", "nokri-elementor") . '">';
        }
        /* Section Image */
        $section_imgURL = '';
        if (isset($appsection_img['url'])) {
            $section_imgURL = $appsection_img['url'];
            $appsection_img = '<img src="' . $section_imgURL . '" class="img-responsive" alt="' . esc_attr__("Image", "nokri-elementor") . '">';
        }
        /* Section Color */
        $section_clr = (isset($appsection_clr) && $appsection_clr != "") ? $appsection_clr : "";
        /* Background Image */
        $bg_img = '';
        if (isset($appsection_bg_img['url'])) {
            $bgImageURL = $appsection_bg_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }
        echo  '<section class="n-mobile-app-new" ' . str_replace('\\', "", $bg_img) . '>
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="n-mobile-app-text-area">
                      ' . $section_heading . '
					  ' . $section_details . '
                     <div>
                          <a href="' . $play_store . '" target="_blank">' . $play_store_imag . '</a>
                    	  <a href="' . $app_store . '" target="_blank">' . $app_store_img . '</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="n-mobile-app-new-img">' . $appsection_img . '</div>
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
