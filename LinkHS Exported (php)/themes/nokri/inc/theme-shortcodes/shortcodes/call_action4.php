<?php
/* ------------------------------------------------ */
/* Call To Action 4*/
/* ------------------------------------------------ */
function call_action_short4() 
{
	vc_map(array(
		"name" => esc_html__("Call To Action 4", 'nokri') ,
		"base" => "call_action_short4_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('call_action4.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri'),
		  ),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Background Image", 'nokri' ),
		"param_name" => "sec_bg_img",
		"description" => esc_html__('1920 x 473', 'nokri'),
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Image", 'nokri' ),
		"param_name" => "section_img",
			"description" => esc_html__('692 x 463', 'nokri'),
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Tagline", 'nokri' ),
		"param_name" => "tagline",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "heading",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Description", 'nokri' ),
		"param_name" => "description",
		),
		array
		(
			"group" => esc_html__("Add Counts", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select', 'nokri' ),
			'param_name' => 'numbers',
			'value' => '',
			'params' => array
			(
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Number", 'nokri' ),
					"param_name" => "number",
				 	 ),
					 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Story title", 'nokri' ),
					"param_name" => "title",
				 	 ),
			)
		),
		
	),
	));
}
add_action('vc_before_init', 'call_action_short4');
function call_action_short4_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'sec_bg_img'    => '',
		'section_img' 	=> '',
		'tagline' 		=> '',
		'heading' 		=> '',
		'description'   => '',
		'numbers' 		=> '',
	) , $atts));
	$stories_html = '';
	if(isset($atts['numbers']) && $atts['numbers'] != '')
	{
		$rows_story = vc_param_group_parse_atts( $atts['numbers'] );
		if( (array)count( $rows_story ) > 0 )
		{
			foreach($rows_story as $row_story ) 
			{
				/*Title */
				$astory_title = (isset($row_story['title']) && $row_story['title'] != "") ? ' <p>'.$row_story['title'].'</p>' : "";	
				/*Story Description */
				$astory_no = (isset($row_story['number']) && $row_story['number'] != "") ?  '<span class="counter" data-to="'.$row_story['number'].'" data-time="2000" data-fps="20"></span>' : "";	
				/*Story Html */		
				$stories_html .= '<li> 
									<div class="counter-js">
									'.$astory_no .'
									'.$astory_title .'
									</div>
									</li>';
			 }
		}
	}
/*Section Tagline */
$section_tagline = (isset($tagline) && $tagline != "") ? '<span>'.$tagline.'</span>' : "";
/*Section Heading */
$section_heading = (isset($heading) && $heading != "") ? '<h3>'.$heading.'</h3>' : "";
/*Section Details */
$section_desc    = (isset($description) && $description != "") ? '<p>'.$description.'</p>' : "";
/* Background Image */
$bg_img = '';
if( $sec_bg_img != "" )
{
	$bgImageURL	=	nokri_returnImgSrc( $sec_bg_img );
	$bg_img     =  ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
}
/*Section Image */
$sec_img = '';	
if(isset($section_img))
{
	 $img 		  =  	wp_get_attachment_image_src($section_img, '');
	 $img_thumb   = 	$img[0];
	 $sec_img     =   '<div class="n-8-img"><img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'" class="img-responsive"></div>';
}
return '<section class="n-callto-action-8" '.str_replace('\\',"",$bg_img).'> 
			<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
				<div class="n-callto-details">
					'.$section_tagline.'
					'.$section_heading.'
					'.$section_desc.'
				</div>
				<ul>
					'.$stories_html.'
				</ul>
				</div>
				'.$sec_img.'
			  </div>
			</div>
			</section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('call_action_short4_base', 'call_action_short4_base_func');
}