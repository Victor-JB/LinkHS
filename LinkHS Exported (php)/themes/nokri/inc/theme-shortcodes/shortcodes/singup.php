<?php

/* ------------------------------------------------ */
/* Singn Up */
/* ------------------------------------------------ */
function singnup_short() {
    vc_map(array(
        "name" => esc_html__("Signup", 'nokri'),
        "base" => "admin_choice_short_base",
        "category" => esc_html__("Theme Shortcodes", 'nokri'),
        "params" => array(
            array(
                'group' => esc_html__('Shortcode Output', 'nokri'),
                'type' => 'custom_markup',
                'heading' => esc_html__('Shortcode Output', 'nokri'),
                'param_name' => 'order_field_key',
                'description' => nokri_VCImage('nokri_sign_up.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Main heading", 'nokri'),
                "param_name" => "basic_heading",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Some Details", 'nokri'),
                "param_name" => "basic_details",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Image", 'nokri'),
                "param_name" => "basic_bg_img",
                "description" => esc_html__('263x394', 'nokri'),
            ),
            array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Show/hide Show password", 'nokri') ,
			"param_name" => "show_password",
			"admin_label" => true,
			"value" => array(
			esc_html__('Select option', 'nokri') => '',
			esc_html__('Yes', 'nokri') => 'yes',
			esc_html__('No', 'nokri') => 'no',
			) ,
		),
                  array(
			"group" => esc_html__("Basic", "nokri"),
			"type" => "dropdown",
			"heading" => esc_html__("Show/hide Show confirm  password field", 'nokri') ,
			"param_name" => "show_pass_confirm",
			"admin_label" => true,
			"value" => array(
			esc_html__('Select option', 'nokri') => '',
			esc_html__('Yes', 'nokri') => 'yes',
			esc_html__('No', 'nokri') => 'no',
			) ,
		),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section heading", 'nokri'),
                "param_name" => "section_heading",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Name Text", 'nokri'),
                "param_name" => "user_name",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Email Text", 'nokri'),
                "param_name" => "user_email",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Password Text", 'nokri'),
                "param_name" => "user_password",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Employer Button Text", 'nokri'),
                "param_name" => "emp_btn",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Candidate Button Text", 'nokri'),
                "param_name" => "cand_btn",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Select default button", 'nokri'),
                "param_name" => "default_btn",
                "admin_label" => true,
                "value" => array(
                    esc_html__('Select desired', 'nokri') => '',
                    esc_html__('Candidate', 'nokri') => '0',
                    esc_html__('Employer', 'nokri') => '1',
                ),
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Agrement Text", 'nokri'),
                "param_name" => "user_agrement",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Agrement Link", 'nokri'),
                "param_name" => "user_agrement_link",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Button Text", 'nokri'),
                "param_name" => "user_btn",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Already Registered Text", 'nokri'),
                "param_name" => "already_txt",
            ),
            array(
                "group" => esc_html__("Field Names", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Login text", 'nokri'),
                "param_name" => "login_txt",
            ),
            /* Sidebar details */
            array(
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Hide/show sidebar", 'nokri'),
                "param_name" => "is_show_side",
                "admin_label" => true,
                "value" => array(
                    esc_html__('Select Option', 'nokri') => '',
                    esc_html__('Yes', 'nokri') => '1',
                    esc_html__('No', 'nokri') => '0',
                ),
            ),
            array(
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Heading", 'nokri'),
                "param_name" => "side_heading",
            ),
            array(
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Details", 'nokri'),
                "param_name" => "side_details",
            ),
            /* Login option in signup start */
            array(
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Select points/social buttons", 'nokri'),
                "param_name" => "login_btns_points",
                "admin_label" => true,
                "value" => array(
                    esc_html__('Select desired', 'nokri') => '',
                    esc_html__('Points', 'nokri') => 'pnt',
                    esc_html__('Social buttons', 'nokri') => 'social',
                ),
            ),
            array(
                "group" => esc_html__("Social button text", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Facebook text", 'nokri'),
                "param_name" => "social_fb",
                'dependency' => array('element' => 'login_btns_points', 'value' => array('social'),),
            ),
            array(
                "group" => esc_html__("Social button text", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Google text", 'nokri'),
                "param_name" => "social_gmail",
                'dependency' => array('element' => 'login_btns_points', 'value' => array('social'),),
            ),
            array(
                "group" => esc_html__("Social button text", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Linkedin text", 'nokri'),
                "param_name" => "social_linked",
                'dependency' => array('element' => 'login_btns_points', 'value' => array('social'),),
            ),
            /* Login option in signup End */
            array(
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "textarea",
                'dependency' => array('element' => 'login_btns_points', 'value' => array('pnt'),),
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Details", 'nokri'),
                "param_name" => "side_points",
                "description" => __("Points separate with | sign", "nokri")
            ),
            array(
                'dependency' => array('element' => 'login_btns_points', 'value' => array('pnt'),),
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Button text", 'nokri'),
                "param_name" => "side_button",
            ),
            array(
                'dependency' => array('element' => 'login_btns_points', 'value' => array('pnt'),),
                "group" => esc_html__("Sidebar", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Button link", 'nokri'),
                "param_name" => "side_button_link",
            ),
        ),
    ));
}

add_action('vc_before_init', 'singnup_short');

function admin_choice_short_base_func($atts, $content = '') {
    extract(shortcode_atts(array(
        'order_field_key' => '',
        'basic_heading' => '',
        'basic_details' => '',
        'basic_bg_img' => '',
        'section_heading' => '',
        'user_name' => '',
        'user_email' => '',
        'user_password' => '',
        'user_agrement' => '',
        'user_btn' => '',
        'user_agrement_link' => '',
        'terms_title' => '',
        'section_title' => '',
        'cand_btn' => '',
        'emp_btn' => '',
        'already_txt' => '',
        'login_txt' => '',
        'side_heading' => '',
        'side_details' => '',
        'login_btns_points' => '',
        'social_fb' => '',
        'social_gmail' => '',
        'social_linked' => '',
        'side_points' => '',
        'side_button' => '',
        'side_button_link' => '',
        'is_show_side' => '',
        'default_btn' => '',
        'show_password'=>'',
        'show_pass_confirm'=>'',
                    ), $atts));

    if (!nokri_vc_forntend_edit()) {
        if (get_current_user_id() != "" &&  get_current_user_id() != 0) {
            echo nokri_redirect(home_url('/'));
        }
    }
    global $nokri;


    /* Main heading */
    $basic_heading = (isset($basic_heading) && $basic_heading != "") ? '<h1>' . $basic_heading . '</h1>' : "";
    /* Main details */
    $basic_details = (isset($basic_details) && $basic_details != "") ? '<p>' . $basic_details . '</p>' : "";
    /* Section heading */
    $section_heading = (isset($section_heading) && $section_heading != "") ? '<h3>' . $section_heading . '</h3>' : "";
    /* Section Social */
    $section_social = (isset($user_social) && $user_social != "") ? '<div class="loginbox-title">' . $user_social . '</div>' : "";
    /* User Name */
    $section_user_name = (isset($user_name) && $user_name != "") ?  $user_name : esc_html__( 'Your Name','nokri' );
    /* Email */
    $section_user_email = (isset($user_email) && $user_email != "") ? $user_email : esc_html__( 'Your Email','nokri' );
    /* Password */
    $section_user_password = (isset($user_password) && $user_password != "") ?  $user_password  : esc_html__( 'Your Password','nokri' );
    /* Phone Number */
    $section_user_phone = (isset($user_phone) && $user_phone != "") ? '<label>' . $user_phone . '<span class="required">*</span></label>' : "";
    /* Button Text */
    $section_user_btn = (isset($user_btn) && $user_btn != "") ? $user_btn : "";
    /* Term & Condition */
    $section_term = (isset($user_agrement) && $user_agrement != "") ? $user_agrement : "";
    /* Term & Condition  Link */
    $section_term_link = (isset($user_agrement_link) && $user_agrement_link != "") ? $user_agrement_link : "";
    /* Employer Button */
    $section_emp_btn = (isset($emp_btn) && $emp_btn != "") ? $emp_btn : esc_html__('Employer', 'nokri');
    /* Candidate Button */
    $section_cand_btn = (isset($cand_btn) && $cand_btn != "") ? $cand_btn : esc_html__('Candidate', 'nokri');
    /* Already Register Text */
    $section_already_txt = (isset($already_txt) && $already_txt != "") ? $already_txt : esc_html__('Already registered, login here.', 'nokri');
    /* side bar heading */
    $side_heading = (isset($side_heading) && $side_heading != "") ? '<h3>' . $side_heading . '</h3>' : '';
    /* side bar details */
    $side_details = (isset($side_details) && $side_details != "") ? '<p>' . $side_details . '</p>' : '';
    /* side bar link */
    $side_button_link = (isset($side_button_link) && $side_button_link != "") ? $side_button_link : '';
    /* side bar button */
    $side_button = (isset($side_button) && $side_button != "") ? '<a href="' . $side_button_link . '" class="btn n-btn-flat btn-mid btn-block">' . $side_button . '</a>' : '';
    /* default btn button */
    $default_btn = (isset($default_btn) && $default_btn != "") ? $default_btn : '0';
    /* show password */
   $show_password = (isset($show_password) && $show_password != "") ? $show_password : "no";
   $show_pass_confirm  = (isset($show_pass_confirm) && $show_pass_confirm != "") ? $show_pass_confirm : "no";

    $authentication = new authentication();
    $code = time();
    $_SESSION['sb_nonce'] = $code;
    /* Points */
    $li = '';
    $points = explode("|", $side_points);
    foreach ($points as $point) {
        $li .= '<li>' . esc_html($point) . '</li>';
    }

    /* Background Image */
    $bg_img = '';
    if ($basic_bg_img != "") {
        $bgImageURL = nokri_returnImgSrc($basic_bg_img);
        $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
    }


    /* Social options starts */
    if (isset($login_btns_points) && $login_btns_points == 'social') {
        /* fb button */
        $social_fb = (isset($social_fb) && $social_fb != "") ? $social_fb : "";
        /* gmail button */
        $social_gmail = (isset($social_gmail) && $social_gmail != "") ? $social_gmail : "";
        /* linkedin button */
        $social_linked = (isset($social_linked) && $social_linked != "") ? $social_linked : "";


        global $nokri;
        $social_login = '';
        if (isset($nokri['fb_api_key']) && $nokri['fb_api_key'] != "") {
            $li .= '<div class="form-group"><a href="javascript:void(0)" class="btn-facebook btn-block btn-social"  onclick="hello(\'facebook\').login(' . "{scope : 'email',}" . ')"><img src="' . get_template_directory_uri() . '/images/f-logo.png" class="img-resposive" alt="facebook logo"><span>' . ($social_fb) . '</span></a></div> ';
        }
        if (isset($nokri['gmail_api_key']) && $nokri['gmail_api_key'] != "") {
            $li .= '<div class="form-group"><a href="javascript:void(0)" class="btn-google btn-block btn-social"  onclick="hello(\'google\').login(' . "{scope : 'email',}" . ')"><img src="' . get_template_directory_uri() . '/images/g-logo.png" class="img-resposive" alt="Google logo"><span>' . ($social_gmail) . '</span></a></div>';
        }

        /* Linkedin key */
        $linkedin_api_key = '';
        if ((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key'] != '' && (isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret'] != '' && (isset($nokri['redirect_uri'])) && $nokri['redirect_uri'] != '') {
            $linkedin_api_key = ($nokri['linkedin_api_key']);
            $linkedin_secret_key = ($nokri['linkedin_api_secret']);
            $redirect_uri = ($nokri['redirect_uri']);
            $linkedin_url = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . $linkedin_api_key . '&redirect_uri=' . $redirect_uri . '&state=popup&scope=r_liteprofile r_emailaddress';
            $li .= '<div class="form-group"><a href="' . esc_url($linkedin_url) . '" class="btn-linkedIn btn-block"><i class="ti-linkedin"></i><span>' . ($social_linked) . '</span></a></div>';
        }
    }
    /* Social options End */

    if (isset($login_btns_points) && $login_btns_points == 'pnt') {
        $final_html = '<ul> ' . ($li) . '</ul>';
    } else {
        $final_html = '<div class="social-buttons"><ul> ' . ($li) . '</ul></div>';
    }
   $feilds = nokri_get_custom_feilds('Registration');
    /* Sidebar */
    $side_bar = (isset($is_show_side) && $is_show_side != "") ? $is_show_side : "";
    $side_bar_html = '';
    $col_sizes = 'col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-lg-offset-3';
    $col_sizes2 = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
    if ($side_bar) {
        $col_sizes = 'col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1 col-lg-offset-1';
        $col_sizes2 = 'col-lg-7 col-md-7 col-sm-12 col-xs-12 ';
        $side_bar_html = '<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 nopadding">
                           <div class="n-page-right-side">
                              <div class="post-job-heading">
                                 ' . ($side_heading) . '
                              </div>
                              <div class="form-group">
                                 ' . ($side_details) . '
                              </div>
                              ' . ($final_html) . '
                              ' . ($side_button) . '
                           </div>
                        </div>';
    }

    return '<section class="n-pages-breadcrumb" ' . str_replace('\\', "", $bg_img) . '>
     <div class="container">
        <div class="row">
           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
              <div class="n-breadcrumb-info">
                ' . ($basic_heading . $basic_details) . '
              </div>
           </div>
        </div>
     </div>
</section>
<section class="n-job-pages-section">
         <div class="container">
            <div class="row">
               <div class="' . esc_attr($col_sizes) . '">
                  <div class="row">
                     <div class="n-job-pages register-page">
                        <div class="' . esc_attr($col_sizes2) . '">
                           <div class="row">
                              <div class="n-page-left-side">
                                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="post-job-heading">
                                       ' . ($section_heading) . '
                                    </div>
                                 </div>
                                 ' . $authentication->nokri_sign_up_form($section_term_link, $terms_title, $section_user_name, $section_user_email, $section_user_password, $section_term, $section_user_btn, $section_user_phone, $code, $section_term_link, $section_emp_btn, $section_cand_btn, $section_already_txt, $login_txt, $default_btn,$show_password,$show_pass_confirm) . '
                              </div>
                           </div>
                        </div>
                        ' . $side_bar_html . '
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>';
}

if (function_exists('nokri_add_code')) {
    nokri_add_code('admin_choice_short_base', 'admin_choice_short_base_func');
}