<?php
/* ------------------*/
/* Success Stories*/ 
/* ----------------- */
if (!function_exists('client_with_bg')) {
function client_with_bg()
{
	vc_map(array(
		"name" => esc_html__("Our Clients", 'nokri') ,
		"base" => "client_with_bg",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_our_clients.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Heading", 'nokri' ),
			"param_name" => "section_heading",
		),
		array
		(
			"group" => esc_html__("Add Clients", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select', 'nokri' ),
			'param_name' => 'images',
			'value' => '',
			'params' => array
			(
					array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Client Image", 'nokri' ),
					"param_name" => "section_client",
					 "description" => esc_html__('150 x 150', 'nokri'),
					),
					array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Client Link", 'nokri' ),
					"param_name" => "client_link",
					),
			)
		),
		
		),
	));
}
}

add_action('vc_before_init', 'client_with_bg');

if (!function_exists('client_with_bg_short_base_func')) {
function client_with_bg_short_base_func($atts, $content = '')
{
	
	extract(shortcode_atts(array(
		'images' 			=> 	'', 
		'section_img' 		=> 	'',  
		'section_heading' 	=> 	'',
	) , $atts));
if(isset($atts['images']) && $atts['images'] != '')
{	
	$rows = vc_param_group_parse_atts( $atts['images'] );
	$images_html = '';
	if( (array)count( $rows ) > 0 )
	{
		foreach($rows as $row ) 
		{
			$img_html = '';
			if(isset( $row['section_client']) &&  $row['section_client'] !='') 
			{
				$img  		= 	wp_get_attachment_image_src($row['section_client'], 'nokri_job_post_single');
				$img  		= 	$img[0];
				$img_html 	= 	'<img class="img-responsive"  src="'.$img.'" alt="'.esc_attr__("image", "nokri").'">';
			}
	/*Client Link  */
	$link = (isset($row['client_link']) && $row['client_link'] != "") ? $row['client_link'] : "#";	 	
	/*Story Html */		
	$images_html .= '<div class="item">
						   <a href="'.$link.'">'.$img_html.'</a>
						</div>';
		 }
	}
}
/*Section Heading */
$section_heading1 = (isset($section_heading) && $section_heading != "") ? ' <h4>'.$section_heading.'</h4>' : ""; 
		
   return  '<section class="n-client pt0">
    <div class="container">
      <div class="row">
      	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-client-heading">
               '.$section_heading1.' 
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="n-client-box owl-carousel owl-theme">
                '.$images_html.'
            </div>
        </div>
      </div>
    </div>
  </section>'; 

}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('client_with_bg', 'client_with_bg_short_base_func');
}