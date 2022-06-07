<?php
	extract(shortcode_atts(array(
		'section_bg' => '',
		'bg_img' => '',
		'bg_img1' => '',
		'bg_img2' => '',
		'header_style' => '',
		'section_title' => '',
		'section_description' => '',
		'section_description1' => '',
		'ad_left' => '',
		'ad_right' => '',
		'sub_limit' => '',
		'max_limit' => '',
		'p_cols' => '',
		'main_heading' => '',
		'main_description' => '',
		'main_description1' => '',
		'main_image' => '',
		'main_image1' => '',
		'main_link' => '',
		'main_link1' => '',
		'ad_720_90' => '',
		'woo_products' => '',
		'section_padding' => '',
		'service_img' => '',
		'client_tagline' => '',
		'client_heading' => '',
		'img_postion' => 'left',
		'sell_tagline' => '',
		'section_title_about' => '',
		'tip_section_title' => '',
		'tips_description' => '',
		'fields' => '',
		'tips' => '',
		'cat_link_page' => '',
		'comparison_loop' =>'',
		'sidebar_position' =>'',
		'name' =>'',
		'img' =>'',
		'select_locations' =>'',
		'animation_effects' =>'',
		'animation_effects2' =>'',
	) , $atts));
	
	
	if ( isset( $header_style ) )
	{
		$main_title	=	'';
		$main_title	=	$section_title;
		$header	=	nokri_getHeader( $main_title, $section_description);	
	}
	$style = '';
	$bg_color	=	'';
	
	if(isset($section_bg) && $section_bg == 'img' )
	{
		
		$bgImageURL	=	nokri_returnImgSrc( $bg_img );
			$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
	}
	else
	{
		$style = '';
		$bg_color	=	$section_bg;
	}
	
	$top_padding = '';
	if( $section_padding == 'yes' )
	{
		$top_padding = 'no-top';
	}
	else
	{
		$top_padding = $section_padding;
	}
?>