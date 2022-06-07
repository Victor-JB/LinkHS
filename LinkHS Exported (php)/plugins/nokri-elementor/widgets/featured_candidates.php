<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Featured_Candidates extends Widget_Base {

    public function get_name() {
        return 'featured_candidates';
    }

    public function get_title() {
        return __('Featured candidates', 'nokri-elementor');
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
                    'label' => __('Select Bg color', 'nokri-elementor'),
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
                'candidate_type',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                     '' =>    esc_html__('Select Option', 'nokri-elementor'),
                   '1'   =>  esc_html__('Featured', 'nokri-elementor')  ,
                     '0' =>  esc_html__('Simple', 'nokri-elementor') ,
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
        );
        $user_query = new \WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = $featured = '';
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $cand_address = '';
                $user_id = $author->ID;
                $user_name = $author->display_name;
                $cand_add = get_user_meta($user_id, '_cand_address', true);
                $cand_head = get_user_meta($user_id, '_user_headline', true);
                $featured_date = get_user_meta($user_id, '_candidate_feature_profile', true);
                $today = date("Y-m-d");
                $expiry_date_string = strtotime($featured_date);
                $today_string = strtotime($today);
                if ($today_string > $expiry_date_string) {
                    delete_user_meta($user_id, '_candidate_feature_profile');
                    delete_user_meta($user_id, '_is_candidate_featured');
                }
                if ($cand_head != '') {
                    $cand_head = '<p>' . $cand_head . '</p>';
                }
                if ($cand_add != '') {
                    $cand_address = '<div class="n-candidate-location"><i class="fa fa-map-marker"></i><p>' . $cand_add . '</p></div>';
                }
                /* Getting Star */
                if (isset($candidate_type) && $candidate_type == "1") {
                    $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                };
                /* Getting Candidates Skills  */
                $skill_tags = nokri_get_candidates_skills($user_id, '');
                $required_user_html .= '<div class="item">
								   <div class="n-featured-single">
									  <div class="n-featured-candidates-single-top">
									  <a href="javascript:void(0)" class="bookmark-icon active saving_resume" data-cand-id=' . esc_attr($user_id) . '><i class="fa fa-heart-o"></i></a>
									  ' . $featured . '
										 <div class="n-candidate-title">
											<h4>' . $user_name . '</h4>
											' . $cand_head . '
										 </div>
										 <div class="n-canididate-avatar">
											<img src="' . nokri_get_user_profile_pic($user_id, '_cand_dp') . '" class="img-responsive" alt="' . esc_attr__('Image', 'nokri-elementor') . '">
										 </div>
										 ' . $cand_address . '
										 <div class="n-candidate-skills">
											' . $skill_tags . '
										 </div>
									  </div>
									  <div class="n-candidates-single-bottom">
										  <a href="' . esc_url(get_author_posts_url($user_id)) . '">' . esc_html__('View Profile', 'nokri-elementor') . '</a>
									  </div>
								   </div>
								</div>';
            }
        }

        /* Section clr */
        $section_clr = (isset($sec_bg_clr) && $sec_bg_clr != "") ? $sec_bg_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";

        echo '<section class="n-featured-candidates ' . esc_attr($section_clr) . ' candidates-2">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="heading-title left">
                    ' . $section_title . '
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-featured-candidates-box">
					  <div class="n-candidatel-2 owl-carousel owl-theme">
                        ' . $required_user_html . '
						</div>
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
