<?php
/* ------------------------------------------------ */
/* About Us Tabs*/
/* ------------------------------------------------ */
function about_us_short_base()
{
	vc_map(array(
		"name" => esc_html__("About us", 'nokri') ,
		"base" => "about_us_short_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_about_section.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "section1_heading",
		),
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section subheading", 'nokri' ),
		"param_name" => "section1_description",
		),
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section description", 'nokri' ),
		"param_name" => "section2_description",
		),
		array(
		"group" => esc_html__("Image Settings", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "employer_signup_img",
		 "description" => esc_html__('767 x 467', 'nokri'),
		),
		array
		(
		'group' => esc_html__( 'Add More', 'nokri' ),
		'type' => 'param_group',
		'heading' => esc_html__( 'Add More', 'nokri' ),
		'param_name' => 'faq_qstns',
		'value' => '',
		'params' => array
		(
					array(
					"group" => esc_html__("Basic", "nokri"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Title", 'nokri' ),
					"param_name" => "faq_qstn_title",
					),
					array(
					"group" => esc_html__("Basic", "nokri"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Details", 'nokri' ),
					"param_name" => "faq_qstn_details",
					),
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
					"param_name" => "abt_img",
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
					
				
   		    )
 			),
	),
	));
}

add_action('vc_before_init', 'about_us_short_base');

function about_us_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'about_us_clr' => '',
		'section1_heading' => '',
		'section1_description' => '',
		'section2_description' => '',
		'section1_qoute' => '',
		'faq_qstns' => '',  
		'abt_img' => '', 
		'employer_signup_img' => '',
	) , $atts));
	if(isset($atts['faq_qstns']) && $atts['faq_qstns'] != '')
	{
		$rows = vc_param_group_parse_atts( $atts['faq_qstns'] );
		$about_html = '';
		if( count( $rows ) > 0)
		 {
	   foreach($rows as $row )
	   {	
			/*Title */
			$title = (isset($row['faq_qstn_title']) && $row['faq_qstn_title'] != "") ? '<h4>'.$row['faq_qstn_title'].'</h4>' : "";
			/*Details */
			$details = (isset($row['faq_qstn_details']) && $row['faq_qstn_details'] != "") ? '<p>'.$row['faq_qstn_details'].'</p>' : "";
			 /*Icons Image */
				 $about_img = '';	
				if(isset($row['abt_img']))
				{
					$img 		=  	wp_get_attachment_image_src($row['abt_img'], '');
					$img_thumb 	= 	$img[0];
					$about_img  =   '<div class="icons"><img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'"></div>';
				}
				
				/*Step Icon */
				$astep_icon = '';	
				if(isset($row['step_icon']))
				{
					$about_img    =   '<i class="la '.trim($row['step_icon']).' la-4x"></i>';
				}
							
			$about_html .='<div class="col-md-6 col-xs-12 col-sm-6">
									 <div class="services-grid">
										'.$about_img.'
										'.$title.'
										'.$details.'
									 </div>
								  </div>';
	   }
	   
	  }
	}
/*Section Image */
 $img_html = '';	
if(isset($employer_signup_img))
{
	 $img 		=  	wp_get_attachment_image_src($employer_signup_img, '');
	$img_thumb 	= 	$img[0];
	$img_html    =   '<div class="col-md-5 col-sm-12 col-xs-12"><img src="'.esc_url($img_thumb).'" class="img-responsive"  alt="'.esc_attr__( 'image', 'nokri' ).'"></div>';
}
/*Section Color */
$section_clr = (isset($faq_qstn_section_clr) && $faq_qstn_section_clr != "") ? $faq_qstn_section_clr : "";
/*Section Title */
$section_title = (isset($section1_heading) && $section1_heading != "") ? '<h2>'.$section1_heading.'</h2>' : "";
/*Section subheading */
$section_subheading = (isset($section1_description) && $section1_description != "") ? '<p class="large-paragraph">'.$section1_description.'</p>' : "";
/*Section Details */
$section_details = (isset($section2_description) && $section2_description != "") ? '<p>'.$section2_description.'</p>' : "";
return ' <section class="about-us">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
               	 	<div class="col-md-7 col-sm-12 col-xs-12">
               	 		'.$section_title.'
               	 		'.$section_subheading.'
						'.$section_details.' 
               	 		<div class="row">
               	 			<div class="services">
               	 			'.$about_html.'
               	 		</div>
               	 		</div>
               	 	</div>
               	 	'.$img_html .'
               </div>
            </div>
         </div>
      </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('about_us_short_base', 'about_us_short_base_func');
}