<?php
/* ------------------*/
/* Recent Jobs      */ 
/* --------------- */
if (!function_exists('latest_jobs_list')) {
function latest_jobs_list()
{
	vc_map(array(
		"name" => esc_html__("Latest Jobs List", 'nokri') ,
		"base" => "latest_jobs_list",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('latest_jobs_list.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "latest_jobs_list_clr",
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
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "section_desc",
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

add_action('vc_before_init', 'latest_jobs_list');

if (!function_exists('latest_jobs_list_short_base_func')) {
function latest_jobs_list_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

	extract(shortcode_atts(array(
		'latest_jobs_list_clr' => '',
		'jobs_no' => '',   
		'section_title' => '', 
		'section_desc' => '', 
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
                        
                        $post_author_data  = get_userdata( $post_author_id);
                        
                        $author_name      =   $post_author_data->display_name;
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
			
			/* Getting Last country value*/
			$job_locations  = array();
			$last_location        =  '';
			$job_locations  =  wp_get_object_terms( $job_id,  array('ad_location'), array('orderby' => 'term_group') );
			$comma   = "";
                        if ( ! empty( $job_locations ) ) { 
                            $author_name  = $author_name.", ";
				foreach($job_locations as $location)
				{
				   $last_location = '<p>'.$location->name.'</p>';
				}
			}
			
			
			$recent_job_html    .= '<div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="job-list-simple">
                                            <div class="job-list-simple-img">
                                                <a href="'.get_the_permalink().'"><img src="'.esc_url($rel_image_link[0]).'" class="img-responsive" alt="'.esc_html__('image','nokri').'"></a>
                                            </div> 
                                            <div class="job-list-simple-title">
                                                <a href="'.get_the_permalink().'">'.get_the_title().'</a>
                                                   '. $author_name.'   
                                                    '.$last_location.'
                                                  
                                            </div>
                                        </div>
                                    </div>';
				  }
	} 
/*View All  Link */
$read_more = '';
if( isset( $link) )
{
	$read_more = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid',false);	
}
/*Section Color */
$section_clr = (isset($latest_jobs_list_clr) && $latest_jobs_list_clr != "") ? $latest_jobs_list_clr : "";
/*Section title */
$section_title = (isset($section_title) && $section_title != "") ? ' <h2>'.$section_title.'</h2>' : "";
/*Section DESC */
$section_desc = (isset($section_desc) && $section_desc != "") ? ' <p>'.$section_desc.'</p>' : "";
   return   ' <section class="list-jobs '.$section_clr.'">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-title black">
                                '.$section_title.'
                                '.$section_desc.'
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="mansi">
                                   '.$recent_job_html.'
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
    </section> ';
}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('latest_jobs_list', 'latest_jobs_list_short_base_func');
}