<?php
/* ------------------------------------------------ */
/* Contact Us*/
/* ------------------------------------------------ */
function contact_form()
{
	vc_map(array(
		"name" => esc_html__("Conact Us", 'nokri') ,
		"base" => "contact_form_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_contact_us.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' 			),
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
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section_desc",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "attach_image",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Image", 'nokri' ),
		"param_name" => "basic_bg_img",
		"description" => esc_html__('263x394', 'nokri'),
		),
		array(
		"group" => esc_html__("Contact Form", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "contact_form_title",
		),
		array(
			"group" => __("Contact Form", "nokri"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => __( "Form Input", 'nokri' ),
			"param_name" => "contact_form_input",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Title", 'nokri' ),
		"param_name" => "contact_title",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Adress", 'nokri' ),
		"param_name" => "adress",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Email", 'nokri' ),
		"param_name" => "email",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Phone", 'nokri' ),
		"param_name" => "phone",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Facebook", 'nokri' ),
		"param_name" => "fb",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Twitter", 'nokri' ),
		"param_name" => "twitter",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Linkedin", 'nokri' ),
		"param_name" => "linkedin",
		),
		array(
		"group" => esc_html__("Contact Information", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Google+", 'nokri' ),
		"param_name" => "google",
		),
	),
	));
}



add_action('vc_before_init', 'contact_form');
function contact_form_base_func($atts, $content = '')
{
extract(shortcode_atts(array(
	'section_title' => '',
	'section_desc' => '',
	'basic_bg_img' => '',
	'contact_form_title' => '',
	'contact_form_input' => '',
	'contact_title' => '',
	'twitter' => '',
	'linkedin' => '',
	'google' => '',
	'adress' => '',
	'email' => '',
	'phone' => '', 
	'fb' => '',
) , $atts));


/*Section Title */
$section_title = (isset($section_title) && $section_title != "") ? '<h1>'.$section_title.'</h1>' : "";  
/*Section Desc */
$section_desc = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
/*cotact title */
$contact_title = (isset($contact_title) && $contact_title != "") ? '<h3>'.$contact_title.'</h3>' : "";
/*Adress */
$adress = (isset($adress) && $adress != "") ? '<li><i class="ti-location-pin"></i><div class="contact-detail"><p>'.$adress.'</p></div></li>' : "";
/*email */
$email = (isset($email) && $email != "") ? '<li><i class="ti-email"></i><div class="contact-detail"><p><a href="mailto:'.$email.'">'.$email.'</a></p></div></li>' : "";
/*phone */
$phone = (isset($phone) && $phone != "") ? '<li><i class="ti-mobile"></i><div class="contact-detail"><p><a href="callto:'.$phone.'">'.$phone.'</a></p> </div></li>' : "";
/* Social Contact */
/*fb */
$fb = (isset($fb) && $fb != "") ? ' <li><a href="'.esc_url($fb).'" target="_blank"><img src="'.get_template_directory_uri().'/images/icons/006-facebook.png" class="img-responsive" alt="'.esc_attr__( 'icon','nokri' ).'"></a></li>' : "";
/*twitter */
$twitter = (isset($twitter) && $twitter != "") ? '<li><a href="'.esc_url($twitter).'" target="_blank"><img src="'.get_template_directory_uri().'/images/icons/004-twitter.png" class="img-responsive" alt="'.esc_attr__( 'icon','nokri' ).'"></a></li>' : "";
/*linkedin */
$linkedin = (isset($linkedin) && $linkedin != "") ? '<li><a href="'.esc_url($linkedin).'" target="_blank"><img src="'.get_template_directory_uri().'/images/icons/005-linkedin.png" class="img-responsive" alt="'.esc_attr__( 'icon','nokri' ).'"></a></li>' : "";
/*google */
$google = (isset($google) && $google != "") ? '<li><a href="'.esc_url($google).'" target="_blank"><img src="'.get_template_directory_uri().'/images/icons/003-google-plus.png" class="img-responsive" alt="'.esc_attr__( 'icon','nokri' ).'"></a></li>' : "";
/*contact Title */
$contact_form_title = (isset($contact_form_title) && $contact_form_title != "") ? '<h3>'.$contact_form_title.'</h3>' : "";
$shortCode = '';
$shortCode = nokri_clean_shortcode($contact_form_input);
$contact_form_input = do_shortcode($shortCode);

/* Background Image */
$bg_img = '';
if( isset($basic_bg_img) && $basic_bg_img != " " )
{
$img  		        = 	wp_get_attachment_image_src($basic_bg_img,'');
$bgImageURL  		= 	isset($img[0]) ?  $img[0]   :  "";
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url('.$bgImageURL.') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
}

return '<section class="n-pages-breadcrumb" '.str_replace('\\',"",$bg_img).'>
  	<div class="container">
    	<div class="row">
        	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
            	<div class="n-breadcrumb-info">
                   '.$section_title.'
                   '.$section_desc.'
                </div>
            </div>
        </div>
    </div>
  </section>
	<section class="n-job-pages-section">
  	<div class="container">
    	<div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="n-job-pages contact-page">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="n-page-left-side">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="post-job-heading">
                                        '.$contact_form_title.'
                                    </div>
                                </div>
                                 '.$contact_form_input.'
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 nopadding">
                        <div class="n-page-right-side">
                            <div class="post-job-heading">
                                '.$contact_title.'
                            </div>
                            <ul>
                                '.$adress.'
                                '.$email.'
                                '.$phone.'
                            </ul>
                            <ul class="social-links">
                               '.$fb.'
                               '.$twitter.'
                                '.$linkedin.'
                               '.$google.'
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('contact_form_base', 'contact_form_base_func');
}