<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us_Tabs extends Widget_Base {

    public function get_name() {
        return 'about-us-tabs';
    }

    public function get_title() {
        return __('Faqs Tab', 'nokri-elementor');
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
                'about_us_clr',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Sky BLue', 'nokri-elementor') => 'light-grey',
                        esc_html__('White', 'nokri-elementor') => '',
                            )),
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
                    'label' => __('Section Detail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'section1_qoute',
                [
                    'label' => __('Section Quote', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'add_section',
                [
                    'label' => __('Add Tabs', 'nokri-elementor'),
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
          $faq_html   =   "";
        if (isset($atts['faq_qstns']) && $atts['faq_qstns'] != '') {
            $rows = $atts['faq_qstns'];
            $faq_html = '';
            $tabs_no = 1;
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $open_tab = 'false';
                    $is_in = '';
                    $tab_closed = '';
                    if ($tabs_no == 1) {
                        $open_tab = 'true';
                        $is_in = ' in';
                        $tab_closed = 'tab-';
                    }

                    /* Question Title */
                    $qstn_title = (isset($row['faq_qstn_title']) && $row['faq_qstn_title'] != "") ? $row['faq_qstn_title'] : "";
                    /* Question Details */
                    $qstn_details = (isset($row['faq_qstn_details']) && $row['faq_qstn_details'] != "") ? $row['faq_qstn_details'] : "";
                    /* Icons */
                    $icon_html = '';
                    if (isset($row['icon']))
                        $icon_html = '<div class="panel-body-icon"><i class="' . esc_attr($row['icon']) . '"></i></div>';
                    $tabs_no++;
                    $faq_html .= '<div class="panel panel-default">
										<div class="panel-heading tab-collapsed" role="tab" id="heading' . esc_attr($tabs_no) . '">
											<h4 class="panel-title">
										<a class="collapse-controle" data-toggle="collapse" data-parent="#accordion" href="#collapse' . esc_attr($tabs_no) . '" aria-expanded="true" aria-controls="collapse' . esc_attr($tabs_no) . '">
										   ' . $qstn_title . '
											<span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
										</a>
									  </h4>
										</div>
										<div id="collapse' . esc_attr($tabs_no) . '" class="panel-collapse collapse ' . esc_attr($is_in) . '" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true">
											<div class="panel-body">
												<div class="panel-body-icon"><i class="fa fa-magic"></i></div>
												' . $qstn_details . '
											</div>
										</div>
									</div>';
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($about_us_clr) && $about_us_clr != "") ? $about_us_clr : "";
        /* Section Title */
        $section_title = (isset($section1_heading) && $section1_heading != "") ? '<h1>' . $section1_heading . '</h1>' : "";
        /* Section Details */
        $section_details = (isset($section1_description) && $section1_description != "") ? '<p>' . $section1_description . '</p>' : "";
        /* Section Details */
        $section_qoute = (isset($section1_qoute) && $section1_qoute != "") ? '<blockquote>' . $section1_qoute . '</blockquote>' : "";
        echo ' <section class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="Heading-title black ">
                                ' . $section_title . '
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            ' . $section_details . '
                            ' . $section_qoute . '
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="panel-group drop-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                              ' . $faq_html . '
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
