<?php
/* ------------------------------------------------ */
/* Advance Search - Tabs*/ 
/* ------------------------------------------------ */
if (!function_exists('search_tabs')) {
function search_tabs()
{
	vc_map(array(
		"name" => esc_html__("Advance Search - Tabs", 'nokri') ,
		"base" => "search_tabs",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_main_section.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		  array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "search_section_img",
		 "description" => esc_html__('1263 x 147', 'nokri'),
		),	
		
		array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Heading", 'nokri' ),
			"param_name" => "section_title",
		),
		array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section tagline", 'nokri' ),
			"param_name" => "section_tagline",
		),	
		
		array(
			"group" => esc_html__("Categories", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Do you want to show Sub Categories", 'nokri') ,
			"param_name" => "want_to_show",
			"admin_label" => true,
			"value" => array(
				esc_html__('yes', 'nokri') => 'yes',
				esc_html__('no', 'nokri') => 'no',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
		),
		
		array
		(
			"group" => esc_html__("Categories", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select categories ( All or Selective )', 'nokri' ),
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
		array(
			"group" => esc_html__("Countries", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Do you want to show Sub Categories", 'nokri') ,
			"param_name" => "want_to_show_loc",
			"admin_label" => true,
			"value" => array(
				esc_html__('yes', 'nokri') => 'yes',
				esc_html__('no', 'nokri') => 'no',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
		),
		array
		(
			"group" => esc_html__("Countries", "nokri"),
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

			)
		),
		array(
			"group" => esc_html__("Hot Cats", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "hot_title",
		),
		array
		(
			"group" => esc_html__("Hot Cats", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select hot categories', 'nokri' ),
			'param_name' => 'hot_cats',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Category", 'nokri') ,
					"param_name" => "hot_cat",
					"admin_label" => true,
					"value" => nokri_get_parests('job_category','no'),
				),

			)
		),
		
		/* Cats slider */
		array(
			"group" => esc_html__("Cats slider", "nokri"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'nokri' ),
			"param_name" => "cats_title",
		),
		array(
		'group' => esc_html__( 'Cats slider', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Link", 'nokri' ),
		"param_name" => "cats_link",
		),
		array
		(
			"group" => esc_html__("Cats slider", "nokri"),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Categories', 'nokri' ),
			'param_name' => 'cat_sliders',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Category", 'nokri') ,
					"param_name" => "cat_slider",
					"admin_label" => true,
					"value" => nokri_get_parests('job_category','yes'),
				),
			)
		),
		),
	));
}
}
add_action('vc_before_init', 'search_tabs');
if (!function_exists('search_tabs_short_base_func')) {
function search_tabs_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'cats' => '',
		'section_title' => '',
		'section_tagline' => '',
		'countries' => '',
		'want_to_show' => '', 
		'want_to_show_loc' => '', 
		'search_section_img' => '',
		'hot_cats' => '',
		'hot_title' => '',  
		'cat_slider' => '',
		'cats_title' => '',
		'cats_link' => '',
	) , $atts));
		global $nokri;
		if(isset($want_to_show) && $want_to_show == "yes")
		{
			
		}
	    // For Job Category
		if(isset($atts['cats']) && !empty($atts['cats']) != '')
       {
			$rows = vc_param_group_parse_atts( $atts['cats'] );
			$cats	=	false;
			$cats_html	=	'';
			if( count( $rows ) > 0 )
			{
				$cats_html .= '';
				foreach($rows as $row )
				{
					if( isset( $row['cat'] )  )
					{
						if($row['cat'] == 'all' )
						{
							$cats = true;
							$cats_html = '';
							break;
						}
						$category = get_term_by('slug', $row['cat'], 'job_category');
						if( count( $category ) == 0 )
						continue;
						
						if(isset($want_to_show) && $want_to_show == "yes")
						{
						
							$ad_cats_sub	=	nokri_get_cats('job_category' , $category->term_id );
							if(count($ad_cats_sub) > 0 )
							{
								$cats_html .= '<option value="'.$category->term_id.'" >'.$category->name.'  ('.$category->count.')' ;
								foreach( $ad_cats_sub as $ad_cats_subz )
								{
									$cats_html .= '<option value="'.$ad_cats_subz->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$ad_cats_subz->name.'  ('.$ad_cats_subz->count.') </option>';
								}
								$cats_html .='</option>';
							}
							else
							{
								$cats_html .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
							}
						}
						else
						{
							$cats_html .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
						}
						
					}
				}
				
				if( $cats )
				{
					$ad_cats = nokri_get_cats('job_category', 0 );
					foreach( $ad_cats as $cat )
					{
						if(isset($want_to_show) && $want_to_show == "yes")
						{
						   //sub cat
							$ad_sub_cats	=	nokri_get_cats('job_category' , $cat->term_id );
							if(count($ad_sub_cats) > 0 )
							{
								$cats_html .= '<option value="'.$cat->term_id.'" >'.$cat->name.'  ('.$cat->count.')' ;
								foreach( $ad_sub_cats as $sub_cat )
								{
									$cats_html .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
									 //sub sub cat
									 $ad_sub_sub_cats	=	nokri_get_cats('job_category' , $sub_cat->term_id );
									 if(count($ad_sub_sub_cats) > 0 )
										{
											foreach( $ad_sub_sub_cats as $sub_cat_sub )
											{
												$cats_html .= '<option value="'.$sub_cat_sub->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;' .$sub_cat_sub->name.'  ('.$sub_cat_sub->count.') </option>';
												//sub sub sub cat
												 $ad_sub_sub_sub_cats	=	nokri_get_cats('job_category' , $sub_cat_sub->term_id );
												 if(count($ad_sub_sub_sub_cats) > 0 )
												 {
													foreach( $ad_sub_sub_sub_cats as $sub_cat )
													{
														$cats_html .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
													}
												 }
											}
										}
								}
								$cats_html .='</option>';	
							}
							else
							{
								$cats_html .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
							}
						}
						else
						{
							$cats_html .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
						}
					}
					
				}
			}
	   }
		// countries
           
           
          
		if(isset($atts['countries']) && !empty($atts['countries']) != '')
       {
			$rows = vc_param_group_parse_atts( $atts['countries'] );
			$countries_sub	=	false;
			$countries_html 	=	'';
			if( count( $rows ) > 0 )
			{
				$countries_html  .= '';
				foreach($rows as $row )
				{
					if( isset( $row['country'] )  )
					{
						if($row['country'] == 'all' )
						{
							$countries_sub = true;
							$countries_html  = '';
							break;
						}
						$locations = get_term_by('slug', $row['country'], 'ad_location');
						if( count( array($locations) ) == 0 )
						continue;
						if(isset($want_to_show_loc) && $want_to_show_loc == "yes")
						{
							$ad_cats_sub	=	nokri_get_cats('ad_location' , $locations->term_id );
							if(count(array($ad_cats_sub)) > 0 )
							{
								$countries_html  .= '<option value="'.$locations->term_id.'" >'.$locations->name.'  ('.$locations->count.')' ;
								foreach( $ad_cats_sub as $ad_cats_subz )
								{
									$countries_html  .= '<option value="'.$ad_cats_subz->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$ad_cats_subz->name.'  ('.$ad_cats_subz->count.') </option>';
								}
								$countries_html  .='</option>';
							}
							else
							{
								$countries_html  .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
							}
						}
						else
						{
							$countries_html  .= '<option value="'.$locations->term_id.'">'.$locations->name. '  ('.$locations->count.')</option>';
						}
						
					}
				}
                                
                                
                                
                               
                                
				if( $countries_sub )
				{
					$ad_cats = nokri_get_cats('ad_location', 0 );
					foreach( $ad_cats as $cat )
					{
						if(isset($want_to_show_loc) && $want_to_show_loc == "yes")
						{
						   //sub cat
							$ad_sub_cats	=	nokri_get_cats('ad_location' , $cat->term_id );
							if(count($ad_sub_cats) > 0 )
							{
								$countries_html  .= '<option value="'.$cat->term_id.'" >'.$cat->name.'  ('.$cat->count.')' ;
								foreach( $ad_sub_cats as $sub_cat )
								{
									$countries_html  .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
									 //sub sub cat
									 $ad_sub_sub_cats	=	nokri_get_cats('ad_location' , $sub_cat->term_id );
									 if(count($ad_sub_sub_cats) > 0 )
										{
											foreach( $ad_sub_sub_cats as $sub_cat_sub )
											{
												$countries_html  .= '<option value="'.$sub_cat_sub->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;' .$sub_cat_sub->name.'  ('.$sub_cat_sub->count.') </option>';
												//sub sub sub cat
												 $ad_sub_sub_sub_cats	=	nokri_get_cats('ad_location' , $sub_cat_sub->term_id );
												 if(count($ad_sub_sub_sub_cats) > 0 )
												 {
													foreach( $ad_sub_sub_sub_cats as $sub_cat )
													{
														$countries_html  .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
													}
												 }
											}
										}
								}
								$countries_html  .='</option>';	
							}
							else
							{
								$countries_html  .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
							}
						}
						else
						{
							$countries_html  .= '<option value="'.$cat->term_id.'">'.$cat->name.'  ('.$cat->count.')</option>';
						}
					}
					
				}
			}
	   }
	    // For hot categories
		$hot_cats_html = ''; 
		if(isset($atts['hot_cats']) && !empty($atts['hot_cats']))
		{
		  $rows_hot_cats   = vc_param_group_parse_atts( $atts['hot_cats'] );
			$year_countries	=	false;
			$hot_cats_html	=	'';
			$get_year = '';
			if( count( $rows_hot_cats ) > 0 )
			{
				foreach($rows_hot_cats as $rows_hot_cat )
				{
					if( isset( $rows_hot_cat['hot_cat'] )  )
					{
						if($rows_hot_cat['hot_cat'] == 'all' )
						{
							$year_countries = true;
							$countries_html = '';
							break;
						}
						$get_hot_cat = get_term_by('slug', $rows_hot_cat['hot_cat'], 'job_category');
						if( count( (array)$get_hot_cat ) == 0 )
						continue;
						$hot_cats_html .= '<a href="'.nokri_cat_link_page($get_hot_cat->term_id).'">'.$get_hot_cat->name.'</a>';
					}
				}
			}
		}
		/*Section Title */
		$main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>'.$section_title.'</h1>' : "";
		/*Section Tagline */
		$main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? ' <p>'.$section_tagline.'</p>' : "";
		/*hot Title */
		$hot_section_title = (isset($hot_title) && $hot_title != "") ? '<span class="n-most-cat-title">'.$hot_title.'</span>' : "";
		 /* Background Image */
		$bg_img = '';
		if( $search_section_img != "" )
		{
			$bgImageURL	=	nokri_returnImgSrc( $search_section_img );
			$bg_img     =   ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url('.$bgImageURL.') no-repeat scroll center center / cover;"' : "";
		}
		// For cats slider
		 $cats_slide_html 	= '';
		 if(!empty($atts['cat_sliders']))
		 {
		  $rows_sliders = vc_param_group_parse_atts( $atts['cat_sliders'] );
		  $cats_slide 	= false;
		  if( count((array) $rows_sliders ) > 0 )
		  {
		   $cats_slide_html .=  '';
		   foreach($rows_sliders as $rows_slider )
		   {
				if( isset( $rows_slider['cat_slider'] )  )
				{
					 if($rows_slider['cat_slider'] == 'all' )
					 {
						  $cats_slide = true;
						  break;
					 }
					 $category = get_term_by('slug', $rows_slider['cat_slider'], 'job_category');
					 if( count((array) $category ) == 0 )
					 continue;
					$count_cat = esc_html__( 'Opening', 'nokri' );
					if ($category->count > 1)
					{
						$count_cat = esc_html__( 'Openings', 'nokri' );
					}
					 $cats_slide_html .= '<div class="item">
											<div class="n-cats">
												<a href="'.nokri_cat_link_page($category->term_id).'">
													<h4>'.$category->name.'</h4>
													<p>('.$category->count." ".$count_cat.')</p>
												</a>
											</div>
										</div>';
			   }
			}
			  if( $cats_slide )
			   {
				   $count_cat = '';
					$ad_cats = nokri_get_cats('job_category', 0 );
					foreach( $ad_cats as $cat )
					{
						if ($cat->count > 1)
						{
							$count_cat = esc_html__( 'Openings', 'nokri' );
						}
						else
						{
							$count_cat = esc_html__( 'Opening', 'nokri' );
						}
						$cats_slide_html .= '<div class="item">
											<div class="n-cats">
												<a href="'.nokri_cat_link_page($cat->term_id).'">
													<h4>'.$cat->name.'</h4>
													<p>('.$cat->count." ".$count_cat.')</p>
												</a>
											</div>
										</div>';
					}
			   }		  
		}
		 }
		/*Section Title */
		$cats_title = (isset($cats_title) && $cats_title != "") ? ' <h4>'.$cats_title.'</h4>' : "";
		/*Link  */
		$btn = '';
		if( isset( $cats_link) )
		{
			$btn = nokri_ThemeBtn($cats_link, '',false);	
		}
   return   '<section class="n-hero-section" '.str_replace('\\',"",$bg_img).'>
    <div class="container">
      <div class="row">
      		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2">
            	<div class="n-hero-box">
                    <div class="n-hero-main-text">
                        '.$main_section_title.'
                        '.$main_section_tagline.'
                    </div>
                    <div class="n-hero-form-cat">
                        <div class="n-most-cat">
                            '.$hot_section_title.'
                            <span class="n-most-cat-list">
                                '.$hot_cats_html.'
                            </span>
                        </div>
                        <div class="n-saech-form">
							<form  method="get" action="'.get_the_permalink($nokri['sb_search_page']).'">
								'.nokri_form_lang_field_callback(false).'
                            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                	<div class="row">
                                    	<div class="form-group">
										 <input type="text" class="form-control" name="job-title" placeholder="'.esc_html__('Search Keyword','nokri').'">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                	<div class="row">
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="'.esc_html__('Select Category','nokri').'" style="width: 100%" name="cat-id">
                                             <option label="'.esc_html__('Select Category','nokri').'"></option>
                     					'.$cats_html.'
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                                	<div class="row">
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="'.esc_html__('Select Location','nokri').'" style="width: 100%" name="job-location">
                                         <option value="">'.esc_html__('Select Location','nokri').'</option>
                                           '.$countries_html.'
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                	<div class="row">
									<button type="submit" class="btn n-btn-flat">'.esc_html__('Search','nokri').'<i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
    <div class="n-hero-cat-section" id="hero-cat-parralex">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="n-category-box">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div class="n-hero-cat-heading">
                                '.$cats_title.'
                                '.$btn.'
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                            <div class="main-hero-cat owl-carousel owl-theme ">
                              '.$cats_slide_html.'
                           </div>
                        </div>
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
	nokri_add_code('search_tabs', 'search_tabs_short_base_func');
}