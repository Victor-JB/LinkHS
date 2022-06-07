<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Signin_Sec extends Widget_Base {

    public function get_name() {
        return 'signin-sec';
    }

    public function get_title() {
        return __('Sign In', 'nokri-elementor');
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
                'remember_me',
                [
                    'label' => __('Remember me', 'nokri-elementor'),
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
                'page_heading',
                [
                    'label' => __('Page heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'user_email',
                [
                    'label' => __('Email address', 'nokri-elementor'),
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
                'forgot_password',
                [
                    'label' => __('Forgot Password Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'submit_button',
                [
                    'label' => __('Submit Button Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'already_acount',
                [
                    'label' => __('Already acount text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'signup_text',
                [
                    'label' => __('Signup text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();



        $this->start_controls_section(
                'fieldname_social_section',
                [
                    'label' => __('Social fields', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $this->add_control(
                'is_show_side', array(
            'label' => __('Sidebar', 'nokri-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'yes',
            'options' => array(
                'yes' => __('Yes', 'nokri-elementor'),
                'no' => __('No', 'nokri-elementor'),
            ),
                )
        );

        $this->add_control(
                'social_heading',
                [
                    'label' => __('heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'is_show_side',
                                'operator' => 'in',
                                'value' => [
                                    'yes',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'social_details',
                [
                    'label' => __('Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'is_show_side',
                                'operator' => 'in',
                                'value' => [
                                    'yes',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'social_fb',
                [
                    'label' => __('Facebook txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'is_show_side',
                                'operator' => 'in',
                                'value' => [
                                    'yes',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'social_gmail',
                [
                    'label' => __('Gmail txt', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'is_show_side',
                                'operator' => 'in',
                                'value' => [
                                    'yes',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'social_linked',
                [
                    'label' => __('Linkedin text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'is_show_side',
                                'operator' => 'in',
                                'value' => [
                                    'yes',
                                ],
                            ],
                        ],
                    ],
                ]
        );
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
        $page_heading = (isset($page_heading) && $page_heading != "") ? '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="post-job-heading"><h3>' . $page_heading . '</h3></div></div>' : "";
        /* Social heading */
        $social_heading = (isset($social_heading) && $social_heading != "") ? '<div class="post-job-heading"><h3>' . $social_heading . '</h3></div>' : "";
        /* Social details */
        $social_details = (isset($social_details) && $social_details != "") ? '<div class="form-group"><p>' . $social_details . '</p></div>' : "";
        /* already acount */
        $already_acount = (isset($already_acount) && $already_acount != "") ? $already_acount : "";
        /* signup */
        $signup_text = (isset($signup_text) && $signup_text != "") ? $signup_text : "";
        /* submit button */
        $submit_button = (isset($submit_button) && $submit_button != "") ? $submit_button : "";

        $remember_me = (isset($remember_me) && $remember_me != "") ? $remember_me : "";

        $show_password = (isset($show_password) && $show_password != "") ? $show_password : "";


        /* user_password placeholder and email placeholder */

        $user_email_plc = (isset($user_email) && $user_email != "") ? $user_email : esc_html__('Your Email', 'nokri-elementor');

        $user_password_plc = (isset($user_password) && $user_password != "") ? $user_password : esc_html__('Your Password', 'nokri-elementor');

        /* submit button */
        $forgot_password = (isset($forgot_password) && $forgot_password != "") ? $forgot_password : "";

        /* fb button */
        $social_fb = (isset($social_fb) && $social_fb != "") ? $social_fb : "";
        /* gmail button */
        $social_gmail = (isset($social_gmail) && $social_gmail != "") ? $social_gmail : "";
        /* linkedin button */
        $social_linked = (isset($social_linked) && $social_linked != "") ? $social_linked : "";



        global $nokri;
        $social_login = '';
        if (isset($nokri['fb_api_key']) && $nokri['fb_api_key'] != "") {
            $social_login .= '<div class="form-group"><a href="javascript:void(0)" class="btn-facebook btn-block btn-social"  onclick="hello(\'facebook\').login(' . "{scope : 'email',}" . ')"><img src="' . get_template_directory_uri() . '/images/f-logo.png" class="img-resposive" alt="facebook logo"><span>' . ($social_fb) . '</span></a></div> ';
        }
        if (isset($nokri['gmail_api_key']) && $nokri['gmail_api_key'] != "") {
            $social_login .= '<div class="form-group"><a href="javascript:void(0)" class="btn-google btn-block btn-social"  onclick="hello(\'google\').login(' . "{scope : 'email',}" . ')"><img src="' . get_template_directory_uri() . '/images/g-logo.png" class="img-resposive" alt="Google logo"><span>' . ($social_gmail) . '</span></a></div>';
        }

        /* Linkedin key */
        $linkedin_api_key = '';
        if ((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key'] != '' && (isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret'] != '' && (isset($nokri['redirect_uri'])) && $nokri['redirect_uri'] != '') {
            $linkedin_api_key = ($nokri['linkedin_api_key']);
            $linkedin_secret_key = ($nokri['linkedin_api_secret']);
            $redirect_uri = ($nokri['redirect_uri']);
            $linkedin_url = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . $linkedin_api_key . '&redirect_uri=' . $redirect_uri . '&state=popup&scope=r_liteprofile r_emailaddress';
            $social_login .= '<div class="form-group"><a href="' . esc_url($linkedin_url) . '" class="btn-linkedIn btn-block"><i class="ti-linkedin"></i><span>' . ($social_linked) . '</span></a></div>';
        }

        $authentication = new \authentication();
        $code = time();
        $_SESSION['sb_nonce'] = $code;

        /* Background Image */
        $bg_img = '';
        if (isset($basic_bg_img['url'])) {
            $bgImageURL = $basic_bg_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }

        /* Sidebar */
    $side_bar = (isset($is_show_side) && $is_show_side != "") ? $is_show_side : true;
    $side_bar_html = '';
    $col_sizes = 'col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-lg-offset-3';
    $col_sizes2 = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
    if ($side_bar == 'yes') {
        $col_sizes = 'col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1 col-lg-offset-1';
        $col_sizes2 = 'col-lg-7 col-md-7 col-sm-12 col-xs-12 ';
        $side_bar_html = '<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 nopadding">
                            <div class="n-page-right-side">
                              '.($social_heading . $social_details).'
							  <div class="social-buttons">
							  '.($social_login).'
                                                              </div>
				</div>			  
                           </div>';
    }
        echo
        '<div class="custom-modal">
         <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
			   <div class="cp-spinner cp-skeleton"></div>
                  <div class="modal-header rte">
                     <h2 class="modal-title">' . esc_html__('Forgot your password?', 'nokri-elementor') . '</h2>
                  </div>
					' . $authentication->nokri_forgot_password_form() . '
               </div>
            </div>
         </div>
      </div>
      <section class="n-pages-breadcrumb" ' . str_replace('\\', "", $bg_img) . '>
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
                     <div class="n-job-pages">
                        <div class="' . esc_attr($col_sizes2) . '">
                           <div class="row">
                              <div class="n-page-left-side">
							  ' . ($page_heading) . '
							   ' . $authentication->nokri_sign_in_form($code, $already_acount, $signup_text, $submit_button, $forgot_password, $user_email_plc, $user_password_plc, $remember_me, $show_password) . '
							   </div>
                           </div>
                        </div>
                        
                        ' . $side_bar_html . '
                           
                        </div>
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
