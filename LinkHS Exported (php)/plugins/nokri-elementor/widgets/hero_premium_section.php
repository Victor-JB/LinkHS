<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Premium_Section extends Widget_Base {

    public function get_name() {
        return 'hero-section-premium';
    }

    public function get_title() {
        return __('Hero Premium Section ', 'nokri-elementor');
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
                'section_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );    
        $this->add_control(
                'section_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_tagline',
                [
                    'label' => __('Section Tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'tabs_slider_switch',
                [
                    'label' => __('Hide/show tabs and slider', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> array_flip( array(
			esc_html__('Select an option', 'nokri-elementor') => '',
			esc_html__('Show', 'nokri-elementor') => '1',
			esc_html__('Hide', 'nokri-elementor') => '0',
			) ),
                ]
        );
        $this->end_controls_section();

      
        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Category', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
     
         $this->add_control(
                'slider_cat_switch',
                [
                    'label' => __('Hide/Show Categories Slider', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> array_flip(array(
			esc_html__('Select an option', 'nokri-elementor') => '',
			esc_html__('Show', 'nokri-elementor') => '1',
			esc_html__('Hide', 'nokri-elementor') => '0',
			) ),
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );
         $repeater->add_control(
                'cat_img',
                [
                    'label' => __('Select category image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                     "description" => esc_html__('64x64', 'nokri-elementor'),
                   
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'countries' => '{{ { countries }}}',
                ]
        );
        
        $this->end_controls_section();
           $this->start_controls_section(
                'Tab_section',
                [
                    'label' => __('Tabs', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
     
       $this->add_control(
                'tab_animation',
                [
                    'label' => __('Tabs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> array_flip( array(
			esc_html__('Select your desired', 'nokri-elementor') => '',
			esc_html__('Down', 'nokri-elementor') => 'fadeInDown',
			esc_html__('Left', 'nokri-elementor') => 'fadeInLeft',
			esc_html__('Right', 'nokri-elementor') => 'fadeInRight',
			) ),
                ]
        );
        $this->add_control(
                'job_class_no',
                [
                    'label' => __('Number fo Jobs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> range( 1, 50 ),
                ]
        );
         $this->add_control(
                'job_order',
                [
                    'label' => __('Order By', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> array_flip(array(
			esc_html__('Select Job order', 'nokri-elementor') => '',
			esc_html__('ASC', 'nokri-elementor') => 'asc',
			esc_html__('DESC', 'nokri-elementor') => 'desc',
			) )
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'job_class',
                [
                    'label' => __('Select Job class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_job_class_elementor('job_class'),
                ]
        );
        $this->add_control(
                'job_classes',
                [
                    'label' => __('Select job class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    
                ]
        );
          
        $this->end_controls_section();
        
        $this->start_controls_section(
                'Slider',
                [
                    'label' => __('Slider', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
     
       $this->add_control(
                'slider_switch',
                [
                    'label' => __("Hide/Show Slider", 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options'=> array_flip( array(
			esc_html__('Select an option', 'nokri-elementor') => '',
			esc_html__('Show', 'nokri-elementor') => '1',
			esc_html__('Hide', 'nokri-elementor') => '0',
			)  ),
                ]
        );
        $this->add_control(
                'slider_title',
                [
                    'label' => __('Slider title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,                  
                ]
        );
        
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'slider_job_class',
                [
                    'label' => __('Select Job class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_job_class_elementor('job_class'),
                ]
        );
        $this->add_control(
                'slider_jobs_class',
                [
                    'label' => __('Select job class', 'nokri-elementor'),
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
        
        $atts   =  $settings;
        
        extract($settings);
       
        $job_class_array = array();    
       if(isset($atts['slider_jobs_class']) && $atts['slider_jobs_class'] != '')
{	
	$rows_class = $atts['slider_jobs_class'] ;
	if( (array)count( $rows_class ) > 0 )
	{
		foreach($rows_class as $row ) 
		{
			$job_class_array[] = (isset($row['slider_job_class']) && $row['slider_job_class'] != "") ? $row['slider_job_class'] : array();
		}
	}
}


$job_class_no   = isset($job_class_no) && $job_class_no != ""  ? $job_class_no + 1 : 3;
$args1 = array(
	'post_type'   		=> 'job_post',
	'order'       		=> 'date',
	'orderby'     		=> $job_order,
	'posts_per_page' 	=> $job_class_no +1,
	'post_status' 		=> array('publish'),
	'tax_query' => array(
            array(
                'taxonomy' => 'job_class',
                'field' => 'term_id',
                'terms' => $job_class_array,
            )
        ), 
	 'meta_query' 		=> array(
		array(
			'key'     => '_job_status',
			'value'   => 'active',
			'compare' => '='
		)
	)
);
global $nokri;
$args1 = nokri_wpml_show_all_posts_callback($args1);
$job_class_slider = new \WP_Query( $args1 ); 
$slider_html = '';
 $count = 1;
if ( $job_class_slider->have_posts() )
{
	 $count = 1;
	  while ( $job_class_slider->have_posts()  )
	  { 
			$job_class_slider->the_post();
			$job_id		    = get_the_ID().'<br>';
		        $post_author_id = get_post_field('post_author', $job_id );
			$job_type       = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
			$job_type	    = isset( $job_type[0] ) ? $job_type[0] : '';
			$job_salary     =  wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
			$job_salary	    =  isset( $job_salary[0] ) ? $job_salary[0] : '';
			$job_currency   =  wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
			$job_currency	=  isset( $job_currency[0] ) ? $job_currency[0] : '';
			$job_salary_type =  wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
			$job_salary_type =	isset( $job_salary_type[0] ) ? $job_salary_type[0] : '';
			/* Getting Profile Photo */
			$rel_image_link[0]   =   get_template_directory_uri(). '/images/candidate-dp.jpg';
			if( get_user_meta($post_author_id, '_sb_user_pic', true ) != "" )
			{
				$attach_id       =	 get_user_meta($post_author_id, '_sb_user_pic', true );
				$rel_image_link  =   wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single');
			}
			if(empty($rel_image_link[0]))
			{
				$rel_image_link[0] =  get_template_directory_uri(). '/images/default-job.png';
			}
			/* Calling Funtion Job Class For Badges */ 
			$job_badge_text = nokri_premium_job_class_badges($job_id);
			if($job_badge_text != '')
			{
				$featured_html = '<div class="features-star"><i class="fa fa-star"></i></div>';
			}
			/* Getting Last country value*/
			$job_locations  = array();
			$last_location  =  '';
			$job_locations  =  wp_get_object_terms( $job_id,  array('ad_location'), array('orderby' => 'term_group') );
			if ( ! empty( $job_locations ) ) { 
				foreach($job_locations as $location)
				{
					$search_url      = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location',$location->term_id); 
					$last_location = '<a href="'.esc_url(nokri_page_lang_url_callback($search_url)).'">'.$location->name.'</a>';
				}
			}
			if(  $count%2 == 1)
			{
				 $slider_html .= '<div class="item">';
			}
			$slider_html .= '<div class="featured-image-box">
                              <div class="img-box"><img src="'.esc_url($rel_image_link[0]).'" class="img-responsive center-block" alt="'.esc_attr__( 'logo', 'nokri-elementor' ).'"></div>
                              <div class="content-area">
                                <div class="">
                                  <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>                                  
                                  <p>'." ".$last_location.'</p>
                                </div>
                                <div class="feature-post-meta"> <a href=""> <i class="fa fa-clock-o"></i> '." ".nokri_time_ago().'</a>'.nokri_job_search_taxonomy($job_id).'</div>
                                <div class="feature-post-meta-bottom"> <span> '.nokri_job_post_single_taxonomies('job_currency', $job_currency). " ".nokri_job_post_single_taxonomies('job_salary', $job_salary)." ".'/'. " ".nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type).'</span>  </div>
                              </div>
                            </div>';
							if($count%2 == 0)
							{
								 $slider_html .= '</div>';
							}
							$count++;
				  }
	}
        
if ( $count % 2 != 1) $slider_html .= '</div>';
// For Category Slider Start
if(isset($atts['cats']) && $atts['cats'] != '')
{
	$rows  		=  $atts['cats'] ;
	$cats 		= false;
	$cats_html 	= '';
	if( count((array) $rows ) > 0 )
	{
	   $cats_html =  '';
	   foreach($rows as $row )
	   {
			if( isset( $row['cat'] )  )
			{
                            
                        
				 if($row['cat'] == 'all' ) 
				 {
					  $cats = true;
					  break;
				 }
                                 
                                
				 $category = get_term_by('slug', $row['cat'], 'job_category');
				 /* calling function for openings*/
				 $custom_count =  nokri_get_opening_count($category->term_id,'job_category');
				 if( count((array) $category ) == 0 )
				 continue;
				 /*Category Image */
				 $cat_img = '';	
				if(isset($row['cat_img']['url']))
				{
					
					$img_thumb 	= $row['cat_img']['url'];	
					$cat_img    =   '<img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri-elementor' ).'">';
				}
					$cats_html .= '<div class="item">
									<a href="'.nokri_cat_link_page($category->term_id).'">
										'.$cat_img.'
										<h4>'.$category->name.'</h4>
									</a>
								  </div>';
		   }
		}
		  if( $cats )
		   {
				$ad_cats = nokri_get_cats('job_category', 0 );
				 /*Category Image */
				 $cat_img = '';	
				if(isset($row['cat_img']['url']))
				{
					 $img 		=  	$row['cat_img']['url'];
					$img_thumb 	= 	$img;
					$cat_img    =   '<img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri-elementor' ).'">';
				}
				foreach( $ad_cats as $cat )
				{
					
					$cats_html .= '<div class="item">
									<a href="'.nokri_cat_link_page($cat->term_id).'">
										'.$cat_img.'
										<h4>'.$cat->name.'</h4>
									</a>
								  </div>';
				}
		   }	  
	}
}
// For Category Slider End
/* Tab animation */
$tab_animation    = (isset($tab_animation) && $tab_animation != "") ? $tab_animation : "fadeInDown";
/* Job class tabs query starts */
$rows =  $atts['job_classes'];	
if( (array)count( $rows ) > 0 )
{
	$tabs_html = $tabs_content = '';
	$count = 1;
	foreach($rows as $row ) 
	{ 
		$active = '';
		if($count == 1) {  $active = 'active'; } 
		$job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
		$term              =  get_term( $row['job_class'], 'job_class' );
		$tabs_html        .= '<li class="'.esc_attr($active).'"> <a href="#tab'.$row['job_class'].'" data-toggle="tab"><span>'.$term->name.'</span></a> </li>';
$args = array(
	'post_type'   		=> 'job_post',
	'order'       		=> 'date',
	'orderby'     		=> $job_order,
	'posts_per_page' 	=> $job_class_no,
	'post_status' 		=> array('publish'),
	'tax_query' => array(
            array(
                'taxonomy' => 'job_class',
                'field' => 'term_id',
                'terms' => $row['job_class'],
            )
        ), 
	 'meta_query' 		=> array(
		array(
			'key'     => '_job_status',
			'value'   => 'active',
			'compare' => '='
		)
	)
);
$tabs_content .= '<div class="tab-pane '.esc_attr($active).' animated '.$tab_animation.'" id="tab'.$row['job_class'].'">
                              <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                <div class="n-search-listing n-featured-jobs">
                              <div class="n-featured-job-boxes">';
global $nokri;
$job_class_query = new \WP_Query( $args ); 
$job_class_html = '';
if ( $job_class_query->have_posts() )
{
	  while ( $job_class_query->have_posts()  )
	  { 
			$job_class_query->the_post();
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
                        
                        
                        $job_apply_with	   = get_post_meta($job_id, '_job_apply_with', true);
			$job_apply_url	   = get_post_meta($job_id, '_job_apply_url', true); 
			$job_apply_mail	   = get_post_meta($job_id, '_job_apply_mail', true);
			if($job_apply_with == 'exter')
			{ 
				$apply_button = '<a href="javascript:void(0)" class="btn n-btn-rounded external_apply" data-job-id="'. esc_attr( $job_id ).'"  data-job-exter="'.( $job_apply_url ).'">'. esc_html__('Apply now', 'nokri-elementor' ).'</a>';
			}
			else if ($job_apply_with == 'mail') 
			{
				$apply_button = '<a href="javascript:void(0)" class="btn n-btn-rounded email_apply" data-job-id="'. esc_attr( $job_id ).'" data-job-exter="'.( $job_apply_mail ).'">'. esc_html__('Apply now', 'nokri-elementor' ).'</a>';
			}
			else
			{
				$apply_button = '<a href="javascript:void(0)" class="btn n-btn-rounded apply_job" data-toggle="modal" data-target="#myModal"  data-job-id='.esc_attr( $job_id ).'>'.esc_html__( 'Apply Now', 'nokri-elementor' ).' </a>';
			}
			/* Getting Profile Photo */
			$rel_image_link[0]   =   get_template_directory_uri(). '/images/candidate-dp.jpg';
			if( get_user_meta($post_author_id, '_sb_user_pic', true ) != "" )
			{
				$attach_id       =	 get_user_meta($post_author_id, '_sb_user_pic', true );
				$rel_image_link  =   wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single');
			}
			if(empty($rel_image_link[0]))
			{
				$rel_image_link[0] =  get_template_directory_uri(). '/images/default-job.png';
			}
			/* Calling Funtion Job Class For Badges */ 
			$job_badge_text = nokri_premium_job_class_badges($job_id);
			if($job_badge_text != '')
			{
				$featured_html = '<div class="features-star"><i class="fa fa-star"></i></div>';
			}
			/* Getting Last country value*/
			$job_locations  = array();
			$last_location        =  '';
			$job_locations  =  wp_get_object_terms( $job_id,  array('ad_location'), array('orderby' => 'term_group') );
			if ( ! empty( $job_locations ) ) { 
				foreach($job_locations as $location)
				{
					$search_url      = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location',$location->term_id); 	
					$last_location = '<a href="'.esc_url(nokri_page_lang_url_callback($search_url)).'">'.$location->name.'</a>';
				}
			}
			/* save job */
			if(is_user_logged_in())
			{
				$user_id         =  get_current_user_id();
			}
			else
			{
				$user_id = '';
			}
			$job_bookmark = get_post_meta( $job_id, '_job_saved_value_'.$user_id, true);
			if ( $job_bookmark == '' ) 
			{
                            $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class=" fa fa-heart-o"></i></a>';
				
			}
			else
			{
                            
				$save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "'.$job_id.'"><i class="fa fa-heart"></i></a>';
			}
			$tabs_content .= '<div class="n-job-single">
                                    <div class="n-job-img">
                                       <img src="'.esc_url($rel_image_link[0]).'" alt="'.esc_attr__( 'logo', 'nokri-elementor' ).'" class="img-responsive">
                                    </div>
                                    <div class="n-job-detail">
                                       <ul class="list-inline">
                                          <li class="n-job-title-box">
                                                                                     
                                            <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                                                
                                             <p>'." ".$last_location.'</p>
                                                  <p>'.$job_badge_text.'</p>  
                                          </li>
                                          <li class="n-job-short">
                                             <span> <strong>'.esc_html__( ' Type :', 'nokri-elementor' ).'</strong>'.nokri_job_post_single_taxonomies('job_type', $job_type).'</span>
                                             <span> <strong> '.esc_html__( 'Date :', 'nokri-elementor' ).'</strong>'." ".nokri_time_ago().'</span>
                                          </li>
                                          <li class="n-job-btns">
                                            '.$apply_button.'
                                             '.$save_job.'
                                          </li>
                                       </ul>
                                    </div>
                                 </div>';
				  }
} 
$tabs_content .= '</div></div> </div></div>';
 $count++;
	}
}
/* Job class tabs query End */
/*Section title */
$section_heading    = (isset($section_heading) && $section_heading != "") ? '<h1>'.$section_heading.'</h1>' : "";
/*slider title */
$slider_title       = (isset($slider_title) && $slider_title != "") ? '<h4 class="featured-job-sidebar-heading-title">'.$slider_title.'</h4>' : "";
/*Section description */
$section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<p>'.$section_tagline.'<p>' : "";
/* Background Image */
$bg_img = '';
if( isset($section_img['url'])!= "" )
{ 
$bgImageURL	=	$section_img['url'];
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url('.$bgImageURL.') no-repeat scroll center center / cover;"' : "";
}
/*Slider Switch */
$slider_final_html = '';
$tabs_col = 12;
$slider_switch = (isset($slider_switch) && $slider_switch != "") ? $slider_switch : "1";
if($slider_switch)
{
	$tabs_col = 8;
	$slider_final_html = '<div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="featured-job-slider-sidebar">
                        '.$slider_title.'
                        <div class="featured-job-slider owl-carousel owl-theme">
                         '.$slider_html.'
                        </div>
                    </div>
                </div>';
}
/*Slider Cat Switch */
$slider_cat_html = '';
$slider_cat_switch = (isset($slider_cat_switch) && $slider_cat_switch != "") ? $slider_cat_switch : "1";
if($slider_cat_switch)
{
	$slider_cat_html = '<div class="categories-icons">
                        	<div class="featured-cat owl-carousel owl-theme">
                              '.$cats_html.'
                            </div>
                        </div>';
}
/*Tabs slider Switch */
$tabs_slider_html = '';
$tabs_slider_switch = (isset($tabs_slider_switch) && $tabs_slider_switch != "") ? $tabs_slider_switch : "1";
if($tabs_slider_switch)
{
	$tabs_slider_html = '<section class="cat-tabs bg-white">
            <div class="container">
              <div class="row">
                <div class="col-md-'.esc_attr($tabs_col).' col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-primary">
                          <div class="panel-heading"> 
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                              '.$tabs_html.'
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="tab-content">
                            '.$tabs_content.'
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                '.$slider_final_html.'
              </div>
            </div>
          </section>';
}
echo   '<section class="main-section-category" '.str_replace('\\',"",$bg_img).'> 
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12 ">
                	<div class="main-cat-detail-box">
                    	'.$section_heading.'
                        <hr>
                        <div class="clearfix"></div>
                        '.$section_tagline.'
                    	<form method="get" action="'.get_the_permalink($nokri['sb_search_page']).'">
						'.nokri_form_lang_field_callback(false).'
                          <div class="form-group">
							  <input type="text" class="form-control" name="job-title" placeholder="'.esc_html__('Search here','nokri-elementor').'">
                              <button type="submit"><i class="ti-search"></i> </button>
                            </div>
                        </form>
                        '.$slider_cat_html.'
                    </div>
                </div>
              </div>
            </div>
          </section>
         '.$tabs_slider_html.'';

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
