<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section2 extends Widget_Base {

    public function get_name() {
        return 'hero-section2';
    }

    public function get_title() {
        return __('Hero Section 2', 'nokri-elementor');
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
                    'label' => __('Basic)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'search_section_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('1263 x 147', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'keyword_title',
                [
                    'label' => __('Keyword title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'cats_title',
                [
                    'label' => __('Category title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'locat_title',
                [
                    'label' => __('Location title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Category', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Do you want to show Sub Categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Yes', 'nokri-elementor') => 'yes',
                        esc_html__('No', 'nokri-elementor') => 'no',
                            )),
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );

        $this->add_control(
                'cats',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'Location_section',
                [
                    'label' => __('Location', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'country',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(nokri_get_all('ad_location', 'yes')),
                ]
        );
        $this->add_control(
                'countries',
                [
                    'label' => __('Select Countries', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );
        $this->add_control(
                'want_to_show_loc',
                [
                    'label' => __('Do you want to show Sub location', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Yes', 'nokri-elementor') => 'yes',
                        esc_html__('No', 'nokri-elementor') => 'no',
                            )),
                ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
                'button_section',
                [
                    'label' => __('Side Button', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
       
       $this->add_control(
               'side_tagline', 
               [
                    'label' => __('side tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
               );
       $this->add_control(
               'side_title', 
               [
                    'label' => __('side title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
               );
       $this->add_control(
               'resume_btn_txt', 
               [
                    'label' => __('side title', 'nokri-elementor'),
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

        global $nokri;
        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        // For Job Category
        $cats_html = " ";
        if (isset($atts['cats']) && !empty($atts['cats']) != '') {
            $rows = $atts['cats'];
            $cats = false;
            $cats_html = '';
            if (count($rows) > 0) {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count(array($category)) == 0)
                            continue;

                        if (isset($want_to_show) && $want_to_show == "yes") {

                            $ad_cats_sub = nokri_get_cats('job_category', $category->term_id);
                            if (count(array($ad_cats_sub)) > 0) {
                                $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }

                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show) && $want_to_show == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('job_category', $cat->term_id);
                            if (count(array($ad_sub_cats)) > 0) {
                                $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('job_category', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $cats_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('job_category', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        // countries
        $countries_html = " ";
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {
            $rows = $atts['countries'];
            $cats = false;
            $countries_html = '';
            if (count($rows) > 0) {
                $countries_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['country'])) {
                        if ($row['country'] == 'all') {
                            $cats = true;
                            $countries_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['country'], 'ad_location');
                        if (count(array($category)) == 0)
                            continue;
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {

                            $ad_cats_sub = nokri_get_cats('ad_location', $category->term_id);
                            if (count($ad_cats_sub) > 0) {
                                $countries_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $countries_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }

                if ($cats) {
                    $ad_cats = nokri_get_cats('ad_location', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('ad_location', $cat->term_id);
                            if (count(array($ad_sub_cats)) > 0) {
                                $countries_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $countries_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <div class="n-hero7-container"><h1>' . $section_title . '</h1></div>' : "";
        /* Background Image */
        $bg_img = '';
        if (isset($search_section_img['url'])) {
            $bgImageURL = $search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* Keyword Title */
        $keyword_titles = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* Cat Title */
        $cats_titles = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '</label>' : "";
        /* Loc Title */
        $locat_titles = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '</label>' : "";

        /* side  tagline */
        $side_taglines = (isset($side_tagline) && $side_tagline != "") ? '<span>' . $side_tagline . '</span>' : "";
        /* side  heading */
        $side_titles = (isset($side_title) && $side_title != "") ? '<p class="h-style">' . $side_title . '</p>' : "";
        /* side button link */
        $side_btn_link = '';
        if (isset($resume_btn_txt)) {
            $side_btn_link = '<input type="button"  class="btn btn-default" value="' . esc_attr($resume_btn_txt) . '" name="upload_cand_resume" id="upload_cand_resume">';
        }
        $user_id = get_current_user_id();
        $signin_page = '';
        if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
            $signin_page = get_page_link($nokri['sb_sign_in_page']);
        }
        echo '<section class="n-hero-7" ' . str_replace('\\', "", $bg_img) . '>
				<div class="container">
					<div class="row">
					<div class="col-lg-9 col-xs-12 col-sm-12 col-md-9">
						<div class="n-hero7-products">
						' . $main_section_title . '
						<div class="n-hero7-fields">
						<form   method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
						' . nokri_form_lang_field_callback(false) . '
							<ul>
								<li>
								<div class="form-group">
									' . $keyword_titles . '
									<input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri-elementor') . '">
								</div>
								</li>
								<li>
								<div class="form-group">
								' . $cats_titles . '
									<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri-elementor') . '"    name="cat-id">
								   <option label="' . esc_html__('Select Category', 'nokri-elementor') . '"></option>
									' . $cats_html . '
								</select>
								</div>
								</li>
								<li>
								<div class="form-group">
								' . $locat_titles . '
									<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri-elementor') . '"  name="job-location">
										<option value="">' . esc_html__('Select Location', 'nokri-elementor') . '</option>
									' . $countries_html . '
									</select>
								</div>
								</li>
							</ul>
							<button type="submit" class="hero-submit-form"><i class="fa fa-search"></i></button>
							</form>
						</div>
						</div>
					</div>
					<div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
						<div class="n-hero7-resume">
						' . $side_taglines . '
						' . $side_titles . '
						' . $side_btn_link . '
                                                     <input id="my_cv_upload_custom" name="my_cv_upload[]"  class="upload_resume_tab" type="file"  hidden/>
                                     <input type="hidden"  value="' . $user_id . '"  id="check_user_login" data-redirect_url="' . $signin_page . '"/>
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
