<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Success_Stories_Slider extends Widget_Base {

    public function get_name() {
        return 'success_stories_slider';
    }

    public function get_title() {
        return __('Success Stories Slider', 'nokri-elementor');
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


        $this->start_controls_section(
                'background_section',
                [
                    'label' => __('Background Options', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'success_stories_slider_clr',
                [
                    'label' => __('Select background color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array( 
		esc_html__('Select Option', 'nokri-elementor') => '', 
		esc_html__('Sky BLue', 'nokri-elementor') =>'light-grey',
		esc_html__('White', 'nokri-elementor') =>'',
		)),
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
                'section_desc',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'story_section',
                [
                    'label' => __('Story Section', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'story_title',
                [
                    'label' => __('Story Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater->add_control(
                'story_designation',
                [
                    'label' => __('Designation', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater->add_control(
                'story_description',
                [
                    'label' => __('Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $repeater->add_control(
                'story_img',
                [
                    'label' => __('Client Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('45 x 45', 'nokri-elementor'),
                ]
        );



        $this->add_control(
                'stories',
                [
                    'label' => __('Add Stories', 'nokri-elementor'),
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
  $stories_html = '';
        if (isset($atts['stories']) && !empty($atts['stories']) != '') {
            $rows = $atts['stories'];
            $stories_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['story_img']['url']) && $row['story_img']['url'] != '') {
                        
                        $img = $row['story_img']['url'];
                        $img_html = '<img  src="' . $img . '" class="img-responsive" alt="' . esc_attr__("image", "nokri-elementor") . '">';
                    }
                    /* Story Title */
                    $astory_title = (isset($row['story_title']) && $row['story_title'] != "") ? '<h3>' . $row['story_title'] . '</h3>' : "";
                    /* Story Description */
                    $astory_desc = (isset($row['story_description']) && $row['story_description'] != "") ? $row['story_description'] : "";
                    $paras = explode("|", $astory_desc);
                    $paragraph_html = '';
                    foreach ($paras as $para) {
                        $paragraph_html .= '<p>' . $para . '</p>';
                    }
                    /* Story client */
                    $story_designation = (isset($row['story_designation']) && $row['story_designation'] != "") ? ' <p>' . $row['story_designation'] . '</p>' : "";

                    /* Story Html */
                    $stories_html .= '<div class="item">
							<div class="n-single_testimonial">
							   <div class="n-testimoial-text">
								<i class="fa fa-quote-left"></i>
								 ' . $paragraph_html . '
							   </div>
							   <div class="n-user-meta">
								  <div class="n-user-avatar">
									 ' . $img_html . '
								  </div>
								  <div class="n-user-detail">
									' . $astory_title . '
									 ' . $story_designation . '
								  </div>
							   </div>
							</div>
						 </div>';
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($success_stories_slider_clr) && $success_stories_slider_clr != "") ? $success_stories_slider_clr : "";
        /* Section name */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";
        /* Section desc */
        $section_desc = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        echo '<section class="n-testimonials ' . esc_attr($section_clr) . '">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="heading-title black">
                   ' . $section_title . '
				   ' . $section_desc . '
                </div>
              </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="n-owl-testimonial-2 owl-carousel owl-theme">
				  ' . $stories_html . '
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
