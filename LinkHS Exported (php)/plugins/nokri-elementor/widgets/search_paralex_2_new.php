<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section_New extends Widget_Base {

    public function get_name() {
        return 'hero-section-new';
    }

    public function get_title() {
        return __('Hero Section new', 'nokri-elementor');
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
                ]
        );
        $this->add_control(
                'search_section_arrow_img',
                [
                    'label' => __('Arrow Icons', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'description' => __('Click to explore more icons', 'nokri-elementor') . ' ' . nokri_make_link('https://themify.me/themify-icons', __('Get Icons', 'nokri-elementor')),
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
                    'label' => __('Section Tagline', 'nokri-elementor'),
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
                'country_title',
                [
                    'label' => __('Country title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'country_section',
                [
                    'label' => __('Countries', 'nokri-elementor'),
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
                    'label' => __('Select Countries ( All or Selective )', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'countries' => '{{ { countries }}}',
                ]
        );
        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Do you want to show sub locations', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        'yes' => __('yes', 'nokri-elementor'),
                        'no' => __('no', 'nokri-elementor'),
                    ],
                ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Hot Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'hot_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'hot_cat',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'no'),
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
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries
        
        $atts   =  $settings;
        
        extract($settings);
                $countries_html = '';     
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {            
            $rows_countries = $atts['countries'];
            $year_countries = false;
            $countries_html = '';
            $get_year = '';
            if (count($rows_countries) > 0) {
                $countries_html .= '';
                foreach ($rows_countries as $rows_country) {
                    if (isset($rows_country['country'])) {
                        if ($rows_country['country'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                        $get_country = get_term_by('slug', $rows_country['country'], 'ad_location');
                        if (count((array) $get_country) == 0)
                            continue;
                        $countries_html .= '<option value="' . $get_country->term_id . '">' . $get_country->name . '</option>';
                    }
                }

                if ($year_countries) {

                    $all_countries = nokri_get_cats('ad_location', 0);
                    foreach ($all_countries as $all_year) {
                        $countries_html .= '<option value="' . $all_year->term_id . '">' . $all_year->name . '</option>';
                    }
                }
            }
        }
        // countries
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
                         
                       
                        if (isset($want_to_show) && $want_to_show == "yes") {

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
                        if (isset($want_to_show) && $want_to_show == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('ad_location', $cat->term_id);
                            if (count($ad_sub_cats) > 0) {
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
        
       
        if (!empty($atts['hot_cats']) && isset($atts['hot_cats'])) {
            
       
            $rows_hot_cats = $atts['hot_cats'];
           
            $year_countries = false;
            $hot_cats_html = '';
            $get_year = '';
            if (count($rows_hot_cats) > 0) {
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
                        $hot_cats_html .= '<a href="' . nokri_cat_link_page($get_hot_cat->term_id) . '">' . $get_hot_cat->name . '</a>';
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section Tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? ' <p>' . $section_tagline . '</p>' : "";
        /* hot Title */
        $hot_section_title = (isset($hot_title) && $hot_title != "") ? '<span class="n-most-cat-title">' . $hot_title . '</span>' : "";
        /* keyowrd Title */
        $keyword_title = (isset($keyword_title) && $keyword_title != "") ? '<label><i class="ti-search"></i>' . " " . $keyword_title . '</label>' : "";
        /* country Title */
        $country_title = (isset($country_title) && $country_title != "") ? '<label><i class="ti-location-pin"></i>' . " " . $country_title . '</label>' : "";
        /* Background Image */
        $bg_img = '';

        if (isset($search_section_img['url'])) {
           $bgImageURL = $search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
       }
        /* Arrow icons */
        $arrow_icon = '';
        if (isset($search_section_arrow_img) && $search_section_arrow_img != '') {
            $arrow_icon = '<div class="move-down">
								<a href="#elegent_catz"><i class="' . esc_attr($search_section_arrow_img) . '"></i></a>
							   </div>';
        }
                  
       echo   '<section class="n-hero-section-two rebuild" '.str_replace('\\',"",$bg_img).'>
         <div class="container">
            <div class="row">
               <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1 col-md-offset-1">
                  <div class="n-hero-two-box">
                     <div class="n-hero-two-main-text">
					    '.$main_section_tagline.'
                     	'.$main_section_title.'
                     </div>
                     <div class="n-hero-two-form-cat">
                        <div class="n-saech-two-form">
                        	<div class="row">
                            	<form  method="get" action="'.get_the_permalink($nokri['sb_search_page']).'">
								
                                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                     <div class="form-group">
                                        '.$keyword_title.'
									 <input type="text" class="form-control" name="job-title" placeholder="'.esc_attr__('Keyword','nokri-elementor').'">
                                     </div>
                                  </div>
                                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                     <div class="form-group">
									'.$country_title.'
                                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="'.esc_html__('Select Location','nokri-elementor').'" style="width: 100%" name="job-location">
                                         <option value="">'.$country_title.'</option>
                                           '.$countries_html .'
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                     <button class="btn n-btn-flat" type="submit">'.esc_html__( 'Search', 'nokri-elementor' ).'</button>
                                  </div>
                               </form>
                            </div>
                        </div>
                        <div class="n-most-two-cat">
                           <span class="n-most-cat-title">'.$hot_section_title.'</span>
                           <span class="n-most-cat-list">
                           '.$hot_cats_html.'
                           </span>
                        </div>
                     </div>
                  </div>
                  '.$arrow_icon.'
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
