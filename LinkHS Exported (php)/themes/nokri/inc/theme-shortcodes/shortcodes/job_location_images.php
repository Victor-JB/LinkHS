<?php
/* ------------------*/
/* Job location images*/ 
/* ----------------- */
if (!function_exists('job_location_images')) {
function job_location_images()
{
	vc_map(array(
		"name" => esc_html__("Location With Images", 'nokri') ,
		"base" => "job_location_images",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('job_location_images.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
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
			"group" => esc_html__("Location", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Countries ( All or Selective )', 'nokri' ),
			'param_name' => 'countries',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Select Country", 'nokri') ,
					"param_name" => "country",
					"admin_label" => true,
					"value" => nokri_get_all('ad_location','yes'),
				),
				array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Client Image", 'nokri' ),
					"param_name" => "country_img",
					 "description" => esc_html__('190 x 125', 'nokri'),
					),

			)
		),

		),
	));
}
}
add_action('vc_before_init', 'job_location_images');
if (!function_exists('job_location_images_short_base_func')) {
function job_location_images_short_base_func($atts, $content = '')
{
require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'countries' => '', 
		'section_title' => '',
		'section_desc' => '', 
		'section_bg_img' => '',
		'employer_img' => '', 
		'link' => '',
		'country_img' => '',
	) , $atts));
$cats_html = '';
// For Job countries\



if(isset($atts['countries']) && !empty($atts['countries']) != '')
{
	$rows  		= vc_param_group_parse_atts( $atts['countries'] );
	$cats 		= false;
	$cats_html 	= '';
        
    
	if( count((array) $rows ) > 0 )
	{
	 $cats_html =  '';
	 foreach($rows as $row )
	 {
		  if( isset( $row['country'] )  )
		  {
			   if($row['country'] == 'all' )
			   {
					$cats = true;
					break;
			   }
			   $category = get_term_by('name', $row['country'], 'ad_location');                                                                             
			   if( count((array) $category ) == 0 )
			   continue;
			   /*Location Image */
			   $loc_img = '';	
			  if(isset($row['country_img']))
			  {
				   $img 		=  	wp_get_attachment_image_src($row['country_img'], '');
				  $img_thumb 	= 	$img[0];
				  $loc_img      =   '<img class="img-responsive" src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'">';
			  }
			  /* calling function for openings*/
			  $custom_count =  nokri_get_opening_count($category->term_id,'ad_location');
			  $count_cat    =  esc_html__( 'Opening', 'nokri' );
			  if ($category->count > 1)
			  {
				  $count_cat = esc_html__( 'Openings', 'nokri' );
			  }
				  $cats_html .= '<div class="col-lg-3 col-sm-4 col-md-3 col-xs-12">
									<a href="'.nokri_location_page_link($category->term_id).'">
									<div class="n-location-style"> 
										'.$loc_img.'
										<div class="n-city-location">
										<ul>
										<li>'.$category->name.'</li>
											<li class="n-style2"><span class="badge">'.$custom_count." ".$count_cat.'</span></li>
										</ul>
										</div>
									</div>
									</a>
								</div>';
		 }
	  }
		if( $cats )
		 {
			  $ad_cats = nokri_get_cats('ad_location', 0 );
			   /*Location Image */
			   $loc_img = '';	
			  if(isset($row['country_img']))
			  {
				   $img 		=  	wp_get_attachment_image_src($row['country_img'], '');
				  $img_thumb 	= 	$img[0];
				  $loc_img      =   '<img class="img-responsive" src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'">';
			  }
			  foreach( $ad_cats as $cat )
			  {
				  /* calling function for openings*/
				  $custom_count =  nokri_get_opening_count($cat->term_id,'ad_location');
				  $count_cat = esc_html__( 'Opening', 'nokri' );
				  if ($cat->count > 1)
				  {
					  $count_cat = esc_html__( 'Openings', 'nokri' );
				  }
				  $cats_html .= '<div class="col-lg-3 col-sm-4 col-md-3 col-xs-12">
								<a href="'.nokri_location_page_link($cat->term_id).'">
								<div class="n-location-style"> 
									'.$loc_img.'
									<div class="n-city-location">
									<ul>
										<li>'.$cat->name.'</li>
										<li class="n-style2"><span class="badge">'.$custom_count." ".$count_cat.'</span></li>
									</ul>
									</div>
								</div>
								</a>
								</div>';
			  }
		 }	  
	}
}
  /*Section name */
$section_title = (isset($section_title) && $section_title != "") ? '<h3>'.$section_title.'</h3>' : "";
 /*Section desc */
$section_descs = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
   return  '<section class="n-location space2">
			   <div class="container">
				 <div class="row">
				   <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
					 <div class="heading-penel">
					   '.$section_title.'
					   '.$section_descs.'
					 </div>
				   </div>
				   '.$cats_html.'
				 </div>
			   </div>
			 </section>';
}
}

if (function_exists('nokri_add_code'))
{
	nokri_add_code('job_location_images', 'job_location_images_short_base_func');
}