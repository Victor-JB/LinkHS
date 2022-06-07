<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section1 extends Widget_Base {

    public function get_name() {
        return 'hero-section1';
    }

    public function get_title() {
        return __('Hero Section 1', 'nokri-elementor');
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
                'section_tagline',
                [
                    'label' => __('Section tagline', 'nokri-elementor'),
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
                'category_hot_section',
                [
                    'label' => __('Hot Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
         $this->add_control(
                'hot_title',
                [
                    'label' => __('Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'hot_cat',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );

        $this->add_control(
                'hot_cats',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'button_section',
                [
                    'label' => __('Button Section', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'is_show',
                [
                    'label' => __('Do you want to show', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        'yes' => esc_html__('yes', 'nokri-elementor'),
                        'no' => esc_html__('no', 'nokri-elementor'),
                    ),
                ]
        );
        $this->add_control(
                'cand_image',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('64 by 64', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'cand_title',
                [
                    'label' => __('Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'cand_tagline',
                [
                    'label' => __('tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'resume_btn_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
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

        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        // For Job Category
        $cats_html = "";
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
                            if (count($ad_cats_sub) > 0) {
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
         $countries_html = '';
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {
            $rows = $atts['countries'];


            $cats = false;
           
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


                            if (count(array($ad_cats_sub)) > 0) {
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
        // For hot categories
        $hot_cats_html = '';
        if (!empty($atts['hot_cats'])) {
            $rows_hot_cats = $atts['hot_cats'];
            $year_countries = false;
            $hot_cats_html = '';
            $get_year = '';
            if (count(array($rows_hot_cats)) > 0) {
                foreach ($rows_hot_cats as $rows_hot_cat) {
                    if (isset($rows_hot_cat['hot_cat'])) {
                        if ($rows_hot_cat['hot_cat'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                        $get_hot_cat = get_term_by('slug', $rows_hot_cat['hot_cat'], 'job_category');
                        if (count((array) $get_hot_cat) == 0)
                            continue;
                        $hot_cats_html .= '<li><a href="' . nokri_cat_link_page($get_hot_cat->term_id) . '">' . $get_hot_cat->name . '</a></li>';
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<span class="h6-style">' . $section_tagline . '</span>' : "";
        /* hot Title */
        $hot_section_title = (isset($hot_title) && $hot_title != "") ? '<li class="style-flex"><a href="#">' . $hot_title . '</a></li>' : "";
        /* Background Image */
        $bg_img = '';
        if (isset($search_section_img['url'])) {
            $bgImageURL = $search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }

        /* Section Title */
        $can_section_title = (isset($cand_title) && $cand_title != "") ? '<div class="h6-product">' . $cand_title . '</div>' : "";
        /* Section tagline */
        $can_section_tagline1 = (isset($cand_tagline) && $cand_tagline != "") ? ' <p>' . $cand_tagline . '</p>' : "";
        /* Link */
        $cand_btn_txt = '';
        if (isset($resume_btn_txt)) {
            $cand_btn_txt = '<div class="col-lg-6 col-md-6 col-sm-6"><div class="n-profile-btn"><input type="button"  class="btn n-btn-flat" value="' . esc_attr($resume_btn_txt) . '" name="upload_cand_resume" id="upload_cand_resume"></div></div>';
        }
        /* cand Image */
        $cand_image1 = '';
        if (isset($cand_image['url'])) {


            
            $img_thumb = $cand_image['url'];
            $cand_image1 = '<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
        }
        /* Section show */
        $can_show = (isset($is_show) && $is_show != "") ? $is_show : "yes";
        $can_show = '';
        $user_id = get_current_user_id();
        $signin_page = '';
        if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
            $signin_page = get_page_link($nokri['sb_sign_in_page']);
        }
        $height_section = 'n-option';
        if ($is_show == 'yes') {
            $height_section = '';
            $can_show = '<div class="n-h6-profile">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="n-jobs-h6">
							' . $cand_image1 . '
							' . $can_section_title . '
							' . $can_section_tagline1 . '
						</div>
					</div>
					' . $cand_btn_txt . '
                                     <input id="my_cv_upload_custom" name="my_cv_upload[]"  class="upload_resume_tab" type="file"  hidden/>
                                     <input type="hidden"  value="' . $user_id . '"  id="check_user_login" data-redirect_url="' . $signin_page . '"/>
				</div>
			</div>
		</div>';
        }

        echo '<section class="n-hero-6" ' . str_replace('\\', "", $bg_img) . '>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
				<div class="n-h6-content" ' . esc_attr($height_section) . '>' . $main_section_tagline . ' ' . $main_section_title . '
					<form  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
					    ' . nokri_form_lang_field_callback(false) . '
						<div class="n-h6-form">
							<ul>
								<li>
									<div class="form-group">
                                     <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri-elementor') . '">
									</div>
								</li>
								<li>
									<div class="form-group">
										<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri-elementor') . '" name="cat-id">
											<option label="' . esc_html__('Select Category', 'nokri-elementor') . '"></option>' . $cats_html . '</select>
									</div>
								</li>
								<li>
									<div class="form-group">
										<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri-elementor') . '"  name="job-location">
								   <option value="">' . esc_html__('Select Location', 'nokri-elementor') . '</option>
									 ' . $countries_html . '
										</select>
									</div>
								</li>
								<li>	
									<button type="submit" class="btn n-btn-flat">' . esc_html__('Search', 'nokri-elementor') . '<i class="fa fa-search"></i></button>
								</li>
							</ul>
						</div>
					</form>
					<div class="n-hero-list">
						<ul>
							' . $hot_section_title . '
							' . $hot_cats_html . '
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	' . $can_show . '
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
