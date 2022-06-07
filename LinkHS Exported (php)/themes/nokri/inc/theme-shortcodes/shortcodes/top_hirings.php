<?php
/* ------------------*/
/* Top Hirings */ 
/* ----------------- */
if (!function_exists('top_hirings')) {
function top_hirings()
{
	vc_map(array(
		"name" => esc_html__("Top Hirings", 'nokri') ,
		"base" => "top_hirings",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('top_hirings.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),	
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "section_clr",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Sky BLue', 'nokri') =>'light-grey',
		esc_html__('White', 'nokri') =>'',
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
			"group" => esc_html__("Add Employers", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select', 'nokri' ),
			'param_name' => 'employers',
			'value' => '',
			'params' => array
			(
					array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Client Image", 'nokri' ),
					"param_name" => "employer_img",
					 "description" => esc_html__('190 x 125', 'nokri'),
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__( "Link", 'nokri' ),
						"param_name" => "link",
						),
			)
		),
		),
	));
}
}
add_action('vc_before_init', 'top_hirings');
if (!function_exists('top_hirings_short_base_func')) {
function top_hirings_short_base_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'employers' => '', 
		'section_title' => '', 
		'section_clr' => '',
		'employer_img' => '', 
		'link' => '', 
	) , $atts));
if(isset($atts['employers']) && !empty($atts['employers']) != '')
{
	$rows = vc_param_group_parse_atts( $atts['employers'] );
	$hiring_html = '';
	if( (array)count( $rows ) > 0 )
	{
		foreach($rows as $row ) 
		{
			$img_html = '';
			if(isset( $row['employer_img']) &&  $row['employer_img'] !='') 
			{
				$img  = wp_get_attachment_image_src($row['employer_img'], '');
				$img  = $img[0];
				if(isset( $row['link']) &&  $row['link'] !='')
				{
					$url      =  $row['link'];
					$img_html = '<a href="'.esc_url($url).'"><img  src="'.$img.'" class="img-responsive" alt="'.esc_attr__("image", "nokri").'"></a>';
				}
				else
				{
					$img_html = '<img  src="'.$img.'" class="img-responsive" alt="'.esc_attr__("image", "nokri").'">';
				}
			}
				/*Story Html */		
				$hiring_html .= $img_html;
		 }
	}
}
  /*Section Color */
$section_clr = (isset($top_hirings_clr) && $top_hirings_clr != "") ? $top_hirings_clr : "";
  /*Section name */
$section_title = (isset($section_title) && $section_title != "") ? '<h3>'.$section_title.'</h3>' : "";
 /*Section desc */
$section_desc = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
   return  '<section class="nth-hiring" '.esc_attr($section_clr).'>
   <div class="container">
	   <div class="row">
		   <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
			   <div class="heading-penel">
				   '.$section_title.'
				   '.$section_desc.'
			   </div>
		   </div>
		   <div class="nth-hiring-content">
			   '.$hiring_html.'
		   </div>
	   </div>
   </div>
</section>';
}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('top_hirings', 'top_hirings_short_base_func');
}