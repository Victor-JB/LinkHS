<?php
/* ------------------------------------------------ */
/* Category - With Icons*/ 
/* ------------------------------------------------ */
if (!function_exists('categories_with_icons')) {
function categories_with_icons()
{
	vc_map(array(
		"name" => esc_html__("Categories With Icon", 'nokri') ,
		"base" => "categories_with_icons",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_cats_with_icons.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
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
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "section_desc",
		),
		
		array(
		'group' => esc_html__( 'Basic', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Link", 'nokri' ),
		"param_name" => "link",
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
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Put icon like (la-adjust)", 'nokri' ),
			"param_name" => "cat_img",
			'description'     => __( 'Click to explore more icons', 'nokri' ) . ' ' . nokri_make_link ( 'https://icons8.com/line-awesome/cheatsheet' , __( 'Get Icons' , 'nokri' ) ),
		),
			)
		),
		
		),
	));
}
}
add_action('vc_before_init', 'categories_with_icons');
if (!function_exists('categories_with_icons_short_base_func')) {
function categories_with_icons_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	extract(shortcode_atts(array(
		'cats' => '',  
		'section_title' => '', 
		'section_desc' => '',
		'cats_section_clr' => '',
		'link' => '',
	) , $atts));
	
	// For Job Category
  $rows  		= vc_param_group_parse_atts( $atts['cats'] );
  if(isset($atts['cats']) && $atts['cats'] != '')
  {
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
					$cat_img    =   '<i class="la '.trim($row['cat_img']).' la-4x"></i>';
				}
				/* calling function for openings*/
				$custom_count =  nokri_get_opening_count($category->term_id,'job_category');
				$count_cat = esc_html__( 'Openings', 'nokri' );
				if ($category->count > 1)
				{
					$count_cat = esc_html__( 'Openings', 'nokri' );
				}
					$cats_html .= '<li><a href="'.nokri_cat_link_page($category->term_id).'" >
					'.$cat_img.'
					'.$category->name.'
					<span>'.$custom_count." ".$count_cat.'</span>
					</a>
					</li>';
		   }
		}
		  if( $cats )
		   {
				$ad_cats = nokri_get_cats('job_category', 0 );
				 /*Category Image */
				 $cat_img = '';	
				if(isset($row['cat_img']))
				{
					$cat_img    =   '<i class="la '.trim($row['cat_img']).'"></i>';
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
					$cats_html .= '<li><a href="'.nokri_cat_link_page($cat->term_id).'" >
					'.$cat_img.'
					'.$cat->name.'
					<span>'.$custom_count." ".$count_cat.'</span>
					</a>
					</li>';
				}
		   }	  
	}
  }
/*Section Color */
$section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
/*Section title */
$section_title = (isset($section_title) && $section_title != "") ? '<h2>'.$section_title.'</h2>' : "";
/*Section description */
$section_description = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";

/*Link 1 */
$btn = '';
if( isset( $link) )
{
	$btn = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear',false);	
}

   return  '<section class="categories-section-2">
    <div class="container">
        <div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="heading-title black">
                  '.$section_title.'
                  '.$section_description.'
                </div>
              </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="categories-boxes-2">
                    <ul class="popular-categories">
                       '.$cats_html.'
                    </ul>
                </div>
                <div class="n-extra-btn-section">
            	'.$btn.'
            </div>
            </div>
        </div>
    </div>
</section>';

}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('categories_with_icons', 'categories_with_icons_short_base_func');
}