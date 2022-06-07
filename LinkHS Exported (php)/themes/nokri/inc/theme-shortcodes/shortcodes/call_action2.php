<?php
/* ------------------------------------------------ */
/* Call To Action 2 */
/* ------------------------------------------------ */

function call_action_short2() 
{
	vc_map(array(
		"name" => esc_html__("Call To Action 2", 'nokri') ,
		"base" => "call_action_short2_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_call_action2.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri'),
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
		"description" => esc_html__( "Separate every para with | sign", 'nokri' ),
		"param_name" => "call_action_details",
		),
		array(
		'group' => esc_html__( 'Links', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button", 'nokri' ),
		"param_name" => "link",
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

add_action('vc_before_init', 'call_action_short2');

function call_action_short2_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'call_action_heading' => '',
		'call_action_details' => '',
		'call_action_btn' => '',
		'link' => '',
		'call_action_img' => '', 
		'call_action_bg_img' => '', 
	) , $atts));

/*Section Heading */
$section_heading = (isset($call_action_heading) && $call_action_heading != "") ? '<h3>'.$call_action_heading.'</h3>' : "";
/*Section Details */
$section_details = (isset($call_action_details) && $call_action_details != "") ? '<p>'.$call_action_details.'</p>' : "";
$paras = explode("|", $section_details);
$paragraph_html = '';
foreach($paras as $para)
{
	$paragraph_html .= '<p>'.$para.'</p>';
}
 
/*Link*/
$btn = '';
if( isset( $link) )
{
	$btn = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid',false);	
}

/* Background Image */
$bg_img = '';
if( $call_action_bg_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $call_action_bg_img );
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') no-repeat; -webkit-background-size: contain; -moz-background-size: cover; -o-background-size: contain; background-size: contain; background-position: center center; background-attachment:scroll;"' : "";
}
/*Section Image */
$section_img = '';	
if(isset($call_action_img))
{
	$img 		=  	wp_get_attachment_image_src($call_action_img, '');
	$img_thumb 	= 	$img[0];
}

return '<section class="n-call-to-action-two light-grey nopadding" >
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-call-to-box">
                        <div class="row">
                           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hidden-md">
                              <div class="img-side-fluid" '.str_replace('\\',"",$bg_img).'>
                                 <img src="'.$img_thumb.'" class="img-responsive" alt="'.esc_attr__('image', 'nokri').'">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                              <div class="n-call-to-action-text">
                                 '.$section_heading.'
                                '.$paragraph_html.'
                              </div>
                              <div class="n-extra-btn-section">
                                '.$btn.'
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('call_action_short2_base', 'call_action_short2_base_func');
}