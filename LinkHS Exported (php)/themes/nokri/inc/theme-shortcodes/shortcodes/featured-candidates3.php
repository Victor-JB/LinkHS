<?php
/* -------------- */
/* Featured candidates 3 */
/* ------------*/
if ( !function_exists ( 'featured_candidates3' ) ) {
function featured_candidates3()
{
	vc_map(array(
		"name" => __("Featured Candidates 3", 'nokri') ,
		"base" => "featured_candidates3_base",
		"category" => __("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('featured_candidate3.png') . __( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "sec_bg_clr",
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
			"heading" => esc_html__( "Section Description", 'nokri' ),
			"param_name" => "section_desc",
		),	
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select candidate type", 'nokri') ,
		"param_name" => "candidate_type",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Featured', 'nokri') =>'1',
		esc_html__('Simple', 'nokri') =>'0',
		),
		),
		
		),
	));
}
}
add_action('vc_before_init', 'featured_candidates3');
if ( !function_exists ( 'featured_candidates3_base_func' ) )
{
function featured_candidates3_base_func($atts, $content = '')
{	
extract(shortcode_atts(array( 
		'sec_bg_clr' 	  => '',   
		'section_title'   => '',
		'section_desc' 	  => '',
         'link' 		  => '',
		'candidate_type'  => '',
		'order_by' 		  => '',  
	) , $atts));
$featured_cand	=	'';
if( isset( $candidate_type ) && $candidate_type == "1"  )
{
	$featured_cand	=  array(
					   'key'     => '_is_candidate_featured',
					   'value'   => '1',
					   'compare' => '='
				       );
}
	
    $args = 	array (
			   'order' 		=> 	'DESC',
			   'meta_query'    =>  array(
			   'relation'      =>  'AND',
				array(
					'key'     => '_sb_reg_type',
					'value'   => '0',
					'compare' => '='
				),
				$featured_cand,
			    ),
				);
	$user_query = new WP_User_Query($args);	
	$authors    = $user_query->get_results();
	$required_user_html =  $featured = '';
	if (!empty($authors))
	{
		$num = 1;
		foreach ($authors as $author)
		{
			$cand_address   = ''; 
			$user_id        = $author->ID;
			$user_name 		= $author->display_name;
			$cand_add       = get_user_meta($user_id, '_cand_address', true);
			$cand_head      = get_user_meta($user_id, '_user_headline', true);
			$featured_date  = get_user_meta($user_id, '_candidate_feature_profile', true);
			$salary_range	 = get_user_meta( $user_id, '_cand_salary_range', true);
            $salary_curren	 = get_user_meta( $user_id, '_cand_salary_curren', true);
			$today		     = date("Y-m-d");
			$expiry_date_string   =  strtotime($featured_date);
			$today_string 		  =  strtotime($today);
			if($today_string > $expiry_date_string)
			{
				delete_user_meta($user_id, '_candidate_feature_profile');
				delete_user_meta($user_id, '_is_candidate_featured');
			}
			if($cand_head != '')    {$cand_head    = '<p>'.$cand_head.'</p>';   }
			if($cand_add != '')     {$cand_address = '<p><i class="fa fa-map-marker"></i>'.$cand_add.'</p>';   }
		    /* Getting Star*/									  
			if( isset( $candidate_type ) && $candidate_type == "1"  ){ $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';};					
			$required_user_html .= '<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
									<div class="n-f-canidates-content">
									<a href="'.esc_url(get_author_posts_url($user_id)).'"><img src="'.nokri_get_user_profile_pic($user_id,'_cand_dp').'" alt="'.esc_attr__( 'image', 'nokri' ).'" class="img-responsive"></a>
									<a href="'.esc_url(get_author_posts_url($user_id)).'">
										<div class="n-f-style">
										'.$user_name.'
										</div>
									</a>
									'.$cand_head.'
									<a href="'.esc_url(get_author_posts_url($user_id)).'" class="btn n-btn-flat">'.esc_html__( 'View Profile', 'nokri' ).'</a>
									<div class="n-candidates-style">
									<a href="javascript:void(0)" class="saving_resume" data-cand-id="'.esc_attr($user_id).'"><i class="fa fa-heart-o"></i></a>
									</div>
									'.$featured.'
									</div>
									</div>';
								if($num % 3 == 0){$required_user_html .= '<div class="clearfix"></div>';}
								 $num++;
		}
	}

/*Section clr*/
$section_clr = (isset($sec_bg_clr) && $sec_bg_clr != "") ? $sec_bg_clr : "";
/*Section title*/
$section_title = (isset($section_title) && $section_title != "") ? '<h3>'.$section_title.'</h3>' : "";
/*Section description*/
$section_descrp = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
return '<section class="n-f-candidates4 space2" '.$section_clr.'>
		<div class="container">
		<div class="row">
			<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"> 
			<div class="heading-penel">
				'.$section_title.'
				'.$section_descrp.'
			</div>
			</div>
				'.$required_user_html.'
			</div>
  		</div>
	</section>';
}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('featured_candidates3_base', 'featured_candidates3_base_func');
}