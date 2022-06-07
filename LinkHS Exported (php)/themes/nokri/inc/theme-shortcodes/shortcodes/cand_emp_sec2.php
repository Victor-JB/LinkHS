<?php
/* ------------------------------------------------ */
/* Candidates/Employers section 2  */ 
/* ------------------------------------------------ */
if (!function_exists('cand_emp_section2')) {
function cand_emp_section2()
{
	vc_map(array(
		"name" => esc_html__("Candidates/Employers 2", 'nokri') ,
		"base" => "cand_emp_section2",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('cand_emp2.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Employer", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "emp_img",
		 "description" => esc_html__('570 x 303', 'nokri'),
		),	
		array(
			"group" => esc_html__("Employer", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tagline", 'nokri' ),
			"param_name" => "emp_tagline",
		),
		array(
			"group" => esc_html__("Employer", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Heading", 'nokri' ),
			"param_name" => "emp_heading",
		),
		array(
			"group" => esc_html__("Employer", "nokri"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Description", 'nokri' ),
			"param_name" => "emp_desc",
		),
		array(
		'group' => esc_html__( 'Employer', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button", 'nokri' ),
		"param_name" => "emp_link",
		),	
		/* Candidate */
		array(
		"group" => esc_html__("Candidate", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "cand_img",
		 "description" => esc_html__('570 x 299', 'nokri'),
		),	
		array(
			"group" => esc_html__("Candidate", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Tagline", 'nokri' ),
			"param_name" => "cand_tagline",
		),
		array(
			"group" => esc_html__("Candidate", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Heading", 'nokri' ),
			"param_name" => "cand_heading",
		),
		array(
			"group" => esc_html__("Candidate", "nokri"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Description", 'nokri' ),
			"param_name" => "cand_desc",
		),
		array(
		'group' => esc_html__( 'Candidate', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button", 'nokri' ),
		"param_name" => "cand_link",
		),
		
		
		
		),
	));
}
}

add_action('vc_before_init', 'cand_emp_section2');

if (!function_exists('cand_emp_section2_short_base_func')) {
function cand_emp_section2_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'emp_img' => '',
		'emp_tagline' => '',
		'emp_heading' => '',
		'emp_desc' => '',
		'emp_link' => '',
		'cand_img' => '',
		'cand_tagline' => '',
		'cand_heading' => '',
		'cand_desc' => '',
		'cand_link' => '',
		'arrow_img' => '',
	) , $atts));
	global $nokri;

	
/* Employer Image */
$style1 = '';
if( $emp_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $emp_img );
$style1 = ( $bgImageURL != "" ) ? ' style="background:  url('.$bgImageURL.');  -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; position: absolute; width: 48%; background-position: top left;  height: 390px; top: 0; background-repeat: no-repeat;"' : "";
}
/*Employer Tagline */
$emp_tagline = (isset($emp_heading) && $emp_heading != "") ? '<span>'.$emp_tagline.'</span>' : "";
/*Employer Heading */
$emp_heading = (isset($emp_heading) && $emp_heading != "") ? ' <h3>'.$emp_heading.'</h3>' : "";
/*Employer desc */
$emp_desc = (isset($emp_desc) && $emp_desc != "") ? ' <p>'.$emp_desc.'</p>' : "";
/*Employer Link  */
$btn = '';
if( isset( $emp_link) )
{
	$btn = nokri_ThemeBtn($emp_link, 'btn n-btn-flat btn-mid',false);	
}
/* Candidate Image */
$style2 = '';
if( $cand_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $cand_img );
$style2 = ( $bgImageURL != "" ) ? ' style="background: url('.$bgImageURL.'); position: absolute; width: 50%; top: 0;  right: 0; height: 390px; "' : "";
}

/*Candidate Tagline */
$cand_tagline = (isset($cand_tagline) && $cand_tagline != "") ? '<span>'.$cand_tagline.'</span>' : "";
/*Candidate Heading */
$cand_heading = (isset($cand_heading) && $cand_heading != "") ? '<h3>'.$cand_heading.'</h3>' : "";
/*Candidate desc */
$cand_desc = (isset($cand_desc) && $cand_desc != "") ? '<p>'.$cand_desc.'</p>' : "";
/*Candidate Link  */
$btn2 = '';
if( isset( $cand_link) )
{
	$btn2 = nokri_ThemeBtn($cand_link, 'btn n-btn-flat btn-mid',false);	
}

/*Arrow Image */
 $arrow_img1 = '';	
if(isset($arrow_img))
{
	$img 		=  	wp_get_attachment_image_src($arrow_img, '');
	$img_thumb 	= 	$img[0];
	$arrow_img1  =   '<img class="main-arrow" src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'">';
}
   return   '<section class="n-resouces2 no-padding"> 
			<div class="container">
				<div class="row"> 
					<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6">
						<div class="n-res-details">
						    '.$emp_tagline.'
							'.$emp_heading.'
							'.$emp_desc.'
							'.$btn.'
						</div>
					</div>
					<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6">
						<div class="n-res-details2">
						'.$cand_tagline.'
						'.$cand_heading.'
						'.$cand_desc.'
						'.$btn2.'
						</div>
					</div>
				</div>
				</div>
				<div class="n-res-style1" '.$style1.'></div>
				<div class="clearfix"></div>
				<div class="n-res-style2" '.$style2.'></div>
			</section>';
}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('cand_emp_section2', 'cand_emp_section2_short_base_func');
}