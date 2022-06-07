<?php
/* ------------------------------------------------ */
/*    		 Premium Jobs                   */ 
/* ------------------------------------------------ */
if (!function_exists('premium_jobs_grid')) {
function premium_jobs_grid()
{
	vc_map(array(
		"name" => esc_html__("Premium Jobs Grid", 'nokri') ,
		"base" => "premium_jobs_grid",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('premium_jobs_grid.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "section_title",
		),	
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section_description",
		),
		array(
			"group" => esc_html__("Settings", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Title Limit", 'nokri') ,
			"param_name" => "title_limit",
			"admin_label" => true,
			"value" => range( 1, 50 ),
			),
		array(
			"group" => esc_html__("Settings", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Number fo Jobs", 'nokri') ,
			"param_name" => "job_class_no",
			"admin_label" => true,
			"value" => range( 1, 50 ),
			),
		array(
			"group" => esc_html__("Settings", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Order By", 'nokri') ,
			"param_name" => "job_order",
			"admin_label" => true,
			"value" => array(
			esc_html__('Select Job order', 'nokri') => '',
			esc_html__('ASC', 'nokri') => 'asc',
			esc_html__('DESC', 'nokri') => 'desc',
			) ,
		),
		array
		(
			"group" => esc_html__("Job Class", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Job Class', 'nokri' ),
			'param_name' => 'job_classes',
			'value' => '',
			'params' => array
			(
				array(
				"group" => esc_html__("Job Class", "nokri"),
				"type" => "dropdown",
				"heading" => esc_html__("Select Your Desired ones", 'nokri') ,
				"param_name" => "job_class",
				"admin_label" => true,
				"value" => nokri_job_class('job_class'),
				),

			)
		),
		
		
			array(
			'group' => esc_html__( 'Link', 'nokri' ),
			"type" => "vc_link",
			"heading" => esc_html__( "All Link", 'nokri' ),
			"param_name" => "link",
			),
			
		),
	));
}
}

add_action('vc_before_init', 'premium_jobs_grid');

if (!function_exists('premium_jobs_grid_short_base_func')) {
function premium_jobs_grid_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'job_order' => '', 
		'section_clr' => '',
		'section_title' => '',
		'section_description' => '',
		'job_classes' => '',
		'job_class_no' => '',
		'title_limit' => '',
		'link' => '', 
	) , $atts));
global $nokri;

if(isset($atts['job_classes']) && !empty($atts['job_classes']) != '')
{       
	$rows = vc_param_group_parse_atts( $atts['job_classes'] );  
	$job_class_array = array();	
	if( (array)count( $rows ) > 0 )
	{     
		foreach($rows as $row ) 
		{                                                           
			$job_class           = nokri_show_taxonomy_all($row['job_class'],'job_class');
                        if( $job_class  != ''){
                            $job_class_array[] =    $job_class;
                           }                      			
		}
	}
               
}
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
$args            = nokri_wpml_show_all_posts_callback($args);
$job_class_query = new WP_Query( $args ); 
$job_class_html = '';
if ( $job_class_query->have_posts() )
{
	  while ( $job_class_query->have_posts()  )
	  { 
			$job_class_query->the_post();
			$job_id		    = get_the_ID();
                        
                         $post_author_id = get_post_field('post_author', $job_id );
                        
                        $post_author_data  = get_userdata( $post_author_id);
                        
                        $author_name      =   $post_author_data->display_name;
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
				$rel_image_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
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
				   $search_url    = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location',$location->term_id);
				   $last_location = '<a href="'.esc_url(nokri_page_lang_url_callback($search_url)).'">'.$location->name.'</a>';
				}
			}
			
/*Title limit */
$title_limit = (isset($title_limit) && $title_limit != "") ? $title_limit : "5";
			
                       $seprator = '' ;
                       $currency   =  nokri_job_post_single_taxonomies('job_currency', $job_currency);
                       $sallary    =  nokri_job_post_single_taxonomies('job_salary', $job_salary);
                       $salry_type =  nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type);
                       
                       if($sallary != '' && $salry_type != '' ){
                           $seprator = '/';                          
                       }
                       
			$job_class_html .= '<div class="col-md-4 col-sm-6 col-xs-12">
								  <div class="featured-image-box">
									<div class="img-box"><img src="'.esc_url($rel_image_link[0]).'" class="img-responsive center-block" alt="'.esc_attr__( 'logo', 'nokri' ).'"></div>
									<div class="content-area">
									  <div class="">
										<h4><a href="'.get_the_permalink().'">'.wp_trim_words( get_the_title(), $title_limit ).'</a></h4>
										<p> '. $author_name  .'   
                                                      '.",".'
                                                    '.$last_location.'</p>
									  </div>
									  <div class="feature-post-meta"> <a href=""> <i class="fa fa-clock-o"></i>'." ".nokri_time_ago().'</a>'.nokri_job_search_taxonomy($job_id).'</div>
									  <div class="feature-post-meta-bottom"> '.nokri_job_post_single_taxonomies('job_currency', $job_currency). " ".nokri_job_post_single_taxonomies('job_salary', $job_salary)." ".$seprator. " ".nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type).'</div>
									  '.$featured_html.'
									</div>
								  </div>
								</div>';
				  }
	} 
/*View  Link */
$read_more = '';
if( isset( $link) )
{
	$read_more = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid',false);	
}
/*Section title */
$section_title       = (isset($section_title) && $section_title != "") ? '<h2>'.$section_title.'</h2>' : "";
/*Section description */
$section_description = (isset($section_description) && $section_description != "") ? '<p>'.$section_description.'<p>' : "";
   return   '<section class="featured-jobs light-blue">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="heading-title black">
              '.$section_title.'
              '.$section_description.'
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="mansi">
               '.$job_class_html.'
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="n-extra-btn-section">
              '.$read_more.'
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('premium_jobs_grid', 'premium_jobs_grid_short_base_func');
}