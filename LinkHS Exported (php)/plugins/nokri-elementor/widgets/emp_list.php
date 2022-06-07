<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Emp_List extends Widget_Base {

    public function get_name() {
        return 'emp-list';
    }

    public function get_title() {
        return __('Employer List', 'nokri-elementor');
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
                'employer_bg_clr',
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
                'btn_txt',
                [
                    'label' => __('Some Detail', 'nokri-elementor'),
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

        $this->start_controls_section(
                'employer_section',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'employer',
                [
                    'label' => __('Select employer', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_top_employers_lists_elementor(),
                ]
        );
        $this->add_control(
                'employers',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'countries' => '{{ { countries }}}',
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
       $employers_array   = array();
       if(isset($atts['employers']) && $atts['employers'] != '')
{	
	$rows = $atts['employers'];
	$stories_html = '';
	$current_user_id 	  = get_current_user_id();
	if( (array)count( $rows ) > 0 )
	{
		foreach($rows as $row ) 
		{
			$employers_array[] = (isset($row['employer']) && $row['employer'] != "") ? $row['employer'] : array();
		}
	}
}
		global $nokri;	
	if( count((array)  $employers_array ) > 0 && $employers_array != "" )
		{
			foreach( $employers_array as $key => $value )
			{
				$employers_array[]	=	$value;
			}
		}
		
		
	/* WP User Query */
                $args = array();
                if(!empty($employers_array)){
		$args 			= 	array (
		'order' 		=> 	'DESC',
		'include'       => $employers_array,
                );}
	$user_query = new \WP_User_Query($args);	
	$authors = $user_query->get_results();
	$required_user_html = '';
	if (!empty($authors))
	{
		$fb_link = $twitter_link = $google_link = $linkedin_link =  $follow_btn = '';
		foreach ($authors as $author)
		{
			$emp_fb    =  $emp_twitter = $emp_google = $emp_linkedin = '';
			$user_id   = $author->ID;
			$user_name = $author->display_name;
			/* Profile Pic  */
			$image_dp_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
			if( isset( $nokri['nokri_user_dp']['url'] ) && $nokri['nokri_user_dp']['url'] != "" )
			{
				$image_dp_link = array($nokri['nokri_user_dp']['url']);	
			}
			if(get_user_meta($user_id, '_sb_user_pic', true ) != '')
			{
				$attach_dp_id     =  get_user_meta($user_id, '_sb_user_pic', true );
				$image_dp_link    =  wp_get_attachment_image_src( $attach_dp_id, '' );
			}
			$user_post_count = count_user_posts( $user_id , 'job_post' );
			$user_post_count_html = '<span class="job-openings">'.$user_post_count." ".esc_html__( 'Openings', 'nokri-elementor' ).'</span>';
			$emp_address   = get_user_meta($user_id, '_emp_map_location', true);
				/* Social links */
				$emp_fb        = get_user_meta($user_id, '_emp_fb', true);
				$emp_twitter    = get_user_meta($user_id, '_emp_twiter', true);
				$emp_google    = get_user_meta($user_id, '_emp_google', true);
				$emp_linkedin    = get_user_meta($user_id, '_emp_linked', true);
				 if($emp_fb)
				 {
					 $fb_link = '<li><a href="'. esc_url($emp_fb).'"><img src="'. get_template_directory_uri().'/images/icons/006-facebook.png" alt="'.esc_attr__( 'icon', 'nokri-elementor' ).'"></a></li>';
				 }
				 if($emp_twitter)
				 {
					 $twitter_link = '<li><a href="'. esc_url($emp_twitter).'"><img src="'. get_template_directory_uri().'/images/icons/004-twitter.png" alt="'.esc_attr__( 'icon', 'nokri-elementor' ).'"></a></li>';
				 }
				  if($emp_google)
				 {
					 $google_link = '<li><a href="'. esc_url($emp_google).'"><img src="'. get_template_directory_uri().'/images/icons/003-google-plus.png" alt="'.esc_attr__( 'icon', 'nokri-elementor' ).'"></a></li>';
				 }
				 if($emp_linkedin)
				 {
					 $linkedin_link = '<li><a href="'. esc_url($emp_linkedin).'"><img src="'. get_template_directory_uri().'/images/icons/005-linkedin.png" alt="'.esc_attr__( 'icon', 'nokri-elementor' ).'"></a></li>';
				 }
				/* Social links */
				$adress_html = '';
				if($emp_address)
				{
					$adress_html = '<p><i class="fa fa-map-marker"></i>'.$emp_address.'</p>';
				}
				    /* follow company */
				    if(get_user_meta($current_user_id, '_sb_reg_type', true) == 0)
					 { 
						$comp_follow = get_user_meta( $current_user_id, '_cand_follow_company_'.$user_id,true);
					 	if ( $comp_follow ) 
						{  
							$follow_btn = '<a   class="btn n-btn-rounded">'.esc_html__('Followed','nokri-elementor').'</a>';
					    } 
					 else
					  { 
							$follow_btn = '<a  data-value="'.esc_attr( $user_id ).'"  class="btn n-btn-rounded follow_company"><i class="fa fa-send-o"></i>'. " ".esc_html__('Follow','nokri-elementor').'</a>';
					  }
					 }
                                         
                                         
                                               $featured_date = get_user_meta($user_id, '_emp_feature_profile', true);
                                                    $is_featured = false;
                                                    $today = date("Y-m-d");
                                                    $expiry_date_string = strtotime($featured_date);
                                                    $today_string = strtotime($today);
                                                    if ($today_string > $expiry_date_string) {
                                                        delete_user_meta($user_id, '_emp_feature_profile');
                                                        delete_user_meta($user_id, '_is_emp_featured');
                                                    } else {
                                                        $is_featured = true;
                                                    }
                                                    $featured = "";
                                                    if (isset($is_featured) && $is_featured) {
                                                        $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                                                    };

                                                    
				
				
			$required_user_html .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                             <div class="n-company-grid-single">
                                                 '.$featured.'
                                                <div class="n-company-grid-img">
                                                   <div class="n-company-logo">
                                                      <img src="'.esc_url($image_dp_link[0]).'" class="img-responsive" alt="'.esc_attr__('image','nokri-elementor').'">
                                                   </div>
                                                   <div class="n-company-title">
                                                      <h3><a href="'.esc_url(get_author_posts_url($user_id)).'">'.$user_name.'</a></h3>
                                                      '.$adress_html.'
                                                   </div>
												   <div class="n-company-follow">
                                                      '.$follow_btn.'
                                                   </div>
                                                </div>
                                                <div class="n-company-bottom">
                                                   <ul class="social-links list-inline">
                                                      '.$fb_link.'
                                                     '.$twitter_link.'
                                                      '.$google_link.'
                                                      '.$linkedin_link.'
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>';
		}
	}

/*Section clr*/
$section_clr = (isset($employer_bg_clr) && $employer_bg_clr != "") ? $employer_bg_clr : "";
/*Section title*/
$section_title = (isset($section_title) && $section_title != "") ? '<h2>'.$section_title.'</h2>' : "";
/*View All  Link */
$read_more = ''; 
        if (isset($btn_txt)) {
            $read_more = '<span class="view-more">'.elementor_ThemeBtn($link, 'btn n-btn-rounded', false,'','',$btn_txt).'</span>';	
        }
echo '<section class="'.esc_attr($section_clr).'">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="heading-title left">
                     '.$section_title.'
                     '.$read_more.'
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-company-grids">
					 '.$required_user_html.'
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
