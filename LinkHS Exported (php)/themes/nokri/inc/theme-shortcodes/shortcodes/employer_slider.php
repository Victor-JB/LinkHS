<?php
/* -------------- */
/* Employer Slider */
/* ------------*/
if ( !function_exists ( 'employer_slider' ) ) {
function employer_slider()
{
	vc_map(array(
		"name" => __("Top Hiring Employers", 'nokri') ,
		"base" => "employer_slider_base",
		"category" => __("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('emp_slider.png') . __( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		  array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'nokri' ),
			"param_name" => "section_img",
			 "description" => esc_html__('64x64', 'nokri'),
			),
		  array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tagline", 'nokri' ),
			"param_name" => "section_tagline",
		),
		array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Heading", 'nokri' ),
			"param_name" => "section_heading",
		),	
		array
		(
			"group" => esc_html__("Select Employers", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Employers', 'nokri' ),
			'param_name' => 'employers',
			'value' => '',
			'params' => array
			(
				array(
				"group" => esc_html__(" Select employers", "nokri"),
				"type" => "dropdown",
				"heading" => esc_html__("Select Employers To Show", 'nokri') ,
				"param_name" => "employer",
				"admin_label" => true,
				"value" => nokri_top_employers_lists_shortcodes(),
				),

			)
		),
		
		
		),
	));
}
}
add_action('vc_before_init', 'employer_slider');
if ( !function_exists ( 'employer_slider_base_func' ) )
{
function employer_slider_base_func($atts, $content = '')
{	
extract(shortcode_atts(array( 
		'section_img' => '', 
		'section_tagline' => '', 
		'section_heading' => '',
		'employers' => '',
	) , $atts));
	
if(isset($atts['employers']) && $atts['employers'] != '')
{	
	$rows = vc_param_group_parse_atts( $atts['employers'] );
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
		$args 			= 	array (
		'order' 		=> 	'DESC',
		'include'       => $employers_array,
	);
	$user_query = new WP_User_Query($args);	
	$authors = $user_query->get_results();
	$required_user_html = '';
	if (!empty($authors))
	{
		$fb_link = $twitter_link = $google_link = $linkedin_link =  $follow_btn = '';
		foreach ($authors as $author)
		{
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
			if(empty($image_dp_link[0]))
			{
				$image_dp_link[0] =  get_template_directory_uri(). '/images/default-job.png';
			}
				
			$required_user_html .= '<div class="item"> <a href="'.esc_url(get_author_posts_url($user_id)).'"><img src="'.esc_url($image_dp_link[0]).'" class="img-responsive" alt="'.esc_attr__('image','nokri').'" /></a> </div>';
		}
	}

/*Section tagline*/
$section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<h3>'.$section_tagline.'</h3>' : "";
/*Section title*/
$section_heading = (isset($section_heading) && $section_heading != "") ? '<h2>'.$section_heading.'</h2>' : "";
/*Section Image */
$style = '';
if( $section_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $section_img );
$style = ( $bgImageURL != "" ) ? ' style="background:  url('.$bgImageURL.') no-repeat fixed top center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
return '<section class="client-section" '.$style.'>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="heading-2">
          '.$section_tagline.'
          '.$section_heading.'
        </div>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="top-hiring-company-slider owl-carousel owl-theme">
          '.$required_user_html.'
        </div>
      </div>
    </div>
  </div>
</section>';
}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('employer_slider_base', 'employer_slider_base_func');
}