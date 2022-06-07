<?php
/* -------------- */
/* Featured candidates */
/* ------------*/
if ( !function_exists ( 'featured_candidates2' ) ) {
function featured_candidates2()
{
	vc_map(array(
		"name" => __("Featured Candidates 2", 'nokri') ,
		"base" => "featured_candidates2_base",
		"category" => __("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_premium_candidates2.png') . __( 'Ouput of the shortcode will be look like this.', 'nokri' ),
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
add_action('vc_before_init', 'featured_candidates2');
if ( !function_exists ( 'featured_candidates2_base_func' ) )
{
function featured_candidates2_base_func($atts, $content = '')
{	
extract(shortcode_atts(array( 
		'sec_bg_clr' 	  => '',   
		'section_title'   => '',
		'section_desc' 	  => '',
         'link' 		  => '',
		'candidate_type'  => '',
		'order_by' 		  => '',  
	) , $atts));
  $featured_cand = '';
        
       
        if (isset($candidate_type) && $candidate_type == "1") {
            $featured_cand = array(
                'key' => '_is_candidate_featured',
                'value' => '1',
                'compare' => '='
            );
        }

        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                $featured_cand,
            ),
        );
        $user_query = new \WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = $featured = '';
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $cand_address = '';
                $user_id = $author->ID;
                $user_name = $author->display_name;
                $cand_add = get_user_meta($user_id, '_cand_address', true);
                $cand_head = get_user_meta($user_id, '_user_headline', true);
                $featured_date = get_user_meta($user_id, '_candidate_feature_profile', true);
                $today = date("Y-m-d");
                $expiry_date_string = strtotime($featured_date);
                $today_string = strtotime($today);
                if ($today_string > $expiry_date_string) {
                    delete_user_meta($user_id, '_candidate_feature_profile');
                    delete_user_meta($user_id, '_is_candidate_featured');
                }
                if ($cand_head != '') {
                    $cand_head = '<p>' . $cand_head . '</p>';
                }
                if ($cand_add != '') {
                    $cand_address = '<div class="n-candidate-location"><i class="fa fa-map-marker"></i><p>' . $cand_add . '</p></div>';
                }
                /* Getting Star */
                if (isset($candidate_type) && $candidate_type == "1") {
                    $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                };
                /* Getting Candidates Skills  */
                $skill_tags = nokri_get_candidates_skills($user_id, '');
                $required_user_html .= '<div class="item">
								   <div class="n-featured-single">
									  <div class="n-featured-candidates-single-top">
									  <a href="javascript:void(0)" class="bookmark-icon active saving_resume" data-cand-id=' . esc_attr($user_id) . '><i class="fa fa-heart-o"></i></a>
									  ' . $featured . '
										 <div class="n-candidate-title">
											<h4>' . $user_name . '</h4>
											' . $cand_head . '
										 </div>
										 <div class="n-canididate-avatar">
											<img src="' . nokri_get_user_profile_pic($user_id, '_cand_dp') . '" class="img-responsive" alt="' . esc_attr__('Image', 'nokri') . '">
										 </div>
										 ' . $cand_address . '
										 <div class="n-candidate-skills">
											' . $skill_tags . '
										 </div>
									  </div>
									  <div class="n-candidates-single-bottom">
										  <a href="' . esc_url(get_author_posts_url($user_id)) . '">' . esc_html__('View Profile', 'nokri') . '</a>
									  </div>
								   </div>
								</div>';
            }
        }

        /* Section clr */
        $section_clr = (isset($sec_bg_clr) && $sec_bg_clr != "") ? $sec_bg_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";

        echo '<section class="n-featured-candidates ' . esc_attr($section_clr) . ' candidates-2">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="heading-title left">
                    ' . $section_title . '
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-featured-candidates-box">
					  <div class="n-candidatel-2 owl-carousel owl-theme">
                        ' . $required_user_html . '
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
	nokri_add_code('featured_candidates2_base', 'featured_candidates2_base_func');
}