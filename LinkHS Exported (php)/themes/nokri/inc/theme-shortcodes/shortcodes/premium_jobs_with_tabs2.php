<?php
/* ------------------------------------------------ */
/* Premium Jobs with tabs 2         */ 
/* ------------------------------------------------ */
if (!function_exists('premium_jobs_with_tabs2'))
 {
	function premium_jobs_with_tabs2()
	{
		vc_map(array(
			"name" => esc_html__("Premium Jobs With Tabs 2", 'nokri') ,
			"base" => "premium_jobs_with_tabs2",
			"category" => esc_html__("Theme Shortcodes", 'nokri') ,
			"params" => array(
			array(
			'group' => esc_html__( 'Output', 'nokri' ),  
			'type' => 'custom_markup',
			'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
			'param_name' => 'order_field_key',
			'description' => nokri_VCImage('premium_jobs_with_tabs2.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
			),
			/* Jobs Tab Start */
			array(
				"group" => esc_html__("Job Tabs", "nokri"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Heading", 'nokri' ),
				"param_name" => "jobs_heading",
			),
			array(
				"group" => esc_html__("Job Tabs", "nokri"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'nokri' ),
				"param_name" => "jobs_description",
			),
			array(
				"group" => esc_html__("Job Tabs", "nokri"),
				"type" => "dropdown",
				"heading" => esc_html__("Number Of Jobs", 'nokri') ,
				"param_name" => "job_class_no",
				"admin_label" => true,
				"value" => range( 1, 50 ),
				),
			array(
				"group" => esc_html__("Job Tabs", "nokri"),
				"type" => "dropdown",
				"heading" => esc_html__("Order By", 'nokri') ,
				"param_name" => "job_order",
				"admin_label" => true,
				"value" => array(
				esc_html__('Select Job order', 'nokri') => '',
				esc_html__('ASC', 'nokri') => 'asc',
				esc_html__('DESC', 'nokri') => 'desc',
				) ,
			),
			array(
			"group" => esc_html__("Job Tabs", "nokri"),
			"type" => "vc_link",
			"heading" => esc_html__( "All Jobs", 'nokri' ),
			"param_name" => "link",
			),
			array
			(
				"group" => esc_html__("Job Tabs", "nokri"),
				'type' => 'param_group',
				'heading' => esc_html__( 'Select Job Class', 'nokri' ),
				'param_name' => 'job_classes',
				'value' => '',
				'params' => array
				(
					array(
					"type" => "dropdown",
					"heading" => esc_html__("Select your desired ones", 'nokri') ,
					"param_name" => "job_class",
					"admin_label" => true,
					"value" => nokri_job_class('job_class'),
					),
				)
			),
			/* Jobs Tab End */
				
			),
		));
	}
}

add_action('vc_before_init', 'premium_jobs_with_tabs2');
if (!function_exists('premium_jobs_with_tabs2_short_base_func')) 
{
	function premium_jobs_with_tabs2_short_base_func($atts, $content = '')
	{
		     extract(shortcode_atts(array(
			'jobs_heading'  	=> '',
			'jobs_description'  => '',   
			'job_class_no'      => '',
			'job_order'    		=> '',
			'job_classes'       => '',
			'job_class'        	=> '',
			'link'        	    => '',
		) , $atts));
global $nokri;
$tabs_content = $tabs_html = '';
/*View  Link */
$read_more = '';
if( isset( $link) )
{
	$read_more = '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"><div class="n-jobs3-product">'.nokri_ThemeBtn($link, 'btn n-btn-flat',false).'</div></div>';
}
/* Job class tabs query starts */
if(isset($atts['job_classes']) && !empty($atts['job_classes']) != '')
{
	$rows = vc_param_group_parse_atts( $atts['job_classes'] );	
	if( (array)count( $rows ) > 0 )
	{ 
		$tabs_html =  $tabs_content =  '';
		$count = 1;
		foreach($rows as $row ) 
		{ 
			$active = $active_in ='';
			if($count == 1) {  $active = 'active';  $active_in = 'active in'; } 
			$job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
			$term              =  get_term( $row['job_class'], 'job_class' );
			$tabs_html        .= '<li class="'.esc_attr($active).'"><a data-toggle="tab" href="#home'.$count.'">'.$term->name.'</a></li>';
			$args = array(
				'post_type'   		=> 'job_post',
				'order'       		=> 'date',
				'orderby'     		=> $job_order,
				'posts_per_page' 	=> $job_class_no,
				'post_status' 		=> array('publish'),
				'tax_query'         => array(
											array(
												'taxonomy' => 'job_class',
												'field' => 'term_id',
												'terms' => $row['job_class'],
											)
										), 
				'meta_query' 		=> array(
										array(
											'key'     => '_job_status',
											'value'   => 'active',
											'compare' => '='
										)
				)
			);
	$tabs_content .= '<div id="home'.$count.'" class="tab-pane fade '.esc_attr($active_in).'">
								  <div class="row">';
									$job_class_query = new WP_Query( $args ); 
									$job_class_html = '';
									if ( $job_class_query->have_posts() )
									{
										while ( $job_class_query->have_posts()  )
										{ 
												$job_class_query->the_post();
												$job_id		= get_the_ID();
												$author_id  = get_post_field('post_author', $job_id );
												/* Getting Profile Photo */
												$img             =  nokri_get_user_profile_pic($author_id,'_sb_user_pic');
												$job_type        =   wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
												$job_type	     =   isset( $job_type[0] ) ? $job_type[0] : '';
												$job_salary      =   wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
												$job_salary	     =   isset( $job_salary[0] ) ? $job_salary[0] : '';
												$job_currency    =   wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
												$job_currency	 =   isset( $job_currency[0] ) ? $job_currency[0] : '';
												$job_salary_type =   wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
												$job_salary_type =	 isset( $job_salary_type[0] ) ? $job_salary_type[0] : '';
												$location        =   nokri_job_country($job_id,'');
												/* Getting Catgories*/
												$categories    = nokri_job_categories_with_chlid($job_id,'job_category');
												$tabs_content .= '<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12">
																	<div class="n-jobs3-container">
																		<div class="n-jobs3-categories">
																		<img src="'.$img.'" alt="'.esc_attr__('image','nokri').'" class="img-responsive">
																			<div class="n-jobs3-categories-2">
																				<span>'.$categories.'</span>
																				<a href="'.get_the_permalink().'">
																					<div class="jobs3-style">'.get_the_title().'</div>
																				</a>
																				<p><i class="fa fa-clock-o"></i>'." ".nokri_time_ago().'</p>
																				</div>
																		</div>
																		<div class="n-jobs3-content">
																			<p><i class="fa fa-map-marker"></i>'.$location.'</p>
																		</div>
																	</div>
																</div>';
										}
										$tabs_content .= $read_more;
									} 
					   $tabs_content .= '</div></div>';
						$count++;
		}
	}
}
/*Section title */
$section_title       = (isset($jobs_heading) && $jobs_heading != "") ? '<h2>'.$jobs_heading.'</h2>' : "";
/*Section description */
$section_description = (isset($jobs_description) && $jobs_description != "") ? '<p>'.$jobs_description.'<p>' : "";
	return  '<section class="n-jobs-recomend3 space3">
				<div class="container">
					<div class="row clear-custom">
						<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
							<div class="n-listing-text">
							'.$section_title.'
							'.$section_description.'
							</div>
							<ul class="nav nav-tabs">
							'.$tabs_html.'
							</ul>
							<div class="tab-content">
							'.$tabs_content.'
							</div>
							</div>
						</div>
					</div>
				</section>';
		}
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('premium_jobs_with_tabs2', 'premium_jobs_with_tabs2_short_base_func');
}