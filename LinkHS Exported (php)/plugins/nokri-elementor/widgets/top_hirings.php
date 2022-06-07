<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Top_Hiring extends Widget_Base {

    public function get_name() {
        return 'top-hiring';
    }

    public function get_title() {
        return __('Top Hiring', 'nokri-elementor');
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
                'section_clr',
                [
                    'label' => __('Select Backgroun color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Sky BLue', 'nokri-elementor') => 'light-grey',
                        esc_html__('White', 'nokri-elementor') => '',
                            )),
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
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'employer_section',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'employer_img',
                [
                    'label' => __('Select employer', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
        );

        $repeater->add_control(
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
        $this->add_control(
                'employers',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
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
        $hiring_html = "";
        if (isset($atts['employers']) && !empty($atts['employers']) != '') {
            $rows = $atts['employers'];
            $hiring_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['employer_img']['url']) && $row['employer_img']['url'] != '') {
                        
                        $img = $row['employer_img']['url'];
                        if (isset($row['link']['url']) && $row['link']['url'] != '') {
                            $url = $row['link']['url'];
                            $img_html = '<a href="' . esc_url($url) . '"><img  src="' . $img . '" class="img-responsive" alt="' . esc_attr__("image", "nokri-elementor") . '"></a>';
                        } else {
                            $img_html = '<img  src="' . $img . '" class="img-responsive" alt="' . esc_attr__("image", "nokri-elementor") . '">';
                        }
                    }
                    /* Story Html */
                    $hiring_html .= $img_html;
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($section_clr) && $section_clr != "") ? $section_clr : "";
        /* Section name */
        $section_title = (isset($section_title) && $section_title != "") ? '<h3>' . $section_title . '</h3>' : "";
        /* Section desc */
        $section_desc = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        echo '<section class="nth-hiring" ' . esc_attr($section_clr) . '>
   <div class="container">
	   <div class="row">
		   <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
			   <div class="heading-penel">
				   ' . $section_title . '
				   ' . $section_desc . '
			   </div>
		   </div>
		   <div class="nth-hiring-content">
			   ' . $hiring_html . '
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
