<?php
/* ------------------------------------------------ */
/* About Us Tabs*/
/* ------------------------------------------------ */

function about_us_tabs_short()
{
	vc_map(array(
		"name" => esc_html__("Faqs Tabs", 'nokri') ,
		"base" => "about_us_tabs_short_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_faqs.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' ),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select BG Color", 'nokri') ,
		"param_name" => "about_us_clr",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('Sky BLue', 'nokri') =>'light-grey',
		esc_html__('White', 'nokri') =>'',
		),
		),	
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "section1_heading",
		),
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section1_description",
		),
		array(
		"group" => esc_html__("Section", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Qoute", 'nokri' ),
		"param_name" => "section1_qoute",
		),
		array
		(
		'group' => esc_html__( 'Add Tabs', 'nokri' ),
		'type' => 'param_group',
		'heading' => esc_html__( 'Add Tabs', 'nokri' ),
		'param_name' => 'faq_qstns',
		'value' => '',
		'params' => array
		(
					array(
					"group" => esc_html__("Basic", "nokri"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Title", 'nokri' ),
					"param_name" => "faq_qstn_title",
					),
					array(
					"group" => esc_html__("Basic", "nokri"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Question Details", 'nokri' ),
					"param_name" => "faq_qstn_details",
					),
   		    )
 			),
	),
	));
}

add_action('vc_before_init', 'about_us_tabs_short');

function about_us_tabs_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'about_us_clr' => '',
		'section1_heading' => '',
		'section1_description' => '',
		'section1_qoute' => '',
		'faq_qstns' => '',
	) , $atts));
	if(isset($atts['faq_qstns']) && $atts['faq_qstns'] != '')
	{
		$rows = vc_param_group_parse_atts( $atts['faq_qstns'] );
		$faq_html = '';
		$tabs_no = 1;
		if( count( $rows ) > 0) 
		{
	   foreach($rows as $row )
	   {	
			 $open_tab = 'false';
			 $is_in = '';
			 $tab_closed = '';
			 if ($tabs_no == 1) { $open_tab = 'true'; $is_in = ' in'; $tab_closed = 'tab-';} 
			
			/*Question Title */
			$qstn_title = (isset($row['faq_qstn_title']) && $row['faq_qstn_title'] != "") ? $row['faq_qstn_title'] : "";
			/*Question Details */
			$qstn_details = (isset($row['faq_qstn_details']) && $row['faq_qstn_details'] != "") ? $row['faq_qstn_details'] : "";
			/*Icons*/
			$icon_html = '';	
			if( isset( $row['icon']) )
			$icon_html = '<div class="panel-body-icon"><i class="'.esc_attr($row['icon'] ).'"></i></div>';
			$tabs_no++;
			$faq_html .='<div class="panel panel-default">
										<div class="panel-heading tab-collapsed" role="tab" id="heading'.esc_attr($tabs_no).'">
											<h4 class="panel-title">
										<a class="collapse-controle" data-toggle="collapse" data-parent="#accordion" href="#collapse'.esc_attr($tabs_no).'" aria-expanded="true" aria-controls="collapse'.esc_attr($tabs_no).'">
										   '.$qstn_title.'
											<span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
										</a>
									  </h4>
										</div>
										<div id="collapse'.esc_attr($tabs_no).'" class="panel-collapse collapse '.esc_attr($is_in).'" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true">
											<div class="panel-body">
												<div class="panel-body-icon"><i class="fa fa-magic"></i></div>
												'.$qstn_details.'
											</div>
										</div>
									</div>';
									
	   }
	   
	  }
	}
  /*Section Color */
$section_clr = (isset($faq_qstn_section_clr) && $faq_qstn_section_clr != "") ? $faq_qstn_section_clr : "";
/*Section Title */
$section_title = (isset($section1_heading) && $section1_heading != "") ? '<h1>'.$section1_heading.'</h1>' : "";
/*Section Details */
$section_details = (isset($section1_description) && $section1_description != "") ? '<p>'.$section1_description.'</p>' : "";
/*Section Details */
$section_qoute = (isset($section1_qoute) && $section1_qoute != "") ? '<blockquote>'.$section1_qoute.'</blockquote>' : "";
return ' <section class="about-us">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="Heading-title black ">
                                '.$section_title.'
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            '.$section_details.'
                            '.$section_qoute.'
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="panel-group drop-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                              '.$faq_html.'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('about_us_tabs_short_base', 'about_us_tabs_short_base_func');
}