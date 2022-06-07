<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Success_Stories1 extends Widget_Base {

    public function get_name() {
        return 'success_stories1';
    }

    public function get_title() {
        return __('Success Stories 1', 'nokri-elementor');
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
                'success_stories_clr',
                [
                    'label' => __('Select background option', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Color', 'nokri-elementor') => 'clr',
                        esc_html__('Image', 'nokri-elementor') => 'img',
                    )),
                ]
        );
        $this->add_control(
                'sec_bg_img',
                [
                    'label' => __('Section image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'condition' => [
                        'success_stories_clr' => ['img'],
                    ],
                ]
        );
        $this->add_control(
                'bg_clr',
                [
                    'label' => __('Select background color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('White', 'nokri-elementor') => '',
                        esc_html__('Gray', 'nokri-elementor') => 'light-grey',
                            )),
                     'condition' => [
                        'success_stories_clr' => ['clr'],
                    ],
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
                    "description" => esc_html__('76 x 76', 'nokri-elementor'),
                ]
        );
         $repeater->add_control(
                'qoute_img',
                [
                    'label' => __('Quote Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('102 x 78', 'nokri-elementor'),
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

        if (isset($atts['stories']) && !empty($atts['stories']) != '') {
            $rows = $atts['stories'];
            $stories_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['story_img']['url']) && $row['story_img']['url'] != '') {
                        $img = $row['story_img']['url'];
                       
                        $img_html = '<div class="nth-sc-profile"><img  src="' . $img . '" class="img-responsive" alt="' . esc_attr__("image", "nokri-elementor") . '"></div>';
                    }
                    $qoute_img_html = '';
                    if (isset($row['qoute_img']['url']) && $row['qoute_img']['url'] != '') {
                        $img = $row['qoute_img']['url'];
                   
                        $qoute_img_html = '<div class="nth-image-bg"><img  src="' . $img . '" class="img-responsive" alt="' . esc_attr__("image", "nokri-elementor") . '"></div>';
                    }

                    /* Story Title */
                    $astory_title = (isset($row['story_title']) && $row['story_title'] != "") ? '<div class="nth-profile-text">' . $row['story_title'] . '</div>' : "";
                    /* Story Description */
                    $astory_desc = (isset($row['story_description']) && $row['story_description'] != "") ? '<p>' . $row['story_description'] . '</p>' : "";
                    /* Story client */
                    $story_designation = (isset($row['story_designation']) && $row['story_designation'] != "") ? ' <p>' . $row['story_designation'] . '</p>' : "";
                    /* Story Html */
                    $stories_html .= '<div class="item">
								<div class="nth-sc-box">
									' . $astory_desc . '
										' . $img_html . '
										<div class="nth-sc-details">
											' . $astory_title . '
											' . $story_designation . '
										</div>
									' . $qoute_img_html . '
								</div>
							</div>';
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($bg_clr) && $bg_clr != "") ? $bg_clr : "";
        $section_type = (isset($success_stories_clr) && $success_stories_clr != "") ? $success_stories_clr : "0";
        $bg_class = $bg_img = '';
        if ($section_type == 'img') {
            /* Section bg Image */
            $bg_img = $bg_class = '';
            if (isset($sec_bg_img['url'])) {
                $bgImageURL = $sec_bg_img['url'];
                $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center; background-attachment:scroll;"' : "";
                $section_clr = 'nth-success-2';
            }
        }
        /* Section name */
        $section_title = (isset($section_title) && $section_title != "") ? '<h3>' . $section_title . '</h3>' : "";
        /* Section desc */
        $section_desc = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        echo '<section class="nth-success-products ' . esc_attr($section_clr) . '" ' . str_replace('\\', "", $bg_img) . '>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading-penel">
							' . $section_title . '
							' . $section_desc . '
						</div>
						<div class="success1-slider owl-carousel owl-theme">
							' . $stories_html . '
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
