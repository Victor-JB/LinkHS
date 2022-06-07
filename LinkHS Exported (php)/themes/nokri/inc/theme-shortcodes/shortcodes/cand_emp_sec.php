<?php
/* ------------------------------------------------ */
/* Candidates/Employers section  */ 
/* ------------------------------------------------ */
if (!function_exists('cand_emp_section')) {
function cand_emp_section()
{
	vc_map(array(
		"name" => esc_html__("Candidates/Employers Section", 'nokri') ,
		"base" => "cand_emp_section",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('cand_emp.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Arrow image", 'nokri' ),
		"param_name" => "arrow_img",
		 "description" => esc_html__('1263 x 147', 'nokri'),
		),
		 array(
		"group" => esc_html__("Employer", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "emp_img",
		 "description" => esc_html__('1263 x 147', 'nokri'),
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
		 "description" => esc_html__('1263 x 147', 'nokri'),
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

add_action('vc_before_init', 'cand_emp_section');

if (!function_exists('cand_emp_section_short_base_func')) {
function cand_emp_section_short_base_func($atts, $content = '')
{

	extract(shortcode_atts(array(
	    'emp_img' => '',
		'emp_heading' => '',
		'emp_desc' => '',
		'emp_link' => '',
		'cand_img' => '',
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
$style1 = ( $bgImageURL != "" ) ? ' style="background:  url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
/*Employer Heading */
$emp_heading = (isset($emp_heading) && $emp_heading != "") ? ' <h2>'.$emp_heading.'</h2>' : "";
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
$style2 = ( $bgImageURL != "" ) ? ' style="background: url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
/*Candidate Heading */
$cand_heading = (isset($cand_heading) && $cand_heading != "") ? '<h2>'.$cand_heading.'</h2>' : "";
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
	$img_thumb 	= 	isset($img[0])   ?   $img[0]   : "";
	$arrow_img1  =   '<img class="main-arrow" src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'">';
}
   return   '<section class="static-images-section">
  <div class="background-1 " '.$style1.'></div>
  <div class="background-2" '.$style2.'></div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
        <div class="section-container-left">
          '.$emp_heading.'
          '.$emp_desc.'
          '.$btn.'
          '.$arrow_img1.' 
		</div>
		</div>
      <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
        <div class="section-container-right">
          '.$cand_heading.'
          '.$cand_desc.'
          '.$btn2.'
      </div>
    </div>
  </div>
</section>';
}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('cand_emp_section', 'cand_emp_section_short_base_func');
}