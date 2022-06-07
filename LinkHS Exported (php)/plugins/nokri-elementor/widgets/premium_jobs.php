<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Premium_Jobs extends Widget_Base {

    public function get_name() {
        return 'preminum-jobs';
    }

    public function get_title() {
        return __('Premium Jobs', 'nokri-elementor');
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

        $this->end_controls_section();

        $this->start_controls_section(
                'setting_section',
                [
                    'label' => __('Settings', 'nokri-elementor'),
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
                    'label' => __('Number fo Jobs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select Job order', 'nokri-elementor'),
                        'asc' => esc_html__('ASC', 'nokri-elementor'),
                        'desc' => esc_html__('DESC', 'nokri-elementor'),
                    ),
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'job_class_section',
                [
                    'label' => __('Job Class', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    'job_classes' => '{{ { job_classes }}}',
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'link_section',
                [
                    'label' => __('Links', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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


        $job_class_array = array();

        if (isset($atts['job_classes']) && !empty($atts['job_classes']) != '') {
            $rows = $atts['job_classes'];

            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $job_class = nokri_show_taxonomy_all($row['job_class'], 'job_class');
                    if ($job_class != '') {

                        $job_class_array[] = $job_class;
                    }
                }
            }
        }
      $job_class_no  =  $job_class_no!="" ?  $job_class_no  :  5;
        $args = array(
            'post_type' => 'job_post',
            'order' => 'date',
            'orderby' => $job_order,
            'posts_per_page' => $job_class_no + 1,
            'post_status' => array('publish'),
            'tax_query' => array(
                array(
                    'taxonomy' => 'job_class',
                    'field' => 'term_id',
                    'terms' => $job_class_array,
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

        global $nokri;
        $args = nokri_wpml_show_all_posts_callback($args);
        $job_class_query = new \WP_Query($args);
        $job_class_html = '';
        if ($job_class_query->have_posts()) {
            while ($job_class_query->have_posts()) {
                $job_class_query->the_post();
                $job_id = get_the_ID();
                $post_author_id = get_post_field('post_author', $job_id);
                $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                $job_type = isset($job_type[0]) ? $job_type[0] : '';
                $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
                $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
                $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
                $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';

                /* Getting Profile Photo */
                $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                    $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                }
                if (empty($rel_image_link[0])) {
                    $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                }
                /* save job */
                if (is_user_logged_in()) {
                    $user_id = get_current_user_id();
                } else {
                    $user_id = '';
                }
                $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . $user_id, true);
                if ($job_bookmark == '') {
                    $save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "' . $job_id . '"><i class="fa fa-heart-o"></i></a>';
                } else {
                    $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class="fa fa-heart"></i></a>';
                }

                /* Calling Funtion Job Class For Badges */
                $job_badge_text = nokri_premium_job_class_badges($job_id);
                if ($job_badge_text != '') {
                    $featured_html = '<div class="features-star-2"><i class="fa fa-star"></i></div>';
                }
                /* Getting Last Child Value */
                $job_categories = array();
                $project = '';
                $job_categories = wp_get_object_terms($job_id, array('job_category'), array('orderby' => 'term_group'));
                if (!empty($job_categories)) {
                    $last_cat = '';
                    foreach ($job_categories as $c) {
                        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', $c->term_id);
                        $project = '<a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '">' . $c->name . '</a>';
                    }
                }
                /* Getting Last country value */
                $job_locations = array();
                $last_location = '';
                $job_locations = wp_get_object_terms($job_id, array('ad_location'), array('orderby' => 'term_group'));
                if (!empty($job_locations)) {
                    foreach ($job_locations as $location) {
                        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', $location->term_id);
                        $last_location = '<a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '">' . $location->name . '</a>';
                    }
                }
                /* Jobs aplly with */
                $exter_apply_btn = nokri_apply_with_external_source($job_id);
                $job_class_html .= '<div class="n-job-single">
                    <div class="n-job-img">
                        <img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri-elementor') . '" class="img-responsive">
                    </div>
                    <div class="n-job-detail">
					' . $featured_html . '
                        <ul class="list-inline">
                            <li class="n-job-title-box">
                            	<h4> <a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
                                <p><span><i class="ti-location-pin"></i>' . " " . $last_location . '</span>
								   <span><i class="ti-tag"></i>' . " " . $project . '</span></p>
								 ' . $job_badge_text . '
                            </li>
                            <li class="n-job-short">
                            	<span> <strong>' . esc_html__('Type', 'nokri-elementor') . '</strong>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</span>
                                <span> <strong>' . esc_html__('Time:', 'nokri-elementor') . '</strong>' . nokri_time_ago() . '</span>
                            </li>
                            <li class="n-job-btns">
							' . $exter_apply_btn . '
                             ' . "" . ($save_job) . '
                            </li>
                        </ul>
                    </div>
                </div>';
            }
        }
        /* View  Link */
        $read_more = '';
        if (isset($btn1_txt)) {
            $read_more = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear', false, '', '', $btn1_txt);
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";
        /* Section description */
        $section_description = (isset($section_description) && $section_description != "") ? '<p>' . $section_description . '<p>' : "";
        echo '<section class="n-featured-jobs">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div class="heading-title black">
              ' . $section_title . '
			  ' . $section_description . '
            </div>
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="n-featured-job-boxes">
                ' . $job_class_html . '
            </div>
            <div class="n-extra-btn-section">
            	' . $read_more . '
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
