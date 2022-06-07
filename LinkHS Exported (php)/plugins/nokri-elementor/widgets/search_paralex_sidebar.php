<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section_Paralex_Sidebar extends Widget_Base {

    public function get_name() {
        return 'paralex-with-search-sidebar';
    }

    public function get_title() {
        return __('Paralex with side search', 'nokri-elementor');
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
                'section_tagline',
                [
                    'label' => __('Section tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
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
                'section_details',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'story_section',
                [
                    'label' => __('Add Story', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'story_number',
                [
                    'label' => __('Number', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater->add_control(
                'story_title',
                [
                    'label' => __('Story title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'stories',
                [
                    'label' => __('Select', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'Search_section',
                [
                    'label' => __('Search', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        
         $this->add_control(
                'sidebar_title',
                [
                    'label' => __('Sidebar title', 'nokri-elementor'),
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
                    'label' => __('categories', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select  category', 'nokri-elementor'),
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
        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Do you want to show sub Category', 'plugin-domain'),
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

        // For Job Category
        $cats_html = '';
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
                        
                        if($row['cat'] != ""){
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count((array)$category) == 0)
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
        //For countries
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
                        if (count(array($get_country)) == 0)
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
         $stories_html = '';
        if (isset($atts['stories']) && !empty($atts['stories']) != '') {
            $rows_story = $atts['stories'];
           
            if ((array) count($rows_story) > 0) {
                foreach ($rows_story as $row_story) {
                    /* Story Title */
                    $astory_title = (isset($row_story['story_title']) && $row_story['story_title'] != "") ? ' <h3 class="count-title">' . $row_story['story_title'] . '</h3>' : "";
                    /* Story Description */
                    $astory_no = (isset($row_story['story_number']) && $row_story['story_number'] != "") ? '<h5 class="counter-stats">' . $row_story['story_number'] . '</h5>' : "";

                    /* Story Html */
                    $stories_html .= '<div class="counter-seprator">
					<div class="counter-box">
					   ' . $astory_no . '
					   ' . $astory_title . '
					</div>
				 </div>';
                }
            }
        }
        /* Section Tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<h3 class="hero-title">' . $section_tagline . '</h3>' : "";
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h2>' . $section_title . '</h2>' : "";
        /* Section Descriptions */
        $main_section_deatils = (isset($section_details) && $section_details != "") ? ' <p>' . $section_details . '</p>' : "";
        /* Background Image */
        $bg_img = '';
        if (isset($search_section_img['url'])) {
            $bgImageURL = $search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* sidebar_title */
        $sidebar_title = (isset($sidebar_title) && $sidebar_title != "") ? '<h4>' . $sidebar_title . '</h4>' : "";
        /* keyword_title */
        $keyword_title = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* cats_title */
        $cats_title = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '<label>' : "";
        /* cats_title */
        $locat_title = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '<label>' : "";
        echo '<section id="intro-hero"  ' . str_replace('\\', "", $bg_img) . ' >
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
        <div class="hero-text-box">
         ' . $main_section_tagline . '
          ' . $main_section_title . '
          ' . $main_section_deatils . '
        </div>
        <div class="conter-grid">
             ' . $stories_html . '
          </div>
      </div>
      <div class="col-lg-4 col-md-5 col-sm-8 col-xs-12 col-md-offset-0 col-sm-offset-2 col-lg-offset-1">
		<form class="form-join"  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
		' . nokri_form_lang_field_callback(false) . '
          ' . $sidebar_title . '
          <div class="form-group">
            ' . $keyword_title . '
			 <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search Keyword', 'nokri-elementor') . '">
          </div>
          <div class="form-group">
          	' . $cats_title . '
            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri-elementor') . '" style="width: 100%"   name="cat-id">
               <option label="' . esc_html__('Select Category', 'nokri-elementor') . '"></option>
                ' . $cats_html . '
            </select>
          </div>
          <div class="form-group">
              ' . $locat_title . '
          	<select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri-elementor') . '" style="width: 100%" name="job-location">
               <option value="">' . esc_html__('Select Location', 'nokri-elementor') . '</option>
                 ' . $countries_html . '
            </select>
          </div>
		  <button type="submit" class="btn n-btn-flat btn-block">' . esc_html__('Search', 'nokri-elementor') . '<i class="fa fa-search"></i></button>
        </form>
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
