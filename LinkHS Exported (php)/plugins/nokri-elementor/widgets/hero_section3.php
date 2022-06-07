<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section3 extends Widget_Base {

    public function get_name() {
        return 'hero-section3';
    }

    public function get_title() {
        return __('Hero Section 3', 'nokri-elementor');
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
                'section_for',
                [
                    'label' => __('Section For', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Jobs Search', 'nokri-elementor') => '0',
                        esc_html__('Employers Search', 'nokri-elementor') => '1',
                        esc_html__('Candidates Search', 'nokri-elementor') => '2',
                            )),
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
                    "description" => esc_html__('1920 x 727', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => esc_html__('For color ', 'nokri-elementor') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'nokri-elementor') . '<strong>' . esc_html('{/color}') . '</strong>',
                ]
        );
        $this->add_control(
                'section_details',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->add_control(
                'btn_txt',
                [
                    'label' => __('Button Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'link',
                [
                    'label' => __('Redirection Link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'nokri-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'section_video_title',
                [
                    'label' => __('video button title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_video',
                [
                    'label' => __('Video Url', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => esc_html__("Only Youtube Video Link Allowed", "'nokri"),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'Search_section',
                [
                    'label' => __('Search Section', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'search_image',
                [
                    'label' => __('Search Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('938 x 252', 'nokri-elementor'),
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
                    'label' => __('Select categories ( All or Selective )', 'nokri-elementor'),
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

      
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);

        global $nokri;
       
        // For Job Category
        global $nokri;
        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        $cats_html = $countries_html = '';
        // For Job Category
        if (isset($atts['cats']) && $atts['cats'] != '') {
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
                            if (count($ad_sub_cats) > 0) {
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
        if (isset($atts['countries']) && $atts['countries'] != '') {
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
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section Descriptions */
        $main_section_deatils = (isset($section_details) && $section_details != "") ? ' <p>' . $section_details . '</p>' : "";
        $main_section_title = nokri_color_text($main_section_title);
        /* Background Image */
        $bg_img = '';
        if (isset($search_section_img['url'])) {
            $bgImageURL =$search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* sidebar_title */
        $sidebar_title = (isset($sidebar_title) && $sidebar_title != "") ? '<h4>' . $sidebar_title . '</h4>' : "";
        /* keyword_title */
        $keyword_title = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* cats_title */
        $cats_title = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '</label>' : "";
        /* cats_title */
        $locat_title = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '</label>' : "";
        /* Search Image */
        $search_image1 = '';
        if (isset($search_image['url'])) {
           
            $img_thumb = $search_image['url'];
            $search_image1 = '<div class="n-8-employs"> <img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>';
        }
        /* Section Video */
        $video_title = '';
        if (isset($section_video_title) && $section_video_title != '') {
            $video_title = '<span>' . $section_video_title . '</span>';
        }
        $video = '';
        if (isset($section_video) && $section_video != '') {
            $video = '<li><a class="hero-video" href="' . ($section_video) . '"><i class="fa fa-play"></i> ' . $video_title . ' </a> </li>';
        }
        /* Button  Link */
        $btn = '';
        if (isset($btn_txt)) {
            $btn = elementor_ThemeBtn($link, 'btn n-btn-flat', false,'','',$btn_txt);
        }
        /* Section for */
        $section_for = (isset($section_for) && $section_for != '' ? $section_for : '1');
        if ($section_for == '1') {
            $action = get_the_permalink($nokri['employer_search_page']);
            $title_name = 'emp_title';
            $location_name = 'job-location';
            $category_name = 'emp_skills';
        } elseif ($section_for == '2') {
            $action = get_the_permalink($nokri['candidates_search_page']);
            $title_name = 'cand_title';
            $location_name = 'job-location';
            $category_name = 'cand_skills';
        } else {
            $action = get_the_permalink($nokri['sb_search_page']);
            $title_name = 'job-title';
            $location_name = 'job-location';
            $category_name = 'cat-id';
        }
        echo '<section class="n-hero-8" ' . str_replace('\\', "", $bg_img) . '>
				<div class="container">
					<div class="row">
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						<div class="n-8-container">
						<div class="n-8-content">
						' . $main_section_title . '
                        ' . $main_section_deatils . '
						</div>
						<div class="n-8-product">
							<ul>
							' . $btn . '
							' . $video . '
							</ul>
						</div>
						</div>
						' . $search_image1 . '
						<div class="n-8-serch-field">
						<form   method="get" action="' . $action . '">
						      ' . nokri_form_lang_field_callback(false) . '
							<ul>
							<li>
								<div class="form-group">
								' . $keyword_title . '
								<input type="text" class="form-control" name="' . $title_name . '" placeholder="' . esc_html__('Search here', 'nokri-elementor') . '">
								</div>
							</li>
							<li>
								<div class="form-group">
								' . $cats_title . '
								<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri-elementor') . '"    name="' . $category_name . '">
								   <option label="' . esc_html__('Select Category', 'nokri-elementor') . '"></option>
									' . $cats_html . '
								</select>
								</div>
							</li>
							<li>
								<div class="form-group">
								' . $locat_title . '
								<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri-elementor') . '"  name="' . $location_name . '">
								   <option value="">' . esc_html__('Select Location', 'nokri-elementor') . '</option>
									 ' . $countries_html . '
								</select>
								</div>
							</li>
							<li>
								<div class=""> 
									<button type="submit" class="btn n-btn-flat">' . esc_html__('Search', 'nokri-elementor') . '</button>
								</div>
							</li>
							</ul>
						</form>
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
