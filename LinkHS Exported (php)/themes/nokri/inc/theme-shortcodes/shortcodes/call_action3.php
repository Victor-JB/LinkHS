<?php
/* ------------------------------------------------ */
/* Call To Action 3*/
/* ------------------------------------------------ */

function call_action_short3() 
{
	vc_map(array(
		"name" => esc_html__("Call To Action 3", 'nokri') ,
		"base" => "call_action_short3_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('call_action3.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri'),
		  ),
		  array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Background Image", 'nokri' ),
		"param_name" => "call_action_bg_img",
		"description" => esc_html__('263x394', 'nokri'),
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
		"heading" => esc_html__( "Tagline", 'nokri' ),
		"param_name" => "tagline",
		),
		array(
		'group' => esc_html__( 'Links', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button", 'nokri' ),
		"param_name" => "link",
		),
		
		
	),
	));
}

add_action('vc_before_init', 'call_action_short3');

function call_action_short3_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'call_action_bg_img' => '',
		'heading' => '',
		'tagline' => '',
		'link' => '',
	) , $atts));

/*Section Heading */
$section_heading = (isset($heading) && $heading != "") ? '<h2>'.$heading.'</h2>' : "";
/*Section Details */
$section_tagline = (isset($tagline) && $tagline != "") ? '<div class="text">'.$tagline.'</div>' : "";
/*Link*/
$btn = '';
if( isset( $link) )
{
	$btn = nokri_ThemeBtn($link, 'btn n-btn-flat',false);	
}
/* Background Image */
$bg_img = '';
if( $call_action_bg_img != "" )
{
	$bgImageURL	=	nokri_returnImgSrc( $call_action_bg_img );

	$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
}
return '<section class="appointment-section" '.str_replace('\\',"",$bg_img).'>
    	<div class="container clearfix">
        	<div class="inner-container">
            	'.$section_heading.'
                '.$section_tagline.'
               '.$btn.'
            </div>
        </div>
    </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('call_action_short3_base', 'call_action_short3_base_func');
}