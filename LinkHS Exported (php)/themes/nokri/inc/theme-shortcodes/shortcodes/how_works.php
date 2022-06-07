<?php
/* ------------------*/
/* How it works */ 
/* ----------------- */
if (!function_exists('how_works')) {
function how_works()
{
	vc_map(array(
		"name" => esc_html__("How It Works", 'nokri') ,
		"base" => "how_works",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_how_works.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
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
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section_description",
		),
		array(
		"type" => "attach_image",
		"group" => esc_html__("Basic", "nokri"),
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Image", 'nokri' ),
		"param_name" => "section_img",
		 "description" => esc_html__('1296*316', 'nokri'),
		),
		array
		(
			"group" => esc_html__("Steps", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select', 'nokri' ),
			'param_name' => 'steps',
			'value' => '',
			'params' => array
			(
					
					
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Select option", 'nokri') ,
						"param_name" => "section_img_icon",
						"admin_label" => true,
						"value" => array(
							esc_html__('Select option', 'nokri') => '',
							esc_html__('Icon', 'nokri') => 'icon',
							esc_html__('Image', 'nokri') => 'img'
						) ,
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						"std" => '',
						"description" => esc_html__("Select background color.", 'nokri'),
					),
					array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Step Image", 'nokri' ),
					"param_name" => "step_img",
					 "description" => esc_html__('128x128', 'nokri'),
					 'dependency' => array(
						'element' => 'section_img_icon',
						'value' => array('img'),
						) ,
					),
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Step Icon", 'nokri' ),
					"param_name" => "step_icon",
					'dependency' => array(
						'element' => 'section_img_icon',
						'value' => array('icon'),
						) ,
						'description'     => __( 'Click to explore more icons', 'nokri' ) . ' ' . nokri_make_link ( 'https://icons8.com/line-awesome/cheatsheet' , __( 'Get Icons' , 'nokri' ) ),
				 	 ),
					
					
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Step Title", 'nokri' ),
					"param_name" => "step_title",
				 	 ),
					array(
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Step Details", 'nokri' ),
					"param_name" => "step_description",
					),
			)
		),
		array(
			"group" => esc_html__("Second Section", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "section_title2",
		),
		array(
		"group" => esc_html__("Second Section", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section_details2",
		),
		array(
		'group' => esc_html__( 'Second Section', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Button 2", 'nokri' ),
		"param_name" => "link",
		),
		array(
		"type" => "attach_image",
		"group" => esc_html__("Second Section", "nokri"),
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Image", 'nokri' ),
		"param_name" => "section_img2",
		 "description" => esc_html__('570x468', 'nokri'),
		),
		
		),
	));
}
}

add_action('vc_before_init', 'how_works');

if (!function_exists('how_works_short_base_func')) {
function how_works_short_base_func($atts, $content = '')
{
	
require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

	extract(shortcode_atts(array(
		'steps' => '',
		'how_works_clr' => '', 
		'section_img' => '',
		'section_title2' => '',
		'section_details2' => '',
		'section_img2' => '',
		'link' => '',
	) , $atts));
/* Background Image */
$bg_img = '';
if( $section_img != "" )
{
$bgImageURL	=	nokri_returnImgSrc( $section_img );
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') no-repeat; -webkit-background-size: contain; -moz-background-size: contain; -o-background-size: contain; background-size: contain; background-position: center center; background-attachment:scroll;"' : "";
}
if(isset($atts['steps']) && !empty($atts['steps']) != '')
{
	$rows = vc_param_group_parse_atts( $atts['steps'] );
	$steps_html = '';
	if( (array)count( $rows ) > 0 )
	{
		foreach($rows as $row ) 
		{
	/*Step Image */
	$astep_img = '';	
	if(isset($row['step_img']))
	{
		$img 		=  	wp_get_attachment_image_src($row['step_img'], '');
		$img_thumb 	= 	$img[0];
	}
	/*Step Icon */
	$astep_icon = '';	
	if(isset($row['step_icon']))
	{
		$icon_html    =   '<i class="la '.trim($row['step_icon']).' la-4x"></i>';
	}
	
	if(isset($row['step_img']))
	{
		$astep_img    = ( isset($img_thumb) && $img_thumb != "" ) ? '<img src="'.esc_url($img_thumb).'" class="img-responsive main-img" alt="'.esc_attr__( 'image', 'nokri' ).'" />' : '';
	}
	else
	{
		$astep_img = $icon_html;
	}
		
	/*Step Title */
	$astep_title = (isset($row['step_title']) && $row['step_title'] != "") ? ' <h4>'.$row['step_title'].'</h4>' : "";	
	/*Step Description */
	$astep_desc = (isset($row['step_description']) && $row['step_description'] != "") ? ' <p>'.$row['step_description'].'</p>' : "";	
	/*Step Html */		
	$steps_html .= '<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="h-i-w-content-box">
						'.$astep_img.'
						'.$astep_title.'
						'.$astep_desc.'
					  </div></div>';
		 }
	}
}
/*Section title 2 */
$section_title2 = (isset($section_title2) && $section_title2 != "") ? '<h3>'.$section_title2.'</h3>' : "";
/*Section details 2 */
$section_details2 = (isset($section_details2) && $section_details2 != "") ? $section_details2 : "";
$paras = explode("|", $section_details2);
$paragraph_html = '';
foreach($paras as $para)
{
	$paragraph_html .= '<p>'.$para.'</p>';
}
/*Link  */
$btn = '';
if( isset( $link) )
{
	$btn = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid',false);
}
/*Section Image */
$img_thumb2 = '';	
if(isset($section_img2))
{
	$section_imag2 	 =    wp_get_attachment_image_src($section_img2, '');
	$img_thumb2 	 =   '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><img src="'.$section_imag2[0].'" class="img-responsive" alt="'. esc_attr__( 'image', 'nokri' ).'"></div>';
}
   return  ' <section class="how-it-works style-2" >
    <div class="container">
      <div class="row">
        '.$header.'
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="h-i-w-box" '.str_replace('\\',"",$bg_img).' >
                <div class="work-points">
                 '.$steps_html.'
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="row">
            	<div class="n-call-to-box mt40">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="n-call-to-action-text">
                           '.$section_title2.'
                            '.$paragraph_html.'
                        </div>
                        <div class="n-extra-btn-section">
                           '.$btn.'
                        </div>
                    </div>
                    '.$img_thumb2.'
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>';
}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('how_works', 'how_works_short_base_func');
}