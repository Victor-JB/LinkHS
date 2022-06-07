<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Premium_Jobs_Tab2 extends Widget_Base {

    public function get_name() {
        return 'preminum-jobs_tab2';
    }

    public function get_title() {
        return __('Premium Jobs Tab2', 'nokri-elementor');
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
                'Basic_section',
                [
                    'label' => __('Basic', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'jobs_heading',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'jobs_description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'job_class_section',
                [
                    'label' => __('Job Tab', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'job_class_no',
                [
                    'label' => __('Number fo Jobs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                ]
        );
        $this->add_control(
                'job_order',
                [
                    'label' => __('Job order', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select Job order', 'nokri-elementor'),
                        'asc' => esc_html__('ASC', 'nokri-elementor'),
                        'desc' => esc_html__('DESC', 'nokri-elementor'),
                    ),
                ]
        );
        $this->add_control(
                'btn_txt',
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

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'job_class',
                [
                    'label' => __('Select Job Class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_job_class_elementor('job_class'),
                ]
        );
        $this->add_control(
                'job_classes',
                [
                    'label' => __('Select Your Desired ones', 'nokri-elementor'),
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


        global $nokri;
        $read_more = '';
        if (isset($btn_txt)) {
            $read_more = '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"><div class="n-jobs3-product">' . elementor_ThemeBtn($link, 'btn n-btn-flat', false, '', '', $btn_txt) . '</div></div>';
        }
        /* Job class tabs query starts */
        $tabs_html = $tabs_content = '';
        if (isset($atts['job_classes']) && !empty($atts['job_classes']) != '') {
            $rows = $atts['job_classes'];
            if ((array) count($rows) > 0) {

                $count = 1;
                foreach ($rows as $row) {
                    $active = $active_in = '';
                    if ($count == 1) {
                        $active = 'active';
                        $active_in = 'active in';
                    }
                    $job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
                    $term = get_term($row['job_class'], 'job_class');
                    $tabs_html .= '<li class="' . esc_attr($active) . '"><a data-toggle="tab" href="#home' . $count . '">' . $term->name . '</a></li>';
                    $args = array(
                        'post_type' => 'job_post',
                        'order' => $job_order,
                        'orderby' => 'date',
                        'posts_per_page' => $job_class_no + 1,
                        'post_status' => array('publish'),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'job_class',
                                'field' => 'term_id',
                                'terms' => $row['job_class'],
                            )
                        ),
                        'meta_query' => array(
                            array(
                                'key' => '_job_status',
                                'value' => 'active',
                                'compare' => '='
                            )
                        )
                    );
                    $tabs_content .= '<div id="home' . $count . '" class="tab-pane fade ' . esc_attr($active_in) . '">
								  <div class="row">';
                    $job_class_query = new \WP_Query($args);
                    $job_class_html = '';
                    if ($job_class_query->have_posts()) {
                        while ($job_class_query->have_posts()) {
                            $job_class_query->the_post();
                            $job_id = get_the_ID();
                            $author_id = get_post_field('post_author', $job_id);
                            /* Getting Profile Photo */
                            $img = nokri_get_user_profile_pic($author_id, '_sb_user_pic');
                            $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                            $job_type = isset($job_type[0]) ? $job_type[0] : '';
                            $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
                            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                            $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
                            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                            $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
                            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
                            $location = nokri_job_country($job_id, '');
                            /* Getting Catgories */
                            $categories = nokri_job_categories_with_chlid($job_id, 'job_category');
                            $tabs_content .= '
                                <div class = "col-lg-4 col-sm-6 col-md-4 col-xs-12">
                            <div class = "n-jobs3-container">
                            <div class = "n-jobs3-categories">
                            <img src = "' . $img . '" alt = "' . esc_attr__('image', 'nokri-elementor') . '" class = "img-responsive">
                            <div class = "n-jobs3-categories-2">
                            <span>' . $categories . '</span>
                            <a href = "' . get_the_permalink() . '">
                            <div class = "jobs3-style">' . get_the_title() . '</div>
                            </a>
                            <p><i class = "fa fa-clock-o"></i>' . " " . nokri_time_ago() . '</p>
                            </div>
                            </div>
                            <div class = "n-jobs3-content">
                            <p><i class = "fa fa-map-marker"></i>' . $location . '</p>
                            </div>
                            </div>
                            </div>';
                        }
                        $tabs_content .= $read_more;
                    }
                    $tabs_content .= '</div></div>';
                    $count++;
                }
            }
        }
        /* Section title */
        $section_title = (isset($jobs_heading) && $jobs_heading != "") ? '<h2>' . $jobs_heading . '</h2>' : "";
        /* Section description */
        $section_description = (isset($jobs_description) && $jobs_description != "") ? '<p>' . $jobs_description . '<p>' : "";
        echo '<section class = "n-jobs-recomend3 space3">
                            <div class = "container">
                            <div class = "row clear-custom">
                            <div class = "col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <div class = "n-listing-text">
                            ' . $section_title . '
                            ' . $section_description . '
                            </div>
                            <ul class = "nav nav-tabs">
                            ' . $tabs_html . '
                            </ul>
                            <div class = "tab-content">
                            ' . $tabs_content . '
                            </div>
                            </div>
                            </div>
                            </div>
                            </section>

                            ';
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
