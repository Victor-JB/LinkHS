<?php
/* ------------------------------------------------ */
/* Advertisement */
/* ------------------------------------------------ */

function advertisement_short() 
{
	vc_map(array(
		"name" => esc_html__("Advertisement", 'nokri') ,
		"base" => "advertisement_short_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_advertisement.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' 			),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textarea_raw_html",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Put script here", 'nokri' ),
		"param_name" => "advertisement_code",
		),
		
		
	),
	));
}

add_action('vc_before_init', 'advertisement_short');

function advertisement_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'advertisement_code' => '',
	) , $atts));


$section_add = (isset($advertisement_code) && $advertisement_code != "") ? $advertisement_code : "";

return '<div class="n-advert-box"> '. nokri_encodestring(  $advertisement_code  ).'</div>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('advertisement_short_base', 'advertisement_short_base_func');
}