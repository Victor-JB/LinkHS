<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Recent_Jobs extends Widget_Base {

    public function get_name() {
        return 'recent-jobs';
    }

    public function get_title() {
        return __('Recent Jobs', 'nokri-elementor');
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
                'recent_jobs_clr',
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
                'btn_txt',
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


      $section_post_no = (isset($jobs_no) && $jobs_no != "") ? $jobs_no +1 : "6";	
 /*Post Orders */
$section_post_ordr = (isset($job_order) && $job_order != "") ? $job_order : "ASC";


$recent_job = '';
$recent_job = array(
	'post_type'      =>  'job_post',
	'posts_per_page' =>  $section_post_no,
	'order'		     =>  $section_post_ordr,
	'orderby' 		 =>  'date',
	'post_status'    =>  array('publish'), 
	 'meta_query'    =>  array(
        array(
			'key'     => '_job_status',
			'value'   => 'active',
			'compare' => '=',
		),
    )
  
);

global $nokri;
$recent_job = nokri_wpml_show_all_posts_callback($recent_job);
$recent_job_query = new \WP_Query( $recent_job ); 
$recent_job_html = '';
if ( $recent_job_query->have_posts() )
	{
	  while ( $recent_job_query->have_posts()  )
	  { 
			$recent_job_query->the_post();
		 	$job_id		    = get_the_ID();
		        $post_author_id = get_post_field('post_author', $job_id );
			$job_type       = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
			$job_type	    = isset( $job_type[0] ) ? $job_type[0] : '';
			$job_salary     =  wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
			$job_salary	    =  isset( $job_salary[0] ) ? $job_salary[0] : '';
			$job_currency   =  wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
			$job_currency	=  isset( $job_currency[0] ) ? $job_currency[0] : '';
			$job_salary_type =  wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
			$job_salary_type =	isset( $job_salary_type[0] ) ? $job_salary_type[0] : '';
			/* Getting Last Child Value*/
			$job_categories  = array();
			$project         =  '';
			$job_categories  =  wp_get_object_terms( $job_id,  array('job_category'), array('orderby' => 'term_group') );
			if ( ! empty( $job_categories ) ) { 
				$last_cat        =  '';
				foreach($job_categories as $c)
				{
				   $project = $c->name;
				}
			}
			/* Getting Profile Photo */
			$rel_image_link[0]   =   get_template_directory_uri(). '/images/candidate-dp.jpg';
			if( get_user_meta($post_author_id, '_sb_user_pic', true ) != "" )
			{
				$attach_id       =	 get_user_meta($post_author_id, '_sb_user_pic', true );
				$rel_image_link  =   wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single');
			}
			
			/* Calling Funtion Job Class For Badges */ 
			$single_job_badges	=	nokri_job_class_badg($job_id);
			$job_badge_text     =    $featured_html = '';
			if( count((array)  $single_job_badges ) > 0) 
			{	
				foreach( $single_job_badges as $job_badge => $val )
					{
						$term_vals =  get_term_meta($val);
						$bg_color  =  get_term_meta( $val, '_job_class_term_color_bg', true );
						$color     =  get_term_meta( $val, '_job_class_term_color', true );
						$style_color = $li_bg_color = $an_color = '';
						if($color != "" )
						{
							$an_color = 'style="color: '.$color.' !important;"';
						}
						if($bg_color != "" )
						{
							$li_bg_color = 'style=" background-color: '.$bg_color.' !important;"';
						}
						$search_url    = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_class',$val);
						$job_badge_text .= '<li '.$li_bg_color.'> <a href="'.esc_url(nokri_page_lang_url_callback($search_url)).'" '.$an_color.'>'.esc_html(ucfirst($job_badge)).'</a></li>';
					}  
					$featured_html = ' <div class="features-star"><i class="fa fa-star"></i></div>';
					$job_badge_text = '<ul class="featured-badge-list">'.$job_badge_text.'</ul>';
					
			}
			
			
			$recent_job_html    .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                           <div class="n-featured-single">
                              <div class="n-featured-single-top">
                                 <div class="n-featured-singel-img">
                                    <a href="'.get_the_permalink().'"><img src="'.esc_url($rel_image_link[0]).'" class="img-responsive" alt="'.esc_attr__('logo', 'nokri-elementor').'"></a>
                                 </div>
                                 <div class="n-featured-singel-meta">
                                    <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                                    <div class="n-cat">'.$project.'</div>
                                    <p><i class="fa fa-map-marker"></i>'.nokri_job_country($job_id,'').'</p>
									'.$job_badge_text.'
                                 </div>
								 '.$featured_html.'
                              </div>
                              <div class="n-featured-single-bottom">
                                 <ul class="">
                                    <li> <i class="fa fa-clock-o"></i>'.nokri_time_ago().'</li>
                                    <li>
									'.nokri_job_post_single_taxonomies('job_currency', $job_currency). " ".nokri_job_post_single_taxonomies('job_salary', $job_salary)." ".'/'. " ".nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type).'
									</li>
                                    <li> <i class="fa fa-hand-o-right"></i>'.nokri_job_post_single_taxonomies('job_type', $job_type).'</li>
                                 </ul>
                              </div>
                           </div>
                        </div>';
				  }
	} 
/*View All  Link */

 $read_more = '';
        if (isset($btn_txt)) {
            $read_more = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear', false,'','',$btn_txt);
        }
/*Section Color */
$section_clr = (isset($recent_jobs_clr) && $recent_jobs_clr != "") ? $recent_jobs_clr : "";
/*Section title */
$section_title = (isset($section_title) && $section_title != "") ? ' <h2>'.$section_title.'</h2>' : "";


   echo   '<section class="n-featured-jobs-two">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="heading-title left">
                     '.$section_title.'
                     <span class="view-more">'.$read_more.'</span>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-features-job-two-box clear-custom">
					 '.$recent_job_html.'
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
