<?php
/* ------------------------------------------------ */
/* Call To Action */
/* ------------------------------------------------ */

function call_action_short() 
{
	vc_map(array(
		"name" => esc_html__("Call To Action", 'nokri') ,
		"base" => "call_action_short_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_call_action.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' 			),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "call_action_heading",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Some Detail", 'nokri' ),
		"param_name" => "call_action_details",
		),
		array(
		'group' => esc_html__( 'Links', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button 1", 'nokri' ),
		"param_name" => "link1",
		),
		array(
		'group' => esc_html__( 'Links', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button 2", 'nokri' ),
		"param_name" => "link2",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "call_action_img",
		"description" => esc_html__('263x394', 'nokri'),
		),
		
	),
	));
}

add_action('vc_before_init', 'call_action_short');

function call_action_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'call_action_heading' => '',
		'call_action_details' => '',
		'call_action_btn' => '',
		'link1' => '',
		'link2' => '',     
		'call_action_img' => '',
	) , $atts));
/*Button */
$section_btn = (isset($featured_projects_clr) && $featured_projects_clr != "") ? $featured_projects_clr : "";
/*Section Heading */
$section_heading = (isset($call_action_heading) && $call_action_heading != "") ? '<h2>'.$call_action_heading.'</h2>' : "";
/*Section Details */
$section_details = (isset($call_action_details) && $call_action_details != "") ? '<p>'.$call_action_details.'</p>' : "";

 /* Background Image */
$bg_img = '';
if( $call_action_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $call_action_img );
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url('.$bgImageURL.') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
}

/*Link 1 */
$btn1 = '';
if( isset( $link1) )
{
	$btn1 = nokri_ThemeBtn($link1, 'btn n-btn-flat btn-mid',false);	
}
/*Link 2 */
$btn2 = '';
if( isset( $link2) )
{
	$btn2 = nokri_ThemeBtn($link2, 'btn n-btn-flat btn-mid btn-clear',false);	
}

return '<section class="n-call-to-action" '.str_replace('\\',"",$bg_img).'>
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="heading-title black">
              '.$section_heading.'
              '.$section_details.'
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-extra-btn-section">
            	'.$btn2.'
				'.$btn1.'
		   </div>
        </div>
      </div>
    </div>
  </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('call_action_short_base', 'call_action_short_base_func');
}