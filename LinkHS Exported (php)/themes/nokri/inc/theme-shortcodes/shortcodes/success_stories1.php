<?php
/* ------------------*/
/* Success Stories*/ 
/* ----------------- */
if (!function_exists('success_stories1')) {
function success_stories1()
{
	vc_map(array(
		"name" => esc_html__("Success Stories 1", 'nokri') ,
		"base" => "success_stories1",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_success_stories_slider_new1.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Type", 'nokri') ,
		"param_name" => "success_stories1_type",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Color', 'nokri') =>'clr',
		esc_html__('Image', 'nokri') =>'img',
		),
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Select BG Image", 'nokri' ),
		"param_name" => "sec_bg_img",
		 "description" => esc_html__('1920 x 787', 'nokri'),
		 'dependency' => array(
			'element' => 'success_stories1_type',
			'value' => array('img'),
			) ,
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "bg_clr",
		"admin_label" => true,
		'dependency' => array(
			'element' => 'success_stories1_type',
			'value' => array('clr'),
			) ,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('White', 'nokri') =>'',
		esc_html__('Gray', 'nokri') =>'light-grey',
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
			"heading" => esc_html__( "Section Description", 'nokri' ),
			"param_name" => "section_desc",
		),
		array
		(
			"group" => esc_html__("Add Stories", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select', 'nokri' ),
			'param_name' => 'stories',
			'value' => '',
			'params' => array
			(
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Story Title", 'nokri' ),
					"param_name" => "story_title",
				 	 ),
					 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Designation", 'nokri' ),
					"param_name" => "story_designation",
				 	 ),
					array(
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Story Details", 'nokri' ),
					"param_name" => "story_description",
					),
					array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Story Image", 'nokri' ),
					"param_name" => "story_img",
					 "description" => esc_html__('76 x 76', 'nokri'),
					),
					array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Qoute Image", 'nokri' ),
					"param_name" => "qoute_img",
					 "description" => esc_html__('102 x 78', 'nokri'),
					),
				 

			)
		),
		
		),
	));
}
}

add_action('vc_before_init', 'success_stories1');

if (!function_exists('success_stories1_short_base_func')) {
function success_stories1_short_base_func($atts, $content = '')
{
	
require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

	extract(shortcode_atts(array(
		'stories' => '', 
		'section_title' => '',
		'success_stories1_type' => '',
		'bg_clr' => '', 
		'sec_bg_img' => '', 
		'story_img' => '', 
		'section_desc' => '', 
	) , $atts));
	if(isset($atts['stories']) && !empty($atts['stories']) != '')
   {
		$rows = vc_param_group_parse_atts( $atts['stories'] );
		$stories_html = '';
		if( (array)count( $rows ) > 0 )
		{
			foreach($rows as $row ) 
			{
				$img_html = '';
				if(isset( $row['story_img']) &&  $row['story_img'] !='') 
				{
					$img      = wp_get_attachment_image_src($row['story_img'], '');
					$img      = $img[0];
					$img_html = '<div class="nth-sc-profile"><img  src="'.$img.'" class="img-responsive" alt="'.esc_attr__("image", "nokri").'"></div>';
				}
				$qoute_img_html = '';
				if(isset( $row['qoute_img']) &&  $row['qoute_img'] !='') 
				{
					$img      = wp_get_attachment_image_src($row['qoute_img'], '');
					$img      = $img[0];
					$qoute_img_html = '<div class="nth-image-bg"><img  src="'.$img.'" class="img-responsive" alt="'.esc_attr__("image", "nokri").'"></div>';
				}
				
		/*Story Title */
		$astory_title = (isset($row['story_title']) && $row['story_title'] != "") ? '<div class="nth-profile-text">'.$row['story_title'].'</div>' : "";	
		/*Story Description */
		$astory_desc = (isset($row['story_description']) && $row['story_description'] != "") ? '<p>'.$row['story_description'].'</p>' : "";	
		/*Story client */
		$story_designation = (isset($row['story_designation']) && $row['story_designation'] != "") ? ' <p>'.$row['story_designation'].'</p>' : "";			
		/*Story Html */		
		$stories_html .= '<div class="item">
								<div class="nth-sc-box">
									'.$astory_desc.'
										'.$img_html.'
										<div class="nth-sc-details">
											'.$astory_title.'
											'.$story_designation.'
										</div>
									'.$qoute_img_html.'
								</div>
							</div>';
			 }
		}
   }
/*Section Color */
$section_clr  = (isset($bg_clr) && $bg_clr != "") ? $bg_clr : "";
$section_type = (isset($success_stories1_type) && $success_stories1_type != "") ? $success_stories1_type : "0";
$bg_class = $bg_img = '';
if($section_type == 'img')
{
	/*Section bg Image */
	$bg_img = $bg_class =  '';
	if( $sec_bg_img != "" )
	{
		$bgImageURL	=	nokri_returnImgSrc( $sec_bg_img );
		$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center; background-attachment:scroll;"' : "";
		 $section_clr = 'nth-success-2';
	}
}
/*Section name */
$section_title = (isset($section_title) && $section_title != "") ? '<h3>'.$section_title.'</h3>' : "";
 /*Section desc */
$section_desc = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
return  '<section class="nth-success-products '.esc_attr($section_clr).'" '.str_replace('\\',"",$bg_img).'>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading-penel">
							'.$section_title.'
							'.$section_desc.'
						</div>
						<div class="success1-slider owl-carousel owl-theme">
							'.$stories_html.'
						</div>
					</div>
				</div>
			</section>';
}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('success_stories1', 'success_stories1_short_base_func');
}