<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Recent_Jobs_List extends Widget_Base {

    public function get_name() {
        return 'recent-jobs-list';
    }

    public function get_title() {
        return __('Latest Jobs List', 'nokri-elementor');
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
                'latest_jobs_list_clr',
                [
                    'label' => __('Background Color', 'nokri-elementor'),
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
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_desc',
                [
                    'label' => __('Section Descripton', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'btn_text',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'link',
                [
                    'label' => __('Button Link', 'nokri-elementor'),
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
                'setting_section',
                [
                    'label' => __('Settings', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $this->add_control(
                'jobs_no',
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
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);


        $section_post_no = (isset($jobs_no) && $jobs_no != "") ? $jobs_no+1: "6";
        /* Post Orders */
        $section_post_ordr = (isset($job_order) && $job_order != "") ? $job_order : "DESC";
        $recent_job = '';
        $recent_job = array(
            'post_type' => 'job_post',
            'posts_per_page' => $section_post_no,
            'order' => $section_post_ordr,
            'orderby' => 'date',
            'post_status' => array('publish'),
            'meta_query' => array(
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '=',
                ),
            )
        );

        global $nokri;
        $recent_job = nokri_wpml_show_all_posts_callback($recent_job);
        $recent_job_query = new \WP_Query($recent_job);
        $recent_job_html = '';
        if ($recent_job_query->have_posts()) {
            while ($recent_job_query->have_posts()) {
                $recent_job_query->the_post();
                $job_id = get_the_ID();
                $post_author_id = get_post_field('post_author', $job_id);

                $post_author_data = get_userdata($post_author_id);

                $author_name = $post_author_data->display_name;
                /* Getting Profile Photo */
                $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                    $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                }
                if (empty($rel_image_link[0])) {
                    $rel_image_link[0] = get_template_directory_uri() . '/images/default-job.png';
                }

                /* Getting Last country value */
                $job_locations = array();
                $last_location = '';
                $location_wraper   =   "";
                $job_locations = wp_get_object_terms($job_id, array('ad_location'), array('orderby' => 'term_group'));
                if (!empty($job_locations)) {
                    foreach ($job_locations as $location) {

                        $last_location       =  $location->name ;
                        $location_wraper     = '<p>' . $location->name . '</p>';
                    }
                }

                if($last_location != ""){
                    
                    
                    $author_name   =   $author_name. ","." "."$location_wraper";
                }
                
                $recent_job_html .= '<div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="job-list-simple">
                                            <div class="job-list-simple-img">
                                                <a href="' . get_the_permalink() . '"><img src="' . esc_url($rel_image_link[0]) . '" class="img-responsive" alt="' . esc_html__('image', 'nokri-elementor') . '"></a>
                                            </div> 
                                            <div class="job-list-simple-title">
                                                <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                                                   ' . $author_name . '                                                                                                     
                                            </div>
                                        </div>
                                    </div>';
            }
        }
        /* View All  Link */
        
       
        $read_more = '';
        if (isset($btn_text)) {
            $read_more = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid', false,'','',$btn_text);
        }
        /* Section Color */
        $section_clr = (isset($latest_jobs_list_clr) && $latest_jobs_list_clr != "") ? $latest_jobs_list_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? ' <h2>' . $section_title . '</h2>' : "";
        /* Section DESC */
        $section_desc = (isset($section_desc) && $section_desc != "") ? ' <p>' . $section_desc . '</p>' : "";
        echo ' <section class="list-jobs ' . $section_clr . '">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-title black">
                                ' . $section_title . '
                                ' . $section_desc . '
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="mansi">
                                   ' . $recent_job_html . '
                                </div>
                            </div>
                        </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="n-extra-btn-section">
                ' . $read_more . '
              </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </section> ';
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
