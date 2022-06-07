<?php
/* ------------------------------------------------ */
/* Category - With Images*/ 
/* ------------------------------------------------ */
if (!function_exists('animated_categories')) {
function animated_categories()
{
	vc_map(array(
		"name" => esc_html__("Animated Categories", 'nokri') ,
		"base" => "animated_categories",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('animated_categories.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "cats_section_clr",
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
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "section_desc",
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
				array(
					"type" => "attach_image",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Category Image", 'nokri' ),
					"param_name" => "cat_img",
					 "description" => esc_html__('64x64', 'nokri'),
					),
			)
		),
		
		),
	));
}
}
add_action('vc_before_init', 'animated_categories');
if (!function_exists('animated_categories_short_base_func')) {
function animated_categories_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'cats' => '',  
		'section_title' => '', 
		'cats_section_clr' => '',
		'section_desc' => '',
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
			if( isset( $row['cat'] ) && $row['cat'] != ''  )
			{
				 if($row['cat'] == 'all' )
				 {
					  $cats = true;
					  break;
				 }
				 $category = get_term_by('slug', $row['cat'], 'job_category');
				 if(isset($category->term_id) && $category->term_id != '')
				 {
					if( count((array) $category ) == 0 )
					continue;
					/*Category Image */
					$cat_img = '';	
					if(isset($row['cat_img']))
					{
						$img 		=  	wp_get_attachment_image_src($row['cat_img'], '');
						$img_thumb 	= 	isset($img[0])  ? $img[0] : "";
						$cat_img    =   '<span class="images-icon"><img src="'.esc_url($img_thumb).'" alt="'.esc_attr__( 'image', 'nokri' ).'"></span>';
					}
					/* calling function for openings*/
					$custom_count =  nokri_get_opening_count($category->term_id,'job_category');
					$count_cat    =  esc_html__( 'Opening', 'nokri' );
					if ($category->count > 1)
					{
						$count_cat = esc_html__( 'Openings', 'nokri' );
					}
						$cats_html .= '<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="category-style-4-box">
											<div class="category-style-4-box-img">
												<a href="'.nokri_cat_link_page($category->term_id).'">
												'.$cat_img.'
												</a>
											</div>
											<div class="category-style-4-box-meta">
												<h3><a href="'.nokri_cat_link_page($category->term_id).'">'.$category->name.'</a></h3>
												<p>'.$custom_count." ".$count_cat.'</p>
											</div>
										</div>
									</div>';
				}
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
					if(isset($cat->term_id) && $cat->term_id != '')
				   {
						/* calling function for openings*/
						$custom_count =  nokri_get_opening_count($cat->term_id,'job_category');
						$count_cat = esc_html__( 'Opening', 'nokri' );
						if ($cat->count > 1)
						{
							$count_cat = esc_html__( 'Openings', 'nokri' );
						}
						$cats_html .= '<div class="col-md-3 col-sm-6 col-xs-12">
										<div class="category-style-4-box">
											<div class="category-style-4-box-img">
												<a href="'.nokri_cat_link_page($cat->term_id).'">
												'.$cat_img.'
												</a>
											</div>
											<div class="category-style-4-box-meta">
												<h3><a href="'.nokri_cat_link_page($cat->term_id).'">'.$cat->name.'</a></h3>
												<p>'.$custom_count." ".$count_cat.'</p>
											</div>
										</div>
									</div>';
					}
				}
		   }	  
	}
	}
/*Section Color */
$section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
/*Section title */
$section_title = (isset($section_title) && $section_title != "") ? '<h2>'.$section_title.'</h2>' : "";
/*Section title */
$section_desc = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";


   return  '<section class="category-style-4" '.$section_clr.'>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-title black">
                               '.$section_title.'
                                '.$section_desc.'
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        	'.$cats_html.'
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
	nokri_add_code('animated_categories', 'animated_categories_short_base_func');
}