<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Signup_Sec extends Widget_Base {

    public function get_name() {
        return 'signup-sec';
    }

    public function get_title() {
        return __('Sign Up', 'nokri-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }

    public function get_categories() {
        return ['nokritheme'];
    }

    public function get_script_depends() {
        return [''];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        /* for About Us tab */
        $this->start_controls_section(
                'basic_section',
                [
                    'label' => __('Basic', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'basic_heading',
                [
                    'label' => __('Main Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'basic_details',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'basic_bg_img',
                [
                    'label' => __('Backgorund Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('263x394', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'show_pass_confirm',
                [
                    'label' => __('Show/hide Show confirm  password field', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select option', 'nokri-elementor') => '',
                        esc_html__('Yes', 'nokri-elementor') => 'yes',
                        esc_html__('No', 'nokri-elementor') => 'no',
                    )),
                ]
        );
        $this->add_control(
                'show_password',
                [
                    'label' => __('Show/hide Show password', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select option', 'nokri-elementor') => '',
                        esc_html__('Yes', 'nokri-elementor') => 'yes',
                        esc_html__('No', 'nokri-elementor') => 'no',
                    )),
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'fieldname_section',
                [
                    'label' => __('Fields name', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'section_heading',
                [
                    'label' => __('Section heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'user_name',
                [
                    'label' => __('Name Txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'user_email',
                [
                    'label' => __('Email Txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'user_password',
                [
                    'label' => __('Password Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'emp_btn',
                [
                    'label' => __('Employer Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'cand_btn',
                [
                    'label' => __('Candidate Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'default_btn',
                [
                    'label' => __('Default user', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select desired', 'nokri-elementor') => '',
                        esc_html__('Candidate', 'nokri-elementor') => '0',
                        esc_html__('Employer', 'nokri-elementor') => '1',
                    )),
                ]
        );

        $this->add_control(
                'user_agrement',
                [
                    'label' => __('Agrement Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'user_agrement_link',
                [
                    'label' => __('Agrement Link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'user_btn',
                [
                    'label' => __('Registe Button txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'already_txt',
                [
                    'label' => __('Already registerd text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'login_txt',
                [
                    'label' => __('Login text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
                'Sidebar_section',
                [
                    'label' => __('Sidebar Section', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'is_show_side',
                [
                    'label' => __('Hide/show sidebar', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Yes', 'nokri-elementor') => '1',
                        esc_html__('No', 'nokri-elementor') => '0',
                    )),
                ]
        );



        $this->add_control(
                'side_heading',
                [
                    'label' => __('Sidebar heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'side_details',
                [
                    'label' => __('Sidebar Details', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );


        $this->add_control(
                'login_btns_points',
                [
                    'label' => __('Select points/social buttons', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select desired', 'nokri-elementor') => '',
                        esc_html__('Points', 'nokri-elementor') => 'pnt',
                        esc_html__('Social buttons', 'nokri-elementor') => 'social',
                    )),
                ]
        );
        $this->add_control(
                'side_points',
                [
                    'label' => __('Details', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    "description" => __("Points separate with | sign", "nokri-elementor"),
                    'condition' => [
                        'login_btns_points' => ['pnt'],
                    ],
                ]
        );
        $this->add_control(
                'side_button',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'login_btns_points' => ['pnt'],
                    ],
                ]
        );
        $this->add_control(
                'side_button_link',
                [
                    'label' => __('Button link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'login_btns_points' => ['pnt'],
                    ],
                ]
        );
        $this->end_controls_section();




        $this->start_controls_section(
                'social_section',
                [
                    'label' => __('Sidebar Section', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'login_btns_points' => ['social'],
                    ],
                ]
        );
        $this->add_control(
                'social_fb',
                [
                    'label' => __('Facebook', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'social_gmail',
                [
                    'label' => __('Gmail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'social_linked',
                [
                    'label' => __('Linkedin', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);


        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        if (!nokri_elementor_forntend_edit()) {
            if (get_current_user_id() != "" && get_current_user_id() != 0) {
                echo nokri_redirect(home_url('/'));
            }
        }

        /* Main heading */
        $basic_heading = (isset($basic_heading) && $basic_heading != "") ? '<h1>' . $basic_heading . '</h1>' : "";
        /* Main details */
        $basic_details = (isset($basic_details) && $basic_details != "") ? '<p>' . $basic_details . '</p>' : "";
        /* Section heading */
        $section_heading = (isset($section_heading) && $section_heading != "") ? '<h3>' . $section_heading . '</h3>' : "";
        /* Section Social */
        $section_social = (isset($user_social) && $user_social != "") ? '<div class="loginbox-title">' . $user_social . '</div>' : "";
        /* User Name */
        $section_user_name = (isset($user_name) && $user_name != "") ? $user_name : esc_html__('Your Name', 'nokri-elementor');
        /* Email */
        $section_user_email = (isset($user_email) && $user_email != "") ? $user_email : esc_html__('Your Email', 'nokri-elementor');
        /* Password */
        $section_user_password = (isset($user_password) && $user_password != "") ? $user_password : esc_html__('Your Password', 'nokri-elementor');
        /* Phone Number */
        $section_user_phone = (isset($user_phone) && $user_phone != "") ? '<label>' . $user_phone . '<span class="required">*</span></label>' : "";
        /* Button Text */
        $section_user_btn = (isset($user_btn) && $user_btn != "") ? $user_btn : "";
        /* Term & Condition */
        $section_term = (isset($user_agrement) && $user_agrement != "") ? $user_agrement : "";
        /* Term & Condition  Link */
        $section_term_link = (isset($user_agrement_link) && $user_agrement_link != "") ? $user_agrement_link : "";
        /* Employer Button */
        $section_emp_btn = (isset($emp_btn) && $emp_btn != "") ? $emp_btn : esc_html__('Employer', 'nokri-elementor');
        /* Candidate Button */
        $section_cand_btn = (isset($cand_btn) && $cand_btn != "") ? $cand_btn : esc_html__('Candidate', 'nokri-elementor');
        /* Already Register Text */
        $section_already_txt = (isset($already_txt) && $already_txt != "") ? $already_txt : esc_html__('Already registered, login here.', 'nokri-elementor');
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
        $show_pass_confirm = (isset($show_pass_confirm) && $show_pass_confirm != "") ? $show_pass_confirm : "no";

        $terms_title = " ";

        $authentication = new \authentication();
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
        if (isset($basic_bg_img['url'])) {
            $bgImageURL = $basic_bg_img['url'];
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

        echo '<section class="n-pages-breadcrumb" ' . str_replace('\\', "", $bg_img) . '>
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
                                 ' . $authentication->nokri_sign_up_form($section_term_link, $terms_title, $section_user_name, $section_user_email, $section_user_password, $section_term, $section_user_btn, $section_user_phone, $code, $section_term_link, $section_emp_btn, $section_cand_btn, $section_already_txt, $login_txt, $default_btn, $show_password, $show_pass_confirm) . '
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

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {
        
    }

}
