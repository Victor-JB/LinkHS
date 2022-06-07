<?php
/* ------------------*/
/* Recent Jobs      */ 
/* --------------- */
if (!function_exists('recent_jobs')) {
function recent_jobs()
{
	vc_map(array(
		"name" => esc_html__("Recent Jobs", 'nokri') ,
		"base" => "recent_jobs",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_recent_jobs.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "recent_jobs_clr",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Sky BLue', 'nokri') =>'light-grey',
		esc_html__('White', 'nokri') =>'',
		),
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
		'group' => esc_html__( 'Basic', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Link", 'nokri' ),
		"param_name" => "link",
		),
		array(
			"group" => esc_html__("Settings", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Number fo Jobs", 'nokri') ,
			"param_name" => "jobs_no",
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
			esc_html__('Select Ads order', 'nokri') => '',
			esc_html__('Ascending', 'nokri') => 'ASC',
			esc_html__('Descending ', 'nokri') => 'DESC',
			) ,
		),
			
			
		),
	));
}
}

add_action('vc_before_init', 'recent_jobs');

if (!function_exists('recent_jobs_short_base_func')) {
function recent_jobs_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

	extract(shortcode_atts(array(
		'recent_jobs_clr' => '',
		'jobs_no' => '',   
		'section_title' => '', 
		'link' => '', 
	) , $atts));


 /*Post Numbers*/
$section_post_no = (isset($jobs_no) && $jobs_no != "") ? $jobs_no : "6";	
 /*Post Orders */
$section_post_ordr = (isset($job_order) && $job_order != "") ? $job_order : "ASC";	
$recent_job = '';
$recent_job = array(
	'post_type'      =>  'job_post',
	'posts_per_page' =>  $section_post_no,
	'order'		     =>  'date',
	'orderby' 		 =>  $section_post_ordr,
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
$recent_job_query = new WP_Query( $recent_job ); 
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
                                    <a href="'.get_the_permalink().'"><img src="'.esc_url($rel_image_link[0]).'" class="img-responsive" alt="'.esc_attr__('logo', 'nokri').'"></a>
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
if( isset( $link) )
{
	$read_more = nokri_ThemeBtn($link, 'btn n-btn-rounded',false);	
}
/*Section Color */
$section_clr = (isset($recent_jobs_clr) && $recent_jobs_clr != "") ? $recent_jobs_clr : "";
/*Section title */
$section_title = (isset($section_title) && $section_title != "") ? ' <h2>'.$section_title.'</h2>' : "";
   return   '<section class="n-featured-jobs-two">
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
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('recent_jobs', 'recent_jobs_short_base_func');
}