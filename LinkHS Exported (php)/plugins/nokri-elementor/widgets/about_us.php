<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us extends Widget_Base {

    public function get_name() {
        return 'about-us';
    }

    public function get_title() {
        return __('About us', 'nokri-elementor');
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
                'section1_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section1_description',
                [
                    'label' => __('Section Sub Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section2_description',
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
                'employer_signup_img',
                [
                    'label' => __('Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('767 x 467', 'nokri-elementor'),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'add_section',
                [
                    'label' => __('Add more', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'faq_qstn_title',
                [
                    'label' => __('Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );

        $repeater->add_control(
                'faq_qstn_details',
                [
                    'label' => __('Details', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );
        $repeater->add_control(
                'section_img_icon',
                [
                    'label' => __('Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select option', 'nokri-elementor') => '',
                        esc_html__('Icon', 'nokri-elementor') => 'icon',
                        esc_html__('Image', 'nokri-elementor') => 'img'
                            ))
                ]
        );
        $repeater->add_control(
                'abt_img',
                [
                    'label' => __('Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'condition' => [
                        'section_img_icon' => ['img'],
                    ],
                ]
        );
        $repeater->add_control(
                'step_icon',
                [
                    'label' => __('Icon', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'condition' => [
                        'section_img_icon' => ['icon'],
                    ],
                    'description' => __('Click to explore more icons', 'nokri-elementor') . ' ' . nokri_make_link('https://icons8.com/line-awesome/cheatsheet', __('Get Icons', 'nokri-elementor')),
                ]
        );
        $this->add_control(
                'faq_qstns',
                [
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

        if (isset($atts['faq_qstns']) && $atts['faq_qstns'] != '') {
            $rows = $atts['faq_qstns'];
            $about_html = '';
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    /* Title */
                    $title = (isset($row['faq_qstn_title']) && $row['faq_qstn_title'] != "") ? '<h4>' . $row['faq_qstn_title'] . '</h4>' : "";
                    /* Details */
                    $details = (isset($row['faq_qstn_details']) && $row['faq_qstn_details'] != "") ? '<p>' . $row['faq_qstn_details'] . '</p>' : "";
                    /* Icons Image */
                    $about_img = '';
                    if (isset($row['abt_img']['url'])) {
                       
                        $img_thumb = $row['abt_img']['url'];
                        $about_img = '<div class="icons"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>';
                    }

                    /* Step Icon */
                    $astep_icon = '';
                    if (isset($row['step_icon'])) {
                        $about_img = '<i class="la ' . trim($row['step_icon']) . ' la-4x"></i>';
                    }

                    $about_html .= '<div class="col-md-6 col-xs-12 col-sm-6">
									 <div class="services-grid">
										' . $about_img . '
										' . $title . '
										' . $details . '
									 </div>
								  </div>';
                }
            }
        }
        /* Section Image */
        $img_html = '';
        if (isset($employer_signup_img['url'])) {      
            $img_thumb = $employer_signup_img['url'];
            $img_html = '<div class="col-md-5 col-sm-12 col-xs-12"><img src="' . esc_url($img_thumb) . '" class="img-responsive"  alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>';
        }
        /* Section Color */
        $section_clr = (isset($faq_qstn_section_clr) && $faq_qstn_section_clr != "") ? $faq_qstn_section_clr : "";
        /* Section Title */
        $section_title = (isset($section1_heading) && $section1_heading != "") ? '<h2>' . $section1_heading . '</h2>' : "";
        /* Section subheading */
        $section_subheading = (isset($section1_description) && $section1_description != "") ? '<p class="large-paragraph">' . $section1_description . '</p>' : "";
        /* Section Details */
        $section_details = (isset($section2_description) && $section2_description != "") ? '<p>' . $section2_description . '</p>' : "";
        echo  ' <section class="about-us">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
               	 	<div class="col-md-7 col-sm-12 col-xs-12">
               	 		' . $section_title . '
               	 		' . $section_subheading . '
						' . $section_details . ' 
               	 		<div class="row">
               	 			<div class="services">
               	 			' . $about_html . '
               	 		</div>
               	 		</div>
               	 	</div>
               	 	' . $img_html . '
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
