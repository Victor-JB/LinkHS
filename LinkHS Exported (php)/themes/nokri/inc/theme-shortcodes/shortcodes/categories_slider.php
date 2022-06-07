<?php
/* ------------------------------------------------ */
/* Category - slider*/ 
/* ------------------------------------------------ */
if (!function_exists('categories_sliders')) {
function categories_sliders()
{
	vc_map(array(
		"name" => esc_html__("Categories Slider", 'nokri') ,
		"base" => "categories_sliders",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('categories_slider.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "cats_section_clr",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Blue', 'nokri') =>'light-blue',
		esc_html__('White', 'nokri') =>'',
		),
		),	
		array
		(
			"group" => esc_html__("Categories", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Categories', 'nokri' ),
			'param_name' => 'cats',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Category", 'nokri') ,
					"param_name" => "cat",
					"admin_label" => true,
					"value" => nokri_get_parests('job_category','yes'),
				),
			)
		),
		
		),
	));
}
}
add_action('vc_before_init', 'categories_sliders');
if (!function_exists('categories_sliders_short_base_func')) {
function categories_sliders_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'cats' => '',
		'cats_section_clr' => '', 
	) , $atts));
	
	// For Job Category
	if(isset($atts['cats']) && $atts['cats'] != '')
   {
	  $rows  		= vc_param_group_parse_atts( $atts['cats'] );
	  $cats 		= false;
	  $cats_html 	= '';
	  if( count((array) $rows ) > 0 )
	  {
	   $cats_html =  '';
	   foreach($rows as $row )
	   {
			if( isset( $row['cat'] )  )
			{
				 if($row['cat'] == 'all' )
				 {
					  $cats = true;
					  break;
				 }
				 $category = get_term_by('slug', $row['cat'], 'job_category');
				 if( count((array) $category ) == 0 )
				 continue;
				 /*Category Image */
				 $cat_img = '';	
				if(isset($row['cat_img']))
				{
					 $img 		=  	wp_get_attachment_image_src($row['cat_img'], '');
					$img_thumb 	= 	$img[0];
					$cat_img    =   '<span class="images-icon"><img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'"></span>';
				}
				/* calling function for openings*/
				$custom_count =  nokri_get_opening_count($category->term_id,'job_category');
				$count_cat = esc_html__( 'Opening', 'nokri' );
				if ($category->count > 1)
				{
					$count_cat = esc_html__( 'Openings', 'nokri' );
				}
					$cats_html .= '<div class="item">
							<div class="category-style-3-box"> <a href="'.nokri_cat_link_page($category->term_id).'">
							  <div class="inner-box">
								<h4>'.$category->name.'</h4>
								<span> ('.$custom_count.')</span> </div>
							  </a> </div>
						  </div>
							';
		   }
		}
		  if( $cats )
		   {
				$ad_cats = nokri_get_cats('job_category', 0 );
				 /*Category Image */
				 $cat_img = '';	
				if(isset($row['cat_img']))
				{
					 $img 		=  	wp_get_attachment_image_src($row['cat_img'], '');
					$img_thumb 	= 	$img[0];
					$cat_img    =   '<img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'">';
				}
				foreach( $ad_cats as $cat )
				{
					/* calling function for openings*/
					$custom_count =  nokri_get_opening_count($cat->term_id,'job_category');
					$count_cat = esc_html__( 'Opening', 'nokri' );
					if ($cat->count > 1)
					{
						$count_cat = esc_html__( 'Openings', 'nokri' );
					}
					$cats_html .= '
							<div class="item">
							<div class="category-style-3-box"> <a href="'.nokri_cat_link_page($cat->term_id).'">
							  <div class="inner-box">
								<h4>'.$cat->name.'</h4>
								<span> ('.$custom_count.')</span> </div>
							  </a> </div>
						  </div>
							
							';
				}
		   }	  
	}
   }
/*Section Color */
$section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
   return  '<section class="category-float-slider-sectoion '.$section_clr.'">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="category-style-3-slider owl-carousel owl-theme">
          '.$cats_html.'
      </div>
    </div>
  </div>
</section>';

}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('categories_sliders', 'categories_sliders_short_base_func');
}