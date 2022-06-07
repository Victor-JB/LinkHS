<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Featured_Candidates2 extends Widget_Base {

    public function get_name() {
        return 'featured_candidates_2';
    }

    public function get_title() {
        return __('Featured candidates 2', 'nokri-elementor');
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
                'sec_bg_clr',
                [
                    'label' => __('Section Backgroun color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select Option', 'nokri-elementor'),
                        'light-grey' => esc_html__('Sky BLue', 'nokri-elementor'),
                        '' => esc_html__('White', 'nokri-elementor'),
                    ),
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



        $this->add_control(
                'candidate_type',
                [
                    'label' => __('Select Candidate type', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select Option', 'nokri-elementor'),
                        '1' => esc_html__('Featured', 'nokri-elementor'),
                        '0' => esc_html__('Simple', 'nokri-elementor'),
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

        extract($atts);
        $featured_cand = '';
        if (isset($candidate_type) && $candidate_type == "1") {
            $featured_cand = array(
                'key' => '_is_candidate_featured',
                'value' => '1',
                'compare' => '='
            );
        }
    
        
        $args = array();
        if(!empty($featured_cand)){
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                $featured_cand,
            ),
        );}
        $user_query = new \WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = $featured = '';
        if (!empty($authors)) {
            $num = 1;
            foreach ($authors as $author) {
                $cand_address = '';
                $user_id = $author->ID;
                $user_name = $author->display_name;
                $cand_add = get_user_meta($user_id, '_cand_address', true);
                $cand_head = get_user_meta($user_id, '_user_headline', true);
                $featured_date = get_user_meta($user_id, '_candidate_feature_profile', true);
                $salary_range = get_user_meta($user_id, '_cand_salary_range', true);
                $salary_curren = get_user_meta($user_id, '_cand_salary_curren', true);
                $today = date("Y-m-d");
                $expiry_date_string = strtotime($featured_date);
                $today_string = strtotime($today);
                if ($today_string > $expiry_date_string) {
                    delete_user_meta($user_id, '_candidate_feature_profile');
                    delete_user_meta($user_id, '_is_candidate_featured');
                }
                if ($cand_head != '') {
                    $cand_head = '<span>' . $cand_head . '</span>';
                }
                if ($cand_add != '') {
                    $cand_address = '<p><i class="fa fa-map-marker"></i>' . $cand_add . '</p>';
                }
                /* Getting Star */
                if (isset($candidate_type) && $candidate_type == "1") {
                    $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                };
                $required_user_html .= '<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
									<div class="n-featured-candidates3-content">
									' . $featured . '
									<a href="' . esc_url(get_author_posts_url($user_id)) . '"><img src="' . nokri_get_user_profile_pic($user_id, '_cand_dp') . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive"></a> 
									<a href="' . esc_url(get_author_posts_url($user_id)) . '">
									<div class="feature-style4">' . $user_name . '</div>
									</a> 
									' . $cand_head . '
									' . $cand_address . '
									<div class="n-feature-profile">
										<ul>
										<li><a href="' . esc_url(get_author_posts_url($user_id)) . '" class="btn n-btn-flat">' . esc_html__('View Profile', 'nokri-elementor') . '</a></li>
										<li class="n-active">' . nokri_job_post_single_taxonomies('job_currency', $salary_curren) . " " . nokri_job_post_single_taxonomies('job_salary', $salary_range) . '</li>
										</ul>
									</div>
									<div class="n-feature-2"> 
										<a href="javascript:void(0)" class="saving_resume" data-cand-id="' . esc_attr($user_id) . '"><i class="fa fa-heart-o"></i></a> 
									</div>
									</div>
								</div>';
                if ($num % 3 == 0) {
                    $required_user_html .= '<div class="clearfix"></div>';
                }
                $num++;
            }
        }

        /* Section clr */
        $section_clr = (isset($sec_bg_clr) && $sec_bg_clr != "") ? $sec_bg_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h3>' . $section_title . '</h3>' : "";
        /* Section description */
        $section_descrp = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";
        echo '<section class="n-fetured-candidates3 space2" ' . esc_attr($section_clr) . '>
<div class="container">
  <div class="row">
	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
	  <div class="heading-penel">
	    ' . $section_title . '
		' . $section_descrp . '
	  </div>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		' . $required_user_html . '
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
